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
    /**
     * Show create form
     */
    public function create()
    {
        return view('dashboard.cuti.create');
    }

    /**
     * Store new cuti request
     */
    public function store(Storepengajuan_cutiRequest $request)
    {
        $request->validate([
            'jenis_cuti'        => 'required|in:tahunan,sakit,alasan_penting,besar,melahirkan,cltn',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
            'alasan'            => 'required|string',
            'surat_sakit'       => 'required_if:jenis_cuti,sakit|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $hariCuti = $this->hitungHariCuti($request);

        // Upload file surat sakit (jika ada)
        $suratPath = $request->hasFile('surat_sakit')
            ? $request->file('surat_sakit')->store('surat_cuti', 'public')
            : null;

        // Validasi kuota cuti berdasarkan jenisnya
        $valid = $this->validateKuotaCuti($request->jenis_cuti, $hariCuti, $user, $request);

        if ($valid !== true) {
            return back()->with('error', $valid); // pesan error dari validator
        }

        // Menentukan alur persetujuan
        $status     = $user->role === 'ketua' ? 'disetujui' : 'diajukan';
        $approvalId = $user->getActiveApprover();

        // Simpan ke database
        Pengajuan_Cuti::create([
            'user_id'             => $user->id,
            'jenis_cuti'          => $request->jenis_cuti,
            'tanggal_mulai'       => $request->tanggal_mulai,
            'tanggal_selesai'     => $request->tanggal_selesai,
            'alasan'              => $request->alasan,
            'surat_sakit'         => $suratPath,
            'current_approval_id' => $approvalId,
            'status'              => $status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengajuan cuti berhasil diajukan.');
    }

    /**
     * Helper: Hitung jumlah hari cuti
     */
    private function hitungHariCuti($request)
    {
        return Carbon::parse($request->tanggal_selesai)
            ->diffInDays(Carbon::parse($request->tanggal_mulai)) + 1;
    }

    /**
     * Helper: Validasi kuota cuti per jenis
     */
    private function validateKuotaCuti($jenis, $hariCuti, $user, $request)
    {
        switch ($jenis) {

            case 'tahunan':
                $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', 'tahunan')
                    ->whereYear('tanggal_mulai', now()->year)
                    ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

                $sisaLalu  = min($user->sisa_cuti_tahunan_bulan_lalu ?? 0, 6);
                $kuota     = $user->sisa_cuti_tahunan + $sisaLalu;

                if ($totalTahunan + $hariCuti > $kuota) {
                    return 'Kuota cuti tahunan Anda melebihi batas.';
                }
                break;

            case 'sakit':
                $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', 'sakit')
                    ->whereYear('tanggal_mulai', now()->year)
                    ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

                if ($totalSakit + $hariCuti > $user->sisa_cuti_sakit) {
                    return 'Kuota cuti sakit Anda melebihi batas.';
                }
                break;

            case 'alasan_penting':
                return $hariCuti > 30
                    ? 'Cuti alasan penting maksimal 1 bulan.'
                    : true;

            case 'besar':
                if ($hariCuti > 90) return 'Cuti besar maksimal 3 bulan.';

                $last = Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', 'besar')
                    ->where('tanggal_mulai', '>=', now()->subYears(5))
                    ->exists();

                if ($last) return 'Cuti besar hanya dapat diambil sekali dalam 5 tahun.';
                break;

            case 'melahirkan':
                return $hariCuti > 90
                    ? 'Cuti melahirkan maksimal 3 bulan.'
                    : true;

            case 'cltn':
                return $hariCuti > 1460
                    ? 'CLTN maksimal 3 tahun.'
                    : true;
        }

        return true;
    }

    /**
     * Show daftar cuti user
     */
    public function show(Pengajuan_Cuti $pengajuan_cuti)
    {
        $cuti = Pengajuan_Cuti::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.cuti.index', [
            'cuti' => $cuti,
            'user' => Auth::user()
        ]);
    }

    /**
     * Approve cuti
     */
    public function approve($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);
        $user = auth()->user();

        if ($cuti->current_approval_id != $user->id) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menyetujui cuti ini.');
        }

        $nextApproval = $user->getActiveApprover();

        // Ketua → persetujuan final
        if ($user->role === 'ketua' || $user->is_ketua_pengganti) {
            $cuti->update([
                'status' => 'disetujui',
                'current_approval_id' => null,
            ]);
            $cuti->refresh();
        }
        // Ada atasan berikutnya
        else if ($nextApproval) {
            $cuti->update([
                'status' => 'disetujui_atasan',
                'current_approval_id' => $nextApproval,
            ]);
            $cuti->refresh();
        }
        // Tidak ada atasan → final
        else {
            $cuti->update([
                'status' => 'disetujui',
                'current_approval_id' => null,
            ]);
            $cuti->refresh();
        }

        // Trigger event setelah refresh
        if ($cuti->status === 'disetujui') {
            event(new CutiDisetujui($cuti));
        }

        return redirect()->route('cuti.pengajuan', $user->id)
            ->with('success', 'Pengajuan cuti telah disetujui.');
    }

    /**
     * Reject cuti
     */
    public function reject($id)
    {
        $cuti = Pengajuan_Cuti::findOrFail($id);

        if ($cuti->current_approval_id != auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki hak untuk menolak cuti ini.');
        }

        $cuti->update([
            'status' => 'ditolak',
            'current_approval_id' => null,
        ]);

        return back()->with('success', 'Pengajuan cuti telah ditolak.');
    }

    /**
     * Show daftar pengajuan yang perlu disetujui user
     */
    public function pengajuan($id)
    {
        abort_if(auth()->id() != $id, 403, 'Akses ditolak.');

        $pengajuanCuti = Pengajuan_Cuti::where('current_approval_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.cuti.pengajuan', compact('pengajuanCuti'));
    }

    /**
     * Print form
     */
    public function print_formcuti($id)
    {
        $cuti   = Pengajuan_Cuti::findOrFail($id);
        $user   = User::find($cuti->user_id);
        $atasan = User::find($user->atasan_id);
        $ketua  = User::where('role', 'ketua')->first();

        return view('dashboard.cuti.print_formcuti', [
            'cuti'        => $cuti,
            'user'        => $user,
            'atasan'      => $atasan,
            'ketua'       => $ketua,
            'showAtasan'  => in_array($cuti->status, ['disetujui_atasan', 'disetujui']),
            'showKetua'   => $cuti->status === 'disetujui',
            'showUserTTD' => true,
        ]);
    }

    /**
     * Print surat izin
     */
    public function print_suratizin($id)
    {
        $cuti   = Pengajuan_Cuti::findOrFail($id);
        $user   = User::find($cuti->user_id);
        $ketua  = User::where('role', 'ketua')->first();

        return view('dashboard.cuti.print_suratizin', [
            'cuti' => $cuti,
            'user' => $user,
            'ketua' => $ketua,
            'showKetua' => is_null($cuti->current_approval_id),
        ]);
    }

    /**
     * Admin: lihat semua cuti
     */
    public function allpengajuan()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        return view('dashboard.cuti.get_all_cuti', [
            'cutis' => Pengajuan_Cuti::latest()->get(),
        ]);
    }

    /**
     * Form edit sisa cuti
     */
    public function editcuti($id)
    {
        return view('dashboard.cuti.edit_cuti', [
            'user' => User::findOrFail($id)
        ]);
    }

    /**
     * Update sisa cuti
     */
    public function updateCuti(Request $request, $id)
    {
        $request->validate([
            'sisa_cuti_tahunan' => 'required|integer|min:0',
            'sisa_cuti_sakit'   => 'required|integer|min:0',
        ]);

        User::findOrFail($id)->update($request->only([
            'sisa_cuti_tahunan',
            'sisa_cuti_sakit'
        ]));

        return back()->with('success', 'Sisa cuti berhasil diperbarui.');
    }

    /**
     * Admin: Set ketua pengganti
     */
    public function setKetuaPengganti(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $request->validate(['user_id' => 'required|exists:users,id']);

        User::where('is_ketua_pengganti', true)->update(['is_ketua_pengganti' => false]);
        User::find($request->user_id)->update(['is_ketua_pengganti' => true]);

        return back()->with('success', 'Ketua pengganti diperbarui.');
    }

    /**
     * Admin: Set PLH Panitera
     */
    public function setPlhPanitera(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $request->validate(['user_id' => 'required|exists:users,id']);

        User::where('is_plh_panitera', true)->update(['is_plh_panitera' => false]);
        User::find($request->user_id)->update(['is_plh_panitera' => true]);

        return back()->with('success', 'PLH Panitera diperbarui.');
    }

    /**
     * Admin: Set PLH Sekretaris
     */
    public function setPlhSekretaris(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $request->validate(['user_id' => 'required|exists:users,id']);

        User::where('is_plh_sekretaris', true)->update(['is_plh_sekretaris' => false]);
        User::find($request->user_id)->update(['is_plh_sekretaris' => true]);

        return back()->with('success', 'PLH Sekretaris diperbarui.');
    }

    /**
     * Form ketua pengganti
     */
    public function formKetuaPengganti()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        return view('dashboard.cuti.ketua_pengganti', [
            'users' => User::where('role', '!=', 'admin')->get()
        ]);
    }

    /**
     * Export all cuti
     */
    public function export()
    {
        return Excel::download(new PengajuanCutiExport, 'pengajuan_cuti.xlsx');
    }

    /**
     * Export cuti by user
     */
    public function exportByUser($user_id)
    {
        $user = User::find($user_id);
        if (!$user) return back()->with('error', 'User tidak ditemukan.');

        $cutis = Pengajuan_Cuti::where('user_id', $user_id)->get();
        if ($cutis->isEmpty()) return back()->with('error', 'User belum memiliki data cuti.');

        return Excel::download(
            new PengajuanCutiExport($cutis),
            'pengajuan_cuti_' . str_replace(' ', '_', strtolower($user->name)) . '.xlsx'
        );
    }
}
