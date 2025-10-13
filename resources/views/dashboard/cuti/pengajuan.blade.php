@extends('layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-orange-500 to-red-900 rounded-xl shadow-lg p-6 mb-6 flex items-center justify-between transition hover:scale-[1.01] hover:shadow-xl">
        <div>
            <h1 class="text-2xl font-bold text-white drop-shadow">
                Pengajuan Cuti Masuk
            </h1>
            <p class="text-sm text-red-100 mt-1">
                Kelola semua permintaan cuti pegawai
            </p>
        </div>
        <img src="{{ asset('images/logopnrm.png') }}" alt="Logo PN"
             class="w-14 h-14 drop-shadow-lg rounded-full ring-2 ring-white/50">
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg border border-green-200 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-200 shadow-sm">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Pengajuan --}}
    @if($pengajuanCuti->isEmpty())
        <div class="bg-white shadow rounded-xl p-6 text-center border border-gray-200">
            <p class="text-gray-600 text-sm">Tidak ada pengajuan cuti yang perlu disetujui saat ini.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-orange-500 to-red-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Nama Pegawai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Jenis Cuti</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Mulai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Selesai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Alasan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Berkas</th>                        
                        <th class="px-4 py-3 text-left text-xs font-semibold text-white">Surat</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pengajuanCuti as $cuti)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $cuti->user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($cuti->jenis_cuti) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $cuti->tanggal_mulai }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $cuti->tanggal_selesai }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $cuti->alasan }}</td>

                            {{-- 📄 Kolom Berkas Form dan Surat Izin --}}
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('cuti.print_form', $cuti->id) }}" target="_blank"
                                       class="inline-flex items-center justify-center gap-2 px-3 py-1.5 text-xs font-medium text-white
                                              bg-gradient-to-r from-red-600 to-red-800 rounded-lg shadow 
                                              hover:from-red-700 hover:to-red-900 transition transform hover:scale-[1.05]">
                                        🖨️ Form Cuti
                                    </a>
                                    <a href="{{ route('cuti.print_izin', $cuti->id) }}" target="_blank"
                                       class="inline-flex items-center justify-center gap-2 px-3 py-1.5 text-xs font-medium text-white
                                              bg-gradient-to-r from-orange-500 to-yellow-600 rounded-lg shadow 
                                              hover:from-orange-600 hover:to-yellow-700 transition transform hover:scale-[1.05]">
                                        🖨️ Surat Izin
                                    </a>
                                </div>
                            </td>

                            {{-- 📎 Kolom Surat Sakit --}}
                            <td class="px-4 py-3 text-center">
                                @if($cuti->surat_sakit)
                                    <a href="{{ asset('storage/' . $cuti->surat_sakit) }}" 
                                    target="_blank" 
                                    class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-white 
                                            bg-gradient-to-r from-blue-500 to-indigo-500 
                                            rounded-lg shadow hover:from-blue-600 hover:to-indigo-600 transition">
                                        📄 Lihat Surat
                                    </a>
                                @else
                                    <span class="px-3 py-1 text-xs text-gray-500 bg-gray-100 rounded-md shadow-sm">
                                        Tidak ada
                                    </span>
                                @endif
                            </td>

                            {{-- 🛠️ Kolom Aksi --}}
                            <td class="px-4 py-3 text-center flex space-x-2 justify-center">
                                {{-- Tombol Setujui --}}
                                <form action="{{ route('cuti.approve', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-1.5 rounded-lg text-xs shadow transition transform hover:scale-[1.05]">
                                        ✅ Setujui
                                    </button>
                                </form>
                                {{-- Tombol Tolak --}}
                                <form action="{{ route('cuti.reject', $cuti->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-1.5 rounded-lg text-xs shadow transition transform hover:scale-[1.05]">
                                        ❌ Tolak
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
