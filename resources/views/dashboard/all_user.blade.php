@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="bg-gradient-to-b from-orange-500 to-red-900 rounded-xl shadow-lg p-6 mb-6 flex items-center justify-between transition hover:scale-[1.01] hover:shadow-xl">
        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">Daftar User</h1>
            <p class="text-sm text-red-100">Informasi detail user dan role pegawai</p>
        </div>
        <a href="{{ route('create-user') }}"
            class="px-5 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-700 text-white font-semibold shadow-md hover:shadow-lg transition hover:scale-[1.03]">
            + Tambah User
        </a>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
            <thead class="bg-gradient-to-r from-orange-500 to-red-900 text-white">
                <tr>
                    <th class="px-3 py-3 text-center font-semibold w-[50px]">No</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[220px]">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[130px]">NIP</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[200px]">Jabatan</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[120px]">Role</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[220px]">Atasan</th>
                    <th class="px-4 py-3 text-left font-semibold min-w-[220px]">Email</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[150px]">Sisa Cuti Tahunan</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[140px]">Sisa Cuti Sakit</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[120px]">Status</th>
                    <th class="px-4 py-3 text-center font-semibold min-w-[200px]">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($users as $key => $u)
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-3 py-2 text-center font-semibold">{{ $key + 1 }}</td>
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $u->name }}</td>
                    <td class="px-4 py-2">{{ $u->nip ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $u->jabatan ?? '-' }}</td>
                    <td class="px-4 py-2 text-center capitalize text-gray-700">{{ $u->role }}</td>
                    <td class="px-4 py-2">{{ $u->atasan?->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $u->email }}</td>

                    <td class="px-4 py-2 text-center text-green-600 font-semibold">{{ $u->sisa_cuti_tahunan ?? 0 }} hari</td>
                    <td class="px-4 py-2 text-center text-blue-600 font-semibold">{{ $u->sisa_cuti_sakit ?? 0 }} hari</td>

                    <td class="px-4 py-2 text-center">
                        @if($u->status == 1)
                            <span class="px-3 py-1 text-sm rounded-lg bg-green-100 text-green-700 font-medium shadow">Aktif</span>
                        @else
                            <span class="px-3 py-1 text-sm rounded-lg bg-red-100 text-red-700 font-medium shadow">Non Aktif</span>
                        @endif
                    </td>

                    <td class="px-4 py-2 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('cuti.edit', $u->id) }}"
                                class="px-3 py-1 text-sm font-medium text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition">
                                Edit Cuti
                            </a>
                            <a href="{{ route('edit-user', $u->id) }}"
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                                Edit User
                            </a>
                            <a href="{{ route('edit-user-password', $u->id) }}"
                                class="px-3 py-1 text-sm font-medium text-white bg-yellow-500 rounded-lg shadow hover:bg-yellow-600 transition">
                                Edit Password
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center px-4 py-6 text-gray-500">Tidak ada user ditemukan</td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection
