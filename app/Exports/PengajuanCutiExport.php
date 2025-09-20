<?php

namespace App\Exports;

use App\Models\pengajuan_cuti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengajuanCutiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return pengajuan_cuti::with(['user', 'approval'])->get()->map(function($item){
            return [
                'ID' => $item->id,
                'Nama Pegawai' => $item->user ? $item->user->name : '-',
                'Tanggal Mulai' => $item->tanggal_mulai,
                'Tanggal Selesai' => $item->tanggal_selesai,
                'Jenis Cuti' => $item->jenis_cuti,
                'Alasan' => $item->alasan,
                'Surat Sakit' => $item->surat_sakit ?? '-',
                'Status' => $item->status,
                'Approval Saat Ini' => $item->approval ? $item->approval->name : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pegawai',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jenis Cuti',
            'Alasan',
            'Surat Sakit',
            'Status',
            'Approval Saat Ini',
        ];
    }
}
