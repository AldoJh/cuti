@extends('layouts.auth')

@section('title', 'Login - Aplikasi Cuti Pegawai')
@section('body-class', 'min-h-screen flex items-center justify-center bg-[#992103] font-serif')
<!-- @section('body-class', 'min-h-screen flex items-center justify-center bg-gradient-to-b from-orange-500 to-red-900 font-serif') -->

@section('content')
<div class="bg-white shadow-2xl rounded-2xl overflow-hidden flex w-full max-w-3xl border border-yellow-500/60 transform scale-95 md:scale-100 transition-all duration-300 hover:scale-100 hover:shadow-[0_0_25px_rgba(255,215,0,0.6)]">
    <!-- Bagian Kiri (Logo) -->
    <div class="hidden md:flex flex-col items-center justify-center bg-white w-1/2 p-6 relative">
        <img src="{{ asset('images/logopn.jpg') }}" 
            alt="Logo" 
            class="w-64 max-w-xs md:max-w-sm lg:max-w-md mb-4">
    </div>

    <!-- Bagian Kanan (Judul + Form Login) -->
    <div class="w-full md:w-1/2 bg-white p-8 flex flex-col justify-center">
        <!-- Judul -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Sim-C</h1>
            <p class="text-gray-600 text-sm">Sistem Cuti</p>
        </div>


        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email/NIP -->
            <div class="mb-4">
                <label for="login" class="block text-gray-700 font-medium mb-1">Email/NIP</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center justify-center w-10 h-10">
                        <!-- Icon orang -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a5 5 0 100 10 5 5 0 000-10zM2 18a8 8 0 1116 0H2z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <input id="login" type="text" name="login" required autofocus
                        class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-yellow-500 font-sans">
                </div>
                @error('login')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <div class="relative">
                    <!-- Icon gembok -->
                    <span class="absolute inset-y-0 left-0 flex items-center justify-center w-10 h-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 8V6a5 5 0 1110 0v2h1a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V9a1 1 0 011-1h1zm2-2v2h6V6a3 3 0 00-6 0z" clip-rule="evenodd" />
                        </svg>
                    </span>

                    <!-- Input password -->
                    <input id="password" type="password" name="password" required
                        class="w-full pl-12 pr-10 py-2 border border-gray-300 rounded-lg shadow-sm 
                               focus:outline-none focus:ring-2 focus:ring-yellow-500 font-sans">

                    <!-- Tombol show/hide -->
                    <button type="button" onclick="togglePassword()" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <!-- Icon mata -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path id="eyePath" d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                class="w-full relative overflow-hidden text-white py-2 rounded-lg font-semibold shadow-lg 
                       focus:ring-2 focus:ring-green-400 transition duration-200 font-sans">
                <span class="absolute inset-0 bg-gradient-to-r from-green-600 via-emerald-500 to-green-600 
                             bg-[length:200%_200%] animate-gradient-x"></span>
                <span class="relative">Login</span>
            </button>
        </form>
    </div>
</div>

<!-- Animasi gradient -->
<style>
@keyframes gradient-x {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
.animate-gradient-x {
  animation: gradient-x 3s ease infinite;
}
</style>

<!-- Script Show/Hide Password -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyePath = document.getElementById('eyePath');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        // ikon mata dicoret
        eyePath.setAttribute("d", "M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12zm11-4a4 4 0 100 8 4 4 0 000-8zm10.293 10.293l-1.414 1.414-18-18 1.414-1.414 18 18z");
    } else {
        passwordInput.type = 'password';
        // ikon mata biasa
        eyePath.setAttribute("d", "M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z");
    }
}
</script>
@endsection
