<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan_Cuti;
use App\Http\Requests\Storepengajuan_cutiRequest;
use App\Http\Requests\Updatepengajuan_cutiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Exports\PengajuanCutiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\CutiDisetujui;

class PengajuanCutiController extends Controller
{
    /** Menampilkan form pengajuan cuti */
    public function create()
    {
        return view('dashboard.cuti.create');
    }

    /** Simpan pengajuan cuti baru */
    public function store(Storepengajuan_cutiRequest $request)
    {
        $request->validate([
            'jenis_cuti' => 'required|in:tahunan,sakit,alasan_penting,besar,melahirkan,cltn',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'surat_sakit' => 'required_if:jenis_cuti,sakit|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $hariCuti = Carbon::parse($request->tanggal_selesai)
            ->diffInDays(Carbon::parse($request->tanggal_mulai)) + 1;

        // Upload surat jika ada
        $suratPath = $request->hasFile('surat_sakit')
            ? $request->file('surat_sakit')->store('surat_cuti', 'public')
            : null;

        /** 🔹 Validasi kuota cuti */
        switch ($request->jenis_cuti) {
            case 'tahunan':
                $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', 'tahunan')
                    ->whereYear('tanggal_mulai', now()->year)
                    ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

                $sisaCutiLalu = min($user->sisa_cuti_tahunan_bulan_lalu ?? 0, 6);
                $kuotaTahunan = $user->sisa_cuti_tahunan + $sisaCutiLalu;

                if (($totalTahunan + $hariCuti) > $kuotaTahunan) {
                    return back()->with('error', 'Kuota cuti tahunan Anda melebihi batas.');
                }
                break;

            case 'sakit':
                $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', 'sakit')
                    ->whereYear('tanggal_mulai', now()->year)
                    ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

                if (($totalSakit + $hariCuti) > $user->sisa_cuti_sakit) {
                    return back()->with('error', 'Kuota cuti sakit Anda melebihi batas.');
                }
                break;

            case 'alasan_penting':
                if ($hariCuti > 30) return back()->with('error', 'Cuti karena alasan penting maksimal 1 bulan.');
                break;

            case 'besar':
                if ($hariCuti > 90) return back()->with('error', 'Cuti besar maksimal 3 bulan.');

                $lastCutiBesar = Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', 'besar')
                    ->where('tanggal_mulai', '>=', now()->subYears(5))
                    ->exists();

                if ($lastCutiBesar) {
                    return back()->with('error', 'Cuti besar hanya dapat diambil sekali dalam 5 tahun.');
                }
                break;

            case 'melahirkan':
                if ($hariCuti > 90) return back()->with('error', 'Cuti melahirkan maksimal 3 bulan.');
                break;

            case 'cltn':
                if ($hariCuti > 1460) return back()->with('error', 'Cuti di luar tanggungan negara maksimal 3 tahun.');
                break;
        }

        /** 🔹 Tentukan alur persetujuan */
        $status = $user->role === 'ketua' ? 'disetujui' : 'diajukan';
        $approval = $user->getActiveApprover();

        /** 🔹 Simpan ke database */
        Pengajuan_Cuti::create([
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

    /** Tampilkan daftar cuti milik user */
    public function show(Pengajuan_Cuti $pengajuan_cuti)
    {
        $cuti = Pengajuan_Cuti::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $user = Auth::user();

        return view('dashboard.cuti.index', compact('cuti', 'user'));
    }

    /** Menyetujui pengajuan cuti */
    public function approve($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);
        $user = auth()->user();

        if ($cuti->current_approval_id != $user->id) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menyetujui cuti ini.');
        }

        // Tentukan atasan berikutnya
        $nextApproval = $user->getActiveApprover();

        // Kalau dia ketua / ketua pengganti -> tahap akhir
        if ($user->role === 'ketua' || $user->is_ketua_pengganti) {
            $cuti->update([
                'status' => 'disetujui',
                'current_approval_id' => null,
            ]);
        } 
        // Kalau ada atasan berikutnya
        else if ($nextApproval) {
            $cuti->update([
                'status' => 'disetujui_atasan',
                'current_approval_id' => $nextApproval,
            ]);
        } 
        // Kalau tidak ada atasan lagi, auto setujui
        else {
            $cuti->update([
                'status' => 'disetujui',
                'current_approval_id' => null,
            ]);
        }

        event(new CutiDisetujui($cuti));

        return redirect()->route('cuti.pengajuan', auth()->id())
            ->with('success', 'Pengajuan cuti telah disetujui dan diteruskan ke atasan berikutnya.');
    }

    /** Menolak pengajuan cuti */
    public function reject($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);
        $user = auth()->user();

        if ($cuti->current_approval_id != $user->id) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menolak cuti ini.');
        }

        $cuti->update([
            'status' => 'ditolak',
            'current_approval_id' => null,
        ]);

        return back()->with('success', 'Pengajuan cuti telah ditolak.');
    }

    /** Menampilkan daftar pengajuan cuti yang harus disetujui oleh user saat ini */
    public function pengajuan($id)
    {
        $user = auth()->user();
        abort_if($user->id != $id, 403, 'Akses ditolak.');

        $pengajuanCuti = Pengajuan_Cuti::where('current_approval_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.cuti.pengajuan', compact('pengajuanCuti', 'user'));
    }

    /** Cetak form pengajuan cuti */
    public function print_formcuti($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);
        $user = User::find($cuti->user_id);
        $atasan = User::find($user->atasan_id);
        $ketua = User::where('role', 'ketua')->first();

        $showAtasan = $cuti->current_approval_id != $ketua?->id;
        $showKetua = is_null($cuti->current_approval_id);
        $showUserTTD = true;

        return view('dashboard.cuti.print_formcuti', compact(
            'cuti', 'user', 'atasan', 'ketua', 'showAtasan', 'showKetua', 'showUserTTD'
        ));
    }

    /** Cetak surat izin cuti */
    public function print_suratizin($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);
        $user = User::find($cuti->user_id);
        $ketua = User::where('role', 'ketua')->first();

        $showKetua = is_null($cuti->current_approval_id);
        return view('dashboard.cuti.print_suratizin', compact('cuti', 'user', 'ketua', 'showKetua'));
    }

    /** Menampilkan semua pengajuan cuti (khusus admin) */
    public function allpengajuan()
    {
        $user = auth()->user();
        abort_if($user->role !== 'admin', 403, 'Akses ditolak.');

        $cutis = Pengajuan_Cuti::orderBy('created_at', 'desc')->get();
        return view('dashboard.cuti.get_all_cuti', compact('cutis', 'user'));
    }

    /** Update sisa cuti user */
    public function editcuti($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.cuti.edit_cuti', compact('user'));
    }

    public function updateCuti(Request $request, $id)
    {
        $request->validate([
            'sisa_cuti_tahunan' => 'required|integer|min:0',
            'sisa_cuti_sakit' => 'required|integer|min:0',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['sisa_cuti_tahunan', 'sisa_cuti_sakit']));

        return back()->with('success', 'Sisa cuti berhasil diperbarui.');
    }

    /** Set ketua pengganti (admin) */
    public function setKetuaPengganti(Request $request)
    {
        $auth = Auth::user();
        abort_if($auth->role !== 'admin', 403);

        $request->validate(['user_id' => 'required|exists:users,id']);
        User::where('is_ketua_pengganti', true)->update(['is_ketua_pengganti' => false]);

        $user = User::findOrFail($request->user_id);
        $user->is_ketua_pengganti = true;
        $user->save();

        return back()->with('success', "{$user->name} ditetapkan sebagai Ketua Pengganti.");
    }

    /** Set PLH Panitera */
    public function setPlhPanitera(Request $request)
    {
        $auth = Auth::user();
        abort_if($auth->role !== 'admin', 403);

        $request->validate(['user_id' => 'required|exists:users,id']);
        User::where('is_plh_panitera', true)->update(['is_plh_panitera' => false]);

        $user = User::findOrFail($request->user_id);
        $user->is_plh_panitera = true;
        $user->save();

        return back()->with('success', "{$user->name} ditetapkan sebagai PLH Panitera.");
    }

    /** Set PLH Sekretaris */
    public function setPlhSekretaris(Request $request)
    {
        $auth = Auth::user();
        abort_if($auth->role !== 'admin', 403);

        $request->validate(['user_id' => 'required|exists:users,id']);
        User::where('is_plh_sekretaris', true)->update(['is_plh_sekretaris' => false]);

        $user = User::findOrFail($request->user_id);
        $user->is_plh_sekretaris = true;
        $user->save();

        return back()->with('success', "{$user->name} ditetapkan sebagai PLH Sekretaris.");
    }

    /** Form untuk set ketua pengganti */
    public function formKetuaPengganti()
    {
        $auth = Auth::user();
        abort_if($auth->role !== 'admin', 403);

        $users = User::where('role', '!=', 'admin')->get();
        return view('dashboard.cuti.ketua_pengganti', compact('users'));
    }

    /** Export semua data cuti */
    public function export()
    {
        return Excel::download(new PengajuanCutiExport, 'pengajuan_cuti.xlsx');
    }

    /** Export data cuti per user */
    public function exportByUser($user_id)
    {
        $user = User::find($user_id);
        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        $cutis = Pengajuan_Cuti::where('user_id', $user_id)->get();
        if ($cutis->isEmpty()) return back()->with('error', 'User ini belum memiliki data cuti.');

        $filename = 'pengajuan_cuti_' . str_replace(' ', '_', strtolower($user->name)) . '.xlsx';
        return Excel::download(new PengajuanCutiExport($cutis), $filename);
    }
}
