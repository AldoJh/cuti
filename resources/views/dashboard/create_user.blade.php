@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah User Baru</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('store-user') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="nip">NIP</label>
            <input type="number" name="nip" class="form-control" value="{{ old('nip') }}">
        </div>

        <div class="mb-3">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}">
        </div>

        <div class="mb-3">
            <label for="role">Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="ketua">Ketua</option>
                <option value="hakim">Hakim</option>
                <option value="panitera">Panitera</option>
                <option value="panmud">Panitera Muda</option>
                <option value="panitera_pengganti">Panitera Pengganti</option>
                <option value="sekretaris">Sekretaris</option>
                <option value="kasubbag">Kasubbag</option>
                <option value="pegawai">Pegawai</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="atasan_id">Atasan</label>
            <select name="atasan_id" class="form-control">
                <option value="">-- Pilih Atasan --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->jabatan }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ttd">Tanda Tangan (TTD)</label>
            <input type="file" name="ttd" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
