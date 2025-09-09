@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Ucapan Selamat Datang -->
    <div class="bg-gradient-to-r from-red-500 via-red-600 to-red-700 rounded-xl shadow-lg p-4 flex flex-col sm:flex-row items-center justify-between mb-6 transition duration-300 hover:scale-[1.01]">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Dashboard</h1>
            <p class="text-white text-base mt-1">
                Selamat datang, <span class="font-semibold underline decoration-yellow-300">{{ Auth::user()->name }}</span> 👋
            </p>
            <p class="text-red-100 text-sm mt-1">
                Silakan pilih menu <span class="font-semibold">pengajuan cuti</span> atau <span class="font-semibold">persetujuan cuti</span>.
            </p>
        </div>
        <div class="hidden sm:block">
            <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-20 h-20 drop-shadow-md">
        </div>
    </div>

    <!-- Card Sisa Cuti -->
    @if(!in_array(Auth::user()->role, ['admin']))
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-4">
        <!-- Card Cuti Tahunan -->
        <div class="bg-white shadow-md rounded-xl p-4 border-t-4 border-blue-500 flex flex-col items-center hover:shadow-lg hover:-translate-y-1 transition duration-300">
            <div class="bg-blue-100 rounded-full p-3 mb-3">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2h-1V3H6v2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h4 class="text-gray-700 font-semibold text-base">Sisa Cuti Tahunan</h4>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $sisaCutiTahunan }}<span class="text-base ml-1">hari</span></p>
        </div>

        <!-- Card Cuti Sakit -->
        <div class="bg-white shadow-md rounded-xl p-4 border-t-4 border-green-500 flex flex-col items-center hover:shadow-lg hover:-translate-y-1 transition duration-300">
            <div class="bg-green-100 rounded-full p-3 mb-3">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h4 class="text-gray-700 font-semibold text-base">Sisa Cuti Sakit</h4>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $sisaCutiSakit }}<span class="text-base ml-1">hari</span></p>
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
