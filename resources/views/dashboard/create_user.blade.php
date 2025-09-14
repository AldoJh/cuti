@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white shadow-lg rounded-xl border border-gray-200">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-2xl font-bold text-gray-800">Tambah User Baru</h1>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-12 h-12 drop-shadow-md">
    </div>

    {{-- Notifikasi --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg shadow">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('store-user') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- NIP --}}
        <div>
            <label for="nip" class="block text-gray-700 font-medium mb-1">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" id="role" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                <option value="">-- Pilih Role --</option>
                <option value="ketua">Ketua</option>
                <option value="hakim">Hakim</option>
                <option value="panitera">Panitera</option>
                <option value="panmud">Panitera Muda</option>
                <option value="panitera_pengganti">Panitera Pengganti</option>
                <option value="sekretaris">Sekretaris</option>
                <option value="kasubbag">Kasubbag</option>
                <option value="ppnpn">PPNPN</option>
                <option value="bakti">Bakti</option>
            </select>
        </div>

        {{-- Atasan --}}
<div>
    <label for="atasan_id" class="block text-gray-700 font-medium mb-1">Atasan</label>
    <select name="atasan_id" id="atasan_id"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        <option value="">-- Pilih Atasan --</option>
        @foreach($users as $atasan)
            <option value="{{ $atasan->id }}" {{ old('atasan_id') == $atasan->id ? 'selected' : '' }}>
                {{ $atasan->name }} - {{ $atasan->jabatan }}
            </option>
        @endforeach
    </select>
</div>

{{-- Unit Kerja --}}
<div>
    <label for="unit_kerja" class="block text-gray-700 font-medium mb-1">Unit Kerja</label>
    <input type="text" name="unit_kerja" id="unit_kerja" value="{{ old('unit_kerja') }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">
</div>

{{-- No Telp --}}
<div>
    <label for="no_telp" class="block text-gray-700 font-medium mb-1">No. Telepon</label>
    <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">
</div>

{{-- Golongan --}}
<div>
    <label for="golongan" class="block text-gray-700 font-medium mb-1">Golongan</label>
    <input type="text" name="golongan" id="golongan" value="{{ old('golongan') }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">
</div>

{{-- Tanggal Masuk --}}
<div>
    <label for="tanggal_masuk" class="block text-gray-700 font-medium mb-1">Tanggal Masuk</label>
    <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
        class="w-full border border-gray-300 rounded-lg px-3 py-2">
</div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- Password --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
            </div>
        </div>

        {{-- TTD --}}
        <div>
            <label for="ttd" class="block text-gray-700 font-medium mb-1">Tanda Tangan (TTD)</label>
            <input type="file" name="ttd" id="ttd" accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
