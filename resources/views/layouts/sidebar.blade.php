@php
use App\Models\pengajuan_cuti;

$rolesAtasan = ['panitera', 'sekretaris', 'ketua', 'hakim'];
$rolesAdmin = ['admin', 'superadmin'];
$currentRoute = Route::currentRouteName();

$notifPengajuan = 0;

if (in_array(auth()->user()->role, $rolesAtasan)) {
    if (auth()->user()->role === 'ketua') {
        // Ketua: ambil semua pengajuan yang sudah disetujui atasan
        $notifPengajuan = pengajuan_cuti::where('status', 'disetujui_atasan')->count();
    } else {
        // Panitera & Sekretaris: status diajukan dari bawahannya
        $notifPengajuan = pengajuan_cuti::where('status', 'diajukan')
            ->whereHas('user', function ($q) {
                $q->where('atasan_id', auth()->id());
            })
            ->count();
    }
}
@endphp

<!-- Tambahin animasi shake -->
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
        animation: smooth-shake 1s ease-in-out infinite;
        animation-play-state: running;
        animation-delay: 0s;
        animation-iteration-count: infinite;
        animation-direction: normal;
    }

    .notif-badge {
        animation-duration: 2s;
    }
</style>

<!-- Overlay untuk mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 hidden z-40 lg:hidden"></div>

<!-- Sidebar -->
<div id="sidebar"
     class="bg-[#941824] shadow-lg min-h-screen fixed lg:static left-0 top-0 w-64 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50 flex flex-col">
    
    <!-- Logo & Title -->
    <div class="flex flex-col items-center p-6 border-b border-red-900">
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-16 mb-2">
        <h1 class="text-white font-bold text-lg tracking-wide">WEB-CUTI | PN</h1>
    </div>

    <!-- User Info -->
    <div class="flex items-center space-x-3 px-6 py-4 border-b border-red-900">
        <div class="bg-red-900 text-white rounded-full w-10 h-10 flex items-center justify-center font-semibold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <p class="text-white font-medium">{{ auth()->user()->name }}</p>
            <p class="text-red-200 text-xs capitalize">{{ auth()->user()->role }}</p>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="mt-4 space-y-1 px-4 flex-1">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-2 rounded-md transition duration-200
               {{ $currentRoute == 'dashboard' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                <i class="fas fa-home mr-3"></i> Dashboard
            </a>
        </li>

        <!-- Menu untuk User Biasa -->
        @if(!in_array(auth()->user()->role, $rolesAdmin))
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

        <!-- Menu untuk Atasan -->
        @if(in_array(auth()->user()->role, $rolesAtasan))
            <li>
                <a href="{{ route('cuti.pengajuan', auth()->id()) }}"
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

        <!-- Menu untuk Admin -->
        @if(in_array(auth()->user()->role, $rolesAdmin))
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
                    <i class="fas fa-clipboard-list mr-3"></i> Ganti Ketua
                </a>
            </li>
        @endif
    </ul>
</div>
