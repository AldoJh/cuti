@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm flex justify-between items-center shadow-sm">
            <div>
                <strong class="font-semibold">Berhasil!</strong> {{ session('success') }}
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">✕</button>
        </div>
    @endif

    <!-- Alert Error -->
    @if($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm flex justify-between items-center shadow-sm">
            <div>
                <strong class="font-semibold">Terjadi kesalahan!</strong> Periksa kembali input Anda.
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">✕</button>
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-100 relative">

        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-xl font-bold text-gray-800">Edit Sisa Cuti Pegawai</h2>
            <p class="text-gray-500 text-sm mt-1">Perbarui seluruh data sisa cuti dengan benar.</p>
        </div>

        <!-- Form -->
        <form action="{{ route('updateCuti', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                @php
                    $fields = [
                        'sisa_cuti_tahunan' => 'Sisa Cuti Tahunan',
                        'sisa_cuti_sakit' => 'Sisa Cuti Sakit',
                        'sisa_cuti_alasan_penting' => 'Sisa Cuti Alasan Penting',
                        'sisa_cuti_besar' => 'Sisa Cuti Besar',
                        'sisa_cuti_melahirkan' => 'Sisa Cuti Melahirkan',
                        'sisa_cuti_cltn' => 'Sisa Cuti CLTN'
                    ];
                @endphp

                @foreach ($fields as $key => $label)
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            {{ $label }} <span class="text-red-500">*</span>
                        </label>

                        <input 
                            type="number"
                            name="{{ $key }}"
                            value="{{ old($key, $user->$key) }}"
                            placeholder="Masukkan jumlah hari"
                            class="w-full rounded-xl border @error($key) border-red-400 @else border-gray-300 @enderror 
                                   px-4 py-2.5 text-sm shadow-sm bg-gray-50
                                   focus:ring-2 focus:ring-red-400 focus:border-red-400 transition-all"
                        >

                        @error($key)
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

            </div>

            <!-- Keterangan -->
            <p class="text-xs text-red-500 mt-2">* Semua data wajib diisi</p>

            <!-- Tombol -->
            <div class="flex justify-between items-center pt-4">

                <!-- Tombol Kembali (besar) -->
                <a href="{{ route('get-all-user') }}"
                   class="px-6 py-2.5 rounded-full text-sm font-medium border border-gray-300 bg-white 
                          hover:bg-gray-100 transition shadow-sm">
                    ← Kembali
                </a>

                <!-- Tombol Simpan -->
                <button type="submit"
                    class="px-6 py-2.5 rounded-full text-sm font-medium text-white bg-red-600 
                           hover:bg-red-700 shadow-md transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>
    </div>
</div>
@endsection
