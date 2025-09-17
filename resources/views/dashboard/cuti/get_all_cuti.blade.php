@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Cuti Pegawai</h1>
            <p class="text-sm text-gray-500">Riwayat cuti beserta status approval dan periode cuti</p>
        </div>
        {{-- <a href="{{ route('cutis.create') }}"
           class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-red-700 transition">
            + Tambah Cuti
        </a> --}}
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">ID</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pegawai</th>
                    <th class="px-4 py-3 text-left font-semibold">Jenis Cuti</th>
                    <th class="px-4 py-3 text-center font-semibold">Tanggal Mulai</th>
                    <th class="px-4 py-3 text-center font-semibold">Tanggal Selesai</th>
                    <th class="px-4 py-3 text-left font-semibold">Approval</th>
                    <th class="px-4 py-3 text-center font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($cutis as $cuti)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 font-medium text-gray-700">{{ $cuti->id }}</td>
                    <td class="px-4 py-2">{{ $cuti->user->name ?? '' }} - {{$cuti->user->jabatan ?? ''}}</td>
                    <td class="px-4 py-2">{{ $cuti->jenis_cuti }}</td>
                    <td class="px-4 py-2 text-center">{{ $cuti->tanggal_mulai }}</td>
                    <td class="px-4 py-2 text-center">{{ $cuti->tanggal_selesai }}</td>
                    <td class="px-4 py-2">{{ $cuti->approval->name ?? '' }} - {{$cuti->approval->jabatan ?? ''}}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($cuti->status === 'Approved') bg-green-100 text-green-700
                            @elseif($cuti->status === 'Pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $cuti->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada data cuti</td>
                </tr>
                @endforelse
            </tbody>`
        </table>
    </div>
</div>
@endsection