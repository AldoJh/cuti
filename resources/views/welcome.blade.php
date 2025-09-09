@extends('layouts.public')

@section('content')
<div class="flex flex-col items-center text-center space-y-6">

    {{-- Logo --}}
    <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="h-24 w-24 object-contain">

    {{-- Judul --}}
    <h1 class="text-3xl font-extrabold text-gray-800 tracking-wide">
        Selamat Datang di <br> 
        <span class="text-red-700">Sistem Pengajuan Cuti Pegawai</span>
    </h1>

    {{-- Deskripsi --}}
    <p class="text-gray-600 max-w-md leading-relaxed">
        Sistem ini memudahkan pegawai untuk mengajukan cuti dan mempermudah atasan dalam proses persetujuan.
        Semua proses dilakukan secara online, cepat, dan efisien.
    </p>

    <p class="text-gray-600">
        Silakan login untuk mengakses fitur pengajuan atau persetujuan cuti.
    </p>

    {{-- Tombol Login --}}
    <a href="{{ route('login') }}"
       class="inline-block bg-red-700 hover:bg-red-800 text-white text-lg font-semibold px-8 py-3 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
        🚀 Login Sekarang
    </a>

</div>
@endsection
