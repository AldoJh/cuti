@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-12">
    <div class="bg-gradient-to-b from-orange-500 to-red-900 shadow-xl rounded-2xl p-1">
        <div class="bg-white rounded-xl p-8">
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Atur Ketua Pengganti
            </h2>

            {{-- Alert pesan sukses / error --}}
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 border border-green-300 text-green-700 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-100 border border-red-300 text-red-700 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('cuti.setKetuaPengganti') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Dropdown -->
                <div>
                    <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Ketua Pengganti
                    </label>
                    <div class="relative">
                        <select name="user_id" id="user_id" required
                            class="block w-full appearance-none rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 pr-10 text-gray-800 shadow focus:border-orange-500 focus:ring-2 focus:ring-orange-400 transition">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ $user->is_ketua_pengganti ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ ucfirst($user->role) }})
                                </option>
                            @endforeach
                        </select>
                        {{-- Icon panah --}}
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-3 rounded-lg bg-gradient-to-r from-orange-500 to-red-700 text-white font-semibold shadow-lg hover:opacity-90 focus:ring-2 focus:ring-orange-300 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
