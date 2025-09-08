@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Pengajuan Cuti Masuk</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    @if($pengajuanCuti->isEmpty())
        <p class="text-gray-600">Tidak ada pengajuan cuti yang harus disetujui saat ini.</p>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Pegawai</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Jenis Cuti</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Alasan</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Surat</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pengajuanCuti as $cuti)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $cuti->user->name }}</td>
                            <td class="px-4 py-2">{{ ucfirst($cuti->jenis_cuti) }}</td>
                            <td class="px-4 py-2">{{ $cuti->tanggal_mulai }}</td>
                            <td class="px-4 py-2">{{ $cuti->tanggal_selesai }}</td>
                            <td class="px-4 py-2">{{ $cuti->alasan }}</td>
                            <td class="px-4 py-2">
                                @if($cuti->surat_sakit)
                                    <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" target="_blank" class="text-blue-500 hover:underline">Lihat/Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">Setujui</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
