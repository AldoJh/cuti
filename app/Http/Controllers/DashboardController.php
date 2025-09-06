<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan_Cuti;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tahunIni = Carbon::now()->year;

        // ===== Hitung total cuti tahunan yang sudah diambil tahun ini =====
        $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'tahunan')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        // Ambil sisa cuti tahun sebelumnya (maks 6 hari jika tidak ditangguhkan)
        $sisaCutiLalu = $user->sisa_cuti_tahun_lalu ?? 0;
        $sisaCutiLalu = min($sisaCutiLalu, 6); // bisa 24 jika ditangguhkan

        $kuotaTahunan = 12 + $sisaCutiLalu;
        $sisaCutiTahunan = max($kuotaTahunan - $totalTahunan, 0);

        // ===== Hitung total cuti sakit yang sudah diambil tahun ini =====
        $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'sakit')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $kuotaSakit = 14; // cuti sakit biasa
        $sisaCutiSakit = max($kuotaSakit - $totalSakit, 0);

        return view('dashboard.index', compact('user', 'sisaCutiTahunan', 'sisaCutiSakit'));
    }

    public function all_cuti()
{
    // Ambil semua user yang bukan admin atau ketua (pegawai/PPNPN)
    $users = \App\Models\User::whereIn('role', ['pegawai', 'ppnpn', 'atasan', 'hakim', 'panitera', 'panmud', 'panitera_pengganti', 'sekretaris', 'kasubbag', 'ketua'])
                ->get();

    $tahunIni = \Carbon\Carbon::now()->year;
    $cutiData = [];

    foreach ($users as $user) {
        // Total cuti tahunan yang sudah diambil tahun ini
        $totalTahunan = \App\Models\Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'tahunan')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(\DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $sisaCutiLalu = $user->sisa_cuti_tahun_lalu ?? 0;
        $sisaCutiLalu = min($sisaCutiLalu, 6); // 6 jika tidak ditangguhkan, 24 jika ditangguhkan

        $kuotaTahunan = 12 + $sisaCutiLalu;
        $sisaCutiTahunan = max($kuotaTahunan - $totalTahunan, 0);

        // Total cuti sakit yang sudah diambil tahun ini
        $totalSakit = \App\Models\Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'sakit')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(\DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $kuotaSakit = 14;
        $sisaCutiSakit = max($kuotaSakit - $totalSakit, 0);

        $cutiData[] = [
            'user' => $user,
            'sisa_cuti_tahunan' => $sisaCutiTahunan,
            'sisa_cuti_sakit' => $sisaCutiSakit,
        ];
    }

    return view('dashboard.all_cuti', compact('cutiData'));
}

}
