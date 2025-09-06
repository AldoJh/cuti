<?php

namespace App\Http\Controllers;

use App\Models\pengajuan_cuti;
use App\Http\Requests\Storepengajuan_cutiRequest;
use App\Http\Requests\Updatepengajuan_cutiRequest;
use Illuminate\Support\Facades\Auth;

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
            'jenis_cuti' => 'required|in:tahunan,sakit',
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

        $hariCuti = Carbon\Carbon::parse($request->tanggal_selesai)
                    ->diffInDays(Carbon\Carbon::parse($request->tanggal_mulai)) + 1;

        if ($request->jenis_cuti === 'tahunan') {
            // Ambil total cuti tahunan tahun ini
            $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'tahunan')
                ->whereYear('tanggal_mulai', now()->year)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

            // Ambil sisa cuti tahun sebelumnya
            $sisaCutiLalu = min($user->sisa_cuti_tahun_lalu ?? 0, 6); // atau 24 jika ditangguhkan
            $kuotaTahunan = 12 + $sisaCutiLalu;

            if (($totalTahunan + $hariCuti) > $kuotaTahunan) {
                return redirect()->back()->with('error', 'Kuota cuti tahunan Anda melebihi batas.');
            }
        }

        if ($request->jenis_cuti === 'sakit') {
            $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'sakit')
                ->whereYear('tanggal_mulai', now()->year)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

            $kuotaSakit = ($request->alasan === 'gugur_kandungan') ? 45 : 14;

            if (($totalSakit + $hariCuti) > $kuotaSakit) {
                return redirect()->back()->with('error', 'Kuota cuti sakit Anda melebihi batas.');
            }
        }

        $cuti = Pengajuan_Cuti::create([
            'user_id' => $user->id,
            'jenis_cuti' => $request->jenis_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'surat_sakit' => $suratPath,
            'current_approval_id' => $currentApproval, 
            'status' => 'diajukan',
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

            if ($cuti->current_approval_id != $user->id) {
                return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menyetujui cuti ini.');
            }

            if ($user->atasan_id) {
                // Lanjutkan ke atasan berikutnya
                $cuti->current_approval_id = $user->atasan_id;
                $cuti->status = 'diajukan'; 
            } else {
                // Tidak ada atasan, langsung disetujui
                $cuti->current_approval_id = null;
                $cuti->status = 'disetujui';
            }

            $cuti->save();

            return redirect()->back()->with('success', 'Pengajuan cuti telah disetujui.');
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
}
