<style>
    @keyframes smooth-shake {
        0% { transform: translate(0, 0) rotate(0deg); }
        20% { transform: translate(-1px, 0) rotate(-3deg); }
        40% { transform: translate(2px, 0) rotate(3deg); }
        60% { transform: translate(-2px, 0) rotate(-3deg); }
        80% { transform: translate(1px, 0) rotate(3deg); }
        100% { transform: translate(0, 0) rotate(0deg); }
    }

    .notif-badge-hamburger {
        animation: smooth-shake 2s ease-in-out infinite;
    }
</style>

<nav class="bg-gradient-to-r from-orange-600 to-red-800 text-white 
            flex justify-between items-center px-6 py-3 shadow
            fixed top-0 right-0 left-0 lg:left-64 z-40">
    <div class="flex items-center">
        <div class="relative">
            <button id="hamburger" class="lg:hidden focus:outline-none relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                @php
                use App\Models\Pengajuan_Cuti;

                $rolesAtasan = ['panitera', 'sekretaris', 'ketua', 'hakim'];
                $user = auth()->user();

                // 🔹 Anggap PLH & Ketua Pengganti juga sebagai "atasan"
                $isAtasan = in_array($user->role, $rolesAtasan)
                    || $user->is_plh_panitera
                    || $user->is_plh_sekretaris
                    || $user->is_ketua_pengganti;

                // 🔹 Hitungan notifikasi berdasarkan current_approval_id
                $notifPengajuan = 0;
                if ($isAtasan) {
                    $notifPengajuan = Pengajuan_Cuti::where('current_approval_id', $user->id)
                        ->whereIn('status', ['diajukan', 'disetujui_atasan'])
                        ->count();
                }
                @endphp

                @if($notifPengajuan > 0)
                    <span class="absolute -top-2 -right-2 bg-yellow-400 text-gray-800 text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center notif-badge-hamburger">
                        {{ $notifPengajuan }}
                    </span>
                @endif
            </button>
        </div>
        <span class="ml-2 font-semibold text-lg lg:hidden">Menu</span>
    </div>

    <div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm sm:text-base transition duration-200 flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</nav>
