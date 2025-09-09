@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar User</h1>
            <p class="text-sm text-gray-500">Informasi detail user dan role pegawai</p>
        </div>
        <a href="{{ route('create-user') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah User
        </a>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="px-3 py-3 text-center font-semibold">#</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold">NIP</th>
                    <th class="px-4 py-3 text-left font-semibold">Jabatan</th>
                    <th class="px-4 py-3 text-center font-semibold">Role</th>
                    <th class="px-4 py-3 text-left font-semibold">Atasan</th>
                    <th class="px-4 py-3 text-left font-semibold">Email</th>
                    <th class="px-4 py-3 text-center font-semibold">TTD</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $key => $u)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-3 py-2 text-center font-semibold">{{ $key+1 }}</td>
                    <td class="px-4 py-2 font-medium text-gray-700">{{ $u->name }}</td>
                    <td class="px-4 py-2">{{ $u->nip ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $u->jabatan ?? '-' }}</td>
                    <td class="px-4 py-2 text-center capitalize">{{ $u->role }}</td>
                    <td class="px-4 py-2">{{ $u->atasan?->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $u->email }}</td>
                    <td class="px-4 py-2 text-center">
                        @if($u->ttd_path)
                            <img src="{{ asset('storage/'.$u->ttd_path) }}" alt="TTD" class="h-10 mx-auto rounded shadow">
                        @else
                            <span class="text-gray-400 italic">Belum ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center px-4 py-4 text-gray-500">Tidak ada user ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
