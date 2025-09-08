@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white shadow rounded-lg">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Form Pengajuan Cuti</h1>

    <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="jenis_cuti" class="block text-gray-700 font-medium mb-1">Jenis Cuti</label>
            <select name="jenis_cuti" id="jenis_cuti" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih --</option>
                <option value="tahunan">Cuti Tahunan</option>
                <option value="sakit">Cuti Sakit</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="tanggal_selesai" class="block text-gray-700 font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div>
            <label for="alasan" class="block text-gray-700 font-medium mb-1">Alasan</label>
            <textarea name="alasan" id="alasan" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div id="surat_sakit_group" class="hidden">
            <label for="surat_sakit" class="block text-gray-700 font-medium mb-1">Unggah Surat Cuti Sakit</label>
            <input type="file" name="surat_sakit" id="surat_sakit" accept="image/*,.pdf" class="w-full border border-gray-300 rounded px-3 py-2">
            <p class="text-sm text-gray-500 mt-1">Hanya wajib untuk cuti sakit. Format: pdf/jpg/png, max 2MB.</p>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">Ajukan</button>
    </form>
</div>

<script>
  const jenisCuti = document.getElementById('jenis_cuti');
  const suratGroup = document.getElementById('surat_sakit_group');

  jenisCuti.addEventListener('change', function() {
    suratGroup.classList.toggle('hidden', this.value !== 'sakit');
  });
</script>
@endsection
