@extends('layouts.app')

@section('content')
<h2>Daftar Sisa Cuti Pegawai</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Nama Pegawai</th>
            <th>Role</th>
            <th>Sisa Cuti Tahunan</th>
            <th>Sisa Cuti Sakit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cutiData as $data)
            <tr>
                <td>{{ $data['user']->name }}</td>
                <td>{{ $data['user']->role }}</td>
                <td>{{ $data['sisa_cuti_tahunan'] }} hari</td>
                <td>{{ $data['sisa_cuti_sakit'] }} hari</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
