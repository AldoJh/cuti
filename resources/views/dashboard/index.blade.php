@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-1">Selamat datang, {{ Auth::user()->name }} 👋</p>
        <p class="text-gray-600">Silakan pilih menu pengajuan cuti atau persetujuan cuti.</p>
    </div>

    @if(!in_array(Auth::user()->role, ['admin']))
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
        <div class="bg-white shadow rounded-lg p-4 border-l-4 border-blue-500">
            <h4 class="text-gray-700 font-medium">Sisa Cuti Tahunan</h4>
            <p class="text-xl font-bold text-gray-800 mt-1">{{ $sisaCutiTahunan }} hari</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4 border-l-4 border-green-500">
            <h4 class="text-gray-700 font-medium">Sisa Cuti Sakit</h4>
            <p class="text-xl font-bold text-gray-800 mt-1">{{ $sisaCutiSakit }} hari</p>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
  @if(session('success'))
    swal({
      title: "Berhasil!",
      text: "{{ session('success') }}",
      icon: "success",
      buttons: false,
      timer: 3000
    });
  @endif

  @if(session('error'))
    swal({
      title: "Gagal!",
      text: "{{ session('error') }}",
      icon: "error",
      buttons: false,
      timer: 3000
    });
  @endif
</script>
@endsection
