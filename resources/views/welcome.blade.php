@extends('layouts.public')

@section('content')
<div class="space-y-4">
  <h1 class="text-2xl font-bold text-gray-800">Selamat Datang di Sistem Pengajuan Cuti</h1>
  <p class="text-gray-600">Sistem ini memudahkan pegawai untuk mengajukan cuti dan atasan untuk menyetujui pengajuan cuti.</p>
  <p class="text-gray-600">Silakan login untuk mengakses fitur pengajuan atau persetujuan cuti.</p>
  <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200">
    Login Sekarang
  </a>
</div>
@endsection
