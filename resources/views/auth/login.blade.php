@extends('layouts.auth')

@section('title', 'Login - Aplikasi Cuti Pegawai')
@section('body-class', 'bg-[#a10817]')

@section('content')
<div class="bg-white shadow-2xl rounded-lg overflow-hidden flex w-full max-w-3xl">
    <!-- Bagian Kiri (Logo) -->
    <div class="hidden md:flex items-center justify-center bg-white w-1/2 p-6">
        <img src="{{ asset('images/logopn.jpg') }}" 
            alt="Logo" 
            class="w-64 max-w-xs md:max-w-sm lg:max-w-md">
    </div>


    <!-- Bagian Kanan (Form Login) -->
    <div class="w-full md:w-1/2 bg-white p-8 flex flex-col justify-center">
        <!-- Judul -->
        <!-- Judul -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Aplikasi Cuti Pegawai</h1>
            <p class="text-gray-500 text-sm">Pengadilan Negeri Lhokseumawe</p>
        </div>
        

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email/NIP -->
            <div class="mb-4">
                <label for="login" class="block text-gray-700 font-medium mb-1">Email/NIP</label>
                <input id="login" type="text" name="login" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    @error('login')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

             <!-- Error global (Email/NIP atau password salah) -->
             @if ($errors->has('login'))
             <div class="mb-3">
                 <p class="text-red-600 text-sm">{{ $errors->first('login') }}</p>
             </div>
         @endif

            <!-- Tombol Login -->
            <div class="mb-3">
                <button type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    Login
                </button>
            </div>

            <!-- Tombol Buat Akun -->
            {{-- <div class="mb-3">
                <button type="button"
                    onclick="alert('Fitur pendaftaran akan segera hadir!')"
                    class="w-full bg-gray-300 text-gray-600 py-2 rounded-lg cursor-not-allowed">
                    Buat Akun
                </button>
            </div> --}}
        </form>
    </div>
</div>
@endsection
