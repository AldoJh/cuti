@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Sisa Cuti Pegawai</h2>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Pegawai</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Role</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sisa Cuti Tahunan</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Sisa Cuti Sakit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($cutiData as $data)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $data['user']->name }}</td>
                    <td class="px-4 py-2">{{ $data['user']->role }}</td>
                    <td class="px-4 py-2">{{ $data['sisa_cuti_tahunan'] }} hari</td>
                    <td class="px-4 py-2">{{ $data['sisa_cuti_sakit'] }} hari</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
