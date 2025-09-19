@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    {{-- Card --}}
    <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN"
                 class="w-14 h-14 drop-shadow-lg rounded-full ring-2 ring-orange-400/40">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Form Pengajuan Cuti</h1>
                <p class="text-gray-500 text-sm">Silakan isi form berikut untuk mengajukan cuti pegawai</p>
            </div>
        </div>

        {{-- Alert Sukses & Error --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg border border-green-200 shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-200 shadow-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Jenis Cuti --}}
            <div>
                <label for="jenis_cuti" class="block text-gray-700 font-medium mb-1">Jenis Cuti</label>
                <select name="jenis_cuti" id="jenis_cuti" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">-- Pilih --</option>
                    <option value="tahunan">Cuti Tahunan</option>
                    <option value="sakit">Cuti Sakit</option>
                    <option value="besar">Cuti Besar</option>
                    <option value="melahirkan">Cuti Melahirkan</option>
                    <option value="alasan_penting">Cuti Alasan Penting</option>
                    <option value="cltn">Cuti LTN (Luar Tanggungan Negara)</option>
                </select>
            </div>

            {{-- Tanggal Mulai & Selesai --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-gray-700 font-medium mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
            </div>

            {{-- Alasan --}}
            <div>
                <label for="alasan" class="block text-gray-700 font-medium mb-1">Alasan</label>
                <textarea name="alasan" id="alasan" required rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                    placeholder="Jelaskan alasan cuti secara singkat"></textarea>
            </div>

            {{-- Surat Sakit --}}
            <div id="surat_sakit_group" class="hidden">
                <label for="surat_sakit" class="block text-gray-700 font-medium mb-1">Unggah Surat Cuti Sakit</label>
                <input type="file" name="surat_sakit" id="surat_sakit" accept="image/*,.pdf"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                <p class="text-sm text-gray-500 mt-1">Wajib diunggah untuk cuti sakit. Format: pdf/jpg/png, max 2MB.</p>
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg shadow transition">
                    ← Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-red-900 hover:from-orange-600 hover:to-red-800 text-white px-5 py-2 rounded-lg shadow-lg transition transform hover:scale-[1.02]">
                    🚀 Ajukan Cuti
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const jenisCuti = document.getElementById('jenis_cuti');
    const suratGroup = document.getElementById('surat_sakit_group');

    jenisCuti.addEventListener('change', function() {
        suratGroup.classList.toggle('hidden', this.value !== 'sakit');
    });
</script>
@endsection
