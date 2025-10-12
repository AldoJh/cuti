@extends('layouts.auth')

@section('title', 'Login - Aplikasi Cuti Pegawai')
@section('body-class', 'min-h-screen flex items-center justify-center bg-gradient-to-br from-[#9c1f02] via-[#b12a07] to-[#6d1803] font-serif')

@section('content')
<div
  class="flex flex-col md:flex-row w-full max-w-5xl mx-auto bg-white/95 shadow-2xl rounded-3xl overflow-hidden
         border border-yellow-500/50 transform transition-all duration-500 scale-95 md:scale-100
         hover:scale-100 hover:shadow-[0_0_40px_rgba(255,215,0,0.5)] backdrop-blur-sm">

  <!-- BAGIAN KIRI: VECTOR + TEKS MOTIVASI -->
  <div class="hidden md:flex flex-col items-center justify-center bg-gradient-to-br from-yellow-50 to-orange-100 w-1/2 relative overflow-hidden">
    <img src="{{ asset('images/vector.png') }}" alt="Vector" 
         class="w-4/5 drop-shadow-2xl animate-float select-none mb-6">

    <div class="text-center text-gray-700 px-8">
      <h2 class="text-2xl font-bold mb-2 text-yellow-700">Efisien, Cepat, dan Transparan</h2>
      <p class="text-sm text-gray-600 italic leading-relaxed">
        “Kelola pengajuan cuti Anda dengan mudah melalui sistem digital terintegrasi — 
        karena waktu Anda berharga.”
      </p>
    </div>
  </div>

  <!-- BAGIAN KANAN: CARD LOGIN -->
  <div class="w-full md:w-1/2 bg-white px-10 py-12 flex flex-col justify-center relative">

    <!-- Logo di pojok kanan atas -->
    <div class="absolute top-5 right-5">
      <img src="{{ asset('images/logopn.jpg') }}" alt="Logo" 
           class="w-12 h-12 rounded-full shadow-md border border-yellow-400/50">
    </div>

    <!-- Judul & Deskripsi -->
    <div class="text-center mb-8">
      <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm">SIM-C</h1>
      <p class="text-gray-600 text-sm mt-1 font-sans">Sistem Informasi Manajemen Cuti</p>
      <div class="w-full h-[3px] bg-yellow-500 mx-auto mt-3 rounded-full"></div>
    </div>

    <!-- Sambutan -->
    <div class="text-center mb-8">
      <h2 class="text-xl font-semibold text-gray-700">Selamat Datang Kembali</h2>
      <p class="text-gray-500 text-sm mt-1 font-sans">Masuk ke akun Anda untuk mengelola pengajuan cuti dan status persetujuan</p>
    </div>

    <!-- FORM LOGIN -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
      @csrf

      <!-- Email/NIP -->
      <div>
        <label for="login" class="block text-gray-700 font-medium mb-1">Email atau NIP</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center justify-center w-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M10 2a5 5 0 100 10 5 5 0 000-10zM2 18a8 8 0 1116 0H2z"
                clip-rule="evenodd" />
            </svg>
          </span>
          <input id="login" type="text" name="login" required autofocus
            class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm
                   focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                   transition duration-200 font-sans placeholder-gray-400"
            placeholder="Masukkan email atau NIP">
        </div>
        @error('login')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-gray-700 font-medium mb-1">Kata Sandi</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center justify-center w-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5 8V6a5 5 0 1110 0v2h1a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V9a1 1 0 011-1h1zm2-2v2h6V6a3 3 0 00-6 0z"
                clip-rule="evenodd" />
            </svg>
          </span>

          <input id="password" type="password" name="password" required
            class="w-full pl-12 pr-10 py-2.5 border border-gray-300 rounded-lg shadow-sm
                   focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500
                   transition duration-200 font-sans placeholder-gray-400"
            placeholder="Masukkan kata sandi">

          <!-- Tombol show/hide password -->
          <button type="button" onclick="togglePassword()"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none transition">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path id="eyePath"
                d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z" />
            </svg>
          </button>
        </div>
        @error('password')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Tombol Login -->
      <div class="pt-3">
        <button type="submit"
          class="w-full relative overflow-hidden text-white py-2.5 rounded-lg font-semibold shadow-lg
                 focus:ring-2 focus:ring-green-400 transition duration-300 font-sans
                 hover:shadow-xl hover:scale-[1.02] active:scale-95">
          <span
            class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-500 to-green-600
                   bg-[length:200%_200%] animate-gradient-x rounded-lg"></span>
          <span class="relative z-10">Masuk Sekarang</span>
        </button>
      </div>
    </form>

    <!-- Footer kecil -->
    <div class="text-center text-gray-400 text-xs mt-10 select-none">
      <p>© {{ date('Y') }} SIM-C — Aplikasi Cuti Pegawai</p>
      <p class="text-[10px] italic mt-1">Pengadilan Negeri Lhokseumawe</p>
    </div>
  </div>
</div>

<!-- ANIMASI -->
<style>
@keyframes gradient-x {
  0%   { background-position: 0% 50%; }
  50%  { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
}
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50%      { transform: translateY(-10px); }
}
.animate-float {
  animation: float 4s ease-in-out infinite;
}
</style>

<!-- SCRIPT SHOW/HIDE PASSWORD -->
<script>
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const eyePath = document.getElementById('eyePath');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    eyePath.setAttribute("d",
      "M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12zm11-4a4 4 0 100 8 4 4 0 000-8zm10.293 10.293l-1.414 1.414-18-18 1.414-1.414 18 18z"
    );
  } else {
    passwordInput.type = 'password';
    eyePath.setAttribute("d",
      "M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z"
    );
  }
}
</script>
@endsection
