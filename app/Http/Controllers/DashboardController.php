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
    public function index()
    {
        $user = Auth::user();
        $tahunIni = Carbon::now()->year;

        // ==========================================
        // Helper untuk menghitung hari cuti yang terpakai (untuk ditampilkan)
        // ==========================================
        $hitungHari = function ($jenis) use ($user, $tahunIni) {
            return Pengajuan_Cuti::where('user_id', $user->id)
                ->where('jenis_cuti', $jenis)
                ->where('status', 'disetujui')
                ->whereYear('tanggal_mulai', $tahunIni)
                ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));
        };

        // ==========================================
        // CUTI TAHUNAN – Sisa diambil langsung dari database
        // ==========================================
        $hariTahunanTerpakai = $hitungHari('tahunan');
        $sisaCutiTahunan = $user->sisa_cuti_tahunan; // SUDAH DIPOTONG OLEH LISTENER

        // ==========================================
        // CUTI SAKIT
        // ==========================================
        $hariSakitTerpakai = $hitungHari('sakit');
        $sisaCutiSakit = $user->sisa_cuti_sakit;

        // ==========================================
        // CUTI TAMBAHAN: Alasan Penting, Besar, Melahirkan, CLTN
        // ==========================================
        $jenisCutiTambahan = [
            'alasan_penting',
            'besar',
            'melahirkan',
            'cltn',
        ];

        $cutiData = [];

        foreach ($jenisCutiTambahan as $jenis) {
            $hariDipakai = $hitungHari($jenis);

            $cutiData[$jenis] = [
                'pengajuan' => Pengajuan_Cuti::where('user_id', $user->id)
                    ->where('jenis_cuti', $jenis)
                    ->where('status', 'disetujui')
                    ->count(),

                'hari_dipakai' => $hariDipakai,

                // sisa kuota dari database (SUDAH DI KURANGI LISTENER)
                'sisa' => $user->{"sisa_cuti_$jenis"},
            ];
        }

        return view('dashboard.index', compact(
            'user',
            'sisaCutiTahunan',
            'sisaCutiSakit',
            'cutiData'
        ));
    }

    // ==================================================================
    // HALAMAN SEMUA CUTI (Admin melihat semua user)
    // ==================================================================
    public function all_cuti()
    {
        $users = User::whereIn('role', [
            'bakti','outsourcing','p3k','pelaksana','atasan','hakim','panitera','panmud','panitera_pengganti','sekretaris','kasubbag','wakil_ketua','ketua'
        ])->get();

        $cutiData = [];

        foreach ($users as $user) {
            $cutiData[] = [
                'user' => $user,
                'sisa_cuti_tahunan' => $user->sisa_cuti_tahunan,
                'sisa_cuti_sakit' => $user->sisa_cuti_sakit,
                'sisa_cuti_alasan_penting' => $user->sisa_cuti_alasan_penting ?? 0,
                'sisa_cuti_besar'          => $user->sisa_cuti_besar ?? 0,
                'sisa_cuti_melahirkan'     => $user->sisa_cuti_melahirkan ?? 0,
                'sisa_cuti_cltn'           => $user->sisa_cuti_cltn ?? 0,
            ];
        }

        return view('dashboard.all_cuti', compact('cutiData'));
    }

    // ==================================================================
    // Halaman create user
    // ==================================================================
    public function create_user()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $users = User::where('role', '!=', 'admin')->get();
        return view('dashboard.create_user', compact('users'));
    }

    // ==================================================================
    // Store user baru
    // ==================================================================
    public function store_user(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string|max:255',
            'nip'                  => 'nullable|string|max:50',
            'jabatan'              => 'nullable|string|max:100',
            'role'                 => 'required|in:admin,ketua,wakil_ketua,hakim,panitera,panmud,panitera_pengganti,sekretaris,kasubbag,pelaksana,p3k,outsourcing,bakti',
            'atasan_id'            => 'nullable|exists:users,id',
            'email'                => 'required|string|email|max:255|unique:users',
            'password'             => 'required|string|min:6|confirmed',

            'ttd'                  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',

            'unit_kerja'           => 'nullable|string|max:100',
            'no_telp'              => 'nullable|string|max:20',
            'golongan'             => 'nullable|string|max:50',
            'tanggal_masuk'        => 'nullable|date',

            // CUTI
            'sisa_cuti_tahunan'        => 'nullable|integer|min:0',
            'sisa_cuti_sakit'          => 'nullable|integer|min:0',
            'sisa_cuti_alasan_penting' => 'nullable|integer|min:0',
            'sisa_cuti_besar'          => 'nullable|integer|min:0',
            'sisa_cuti_melahirkan'     => 'nullable|integer|min:0',
            'sisa_cuti_cltn'           => 'nullable|integer|min:0',
        ]);

        $ttdPath = $request->hasFile('ttd')
            ? $request->file('ttd')->store('ttd', 'public')
            : null;

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

            // Default cuti
            'sisa_cuti_tahunan'        => $request->sisa_cuti_tahunan ?? 12,
            'sisa_cuti_sakit'          => $request->sisa_cuti_sakit ?? 14,
            'sisa_cuti_alasan_penting' => $request->sisa_cuti_alasan_penting ?? 30,
            'sisa_cuti_besar'          => $request->sisa_cuti_besar ?? 90,
            'sisa_cuti_melahirkan'     => $request->sisa_cuti_melahirkan ?? 90,
            'sisa_cuti_cltn'           => $request->sisa_cuti_cltn ?? 36,
        ]);

        return redirect()->back()->with('success', 'User berhasil dibuat!');
    }

    // ==================================================================
    // Halaman semua user
    // ==================================================================
    public function getalluser()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $users = User::all();
        return view('dashboard.all_user', compact('users'));
    }

    // ==================================================================
    // Edit user
    // ==================================================================
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

    // ==================================================================
    // Update user
    // ==================================================================
    public function update_user(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses fitur ini.');
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

    // ==================================================================
    // Update password user
    // ==================================================================
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

