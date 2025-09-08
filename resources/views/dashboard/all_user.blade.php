@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar User</h2>
        <a href="{{ route('create-user') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm transition">+ Tambah User</a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">#</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">NIP</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Jabatan</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Role</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Atasan</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">TTD</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $key => $u)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $key+1 }}</td>
                    <td class="px-4 py-2">{{ $u->name }}</td>
                    <td class="px-4 py-2">{{ $u->nip ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $u->jabatan ?? '-' }}</td>
                    <td class="px-4 py-2">{{ ucfirst($u->role) }}</td>
                    <td class="px-4 py-2">{{ $u->atasan?->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $u->email }}</td>
                    <td class="px-4 py-2">
                        @if($u->ttd_path)
                            <img src="{{ asset('storage/'.$u->ttd_path) }}" alt="TTD" class="h-10">
                        @else
                            <span class="text-gray-400">Belum ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center px-4 py-2 text-gray-500">Tidak ada user ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
