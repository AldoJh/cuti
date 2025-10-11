@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white shadow-lg rounded-xl border border-gray-200">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
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
    <form action="{{ route('update-user', $editUser->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $editUser->name) }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- NIP --}}
        <div>
            <label for="nip" class="block text-gray-700 font-medium mb-1">NIP</label>
            <input type="text" name="nip" id="nip" value="{{ old('nip', $editUser->nip) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- Jabatan --}}
        <div>
            <label for="jabatan" class="block text-gray-700 font-medium mb-1">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $editUser->jabatan) }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
            <select name="role" id="role" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                <option value="">-- Pilih Role --</option>
                <option value="ketua" {{ $editUser->role == 'ketua' ? 'selected' : '' }}>Ketua</option>
                <option value="hakim" {{ $editUser->role == 'hakim' ? 'selected' : '' }}>Hakim</option>
                <option value="panitera" {{ $editUser->role == 'panitera' ? 'selected' : '' }}>Panitera</option>
                <option value="panmud" {{ $editUser->role == 'panmud' ? 'selected' : '' }}>Panitera Muda</option>
                <option value="panitera_pengganti" {{ $editUser->role == 'panitera_pengganti' ? 'selected' : '' }}>Panitera Pengganti</option>
                <option value="sekretaris" {{ $editUser->role == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                <option value="kasubbag" {{ $editUser->role == 'kasubbag' ? 'selected' : '' }}>Kasubbag</option>
                <option value="ppnpn" {{ $editUser->role == 'ppnpn' ? 'selected' : '' }}>PPNPN</option>
                <option value="bakti" {{ $editUser->role == 'bakti' ? 'selected' : '' }}>Bakti</option>
            </select>
        </div>

        {{-- Atasan --}}
        <div>
            <label for="atasan_id" class="block text-gray-700 font-medium mb-1">Atasan</label>
            <select name="atasan_id" id="atasan_id"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                <option value="">-- Pilih Atasan --</option>
                @foreach($users as $atasan)
                    <option value="{{ $atasan->id }}" {{ old('atasan_id', $editUser->atasan_id) == $atasan->id ? 'selected' : '' }}>
                        {{ $atasan->name }} - {{ $atasan->jabatan }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Unit Kerja --}}
        <div>
            <label for="unit_kerja" class="block text-gray-700 font-medium mb-1">Unit Kerja</label>
            <input type="text" name="unit_kerja" id="unit_kerja" value="{{ old('unit_kerja', $editUser->unit_kerja) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        {{-- No Telp --}}
        <div>
            <label for="no_telp" class="block text-gray-700 font-medium mb-1">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $editUser->no_telp) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        {{-- Golongan --}}
        <div>
            <label for="golongan" class="block text-gray-700 font-medium mb-1">Golongan</label>
            <input type="text" name="golongan" id="golongan" value="{{ old('golongan', $editUser->golongan) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        {{-- Tanggal Masuk --}}
        <div>
            <label for="tanggal_masuk" class="block text-gray-700 font-medium mb-1">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk', $editUser->tanggal_masuk) }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $editUser->email) }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>

        {{-- Status --}}
        <div class="mb-5">
    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
        Status
    </label>
    <select name="status" id="status" required
        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm p-2.5 shadow-sm">
        <option value="1" {{ $editUser->status == 1 ? 'selected' : '' }}>✅ Aktif</option>
        <option value="0" {{ $editUser->status == 0 ? 'selected' : '' }}>⛔ Non Aktif</option>
    </select>
</div>



        {{-- TTD --}}
        <div>
            <label for="ttd" class="block text-gray-700 font-medium mb-1">Tanda Tangan (TTD)</label>
            <input type="file" name="ttd" id="ttd" accept="image/*"
                class="w-full border border-gray-300 rounded-lg px-3 py-2">
            @if($editUser->ttd)
                <p class="mt-2 text-sm text-gray-600">TTD saat ini:</p>
                <img src="{{ asset('storage/'.$editUser->ttd) }}" alt="TTD" class="w-32 mt-1 border rounded">
            @endif
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
