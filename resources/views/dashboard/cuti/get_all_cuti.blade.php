@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="bg-gradient-to-b from-orange-500 to-red-900 rounded-xl shadow-lg p-6 mb-6 flex items-center justify-between transition hover:scale-[1.01] hover:shadow-xl">
        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">Daftar Cuti Pegawai</h1>
            <p class="text-sm text-red-100">Riwayat cuti beserta status approval dan periode cuti</p>
        </div>
        {{-- Tombol Export Excel --}}
        <a href="{{ route('pengajuan-cuti.export') }}"
           class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-medium shadow transition flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Export ke Excel
        </a>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-orange-500 to-red-900 text-white">
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
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $cuti->id }}</td>
                    <td class="px-4 py-2">
                        <span class="font-semibold text-gray-900">{{ $cuti->user->name ?? '' }}</span>
                        <span class="text-gray-500 text-sm">- {{ $cuti->user->jabatan ?? '' }}</span>
                    </td>
                    <td class="px-4 py-2 text-gray-700">{{ $cuti->jenis_cuti }}</td>
                    <td class="px-4 py-2 text-center">{{ $cuti->tanggal_mulai }}</td>
                    <td class="px-4 py-2 text-center">{{ $cuti->tanggal_selesai }}</td>
                    <td class="px-4 py-2">
                        <span class="font-medium text-gray-900">{{ $cuti->approval->name ?? '' }}</span>
                        <span class="text-gray-500 text-sm">- {{ $cuti->approval->jabatan ?? '' }}</span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm
                            @if($cuti->status === 'diajukan') bg-orange-100 text-orange-700 border border-orange-300
                            @elseif($cuti->status === 'disetujui_atasan') bg-green-200 text-green-800 border border-green-400
                            @elseif($cuti->status === 'disetujui') bg-green-700 text-white
                            @elseif($cuti->status === 'ditolak') bg-red-300 text-red-900 border border-red-300
                            @else bg-gray-100 text-gray-600 border border-gray-300 @endif">
                            {{ ucfirst($cuti->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data cuti</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
