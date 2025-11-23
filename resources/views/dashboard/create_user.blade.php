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
                <label class="block text-gray-700 font-medium mb-2">
                    Nama <span class="text-red-600">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- NIP --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Jabatan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Jabatan <span class="text-red-600">*</span>
                </label>
                <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Role <span class="text-red-600">*</span>
                </label>
                <select name="role" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
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
                <label class="block text-gray-700 font-medium mb-2">Atasan</label>
                <select name="atasan_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
                    <option value="">-- Pilih Atasan --</option>
                    @foreach($users as $atasan)
                        <option value="{{ $atasan->id }}">
                            {{ $atasan->name }} - {{ $atasan->jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Unit Kerja --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Unit Kerja</label>
                <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- No Telp --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">No. Telepon</label>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Golongan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Golongan</label>
                <input type="text" name="golongan" value="{{ old('golongan') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Tanggal Masuk --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Email <span class="text-red-600">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Sisa Cuti Tahunan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Sisa Cuti Tahunan</label>
                <input type="number" name="sisa_cuti_tahunan" value="{{ old('sisa_cuti_tahunan', 12) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Sisa Cuti Sakit --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Sisa Cuti Sakit</label>
                <input type="number" name="sisa_cuti_sakit" value="{{ old('sisa_cuti_sakit', 14) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Password <span class="text-red-600">*</span>
                </label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Konfirmasi Password <span class="text-red-600">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- TTD --}}
            <div class="sm:col-span-2">
                <label class="block text-gray-700 font-medium mb-2">Tanda Tangan (TTD)</label>
                <input type="file" id="ttdInput" name="ttd" accept="image/*"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">

                {{-- Preview TTD --}}
                <div class="mt-4">
                    <img id="ttdPreview" class="hidden w-40 border rounded-lg shadow-md">
                </div>
            </div>

        </div>

        {{-- Keterangan --}}
        <p class="text-sm text-gray-600 mt-4">
            <span class="text-red-600 font-bold">*</span> Kolom dengan tanda bintang wajib diisi.
        </p>

        {{-- Tombol Simpan --}}
        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all">
                Simpan
            </button>
        </div>

    </form>
</div>

{{-- JS Preview TTD --}}
<script>
document.getElementById('ttdInput').addEventListener('change', function(event) {
    let preview = document.getElementById('ttdPreview');
    let file = event.target.files[0];

    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
        preview.src = "";
    }
});
</script>

@endsection
