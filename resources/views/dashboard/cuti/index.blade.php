@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Detail Pengajuan Cuti</h1>

    <div class="space-y-4">
        @foreach($cuti as $c)
        <div class="bg-white shadow rounded-lg p-4 border-l-4 border-blue-500">
            <p><strong>Jenis Cuti:</strong> {{ $c->jenis_cuti }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $c->tanggal_mulai }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $c->tanggal_selesai }}</p>
            <p><strong>Alasan:</strong> {{ $c->alasan }}</p>
            <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $c->status)) }}</p>
            @if($c->jenis_cuti === 'sakit' && $c->surat_sakit)
                <p><strong>Surat Cuti Sakit:</strong> 
                    <a href="{{ asset('storage/' . $c->surat_sakit) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                </p>
            @endif
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md transition">Kembali</a>
    </div>
</div>
@endsection
