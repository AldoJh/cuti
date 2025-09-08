@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white shadow rounded-lg">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah User Baru</h2>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('store-user') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="nip" class="block text-gray-700 font-medium mb-1">NIP</label>
            <input type="number" name="nip" id="nip" value="{{ old('nip') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="jabatan" class="block text-gray-700 font-medium mb-1">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" id="role" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
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

        <div>
            <label for="atasan_id" class="block text-gray-700 font-medium mb-1">Atasan</label>
            <select name="atasan_id" id="atasan_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Atasan --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->jabatan }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div>
            <label for="ttd" class="block text-gray-700 font-medium mb-1">Tanda Tangan (TTD)</label>
            <input type="file" name="ttd" id="ttd" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">Simpan</button>
    </form>
</div>
@endsection
