@php
$rolesAtasan = ['panitera',  'sekretaris', 'ketua'];
$rolesAdmin = ['admin', 'superadmin'];
$currentRoute = Route::currentRouteName();
@endphp

<div class="w-64 bg-gray-50 shadow-md min-h-screen hidden md:block">
    <div class="p-6 font-bold text-xl border-b border-gray-200 text-blue-600">
        Cuti Online
    </div>
    <ul class="mt-4 space-y-1">
        <li>
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                {{ $currentRoute == 'dashboard' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                <i class="fas fa-home mr-3 text-gray-500"></i>
                <span class="text-gray-700">Dashboard</span>
            </a>
        </li>

        @if(!in_array(auth()->user()->role, $rolesAdmin))
            <li>
                <a href="{{ route('cuti.create') }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'cuti.create' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                    <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                    <span class="text-gray-700">Pengajuan Cuti</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cuti.index') }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'cuti.index' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                    <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                    <span class="text-gray-700">Lihat Pengajuan</span>
                </a>
            </li>
        @endif

        @if(in_array(auth()->user()->role, $rolesAtasan))
            <li>
                <a href="{{ route('cuti.pengajuan', auth()->id()) }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'cuti.pengajuan' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                    <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                    <span class="text-gray-700">Pengajuan Masuk</span>
                </a>
            </li>
        @endif

        @if(in_array(auth()->user()->role, $rolesAdmin))
            <li>
                <a href="{{ route('all_cuti') }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'all_cuti' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                    <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                    <span class="text-gray-700">Semua Sisa Cuti</span>
                </a>
            </li>
            <li>
                <a href="{{ route('create-user') }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'create-user' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                    <i class="fas fa-user-plus mr-3 text-gray-500"></i>
                    <span class="text-gray-700">Buat Akun</span>
                </a>
            </li>
            <li>
                <a href="{{ route('get-all-user') }}" class="flex items-center px-4 sm:px-6 py-2 rounded-md transition duration-200
                    {{ $currentRoute == 'get-all-user' ? 'bg-blue-100 font-semibold' : 'hover:bg-blue-50' }}">
                    <i class="fas fa-users mr-3 text-gray-500"></i>
                    <span class="text-gray-700">Data User</span>
                </a>
            </li>
        @endif
    </ul>
</div>
