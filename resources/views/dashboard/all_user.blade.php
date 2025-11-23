@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-orange-600 to-red-700 rounded-xl shadow-lg p-5 md:p-6 mb-6 
                flex items-center justify-between">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-white drop-shadow">
                Daftar User
            </h1>
            <p class="text-xs md:text-sm text-orange-100">
                Kelola data user, jabatan, role, dan status akun
            </p>
        </div>

        <a href="{{ route('create-user') }}"
           class="px-4 md:px-5 py-2 rounded-lg bg-white text-orange-700 font-semibold 
                  shadow-md hover:bg-orange-50 transition text-sm md:text-base">
            + Tambah User
        </a>
    </div>

    {{-- ============ DESKTOP MODE ============ --}}
    <div class="hidden md:block relative overflow-x-auto overflow-y-auto bg-white rounded-xl shadow-lg border border-gray-200"
         style="max-height: 75vh;">

        <table class="min-w-full text-sm">

            {{-- HEADER --}}
            <thead class="bg-gradient-to-r from-orange-600 to-red-700 text-white sticky top-0 z-20">
                <tr>
                    <th class="px-4 py-3 text-center font-semibold w-[150px] sticky left-0 
                               bg-gradient-to-r from-orange-600 to-red-700 z-30">
                        Aksi
                    </th>
                    <th class="px-3 py-3 text-center font-semibold w-[60px]">No</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[220px]">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[150px]">NIP</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[200px]">Jabatan</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[120px]">Role</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[200px]">Atasan</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[220px]">Email</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[120px]">Status</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y divide-gray-200">

                @forelse($users as $key => $u)
                <tr class="hover:bg-orange-50 transition">

                    {{-- Sticky Aksi --}}
                    <td class="px-4 py-3 sticky left-0 bg-white z-10 border-r border-gray-200">
                        <div class="flex flex-col space-y-1">
                            <a href="{{ route('cuti.edit', $u->id) }}"
                                class="px-3 py-1 text-xs text-white bg-green-600 rounded shadow hover:bg-green-700 text-center">
                                Edit Cuti
                            </a>
                            <a href="{{ route('edit-user', $u->id) }}"
                                class="px-3 py-1 text-xs text-white bg-blue-600 rounded shadow hover:bg-blue-700 text-center">
                                Edit User
                            </a>
                            <a href="{{ route('edit-user-password', $u->id) }}"
                                class="px-3 py-1 text-xs text-white bg-yellow-500 rounded shadow hover:bg-yellow-600 text-center">
                                Edit Password
                            </a>
                        </div>
                    </td>

                    <td class="px-3 py-3 text-center font-semibold">{{ $key + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $u->name }}</td>
                    <td class="px-4 py-3">{{ $u->nip ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $u->jabatan ?? '-' }}</td>
                    <td class="px-4 py-3 text-center capitalize text-gray-700">{{ $u->role }}</td>
                    <td class="px-4 py-3">{{ $u->atasan?->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $u->email }}</td>

                    <td class="px-4 py-3 text-center">
                        @if($u->status == 1)
                            <span class="px-3 py-1 text-sm rounded-lg bg-green-100 text-green-700 font-medium shadow">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm rounded-lg bg-red-100 text-red-700 font-medium shadow">
                                Non Aktif
                            </span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center px-4 py-6 text-gray-500">
                        Tidak ada user ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>




    {{-- ============ MOBILE MODE ============ --}}
    <div class="md:hidden space-y-4 mt-4">

        @forelse($users as $key => $u)
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4">

            {{-- Nama --}}
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-bold text-gray-900">{{ $u->name }}</h2>

                @if($u->status == 1)
                    <span class="px-2 py-1 text-xs rounded-lg bg-green-100 text-green-700 font-medium shadow">
                        Aktif
                    </span>
                @else
                    <span class="px-2 py-1 text-xs rounded-lg bg-red-100 text-red-700 font-medium shadow">
                        Non Aktif
                    </span>
                @endif
            </div>

            {{-- Informasi --}}
            <div class="text-sm text-gray-700 space-y-1 mb-4">
                <p><span class="font-semibold">NIP:</span> {{ $u->nip ?? '-' }}</p>
                <p><span class="font-semibold">Jabatan:</span> {{ $u->jabatan ?? '-' }}</p>
                <p><span class="font-semibold">Role:</span> {{ $u->role }}</p>
                <p><span class="font-semibold">Atasan:</span> {{ $u->atasan?->name ?? '-' }}</p>
                <p><span class="font-semibold">Email:</span> {{ $u->email }}</p>
            </div>

            {{-- Aksi --}}
            <div class="grid grid-cols-1 gap-2 text-center">

                <a href="{{ route('cuti.edit', $u->id) }}"
                   class="w-full px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium shadow hover:bg-green-700">
                    Edit Cuti
                </a>

                <a href="{{ route('edit-user', $u->id) }}"
                   class="w-full px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium shadow hover:bg-blue-700">
                    Edit User
                </a>

                <a href="{{ route('edit-user-password', $u->id) }}"
                   class="w-full px-4 py-2 rounded-lg bg-yellow-500 text-white text-sm font-medium shadow hover:bg-yellow-600">
                    Edit Password
                </a>

            </div>

        </div>
        @empty
        <p class="text-center text-gray-500 py-6">Tidak ada user ditemukan</p>
        @endforelse

    </div>

</div>
@endsection
