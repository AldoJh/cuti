@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pengajuan Cuti Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($pengajuanCuti->isEmpty())
        <p>Tidak ada pengajuan cuti yang harus disetujui saat ini.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Pegawai</th>
                    <th>Jenis Cuti</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Alasan</th>
                    <th>Surat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuanCuti as $cuti)
                    <tr>
                        <td>{{ $cuti->user->name }}</td>
                        <td>{{ ucfirst($cuti->jenis_cuti) }}</td>
                        <td>{{ $cuti->tanggal_mulai }}</td>
                        <td>{{ $cuti->tanggal_selesai }}</td>
                        <td>{{ $cuti->alasan }}</td>
                        <td>
                            @if($cuti->surat_sakit)
                                <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" target="_blank">Lihat/Download</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
