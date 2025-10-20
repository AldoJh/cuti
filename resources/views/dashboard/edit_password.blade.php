@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-16">
    <div class="relative bg-gradient-to-br from-orange-500 via-red-600 to-red-800 p-[1px] rounded-2xl shadow-2xl">
        <div class="bg-white rounded-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Ubah Password Pengguna</h2>
                <p class="text-gray-500 text-sm mt-1">Pastikan password baru minimal 8 karakter</p>
            </div>

            {{-- Alert pesan sukses / error --}}
            @if(session('password_success'))
                <div
                    class="mb-4 p-3 rounded-lg bg-green-50 border border-green-400 text-green-700 text-sm font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('password_success') }}
                </div>
            @elseif(session('error'))
                <div
                    class="mb-4 p-3 rounded-lg bg-red-50 border border-red-400 text-red-700 text-sm font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('update-user-password', $editUser->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Password Baru -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required minlength="8"
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-400 transition duration-200">
                        <button type="button" onclick="togglePassword('password', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-gray-800 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-400 transition duration-200">
                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-orange-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('get-all-user') }}"
                        class="text-gray-600 text-sm hover:text-orange-600 font-medium transition">
                        ← Kembali ke daftar user
                    </a>
                    <button type="submit"
                        class="px-6 py-3 rounded-lg bg-gradient-to-r from-orange-500 to-red-700 text-white font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Show/Hide Password --}}
<script>
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        const icon = el.querySelector('svg');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.add('text-orange-500');
        } else {
            input.type = 'password';
            icon.classList.remove('text-orange-500');
        }
    }
</script>
@endsection
