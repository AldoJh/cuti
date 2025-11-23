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
                    <option value="pelaksana">Pelaksana/Staff</option>
                    <option value="p3k">P3K</option>
                    <option value="outsourcing">Outsourcing</option>
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

            {{-- Sisa Cuti Alasan Penting --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Sisa Cuti Alasan Penting</label>
                <input type="number" name="sisa_cuti_alasan_penting"
                    value="{{ old('sisa_cuti_alasan_penting', 30) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Sisa Cuti Besar --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Sisa Cuti Besar</label>
                <input type="number" name="sisa_cuti_besar"
                    value="{{ old('sisa_cuti_besar', 90) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Sisa Cuti Melahirkan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Sisa Cuti Melahirkan</label>
                <input type="number" name="sisa_cuti_melahirkan"
                    value="{{ old('sisa_cuti_melahirkan', 90) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Sisa Cuti CLTN --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">Sisa Cuti CLTN</label>
                <input type="number" name="sisa_cuti_cltn"
                    value="{{ old('sisa_cuti_cltn', 36) }}" min="0"
                    class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-400">
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-700 font-medium mb-2">
                    Password <span class="text-red-600">*</span>
                </label>

                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 pr-12 focus:ring-2 focus:ring-red-400 transition">

                    {{-- Eye Toggle --}}
                    <button type="button" onclick="togglePassword('password','eyePass')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600">
                        <svg id="eyePass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="relative">
                <label class="block text-gray-700 font-medium mb-2">
                    Konfirmasi Password <span class="text-red-600">*</span>
                </label>

                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 pr-12 focus:ring-2 focus:ring-red-400 transition">

                    {{-- Eye Toggle --}}
                    <button type="button" onclick="togglePassword('password_confirmation','eyeConfirm')"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600">
                        <svg id="eyeConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>

                {{-- Pesan Error --}}
                <p id="passwordError" class="hidden text-red-600 text-sm mt-2 flex items-center gap-2 animate-fade">
                    {{-- Icon error --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Password tidak cocok</span>
                </p>
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

const password = document.getElementById('password');
const confirmPass = document.getElementById('password_confirmation');
const errorMsg = document.getElementById('passwordError');
const submitButton = document.querySelector('button[type="submit"]');

function checkPasswordMatch() {
    if (confirmPass.value.length === 0) {
        errorMsg.classList.add("hidden");
        confirmPass.classList.remove("border-red-500");
        submitButton.disabled = false;
        return;
    }

    if (password.value !== confirmPass.value) {
        errorMsg.classList.remove("hidden");
        confirmPass.classList.add("border-red-500", "focus:ring-red-400");
        submitButton.disabled = true;
    } else {
        errorMsg.classList.add("hidden");
        confirmPass.classList.remove("border-red-500");
        submitButton.disabled = false;
    }
}

password.addEventListener("input", checkPasswordMatch);
confirmPass.addEventListener("input", checkPasswordMatch);


// ============================
// TOGGLE PASSWORD ICON
// ============================
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";

        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3l18 18M10.7 10.7A3 3 0 0113.3 13.3M6.1 6.1C3.8 7.9 2.3 10.2 2.036 11.683a1.012 1.012 0 000 .639C3.423 16.49 7.36 19.5 12 19.5c2.06 0 3.99-.5 5.7-1.4M17.9 17.9c1.77-1.39 3.09-3.21 4.064-5.178a1.012 1.012 0 000-.639C20.577 7.51 16.64 4.5 12 4.5c-1.54 0-3.02.3-4.35.85" />
        `;
    } else {
        input.type = "password";

        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.183.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        `;
    }
}
</script>

@endsection
