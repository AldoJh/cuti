@extends('layouts.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="bg-gradient-to-b from-orange-500 to-red-900 rounded-xl shadow-lg p-6 mb-6 flex items-center justify-between transition hover:scale-[1.01] hover:shadow-xl">
        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">
                Daftar Sisa Cuti Pegawai
            </h1>
            <p class="text-sm text-red-100 mt-1">
                Informasi sisa cuti tahunan, cuti sakit, dan rekap cuti setiap pegawai.
            </p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-14 h-14 drop-shadow-lg rounded-full ring-2 ring-white/50">
    </div>

    {{-- Flash Message --}}
    @if (session('error'))
        <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-300 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 border border-green-300 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-orange-500 to-red-900 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pegawai</th>
                    <th class="px-4 py-3 text-left font-semibold">Jabatan</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Cuti Tahunan</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Cuti Sakit</th>
                    <th class="px-4 py-3 text-center font-semibold">Laporan Cuti</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($cutiData as $data)
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $data['user']->name }}</td>
                    <td class="px-4 py-2 capitalize text-gray-600">{{ $data['user']->role }}</td>
                    <td class="px-4 py-2 text-center text-green-600 font-semibold">
                        {{ $data['sisa_cuti_tahunan'] }} hari
                    </td>
                    <td class="px-4 py-2 text-center text-blue-600 font-semibold">
                        {{ $data['sisa_cuti_sakit'] }} hari
                    </td>
                    <td class="px-4 py-2 text-center">
                        @if ($data['user']->pengajuanCuti && $data['user']->pengajuanCuti->isNotEmpty())
                            <a href="{{ route('cuti.exportByUser', $data['user']->id) }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-md bg-green-600 hover:bg-green-700 text-white text-xs font-medium shadow transition">
                                <i class="fas fa-file-excel mr-1.5"></i> Export
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md bg-gray-400 text-white text-xs font-medium shadow cursor-not-allowed">
                                <i class="fas fa-ban mr-1.5"></i> Tidak Ada Data
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
