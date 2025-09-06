@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Daftar User</h2>

    {{-- Pesan sukses atau error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('create-user') }}" class="btn btn-primary">+ Tambah User</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Role</th>
                <th>Atasan</th>
                <th>Email</th>
                <th>TTD</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key => $u)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->nip ?? '-' }}</td>
                    <td>{{ $u->jabatan ?? '-' }}</td>
                    <td>{{ ucfirst($u->role) }}</td>
                    <td>{{ $u->atasan?->name ?? '-' }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->ttd_path)
                            <img src="{{ asset('storage/'.$u->ttd_path) }}" alt="TTD" height="40">
                        @else
                            <span class="text-muted">Belum ada</span>
                        @endif
                    </td>
                    <td>
                        {{-- <a href="{{ route('users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('users.delete', $u->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">Hapus</button>
                        </form> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada user ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
