@extends('layouts.app')

@section('content')
<div class="p-4 md:p-6 max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-orange-600 to-red-800 rounded-2xl shadow-xl p-6 mb-6
                flex items-center justify-between transition hover:shadow-2xl">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-white tracking-wide">
                Daftar Sisa Cuti
            </h1>
            <p class="text-xs md:text-sm text-orange-100 mt-1">
                Rekap lengkap seluruh jenis cuti pegawai.
            </p>
        </div>

        <img src="{{ asset('images/logopnrm.png') }}"
             class="w-12 h-12 md:w-14 md:h-14 rounded-full shadow-lg ring-2 ring-white/60">
    </div>


    {{-- FLASH MESSAGE --}}
    @if (session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 
                    text-red-700 text-sm shadow">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 
                    text-green-700 text-sm shadow">
            {{ session('success') }}
        </div>
    @endif


    {{-- ========= DESKTOP MODE ========= --}}
    <div class="hidden md:block bg-white rounded-2xl shadow-xl border border-gray-200 border-radius-lg p-4">

        {{-- WRAPPER: SCROLL 2 ARAH --}}
        <div class="overflow-x-auto max-h-[600px] overflow-y-auto">

            <table class="min-w-full text-sm border-collapse">

                {{-- HEADER --}}
                <thead class="bg-orange-700 text-white sticky top-0 z-20 shadow text-[13px]">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-orange-700 z-30">Nama Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold sticky left-40 bg-orange-700 z-30">Jabatan</th>

                        <th class="px-4 py-3 text-center font-semibold w-32">Tahunan</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">Sakit</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">Alasan Penting</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">Cuti Besar</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">Melahirkan</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">CLTN</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">Laporan</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-100">

                    @foreach ($cutiData as $data)
                    <tr class="hover:bg-orange-50 transition">

                        {{-- STICKY NAMA --}}
                        <td class="px-4 py-3 font-semibold text-gray-900 sticky left-0 bg-white border-r border-gray-200 z-10">
                            {{ $data['user']->name }}
                        </td>

                        {{-- STICKY JABATAN --}}
                        <td class="px-4 py-3 capitalize text-gray-700 sticky left-40 bg-white border-r border-gray-200 z-10">
                            {{ $data['user']->jabatan }}
                        </td>

                        <td class="px-4 py-3 text-center text-green-600 font-semibold">
                            {{ $data['sisa_cuti_tahunan'] }} hari
                        </td>

                        <td class="px-4 py-3 text-center text-blue-600 font-semibold">
                            {{ $data['sisa_cuti_sakit'] }} hari
                        </td>

                        <td class="px-4 py-3 text-center text-orange-600 font-semibold">
                            {{ $data['sisa_cuti_alasan_penting'] }} hari
                        </td>

                        <td class="px-4 py-3 text-center text-purple-600 font-semibold">
                            {{ $data['sisa_cuti_besar'] }} hari
                        </td>

                        <td class="px-4 py-3 text-center text-pink-600 font-semibold">
                            {{ $data['sisa_cuti_melahirkan'] }} hari
                        </td>

                        <td class="px-4 py-3 text-center text-gray-700 font-semibold">
                            {{ $data['sisa_cuti_cltn'] }} hari
                        </td>

                        {{-- EXPORT --}}
                        <td class="px-4 py-3 text-center">

                            @if ($data['user']->pengajuanCuti && $data['user']->pengajuanCuti->isNotEmpty())
                                <a href="{{ route('cuti.exportByUser', $data['user']->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 rounded-md
                                          bg-green-600 hover:bg-green-700 text-white text-xs font-medium 
                                          shadow transition">
                                    <i class="fas fa-file-excel mr-1.5"></i> Export
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-md
                                             bg-gray-400 text-white text-xs font-medium shadow 
                                             cursor-not-allowed">
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



    {{-- ========= MOBILE MODE ========= --}}
    <div class="md:hidden space-y-4">

        @foreach ($cutiData as $data)
        <div class="bg-white p-4 rounded-2xl shadow border border-gray-200">

            <h2 class="font-bold text-gray-900 text-lg">
                {{ $data['user']->name }}
            </h2>

            <p class="text-gray-600 text-sm mb-3">
                {{ $data['user']->jabatan }}
            </p>

            <div class="grid grid-cols-2 gap-3 text-sm">

                <div class="p-3 bg-green-50 rounded-xl">
                    <p class="font-semibold text-green-600">Tahunan</p>
                    <p>{{ $data['sisa_cuti_tahunan'] }} hari</p>
                </div>

                <div class="p-3 bg-blue-50 rounded-xl">
                    <p class="font-semibold text-blue-600">Sakit</p>
                    <p>{{ $data['sisa_cuti_sakit'] }} hari</p>
                </div>

                <div class="p-3 bg-orange-50 rounded-xl">
                    <p class="font-semibold text-orange-600">Alasan Penting</p>
                    <p>{{ $data['sisa_cuti_alasan_penting'] }} hari</p>
                </div>

                <div class="p-3 bg-purple-50 rounded-xl">
                    <p class="font-semibold text-purple-600">Cuti Besar</p>
                    <p>{{ $data['sisa_cuti_besar'] }} hari</p>
                </div>

                <div class="p-3 bg-pink-50 rounded-xl">
                    <p class="font-semibold text-pink-600">Melahirkan</p>
                    <p>{{ $data['sisa_cuti_melahirkan'] }} hari</p>
                </div>

                <div class="p-3 bg-gray-100 rounded-xl">
                    <p class="font-semibold text-gray-700">CLTN</p>
                    <p>{{ $data['sisa_cuti_cltn'] }} hari</p>
                </div>
            </div>

            {{-- EXPORT MOBILE --}}
            <div class="mt-4">
                @if ($data['user']->pengajuanCuti && $data['user']->pengajuanCuti->isNotEmpty())
                    <a href="{{ route('cuti.exportByUser', $data['user']->id) }}"
                       class="w-full block text-center px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold shadow">
                        Export Laporan
                    </a>
                @else
                    <p class="w-full block text-center px-4 py-2 rounded-lg bg-gray-400 text-white text-sm font-semibold">
                        Tidak Ada Data
                    </p>
                @endif
            </div>

        </div>
        @endforeach

    </div>

</div>
@endsection
