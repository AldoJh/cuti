@extends('layouts.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="bg-gradient-to-b from-orange-500 to-red-900 rounded-xl shadow-lg p-6 mb-6 flex items-center justify-between transition hover:scale-[1.01] hover:shadow-xl">
        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">
                Daftar Sisa Cuti Pegawai
            </h1>
            <p class="text-sm text-red-100 mt-1">
                Informasi sisa cuti tahunan dan cuti sakit untuk seluruh pegawai
            </p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-14 h-14 drop-shadow-lg rounded-full ring-2 ring-white/50">
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-orange-500 to-red-900 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pegawai</th>
                    <th class="px-4 py-3 text-left font-semibold">Jabatan</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Cuti Tahunan</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Cuti Sakit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($cutiData as $data)
                <tr class="hover:bg-orange-50 transition">
                    <td class="px-4 py-2 font-medium text-gray-800">{{ $data['user']->name }}</td>
                    <td class="px-4 py-2 capitalize text-gray-600">{{ $data['user']->role }}</td>
                    <td class="px-4 py-2 text-center text-green-600 font-semibold">
                        {{ $data['sisa_cuti_tahunan'] }} hari
                    </td>
                    <td class="px-4 py-2 text-center text-blue-600 font-semibold">
                        {{ $data['sisa_cuti_sakit'] }} hari
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
