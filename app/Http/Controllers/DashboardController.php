<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan_Cuti;
use App\Models\User;
use App\Models\BackupCutiTahunan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Dashboard user
    public function index()
    {
        $user = Auth::user();
        $tahunIni = Carbon::now()->year;

        // Hitung cuti tahunan
        $totalTahunan = Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'tahunan')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $sisaCutiLalu = $user->sisa_cuti_tahun_lalu ?? 0;
        $sisaCutiLalu = min($sisaCutiLalu, 6); // maksimal 6 hari
        $kuotaTahunan = 12 + $sisaCutiLalu;
        $sisaCutiTahunan = max($kuotaTahunan - $totalTahunan, 0);

        // Hitung cuti sakit
        $totalSakit = Pengajuan_Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'sakit')
            ->whereYear('tanggal_mulai', $tahunIni)
            ->sum(DB::raw('DATEDIFF(tanggal_selesai, tanggal_mulai) + 1'));

        $kuotaSakit = 14;
        $sisaCutiSakit = max($kuotaSakit - $totalSakit, 0);

        return view('dashboard.index', compact('user', 'sisaCutiTahunan', 'sisaCutiSakit'));
    }

    // Semua cuti user dengan filter tahun & bulan
    public function all_cuti(Request $request)
    {
        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan'); // optional

        // Ambil semua user yang relevan
        $users = User::whereIn('role', [
            'pegawai','ppnpn','atasan','hakim','panitera','panmud',
            'panitera_pengganti','sekretaris','kasubbag','ketua'
        ])->with(['pengajuanCuti' => function($q) use ($tahun, $bulan) {
            $q->when($tahun, fn($q) => $q->whereYear('tanggal_mulai', $tahun))
              ->when($bulan, fn($q) => $q->whereMonth('tanggal_mulai', $bulan));
        }])->get();

        // Siapkan data cuti
        $cutiData = $users->map(function($user) use ($tahun) {
            $backup = BackupCutiTahunan::where('user_id', $user->id)
                        ->where('tahun', $tahun)
                        ->first();

            return [
                'user' => $user,
                'sisa_cuti_tahunan' => $backup?->sisa_cuti_tahunan ?? 0,
                'sisa_cuti_sakit' => $backup?->sisa_cuti_sakit ?? 0,
            ];
        });

        return view('dashboard.all_cuti', compact('cutiData', 'tahun', 'bulan'));
    }

    // ===== CRUD USER =====
    public function create_user()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }
        $users = User::where('role', '!=', 'admin')->get();
        return view('dashboard.create_user', compact('users'));
    }

    public function store_user(Request $request)
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
            'golongan' => 'nullable|string|max:50',
            'tanggal_masuk' => 'nullable|date',
        ]);

        $ttdPath = $request->hasFile('ttd') ? $request->file('ttd')->store('ttd', 'public') : null;

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
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

    public function getalluser()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }
        $users = User::all();
        return view('dashboard.all_user', compact('users'));
    }

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

    public function update_user(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:100',
            'role' => 'required|string',
            'atasan_id' => 'nullable|exists:users,id',
            'unit_kerja' => 'nullable|string|max:100',
            'no_telp' => 'nullable|string|max:20',
            'golongan' => 'nullable|string|max:50',
            'tanggal_masuk' => 'nullable|date',
            'email' => 'required|email|unique:users,email,' . $id,
            'ttd' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:0,1',
        ]);

        $editUser = User::findOrFail($id);

        $editUser->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'role' => $request->role,
            'atasan_id' => $request->atasan_id,
            'unit_kerja' => $request->unit_kerja,
            'no_telp' => $request->no_telp,
            'golongan' => $request->golongan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'email' => $request->email,
            'status' => $request->status,
            'ttd_path' => $request->hasFile('ttd') ? $request->file('ttd')->store('ttd', 'public') : $editUser->ttd_path,
        ]);

        return redirect()->route('edit-user', $id)->with('success', 'Data user berhasil diperbarui.');
    }

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
