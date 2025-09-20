@extends('layouts.public')

@section('content')
<div class="flex flex-col items-center text-center space-y-6">

    {{-- Logo --}}
    <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="h-24 w-24 object-contain">

    {{-- Judul --}}
    <h1 class="text-3xl font-extrabold tracking-wide">
        Selamat Datang di <br> 
        <span class="text-yellow-300">Sistem Pengajuan Cuti Pegawai</span>
    </h1>

    {{-- Deskripsi --}}
    <p class="text-yellow-100 max-w-md leading-relaxed">
        Sistem ini memudahkan pegawai untuk mengajukan cuti dan mempermudah atasan dalam proses persetujuan.
        Semua proses dilakukan secara online, cepat, dan efisien.
    </p>

    <p class="text-yellow-100">
        Silakan login untuk mengakses fitur pengajuan atau persetujuan cuti.
    </p>

    {{-- Tombol Login --}}
    <a href="{{ route('login') }}"
       class="inline-block bg-white hover:bg-yellow-200 text-[#992103] text-lg font-semibold px-8 py-3 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
        🚀 Login Sekarang
    </a>

</div>
@endsection
