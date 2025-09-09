@php
    $rolesAtasan = ['panitera', 'sekretaris', 'ketua'];
    $rolesAdmin = ['admin', 'superadmin'];
    $currentRoute = Route::currentRouteName();
@endphp

<div class="w-64 bg-[#941824] shadow-lg min-h-screen hidden md:flex flex-col">
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

        @if(!in_array(auth()->user()->role, $rolesAdmin))
            <!-- Pengajuan Cuti -->
            <li>
                <a href="{{ route('cuti.create') }}"
                    class="flex items-center px-4 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'cuti.create' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-file-signature mr-3"></i> Pengajuan Cuti
                </a>
            </li>
            <!-- Lihat Pengajuan -->
            <li>
                <a href="{{ route('cuti.index') }}"
                    class="flex items-center px-4 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'cuti.index' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-folder-open mr-3"></i> Lihat Pengajuan
                </a>
            </li>
        @endif

        @if(in_array(auth()->user()->role, $rolesAtasan))
            <!-- Pengajuan Masuk -->
            <li>
                <a href="{{ route('cuti.pengajuan', auth()->id()) }}"
                    class="flex items-center px-4 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'cuti.pengajuan' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-inbox mr-3"></i> Pengajuan Masuk
                </a>
            </li>
        @endif

        @if(in_array(auth()->user()->role, $rolesAdmin))
            <!-- Semua Sisa Cuti -->
            <li>
                <a href="{{ route('all_cuti') }}"
                    class="flex items-center px-4 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'all_cuti' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-calendar-check mr-3"></i> Semua Sisa Cuti
                </a>
            </li>
            <!-- Buat Akun -->
            <li>
                <a href="{{ route('create-user') }}"
                    class="flex items-center px-4 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'create-user' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-user-plus mr-3"></i> Buat Akun
                </a>
            </li>
            <!-- Data User -->
            <li>
                <a href="{{ route('get-all-user') }}"
                    class="flex items-center px-4 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'get-all-user' ? 'bg-red-700 font-semibold text-white' : 'text-red-100 hover:bg-red-800' }}">
                    <i class="fas fa-users mr-3"></i> Data User
                </a>
            </li>
        @endif
    </ul>
</div>
