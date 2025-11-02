@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-12 space-y-10">

    {{-- ===== Ketua Pengganti ===== --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4 text-center">
            Atur Ketua Pengganti
        </h2>

        @if(session('success_ketua'))
            <div class="mb-3 p-2 rounded bg-green-100 text-green-900 text-center font-medium">
                {{ session('success_ketua') }}
            </div>
        @elseif(session('error_ketua'))
            <div class="mb-3 p-2 rounded bg-red-100 text-red-900 text-center font-medium">
                {{ session('error_ketua') }}
            </div>
        @endif

        <form action="{{ route('cuti.setKetuaPengganti') }}" method="POST" class="space-y-4">
            @csrf
            <select name="user_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ $user->is_ketua_pengganti ? 'selected' : '' }}>
                        {{ $user->name }} ({{ ucfirst($user->role) }})
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                Simpan
            </button>
        </form>
    </div>

    {{-- ===== PLH Panitera & Sekretaris (grid responsive) ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- PLH Panitera --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 mb-3 text-center">
                Atur PLH Panitera
            </h2>

            @if(session('success_panitera'))
                <div class="mb-2 p-2 rounded bg-green-100 text-green-900 text-center font-medium">
                    {{ session('success_panitera') }}
                </div>
            @elseif(session('error_panitera'))
                <div class="mb-2 p-2 rounded bg-red-100 text-red-900 text-center font-medium">
                    {{ session('error_panitera') }}
                </div>
            @endif

            <form action="{{ route('plh.panitera.set') }}" method="POST" class="space-y-3">
                @csrf
                <select name="user_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        @if(in_array($user->role, ['panitera', 'panitera_pengganti']))
                        <option value="{{ $user->id }}" 
                            {{ $user->is_plh_panitera ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                        </option>
                        @endif
                    @endforeach
                </select>

                <button type="submit"
                    class="w-full py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition">
                    Simpan
                </button>
            </form>
        </div>

        {{-- PLH Sekretaris --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900 mb-3 text-center">
                Atur PLH Sekretaris
            </h2>

            @if(session('success_sekretaris'))
                <div class="mb-2 p-2 rounded bg-green-100 text-green-900 text-center font-medium">
                    {{ session('success_sekretaris') }}
                </div>
            @elseif(session('error_sekretaris'))
                <div class="mb-2 p-2 rounded bg-red-100 text-red-900 text-center font-medium">
                    {{ session('error_sekretaris') }}
                </div>
            @endif

            <form action="{{ route('plh.sekretaris.set') }}" method="POST" class="space-y-3">
                @csrf
                <select name="user_id" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        @if(in_array($user->role, ['sekretaris', 'kassubag']))
                        <option value="{{ $user->id }}" 
                            {{ $user->is_plh_sekretaris ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                        </option>
                        @endif
                    @endforeach
                </select>

                <button type="submit"
                    class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition">
                    Simpan
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
