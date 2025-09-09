@extends('layouts.app')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan Cuti</h1>
            <p class="text-gray-500 text-sm">Berikut adalah detail dari pengajuan cuti Anda</p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-12 h-12 drop-shadow-md">
    </div>

    {{-- Card Detail Cuti --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cuti as $c)
            <div class="bg-white shadow-lg rounded-xl p-5 border border-gray-100 hover:shadow-xl transition-all duration-300">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">{{ ucfirst($c->jenis_cuti) }}</h2>

                <div class="space-y-2 text-sm text-gray-600">
                    <p><strong class="text-gray-800">Tanggal Mulai:</strong> {{ $c->tanggal_mulai }}</p>
                    <p><strong class="text-gray-800">Tanggal Selesai:</strong> {{ $c->tanggal_selesai }}</p>
                    <p><strong class="text-gray-800">Alasan:</strong> {{ $c->alasan }}</p>
                </div>

                {{-- Status Badge --}}
                <div class="mt-4">
                    @php
                        $statusColor = match($c->status) {
                            'disetujui' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            'menunggu_persetujuan' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-gray-100 text-gray-700'
                        };
                    @endphp
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                        {{ ucfirst(str_replace('_', ' ', $c->status)) }}
                    </span>
                </div>

                {{-- Surat Sakit --}}
                @if($c->jenis_cuti === 'sakit' && $c->surat_sakit)
                    <div class="mt-3">
                        <p class="text-sm text-gray-700">
                            <strong>Surat Cuti Sakit:</strong>
                            <a href="{{ asset('storage/' . $c->surat_sakit) }}" target="_blank" 
                               class="text-blue-500 hover:text-blue-700 underline">
                               Lihat Dokumen
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-8">
        <a href="{{ route('dashboard') }}" 
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow-md transition-all duration-300">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
