<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan_Cuti;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function store_user(request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'role' => 'required|in:admin,ketua,hakim,panitera,panmud,panitera_pengganti,sekretaris,kasubbag,pegawai',
            'atasan_id' => 'nullable|exists:users,id',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'unit_kerja' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'golongan' => 'nullable|string|max:10',
            'tanggal_masuk' => 'nullable|date',
        ]);
    
        $ttdPath = null;
        if ($request->hasFile('ttd')) {
            $ttdPath = $request->file('ttd')->store('ttd', 'public');
        }
    
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->role,
            'role' => $request->role,
            'atasan_id' => $request->atasan_id,
            'sisa_cuti_tahun_lalu' => 0,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ttd_path' => $ttdPath,
            'unit_kerja' => $request->unit_kerja,
            'no_telp' => $request->no_telp,
            'golongan' => $request->golongan,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);
    
        return redirect()->back()->with('success', 'User berhasil dibuat!');    
    }

    public function create_user()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }else{
            $users = User::where('role', '!=', 'admin')->get();
            // dd($users);
            return view('dashboard.create_user', compact('users') );
        }
    }

    public function getalluser()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }else{
            $users = User::all();
            return view('dashboard.all_user', compact('users') );
        }
        
    }

}
