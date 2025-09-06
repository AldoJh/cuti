@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Detail Pengajuan Cuti</h1>
</div>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Pengajuan Cuti {{ $user->name }}</h4>
        </div>
        @foreach($cuti as $cuti)
<div class="card mb-3">
    <div class="card-body">
        <p><strong>Jenis Cuti:</strong> {{ $cuti->jenis_cuti }}</p>
        <p><strong>Tanggal Mulai:</strong> {{ $cuti->tanggal_mulai }}</p>
        <p><strong>Tanggal Selesai:</strong> {{ $cuti->tanggal_selesai }}</p>
        <p><strong>Alasan:</strong> {{ $cuti->alasan }}</p>
        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $cuti->status)) }}</p>

        @if($cuti->jenis_cuti === 'sakit' && $cuti->surat_sakit)
            <p><strong>Surat Cuti Sakit:</strong> 
                <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" target="_blank">
                    Lihat
                </a>
            </p>
        @endif
    </div>
</div>
@endforeach

        <div class="card-footer">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
