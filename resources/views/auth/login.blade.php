@extends('layouts.auth')

@section('body-class', 'bg-gray-100')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-xl rounded-lg p-6 sm:p-8 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo PN Lhokseumawe" class="w-20 sm:w-24 mx-auto mb-4">
            <h2 class="text-xl sm:text-2xl font-bold text-blue-700">Login Sistem Cuti PN</h2>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input id="email" type="email" name="email" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <button type="submit"
                    class="w-full bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800 transition duration-200">
                    Login
                </button>
            </div>
        </form>

        <p class="text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Pengadilan Negeri Lhokseumawe
        </p>
    </div>
</div>
@endsection
