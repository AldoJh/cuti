@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto mt-8 bg-white shadow-xl rounded-2xl border border-gray-200">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-14 h-14 drop-shadow-md">
    </div>

    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-5 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('update-user', $editUser->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-gray-700 font-medium mb-1">
                Nama <span class="text-red-600">*</span>
            </label>
            <input type="text" name="name" id="name" required
                value="{{ old('name', $editUser->name) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
        </div>

        <div>
            <label for="nip" class="block text-gray-700 font-medium mb-1">
                NIP <span class="text-red-600">*</span>
            </label>
            <input type="text" name="nip" id="nip"
                value="{{ old('nip', $editUser->nip) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
        </div>

        <div>
            <label for="jabatan" class="block text-gray-700 font-medium mb-1">
                Jabatan <span class="text-red-600">*</span>
            </label>
            <input type="text" name="jabatan" id="jabatan" required
                value="{{ old('jabatan', $editUser->jabatan) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
        </div>

        <div>
            <label for="role" class="block text-gray-700 font-medium mb-1">
                Role <span class="text-red-600">*</span>
            </label>
            <select name="role" id="role" required
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
                <option value="">-- Pilih Role --</option>
                <option value="ketua" {{ $editUser->role == 'ketua' ? 'selected' : '' }}>Ketua</option>
                <option value="hakim" {{ $editUser->role == 'hakim' ? 'selected' : '' }}>Hakim</option>
                <option value="panitera" {{ $editUser->role == 'panitera' ? 'selected' : '' }}>Panitera</option>
                <option value="panmud" {{ $editUser->role == 'panmud' ? 'selected' : '' }}>Panitera Muda</option>
                <option value="panitera_pengganti" {{ $editUser->role == 'panitera_pengganti' ? 'selected' : '' }}>Panitera Pengganti</option>
                <option value="sekretaris" {{ $editUser->role == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                <option value="kasubbag" {{ $editUser->role == 'kasubbag' ? 'selected' : '' }}>Kasubbag</option>
                <option value="pelaksana" {{ $editUser->role == 'pelaksana' ? 'selected' : '' }}>Pelaksana/Staff</option>
                <option value="p3k" {{ $editUser->role == 'p3k' ? 'selected' : '' }}>P3K</option>
                <option value="outsourcing" {{ $editUser->role == 'outsourcing' ? 'selected' : '' }}>Outsourcing</option>
                <option value="bakti" {{ $editUser->role == 'bakti' ? 'selected' : '' }}>Bakti</option>
            </select>
        </div>

        <div>
            <label for="atasan_id" class="block text-gray-700 font-medium mb-1">Atasan</label>
            <select name="atasan_id" id="atasan_id"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
                <option value="">-- Pilih Atasan --</option>
                @foreach($users as $atasan)
                    <option value="{{ $atasan->id }}"
                        {{ old('atasan_id', $editUser->atasan_id) == $atasan->id ? 'selected' : '' }}>
                        {{ $atasan->name }} - {{ $atasan->jabatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="unit_kerja" class="block text-gray-700 font-medium mb-1">Unit Kerja</label>
            <input type="text" name="unit_kerja" id="unit_kerja"
                value="{{ old('unit_kerja', $editUser->unit_kerja) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2">
        </div>

        <div>
            <label for="no_telp" class="block text-gray-700 font-medium mb-1">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp"
                value="{{ old('no_telp', $editUser->no_telp) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2">
        </div>

        <div>
            <label for="golongan" class="block text-gray-700 font-medium mb-1">Golongan</label>
            <input type="text" name="golongan" id="golongan"
                value="{{ old('golongan', $editUser->golongan) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2">
        </div>

        <div>
            <label for="tanggal_masuk" class="block text-gray-700 font-medium mb-1">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                value="{{ old('tanggal_masuk', $editUser->tanggal_masuk) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2">
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">
                Email <span class="text-red-600">*</span>
            </label>
            <input type="email" name="email" id="email" required
                value="{{ old('email', $editUser->email) }}"
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
        </div>

        <div>
            <label for="status" class="block text-gray-700 font-medium mb-1">
                Status <span class="text-red-600">*</span>
            </label>
            <select name="status" id="status" required
                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
                <option value="1" {{ $editUser->status == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $editUser->status == 0 ? 'selected' : '' }}>Non Aktif</option>
            </select>
        </div>

        <div>
    <label for="ttd" class="block text-gray-700 font-medium mb-1">
        Tanda Tangan (TTD)
    </label>

    <input 
        type="file" 
        name="ttd" 
        id="ttd" 
        accept="image/png, image/jpeg, image/jpg"
        class="w-full border border-gray-300 rounded-xl px-4 py-2"
    >

    <p class="mt-1 text-xs text-gray-500">
        Format diperbolehkan: <span class="font-semibold">PNG, JPG, JPEG</span> — Maksimal <span class="font-semibold">2MB (2048 KB)</span>
    </p>

    @if($editUser->ttd_path)
        <p class="mt-3 text-sm text-gray-600">TTD saat ini:</p>
        <img 
            src="{{ asset('storage/' . $editUser->ttd_path) }}" 
            alt="TTD Lama"
            class="w-40 mt-2 border rounded-xl shadow-sm"
        >
    @endif

    <div id="previewContainer" class="hidden mt-4">
        <p class="text-sm text-gray-600">Preview TTD baru:</p>
        <img 
            id="previewTTD" 
            class="w-40 mt-2 border rounded-xl shadow-sm"
        >
    </div>
</div>

        <p class="text-sm text-gray-600 pt-3">
            <span class="text-red-600 font-bold">*</span> Kolom dengan tanda bintang wajib diisi.
        </p>

        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all">
                Update
            </button>
        </div>

    </form>
</div>

<script>
document.getElementById('ttd').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (file) {
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewTTD');

        previewImage.src = URL.createObjectURL(file);
        previewContainer.classList.remove('hidden');
    }
});
</script>

@endsection
