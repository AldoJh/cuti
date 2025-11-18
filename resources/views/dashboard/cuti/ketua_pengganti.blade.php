@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-2 space-y-14">

    {{-- ===== Header Glassmorphism ===== --}}
    <div class="rounded-2xl shadow-xl overflow-hidden bg-gradient-to-b from-orange-500 to-red-900 p-6 text-center text-white relative backdrop-blur-md">

        <div class="absolute inset-0 bg-white/10 backdrop-blur-xl rounded-3xl"></div>

        <div class="relative z-10">
            <h1 class="text-4xl font-extrabold tracking-tight drop-shadow-xl">
                Pengaturan PLH Pimpinan & Unit
            </h1>

            <p class="text-lg mt-4 max-w-2xl mx-auto leading-relaxed opacity-95 font-light">
                Kelola penunjukan PLH Ketua, Panitera, dan Sekretaris untuk memastikan layanan tetap berjalan
                saat pejabat utama tidak aktif.
            </p>
        </div>
    </div>


    {{-- ===== Card PLH Ketua ===== --}}
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-gray-200/60 
                p-10 transition-all duration-300 hover:shadow-3xl hover:-translate-y-1">

        <h2 class="text-2xl font-semibold text-gray-900 text-center mb-2">Atur PLH Ketua</h2>
        <p class="text-gray-500 text-center mb-7 text-sm">
            PLH Ketua menggantikan Ketua Pengadilan ketika pejabat utama tidak aktif.
        </p>

        {{-- Alerts --}}
        @if(session('success_ketua'))
            <div class="mb-5 p-3 rounded-xl bg-green-100 text-green-800 text-center font-medium shadow">
                {{ session('success_ketua') }}
            </div>
        @elseif(session('error_ketua'))
            <div class="mb-5 p-3 rounded-xl bg-red-100 text-red-800 text-center font-medium shadow">
                {{ session('error_ketua') }}
            </div>
        @endif

        <form action="{{ route('cuti.setKetuaPengganti') }}" method="POST" class="space-y-5">
            @csrf

            <select name="user_id" required
                class="w-full border border-gray-300 rounded-2xl px-4 py-3 bg-gray-50 text-gray-800 text-center
                       shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">— Pilih PLH Ketua —</option>
                @foreach($users as $user)
                    @if(in_array($user->role, ['ketua', 'wakil_ketua', 'hakim']))
                        <option value="{{ $user->id }}" {{ $user->is_ketua_pengganti ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                        </option>
                    @endif
                @endforeach
            </select>

            <button type="submit"
                class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-2xl shadow-md
                       hover:bg-indigo-700 transition-all">
                Simpan PLH Ketua
            </button>
        </form>
    </div>



    {{-- ===== Grid PLH Panitera & Sekretaris ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- ===== PLH Panitera ===== --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-gray-200/60 
                    p-8 transition-all duration-300 hover:shadow-3xl hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-gray-900 text-center mb-2">Atur PLH Panitera</h2>
            <p class="text-gray-500 text-center mb-6 text-sm">
                PLH Panitera menggantikan Panitera utama saat tidak aktif.
            </p>

            {{-- Alerts --}}
            @if(session('success_panitera'))
                <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-900 text-center font-medium shadow">
                    {{ session('success_panitera') }}
                </div>
            @elseif(session('error_panitera'))
                <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-900 text-center font-medium shadow">
                    {{ session('error_panitera') }}
                </div>
            @endif

            <form action="{{ route('plh.panitera.set') }}" method="POST" class="space-y-4">
                @csrf

                <select name="user_id" required
                    class="w-full border border-gray-300 rounded-2xl px-3 py-3 bg-gray-50 text-center 
                           shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">— Pilih PLH Panitera —</option>
                    @foreach($users as $user)
                        @if(in_array($user->role, ['panitera', 'panmud']))
                            <option value="{{ $user->id }}" {{ $user->is_plh_panitera ? 'selected' : '' }}>
                                {{ $user->name }} ({{ ucfirst($user->jabatan) }})
                            </option>
                        @endif
                    @endforeach
                </select>

                <button type="submit"
                    class="w-full py-3 bg-teal-600 text-white font-semibold rounded-2xl shadow-md
                           hover:bg-teal-700 transition-all">
                    Simpan PLH Panitera
                </button>
            </form>
        </div>



        {{-- ===== PLH Sekretaris ===== --}}
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-gray-200/60 
                    p-8 transition-all duration-300 hover:shadow-3xl hover:-translate-y-1">
            <h2 class="text-xl font-semibold text-gray-900 text-center mb-2">Atur PLH Sekretaris</h2>
            <p class="text-gray-500 text-center mb-6 text-sm">
                PLH Sekretaris menggantikan Sekretaris saat tidak aktif.
            </p>

            {{-- Alerts --}}
            @if(session('success_sekretaris'))
                <div class="mb-4 p-3 rounded-xl bg-green-100 text-green-900 text-center font-medium shadow">
                    {{ session('success_sekretaris') }}
                </div>
            @elseif(session('error_sekretaris'))
                <div class="mb-4 p-3 rounded-xl bg-red-100 text-red-900 text-center font-medium shadow">
                    {{ session('error_sekretaris') }}
                </div>
            @endif

            <form action="{{ route('plh.sekretaris.set') }}" method="POST" class="space-y-4">
                @csrf

                <select name="user_id" required
                    class="w-full border border-gray-300 rounded-2xl px-3 py-3 bg-gray-50 text-center 
                           shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="">— Pilih PLH Sekretaris —</option>
                    @foreach($users as $user)
                        @if(in_array($user->role, ['sekretaris', 'kasubbag']))
                            <option value="{{ $user->id }}" {{ $user->is_plh_sekretaris ? 'selected' : '' }}>
                                {{ $user->name }} ({{ ucfirst($user->jabatan) }})
                            </option>
                        @endif
                    @endforeach
                </select>

                <button type="submit"
                    class="w-full py-3 bg-orange-500 text-white font-semibold rounded-2xl shadow-md
                           hover:bg-orange-600 transition-all">
                    Simpan PLH Sekretaris
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
