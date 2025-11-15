@php
use App\Models\Pengajuan_Cuti;

$rolesAtasan = ['panitera', 'sekretaris', 'ketua', 'hakim'];
$rolesAdmin = ['admin', 'superadmin'];
$currentRoute = Route::currentRouteName();

$user = auth()->user();

// 🔹 Anggap PLH & Ketua Pengganti juga sebagai "atasan"
$isAtasan = in_array($user->role, $rolesAtasan)
    || $user->is_plh_panitera
    || $user->is_plh_sekretaris
    || $user->is_ketua_pengganti;

// 🔹 Hitungan notifikasi berdasarkan current_approval_id (siapa yang benar-benar harus approve)
$notifPengajuan = 0;
if ($isAtasan) {
    $notifPengajuan = Pengajuan_Cuti::where('current_approval_id', $user->id)
        ->whereIn('status', ['diajukan', 'disetujui_atasan'])
        ->count();
}
@endphp

<!-- 🔹 Animasi notifikasi -->
<style>
    @keyframes smooth-shake {
        0% { transform: translate(0, 0) rotate(0deg); }
        20% { transform: translate(-1px, 0) rotate(-3deg); }
        40% { transform: translate(2px, 0) rotate(3deg); }
        60% { transform: translate(-2px, 0) rotate(-3deg); }
        80% { transform: translate(1px, 0) rotate(3deg); }
        100% { transform: translate(0, 0) rotate(0deg); }
    }

    .notif-badge {
        animation: smooth-shake 2s ease-in-out infinite;
    }
</style>

<!-- Overlay untuk Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 hidden z-40 lg:hidden"></div>

<!-- 🔹 Sidebar -->
<div id="sidebar"
     class="bg-[#992103] shadow-lg min-h-screen fixed lg:static left-0 top-0 w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50 flex flex-col">

    <!-- Logo -->
    <div class="flex flex-col items-center p-6 border-b border-[#7a1a00]">
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-16 mb-2">
        <h1 class="text-white font-bold text-lg tracking-wide">SIM-C | PN</h1>
    </div>

    <!-- Info User -->
    <div class="flex items-center space-x-3 px-6 py-4 border-b border-[#7a1a00]">
        <div class="bg-[#7a1a00] text-white rounded-full w-10 h-10 flex items-center justify-center font-semibold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <p class="text-white font-medium">{{ $user->name }}</p>
            <p class="text-red-200 text-xs capitalize">
                {{ $user->role }}
                @if($user->is_plh_panitera)
                    (PLH Panitera)
                @elseif($user->is_plh_sekretaris)
                    (PLH Sekretaris)
                @elseif($user->is_ketua_pengganti)
                    (Ketua Pengganti)
                @endif
            </p>
        </div>
    </div>

    <!-- 🔹 Menu Sidebar -->
    <ul class="mt-4 space-y-1 px-4 flex-1">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-2 rounded-md transition duration-200
               {{ $currentRoute == 'dashboard' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                <i class="fas fa-home mr-3"></i> Dashboard
            </a>
        </li>

        <!-- 🔸 Menu User Biasa -->
        @if(!in_array($user->role, $rolesAdmin))
            <li>
                <a href="{{ route('cuti.create') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'cuti.create' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-file-signature mr-3"></i> Pengajuan Cuti
                </a>
            </li>
            <li>
                <a href="{{ route('cuti.index') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'cuti.index' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-folder-open mr-3"></i> Lihat Pengajuan
                </a>
            </li>
        @endif

        <!-- 🔸 Menu untuk Atasan, PLH, & Ketua Pengganti -->
        @if($isAtasan)
            <li>
                <a href="{{ route('cuti.pengajuan', $user->id) }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'cuti.pengajuan' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-inbox mr-3"></i> Pengajuan Masuk
                    @if($notifPengajuan > 0)
                        <span class="ml-auto bg-yellow-400 text-gray-800 text-xs font-bold px-2 py-0.5 rounded-full notif-badge">
                            {{ $notifPengajuan }}
                        </span>
                    @endif
                </a>
            </li>
        @endif

        <!-- 🔸 Menu untuk Admin -->
        @if(in_array($user->role, $rolesAdmin))
            <li>
                <a href="{{ route('all_cuti') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'all_cuti' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-calendar-check mr-3"></i> Semua Sisa Cuti
                </a>
            </li>
            <li>
                <a href="{{ route('create-user') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'create-user' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-user-plus mr-3"></i> Buat Akun
                </a>
            </li>
            <li>
                <a href="{{ route('get-all-user') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'get-all-user' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-users mr-3"></i> Data User
                </a>
            </li>
            <li>
                <a href="{{ route('cuti.all') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'cuti.all' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-clipboard-list mr-3"></i> Data Seluruh Pengajuan Cuti
                </a>
            </li>
            <li>
                <a href="{{ route('cuti.formKetuaPengganti') }}"
                   class="flex items-center px-4 py-2 rounded-md transition duration-200
                   {{ $currentRoute == 'cuti.formKetuaPengganti' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-user-shield mr-3"></i> PLH
                </a>
            </li>
        @endif
    </ul>
</div>
