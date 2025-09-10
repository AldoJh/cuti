@extends('layouts.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Sisa Cuti Pegawai</h1>
            <p class="text-sm text-gray-500">Informasi sisa cuti tahunan dan cuti sakit untuk seluruh pegawai</p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-12 h-12 drop-shadow-md">
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-xl border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Nama Pegawai</th>
                    <th class="px-4 py-3 text-left font-semibold">Jabatan</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Cuti Tahunan</th>
                    <th class="px-4 py-3 text-center font-semibold">Sisa Cuti Sakit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($cutiData as $data)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-2 font-medium text-gray-700">{{ $data['user']->name }}</td>
                    <td class="px-4 py-2 capitalize">{{ $data['user']->role }}</td>
                    <td class="px-4 py-2 text-center text-green-600 font-semibold">{{ $data['sisa_cuti_tahunan'] }} hari</td>
                    <td class="px-4 py-2 text-center text-blue-600 font-semibold">{{ $data['sisa_cuti_sakit'] }} hari</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
