@extends('layouts.app')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Cuti Masuk</h1>
            <p class="text-gray-500 text-sm">Kelola semua permintaan cuti pegawai</p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN" class="w-12 h-12 drop-shadow-md">
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded shadow">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Pengajuan --}}
    @if($pengajuanCuti->isEmpty())
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <p class="text-gray-600 text-sm">Tidak ada pengajuan cuti yang perlu disetujui saat ini.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-600">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Nama Pegawai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Jenis Cuti</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Mulai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Selesai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Alasan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Surat</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pengajuanCuti as $cuti)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm">{{ $cuti->user->name }}</td>
                            <td class="px-4 py-3 text-sm">{{ ucfirst($cuti->jenis_cuti) }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cuti->tanggal_mulai }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cuti->tanggal_selesai }}</td>
                            <td class="px-4 py-3 text-sm">{{ $cuti->alasan }}</td>
                            <td class="px-4 py-3">
                                @if($cuti->surat_sakit)
                                    <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:underline text-sm font-medium">
                                       Lihat Surat
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center flex space-x-2 justify-center">
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                        Setujui
                                    </button>
                                </form>
                                {{-- Tombol Tolak (opsional) --}}
                                <form action="{{ route('cuti.reject', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow transition">
                                        Tolak
                                    </button>
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
