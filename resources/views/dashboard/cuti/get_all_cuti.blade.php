@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-orange-600 to-red-700 rounded-xl shadow-lg p-6 mb-6 
                flex flex-col md:flex-row items-start md:items-center justify-between gap-4
                transition hover:scale-[1.01] hover:shadow-xl">

        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">Daftar Cuti Pegawai</h1>
            <p class="text-sm text-orange-100">Riwayat cuti pegawai beserta status approval</p>
        </div>

        <a href="{{ route('pengajuan-cuti.export') }}"
           class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white font-semibold shadow-md transition flex items-center gap-2">
            <i class="fas fa-file-excel"></i> Export ke Excel
        </a>
    </div>

    {{-- ========================= --}}
    {{-- 📌 DESKTOP TABLE (md+)   --}}
    {{-- ========================= --}}
    <div class="hidden md:block">
        <div class="relative overflow-x-auto overflow-y-auto bg-white rounded-xl shadow-lg border border-gray-200"
             style="max-height: 75vh;">

            <table class="min-w-full text-sm">

                {{-- TABLE HEADER --}}
                <thead class="bg-gradient-to-r from-orange-600 to-red-700 text-white sticky top-0 z-20">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-[80px]">ID</th>
                        <th class="px-4 py-3 text-left font-semibold min-w-[220px]">Nama Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold min-w-[160px]">Jenis Cuti</th>
                        <th class="px-4 py-3 text-center font-semibold min-w-[150px]">Tanggal Mulai</th>
                        <th class="px-4 py-3 text-center font-semibold min-w-[150px]">Tanggal Selesai</th>
                        <th class="px-4 py-3 text-center font-semibold min-w-[120px]">Status</th>
                    </tr>
                </thead>

                {{-- TABLE BODY --}}
                <tbody>
                    @forelse($cutis as $cuti)
                    <tr class="hover:bg-orange-50 transition border-b border-gray-200">

                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $cuti->id }}</td>

                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-900">{{ $cuti->user->name ?? '-' }}</span>
                                <span class="text-gray-500 text-xs">{{ $cuti->user->jabatan ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-gray-700">{{ $cuti->jenis_cuti }}</td>

                        <td class="px-4 py-3 text-center">{{ $cuti->tanggal_mulai }}</td>

                        <td class="px-4 py-3 text-center">{{ $cuti->tanggal_selesai }}</td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm
                                @if($cuti->status === 'diajukan') bg-orange-100 text-orange-700 border border-orange-300
                                @elseif($cuti->status === 'disetujui_atasan') bg-green-200 text-green-800 border border-green-400
                                @elseif($cuti->status === 'disetujui') bg-green-700 text-white
                                @elseif($cuti->status === 'ditolak') bg-red-300 text-red-900 border border-red-300
                                @else bg-gray-100 text-gray-600 border border-gray-300
                                @endif">
                                {{ ucfirst($cuti->status) }}
                            </span>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-6 text-center text-gray-500 border-b border-gray-200">
                            Belum ada data cuti
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- 📌 MOBILE CARD VIEW     --}}
    {{-- ========================= --}}
    <div class="md:hidden space-y-4 mt-4">
        @forelse ($cutis as $cuti)
        <div class="bg-white shadow rounded-xl border border-gray-200 p-4">

            {{-- HEADER NAMA + STATUS --}}
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="font-bold text-gray-900 text-base">{{ $cuti->user->name ?? '-' }}</h2>
                    <p class="text-gray-500 text-xs">{{ $cuti->user->jabatan ?? '-' }}</p>
                </div>

                <span class="text-xs font-semibold px-2 py-1 rounded
                    @if($cuti->status === 'diajukan') bg-orange-100 text-orange-700
                    @elseif($cuti->status === 'disetujui_atasan') bg-green-100 text-green-700
                    @elseif($cuti->status === 'disetujui') bg-green-700 text-white
                    @elseif($cuti->status === 'ditolak') bg-red-200 text-red-700
                    @else bg-gray-100 text-gray-600
                    @endif">
                    {{ ucfirst($cuti->status) }}
                </span>
            </div>

            {{-- DETAIL --}}
            <div class="mt-3 text-sm text-gray-700 space-y-1">
                <p><strong>ID:</strong> {{ $cuti->id }}</p>
                <p><strong>Jenis Cuti:</strong> {{ $cuti->jenis_cuti }}</p>
                <p><strong>Mulai:</strong> {{ $cuti->tanggal_mulai }}</p>
                <p><strong>Selesai:</strong> {{ $cuti->tanggal_selesai }}</p>
            </div>

        </div>
        @empty
            <p class="text-center text-gray-500">Belum ada data cuti</p>
        @endforelse
    </div>

</div>
@endsection
