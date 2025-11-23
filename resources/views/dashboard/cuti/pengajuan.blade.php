@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-orange-600 to-red-700 rounded-xl shadow-lg p-6 mb-6 
                flex flex-col md:flex-row items-start md:items-center justify-between gap-4
                transition hover:scale-[1.01] hover:shadow-xl">

        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">Pengajuan Cuti Masuk</h1>
            <p class="text-sm text-orange-100">Kelola semua permintaan cuti pegawai</p>
        </div>

        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN"
             class="w-14 h-14 drop-shadow-lg rounded-full ring-2 ring-white/60">
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg border border-green-200 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-200 shadow-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- JIKA DATA KOSONG --}}
    @if($pengajuanCuti->isEmpty())
        <div class="bg-white shadow rounded-xl p-6 text-center border border-gray-200">
            <p class="text-gray-600 text-sm">Tidak ada pengajuan cuti yang perlu disetujui saat ini.</p>
        </div>

    @else

    {{-- ======================== --}}
    {{-- 📌 DESKTOP TABLE (md+) --}}
    {{-- ======================== --}}
    <div class="hidden md:block">
        <div class="relative overflow-x-auto overflow-y-auto bg-white rounded-xl shadow-lg border border-gray-200"
             style="max-height: 75vh;">

            <table class="min-w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-gradient-to-r from-orange-600 to-red-700 text-white sticky top-0 z-20">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nama Pegawai</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis Cuti</th>
                        <th class="px-4 py-3 text-left font-semibold">Mulai</th>
                        <th class="px-4 py-3 text-left font-semibold">Selesai</th>
                        <th class="px-4 py-3 text-left font-semibold">Alasan</th>
                        <th class="px-4 py-3 text-left font-semibold">Berkas</th>
                        <th class="px-4 py-3 text-left font-semibold">Surat</th>
                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-200">
                    @foreach($pengajuanCuti as $cuti)
                    <tr class="hover:bg-orange-50 transition">

                        <td class="px-4 py-3 text-gray-900 font-semibold">{{ $cuti->user->name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ ucfirst($cuti->jenis_cuti) }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $cuti->tanggal_mulai }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $cuti->tanggal_selesai }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $cuti->alasan }}</td>

                        {{-- BERKAS --}}
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('cuti.print_form', $cuti->id) }}" target="_blank"
                                   class="px-3 py-1.5 text-xs text-white bg-gradient-to-r from-red-600 to-red-800 
                                          rounded-lg shadow hover:scale-[1.05] transition inline-flex items-center">
                                    🖨️ Form Cuti
                                </a>

                                <a href="{{ route('cuti.print_izin', $cuti->id) }}" target="_blank"
                                   class="px-3 py-1.5 text-xs text-white bg-gradient-to-r from-orange-500 to-yellow-600 
                                          rounded-lg shadow hover:scale-[1.05] transition inline-flex items-center">
                                    🖨️ Surat Izin
                                </a>
                            </div>
                        </td>

                        {{-- SURAT SAKIT --}}
                        <td class="px-4 py-3 text-center">
                            @if($cuti->surat_sakit)
                                <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" target="_blank"
                                   class="px-3 py-1.5 text-xs text-white bg-gradient-to-r from-blue-500 to-indigo-500 
                                          rounded-lg shadow hover:scale-[1.05] transition inline-flex items-center">
                                    📄 Lihat Surat
                                </a>
                            @else
                                <span class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded shadow-sm">Tidak ada</span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-3 text-center">

                            <div class="flex justify-center gap-2">

                                {{-- SETUJUI --}}
                                <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="px-4 py-1.5 text-xs text-white bg-gradient-to-r from-green-500 to-green-600 
                                                   rounded-lg shadow hover:scale-[1.05] transition">
                                        ✅ Setujui
                                    </button>
                                </form>

                                {{-- TOLAK --}}
                                <form action="{{ route('cuti.reject', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="px-4 py-1.5 text-xs text-white bg-gradient-to-r from-red-500 to-red-600 
                                                   rounded-lg shadow hover:scale-[1.05] transition">
                                        ❌ Tolak
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

    {{-- ======================== --}}
    {{-- 📌 MOBILE CARD VIEW    --}}
    {{-- ======================== --}}
    <div class="md:hidden space-y-4 mt-4">

        @foreach($pengajuanCuti as $cuti)
        <div class="bg-white p-4 rounded-xl shadow border border-gray-200">

            {{-- HEADER --}}
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-gray-900 text-base">{{ $cuti->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst($cuti->jenis_cuti) }}</p>
                </div>
            </div>

            {{-- DETAIL --}}
            <div class="mt-3 text-sm text-gray-700 space-y-1">
                <p><strong>Mulai:</strong> {{ $cuti->tanggal_mulai }}</p>
                <p><strong>Selesai:</strong> {{ $cuti->tanggal_selesai }}</p>
                <p><strong>Alasan:</strong> {{ $cuti->alasan }}</p>
            </div>

            {{-- BERKAS / SURAT --}}
            <div class="mt-3 space-y-2">

                <a href="{{ route('cuti.print_form', $cuti->id) }}" target="_blank"
                   class="w-full block text-center px-3 py-2 text-xs font-medium text-white
                          bg-gradient-to-r from-red-600 to-red-800 rounded-lg shadow hover:scale-[1.03] transition">
                    🖨️ Form Cuti
                </a>

                <a href="{{ route('cuti.print_izin', $cuti->id) }}" target="_blank"
                   class="w-full block text-center px-3 py-2 text-xs font-medium text-white
                          bg-gradient-to-r from-orange-500 to-yellow-600 rounded-lg shadow hover:scale-[1.03] transition">
                    🖨️ Surat Izin
                </a>

                @if($cuti->surat_sakit)
                    <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" target="_blank"
                       class="w-full block text-center px-3 py-2 text-xs font-medium text-white
                              bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg shadow hover:scale-[1.03] transition">
                        📄 Lihat Surat Sakit
                    </a>
                @else
                    <p class="text-xs text-gray-500 text-center">Tidak ada surat sakit</p>
                @endif

            </div>

            {{-- TOMBOL AKSI --}}
            <div class="mt-4 flex gap-2">

                <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full px-4 py-2 text-xs text-white bg-gradient-to-r from-green-500 to-green-600 
                                   rounded-lg shadow hover:scale-[1.03] transition">
                        ✅ Setujui
                    </button>
                </form>

                <form action="{{ route('cuti.reject', $cuti->id) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full px-4 py-2 text-xs text-white bg-gradient-to-r from-red-500 to-red-600 
                                   rounded-lg shadow hover:scale-[1.03] transition">
                        ❌ Tolak
                    </button>
                </form>

            </div>

        </div>
        @endforeach

    </div>

    @endif

</div>
@endsection
