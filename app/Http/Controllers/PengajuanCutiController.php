<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan_Cuti;
use App\Http\Requests\Storepengajuan_cutiRequest;
use App\Http\Requests\Updatepengajuan_cutiRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PengajuanCutiExport;
use Maatwebsite\Excel\Facades\Excel;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('dashboard.cuti.create');
        return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storepengajuan_cutiRequest $request)
{
    $request->validate([
        'jenis_cuti' => 'required|in:tahunan,sakit,alasan_penting,besar,melahirkan,cltn',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'alasan' => 'required|string',
        'surat_sakit' => 'required_if:jenis_cuti,sakit|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $suratPath = null;
    if ($request->hasFile('surat_sakit')) {
        $suratPath = $request->file('surat_sakit')->store('surat_cuti', 'public');
    }

    $user = Auth::user();
    $currentApproval = $user->atasan_id ?? null;

    $hariCuti = Carbon::parse($request->tanggal_selesai)
                ->diffInDays(Carbon::parse($request->tanggal_mulai)) + 1;

    switch ($request->jenis_cuti) {
        case 'tahunan':
            // Kuota cuti tahunan
            $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'tahunan')
                ->whereYear('tanggal_mulai', now()->year)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

            $sisaCutiLalu = min($user->sisa_cuti_tahun_lalu ?? 0, 6);
            $kuotaTahunan = $user->sisa_cuti_tahunan; + $sisaCutiLalu;

            if (($totalTahunan + $hariCuti) > $kuotaTahunan) {
                return back()->with('error', 'Kuota cuti tahunan Anda melebihi batas.');
            }
            break;

        case 'sakit':
            // Kuota cuti sakit (standar: 14 hari, keguguran: 45 hari)
            $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'sakit')
                ->whereYear('tanggal_mulai', now()->year)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

            $kuotaSakit = $user->sisa_cuti_sakit;

            if (($totalSakit + $hariCuti) > $kuotaSakit) {
                return back()->with('error', 'Kuota cuti sakit Anda melebihi batas.');
            }
            break;

        case 'alasan_penting':
            // Cuti karena alasan penting max 1 bulan
            if ($hariCuti > 30) {
                return back()->with('error', 'Cuti karena alasan penting maksimal 1 bulan.');
            }
            break;

        case 'besar':
            // Cuti besar max 3 bulan, 1 kali dalam 5 tahun
            if ($hariCuti > 90) {
                return back()->with('error', 'Cuti besar maksimal 3 bulan.');
            }

            $lastCutiBesar = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'besar')
                ->where('tanggal_mulai', '>=', now()->subYears(5))
                ->exists();

            if ($lastCutiBesar) {
                return back()->with('error', 'Cuti besar hanya bisa diambil sekali dalam 5 tahun.');
            }
            break;

        case 'melahirkan':
            // Cuti melahirkan max 3 bulan
            if ($hariCuti > 90) {
                return back()->with('error', 'Cuti melahirkan maksimal 3 bulan.');
            }
            break;

        case 'cltn':
            // CLTN maksimal 3 tahun (1095 hari), dapat diperpanjang 1 tahun (365 hari)
            if ($hariCuti > 1460) {
                return back()->with('error', 'Cuti di luar tanggungan negara maksimal 3 tahun (dapat diperpanjang 1 tahun).');
            }
            break;
    }

    // 🔹 Tentukan approval flow
    $status = 'diajukan';
    $approval = $user->atasan_id ?? null;
    $ketua = User::where('role', 'ketua')->first();

    if ($user->role === 'ketua') {
        // Kalau ketua yang ajukan → langsung disetujui
        $status = 'disetujui';
        $approval = null;
    } elseif ($user->atasan_id === $ketua?->id ) {
        // Kalau user tidak punya atasan → cek ketua pengganti atau ketua asli
        $ketuaPengganti = User::where('is_ketua_pengganti', true)->first();
        $ketua = User::where('role', 'ketua')->first();
    
        if ($ketuaPengganti) {
            $approval = $ketuaPengganti->id;
        } else {
            $approval = $ketua?->id;
        }
    } else {
        // User punya atasan → approval ke atasan
        $approval = $user->atasan_id;
    }
    
    $cuti = Pengajuan_Cuti::create([
        'user_id' => $user->id,
        'jenis_cuti' => $request->jenis_cuti,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'alasan' => $request->alasan,
        'surat_sakit' => $suratPath,
        'current_approval_id' => $approval, 
        'status' => $status,
    ]);

    return redirect()->route('dashboard')->with('success', 'Pengajuan cuti berhasil diajukan.');
}


    /**
     * Display the specified resource.
     */
    public function show(pengajuan_cuti $pengajuan_cuti)
    {
            $cuti = pengajuan_cuti::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            $user = Auth::user();
            // dd($cuti);
            return view('dashboard.cuti.index', compact('cuti','user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pengajuan_cuti $pengajuan_cuti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatepengajuan_cutiRequest $request, pengajuan_cuti $pengajuan_cuti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pengajuan_cuti $pengajuan_cuti)
    {
        //
    }

    public function approve($id)
    {
            $cuti = Pengajuan_Cuti::findOrFail($id);
            $user = auth()->user();
            $ketua = User::where('role', 'ketua')->first();

            if ($cuti->current_approval_id != $user->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menyetujui cuti ini.');
            }

            if ($user->role === 'ketua' || $user->is_ketua_pengganti) {
                // Kalau ketua yang approve -> final
                $cuti->current_approval_id = null;
                $cuti->status = 'disetujui';
            } elseif ($user->atasan_id === $ketua?->id) {
                $ketuaPengganti = User::where('is_ketua_pengganti', true)->first();

                if ($ketuaPengganti) {
                    // Kalau ada ketua pengganti -> teruskan ke ketua pengganti
                    $cuti->current_approval_id = $ketuaPengganti->id;
                    $cuti->status = 'disetujui_atasan';
                } else {
                    // Kalau tidak ada ketua pengganti -> teruskan ke ketua asli
                    $cuti->current_approval_id = $ketua?->id;
                    $cuti->status = 'disetujui_atasan';
                }
                // Kalau masih ada atasan -> teruskan
                // $cuti->current_approval_id = $user->atasan_id;
                // $cuti->status = 'disetujui_atasan';
            } else {
                // Kalau tidak ada atasan -> final
                $cuti->current_approval_id = null;
                $cuti->status = 'disetujui';
            }
            $cuti->save();

            return redirect()->back()->with('success', 'Pengajuan cuti telah disetujui.');
    }

    //reject function
    public function reject($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);
        $user = auth()->user();

        if ($cuti->current_approval_id != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menolak cuti ini.');
        }

        $cuti->current_approval_id = null;
        $cuti->status = 'ditolak';
        $cuti->save();

        return redirect()->back()->with('success', 'Pengajuan cuti telah ditolak.');
    }


    public function pengajuan($id)
    {
    $user = auth()->user();

    
    if ($user->id != $id) {
        abort(403, 'Akses ditolak.');
    }

    // Ambil semua pengajuan cuti yang saat ini harus disetujui oleh user ini
    $pengajuanCuti = Pengajuan_Cuti::where('current_approval_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();


    return view('dashboard.cuti.pengajuan', compact('pengajuanCuti', 'user'));
    }

    public function print_formcuti($id)
{
    $cuti = pengajuan_cuti::findOrFail($id);
    $user = User::find($cuti->user_id);
    $atasan = User::find($user->atasan_id);

    // Cari user dengan role ketua
    $ketua = User::where('role', 'ketua')->first();

    // Logika tampilkan TTD
    $showAtasan = false;
    $showKetua = false;
    

    if (is_null($cuti->current_approval_id)) {
   
        $showAtasan = true;
        $showKetua = true;
    } elseif ($cuti->current_approval_id == $ketua?->id) {
        
        $showKetua = false;
        $showAtasan = true;
    } else {
        // Kalau approval_id bukan ketua → (default) tidak tampilkan atasan
        $showAtasan = false;
    }

    $showUserTTD = true; 

    return view('dashboard.cuti.print_formcuti', compact(
        'cuti',
        'user',
        'atasan',
        'ketua',
        'showAtasan',
        'showKetua',
        'showUserTTD'
    ));
}

//print surat izin cuti function
public function print_suratizin($id)
{
    $cuti = pengajuan_cuti::findOrFail($id);
    $user = User::find($cuti->user_id);
    $atasan = User::find($user->atasan_id);

    // Cari user dengan role ketua
    $ketua = User::where('role', 'ketua')->first();

    // Logika tampilkan TTD
    $showAtasan = false;
    $showKetua = false;

    if (is_null($cuti->current_approval_id)) {
        // Jika belum ada approval → tampilkan dua-duanya
        $showKetua = true;
    } else {
        // Kalau approval_id bukan ketua → (default) tidak tampilkan atasan
        $showKetua = false;
    }

    return view('dashboard.cuti.print_suratizin', compact(
        'cuti',
        'user',
        'ketua',
        'showKetua'
    ));

}

//get all semua pengajuan cuti
public function allpengajuan()
{
    $user = auth()->user();

    if ($user->role !== 'admin') {
        abort(403, 'Akses ditolak.');
    }

    // Ambil semua pengajuan cuti
    $cutis = Pengajuan_Cuti::orderBy('created_at', 'desc')->get();

    return view('dashboard.cuti.get_all_cuti', compact('cutis', 'user'));
}
public function updateCuti(Request $request, $id)
{
    $request->validate([
        'sisa_cuti_tahunan' => 'required|integer|min:0',
        'sisa_cuti_sakit' => 'required|integer|min:0',
    ]);

    $user = User::findOrFail($id);
    $user->sisa_cuti_tahunan = $request->sisa_cuti_tahunan;
    $user->sisa_cuti_sakit = $request->sisa_cuti_sakit;
    $user->save();

    return redirect()->back()->with('success', 'Sisa cuti berhasil diperbarui.');
}

public function editcuti($id)
{
    //hanya admin yang bisa buka halaman edit
    $user = auth()->user();
    if ($user->role !== 'admin') {
        abort(403, 'Akses ditolak.');
    }
    //get semua data user by id
    $user = User::findOrFail($id);
    return view('dashboard.cuti.edit_cuti', compact('user'));
}

public function setKetuaPengganti(Request $request)
{
    $auth = Auth::user();
    if ($auth->role !== 'admin') {
        abort(403, 'Anda tidak memiliki hak untuk menetapkan ketua pengganti.');
    }

    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Reset semua ketua pengganti sebelumnya
    User::where('is_ketua_pengganti', true)->update(['is_ketua_pengganti' => false]);

    // Set user baru jadi ketua pengganti
    $user = User::findOrFail($request->user_id);
    $user->is_ketua_pengganti = true;
    $user->save();

    return back()->with('success', $user->name . ' ditetapkan sebagai Ketua Pengganti.');
}


public function formKetuaPengganti()
{
    $auth = Auth::user();
    if ($auth->role !== 'admin') {
        abort(403, 'Anda tidak memiliki hak untuk mengatur ketua pengganti.');
    }

    $users = User::where('role', '!=', 'admin')->get(); // ambil semua user kecuali admin
    return view('dashboard.cuti.ketua_pengganti', compact('users'));
}

// export function
public function export()
{
    return Excel::download(new PengajuanCutiExport, 'pengajuan_cuti.xlsx');
}

// export by user function
public function exportByUser($user_id)
{
    // Cari user
    $user = User::find($user_id);
    if (!$user) {
         return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    // Ambil data cuti milik user
    $cutis = pengajuan_cuti::with(['user', 'approval'])
        ->where('user_id', $user_id)
        ->get();

    if ($cutis->isEmpty()) {
        return redirect()->back()->with('error', 'User ini belum memiliki data cuti.');
    }

    // Nama file dinamis pakai nama user
    $filename = 'pengajuan_cuti_' . str_replace(' ', '_', strtolower($user->name)) . '.xlsx';

    return Excel::download(new PengajuanCutiExport($cutis), $filename);
}

}