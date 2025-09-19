@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    {{-- Header --}}
    <div
        class="bg-gradient-to-b from-orange-500 to-red-900 rounded-xl shadow-lg p-6 mb-6 flex items-center justify-between transition hover:scale-[1.01] hover:shadow-xl">
        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">
                Detail Pengajuan Cuti
            </h1>
            <p class="text-sm text-red-100 mt-1">
                Berikut adalah detail dari pengajuan cuti Anda
            </p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN"
            class="w-14 h-14 drop-shadow-lg rounded-full ring-2 ring-white/50">
    </div>

    {{-- Card Detail --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cuti as $c)
            <div
                class="relative bg-white rounded-2xl shadow-md border border-gray-200 p-6 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                
                {{-- Header Jenis Cuti --}}
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        📝 {{ ucfirst($c->jenis_cuti) }}
                    </h2>
                {{-- Status Badge --}}
                @php
                    $statusColor = match($c->status) {
                        'disetujui_atasan' => 'bg-green-50 text-green-800 ring-green-400', // hijau lebih tegas
                        'disetujui' => 'bg-green-800 text-white ring-green-200',        // hijau lebih terang
                        'ditolak' => 'bg-red-100 text-red-700 ring-red-300',
                        'menunggu_persetujuan' => 'bg-yellow-100 text-yellow-700 ring-yellow-300',
                        default => 'bg-gray-100 text-gray-700 ring-gray-300'
                    };
                @endphp
                <span class="px-3 py-1 text-xs font-semibold rounded-full ring-1 {{ $statusColor }}">
                    {{ ucfirst(str_replace('_', ' ', $c->status)) }}
                </span>
                </div>

                {{-- Informasi --}}
                <div class="space-y-3 text-sm text-gray-700">
                    <p>
                        <span class="font-semibold text-gray-900">📅 Tanggal Mulai:</span>  
                        {{ $c->tanggal_mulai }}
                    </p>
                    <p>
                        <span class="font-semibold text-gray-900">📅 Tanggal Selesai:</span>  
                        {{ $c->tanggal_selesai }}
                    </p>
                    <p>
                        <span class="font-semibold text-gray-900">📝 Alasan:</span>  
                        {{ $c->alasan }}
                    </p>
                </div>

                {{-- Surat Sakit --}}
                @if($c->jenis_cuti === 'sakit' && $c->surat_sakit)
                    <div class="mt-4 text-sm">
                        <span class="font-semibold text-gray-900">📄 Surat Cuti Sakit:</span>
                        <a href="{{ asset('storage/' . $c->surat_sakit) }}" target="_blank"
                           class="text-blue-600 hover:text-blue-800 underline font-medium">
                           Lihat Dokumen
                        </a>
                    </div>
                @endif

                {{-- Tombol Aksi --}}
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('cuti.print_form', $c->id) }}" target="_blank"
                        class="flex items-center justify-center bg-gradient-to-r from-red-600 to-red-800 text-white px-5 py-2.5 rounded-xl shadow-md transition transform hover:scale-[1.03] hover:shadow-lg">
                        🖨️ Print Form Cuti
                    </a>
                    <a href="{{ route('cuti.print_izin', $c->id) }}" target="_blank"
                        class="flex items-center justify-center bg-gradient-to-r from-orange-500 to-yellow-600 text-white px-5 py-2.5 rounded-xl shadow-md transition transform hover:scale-[1.03] hover:shadow-lg">
                        🖨️ Print Surat Izin
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-10">
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-700 to-red-800 text-white px-6 py-2.5 rounded-xl shadow-md transition transform hover:scale-[1.03] hover:shadow-xl">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
