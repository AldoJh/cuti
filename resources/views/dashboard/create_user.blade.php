@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-8 bg-white rounded-2xl shadow-xl border border-gray-200">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah User Baru</h1>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-14 h-14 drop-shadow-md">
    </div>

    {{-- Notifikasi --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('store-user') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            {{-- Nama --}}
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- NIP --}}
            <div>
                <label for="nip" class="block text-gray-700 font-medium mb-2">NIP</label>
                <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Jabatan --}}
            <div>
                <label for="jabatan" class="block text-gray-700 font-medium mb-2">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
                <select name="role" id="role" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
                    <option value="">-- Pilih Role --</option>
                    <option value="ketua">Ketua</option>
                    <option value="wakil_ketua">Wakil Ketua</option>
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
                <label for="atasan_id" class="block text-gray-700 font-medium mb-2">Atasan</label>
                <select name="atasan_id" id="atasan_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
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
                <label for="unit_kerja" class="block text-gray-700 font-medium mb-2">Unit Kerja</label>
                <input type="text" name="unit_kerja" id="unit_kerja" value="{{ old('unit_kerja') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- No Telp --}}
            <div>
                <label for="no_telp" class="block text-gray-700 font-medium mb-2">No. Telepon</label>
                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Golongan --}}
            <div>
                <label for="golongan" class="block text-gray-700 font-medium mb-2">Golongan</label>
                <input type="text" name="golongan" id="golongan" value="{{ old('golongan') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Tanggal Masuk --}}
            <div>
                <label for="tanggal_masuk" class="block text-gray-700 font-medium mb-2">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Sisa Cuti Tahunan --}}
            <div>
                <label for="sisa_cuti_tahunan" class="block text-gray-700 font-medium mb-2">Sisa Cuti Tahunan</label>
                <input type="number" name="sisa_cuti_tahunan" id="sisa_cuti_tahunan" value="{{ old('sisa_cuti_tahunan', 12) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Sisa Cuti Sakit --}}
            <div>
                <label for="sisa_cuti_sakit" class="block text-gray-700 font-medium mb-2">Sisa Cuti Sakit</label>
                <input type="number" name="sisa_cuti_sakit" id="sisa_cuti_sakit" value="{{ old('sisa_cuti_sakit', 14) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>

            {{-- TTD --}}
            <div class="sm:col-span-2">
                <label for="ttd" class="block text-gray-700 font-medium mb-2">Tanda Tangan (TTD)</label>
                <input type="file" name="ttd" id="ttd" accept="image/*"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400">
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-200">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
