@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- Ucapan Selamat Datang -->
    <div class="bg-gradient-to-r from-orange-500 via-red-700 to-red-900 rounded-3xl shadow-xl p-8 flex flex-col sm:flex-row items-center justify-between mb-10 transition duration-500 hover:scale-[1.01] hover:shadow-2xl">
        <div>
            <h1 class="text-3xl font-extrabold text-white tracking-wide drop-shadow-lg">
                Dashboard
            </h1>
            <p class="text-white text-lg mt-2">
                Selamat datang, 
                <span class="font-semibold underline decoration-yellow-300 decoration-4 underline-offset-4">
                    {{ Auth::user()->name }}
                </span> 👋
            </p>
            <p class="text-red-100 text-sm mt-2">
                Silakan pilih menu 
                <span class="font-semibold">pengajuan cuti</span> atau 
                <span class="font-semibold">persetujuan cuti</span>.
            </p>
        </div>
        <div class="hidden sm:block">
            <img src="{{ asset('images/logopnrm.png') }}" 
                 alt="Logo PN" 
                 class="w-24 h-24 drop-shadow-2xl rounded-full ring-4 ring-white/50 shadow-lg">
        </div>
    </div>


    <!-- Card Sisa Cuti -->
    @if(!in_array(Auth::user()->role, ['admin']))
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mt-6">

        <!-- Card Cuti Tahunan -->
        <div class="relative group bg-white/80 backdrop-blur-md shadow-md rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition duration-500">
            <div class="flex items-center gap-5">
                <div class="bg-gradient-to-tr from-blue-500 to-blue-700 rounded-2xl p-5 shadow-lg group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 
                                 00-2-2h-1V3H6v2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-gray-700 font-semibold text-lg">Sisa Cuti Tahunan</h4>
                    <p class="text-4xl font-extrabold text-blue-700 mt-2">
                        {{ $sisaCutiTahunan }}
                        <span class="text-base font-medium text-gray-500 ml-1">hari</span>
                    </p>
                </div>
            </div>
            <div class="absolute bottom-2 right-3 text-xs text-blue-400 font-medium opacity-80">
                📅 Tahunan
            </div>
        </div>

        <!-- Card Cuti Sakit -->
        <div class="relative group bg-white/80 backdrop-blur-md shadow-md rounded-3xl p-6 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition duration-500">
            <div class="flex items-center gap-5">
                <div class="bg-gradient-to-tr from-green-500 to-green-700 rounded-2xl p-5 shadow-lg group-hover:scale-110 transition-transform duration-500">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M9 12h6m-3-3v6m9 0a9 9 0 
                                 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-gray-700 font-semibold text-lg">Sisa Cuti Sakit</h4>
                    <p class="text-4xl font-extrabold text-green-700 mt-2">
                        {{ $sisaCutiSakit }}
                        <span class="text-base font-medium text-gray-500 ml-1">hari</span>
                    </p>
                </div>
            </div>
            <div class="absolute bottom-2 right-3 text-xs text-green-500 font-medium opacity-80">
                🩺 Kesehatan
            </div>
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
