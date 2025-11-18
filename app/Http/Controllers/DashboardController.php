<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan_Cuti;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Halaman dashboard user
    public function index()
    {
        $user = Auth::user();
        $tahunIni = Carbon::now()->year;

        // Hitung total cuti tahunan yang sudah diambil tahun ini
        $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'tahunan')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $kuotaTahunan = $user->sisa_cuti_tahunan ?? 12; // ambil dari user atau default 12
        $sisaCutiTahunan = max($kuotaTahunan - $totalTahunan, 0);

        // Hitung total cuti sakit yang sudah diambil tahun ini
        $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'sakit')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $kuotaSakit = $user->sisa_cuti_sakit ?? 14; // ambil dari user atau default 14
        $sisaCutiSakit = max($kuotaSakit - $totalSakit, 0);

        return view('dashboard.index', compact('user', 'sisaCutiTahunan', 'sisaCutiSakit'));
    }

    // Halaman semua cuti
    public function all_cuti()
    {
        $users = User::whereIn('role', [
            'pegawai','ppnpn','atasan','hakim','panitera','panmud','panitera_pengganti','sekretaris','kasubbag','ketua'
        ])->get();

        $tahunIni = Carbon::now()->year;
        $cutiData = [];

        foreach ($users as $user) {
            $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'tahunan')
                ->whereYear('tanggal_mulai', $tahunIni)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

            $kuotaTahunan = $user->sisa_cuti_tahunan ?? 12;
            $sisaCutiTahunan = max($kuotaTahunan - $totalTahunan, 0);

            $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', 'sakit')
                ->whereYear('tanggal_mulai', $tahunIni)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

            $kuotaSakit = $user->sisa_cuti_sakit ?? 14;
            $sisaCutiSakit = max($kuotaSakit - $totalSakit, 0);

            $cutiData[] = [
                'user' => $user,
                'sisa_cuti_tahunan' => $sisaCutiTahunan,
                'sisa_cuti_sakit' => $sisaCutiSakit,
            ];
        }

        return view('dashboard.all_cuti', compact('cutiData'));
    }

    // Halaman create user
    public function create_user()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $users = User::where('role', '!=', 'admin')->get();
        return view('dashboard.create_user', compact('users'));
    }

    // Store user baru
    public function store_user(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'nip'                  => 'nullable|string|max:50',
            'jabatan'              => 'nullable|string|max:100',
            'role'                 => 'required|in:admin,ketua,wakil_ketua,hakim,panitera,panmud,panitera_pengganti,sekretaris,kasubbag,pegawai,ppnpn',
            'atasan_id'            => 'nullable|exists:users,id',
            'email'                => 'required|string|email|max:255|unique:users',
            'password'             => 'required|string|min:6|confirmed',
            'ttd'                  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'unit_kerja'           => 'nullable|string|max:100',
            'no_telp'              => 'nullable|string|max:20',
            'golongan'             => 'nullable|string|max:50',
            'tanggal_masuk'        => 'nullable|date',
            'sisa_cuti_tahunan'    => 'nullable|integer|min:0',
            'sisa_cuti_sakit'      => 'nullable|integer|min:0',
        ]);

        $ttdPath = $request->hasFile('ttd') ? $request->file('ttd')->store('ttd', 'public') : null;

        $user = User::create([
            'name'                 => $request->name,
            'nip'                  => $request->nip,
            'jabatan'              => $request->jabatan,
            'role'                 => $request->role,
            'atasan_id'            => $request->atasan_id,
            'email'                => $request->email,
            'password'             => Hash::make($request->password),
            'ttd_path'             => $ttdPath,
            'unit_kerja'           => $request->unit_kerja,
            'no_telp'              => $request->no_telp,
            'golongan'             => $request->golongan,
            'tanggal_masuk'        => $request->tanggal_masuk,
            'sisa_cuti_tahunan'    => $request->sisa_cuti_tahunan ?? 12,
            'sisa_cuti_sakit'      => $request->sisa_cuti_sakit ?? 14,
        ]);

        return redirect()->back()->with('success', 'User berhasil dibuat!');
    }

    // Halaman semua user
    public function getalluser()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $users = User::all();
        return view('dashboard.all_user', compact('users'));
    }

    // Edit user
    public function edit_user($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $editUser = User::findOrFail($id);
        $users = User::where('role', '!=', 'admin')->get();
        return view('dashboard.cuti.edit_user', compact('editUser', 'users'));
    }

    // Update user
    public function update_user(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'nip'           => 'nullable|string|max:50',
            'jabatan'       => 'required|string|max:100',
            'role'          => 'required|string',
            'atasan_id'     => 'nullable|exists:users,id',
            'unit_kerja'    => 'nullable|string|max:100',
            'no_telp'       => 'nullable|string|max:20',
            'golongan'      => 'nullable|string|max:50',
            'tanggal_masuk' => 'nullable|date',
            'email'         => 'required|email|unique:users,email,' . $id,
            'ttd'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'        => 'required|in:0,1',
            'sisa_cuti_tahunan' => 'nullable|integer|min:0',
            'sisa_cuti_sakit'   => 'nullable|integer|min:0',
        ]);

        $editUser = User::findOrFail($id);

        $editUser->name               = $request->name;
        $editUser->nip                = $request->nip;
        $editUser->jabatan            = $request->jabatan;
        $editUser->role               = $request->role;
        $editUser->atasan_id          = $request->atasan_id;
        $editUser->unit_kerja         = $request->unit_kerja;
        $editUser->no_telp            = $request->no_telp;
        $editUser->golongan           = $request->golongan;
        $editUser->tanggal_masuk      = $request->tanggal_masuk;
        $editUser->email              = $request->email;
        $editUser->status             = $request->status;
        $editUser->sisa_cuti_tahunan  = $request->sisa_cuti_tahunan ?? $editUser->sisa_cuti_tahunan;
        $editUser->sisa_cuti_sakit    = $request->sisa_cuti_sakit ?? $editUser->sisa_cuti_sakit;

        if ($request->hasFile('ttd')) {
            $editUser->ttd_path = $request->file('ttd')->store('ttd', 'public');
        }

        $editUser->save();

        return redirect()->route('edit-user', $id)->with('success', 'Data user berhasil diperbarui.');
    }

    // Update password user
    public function update_user_password(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses fitur ini.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $editUser = User::findOrFail($id);
        $editUser->password = Hash::make($request->password);
        $editUser->save();

        return redirect()->route('edit-user', $id)->with('password_success', 'Password berhasil diperbarui.');
    }
}
