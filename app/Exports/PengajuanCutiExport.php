<?php

namespace App\Exports;

use App\Models\Pengajuan_Cuti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengajuanCutiExport implements FromCollection, WithHeadings
{
    protected $cutis;

    /**
     * Terima collection data cuti dari controller
     * Bisa semua data, bisa juga per user.
     */
    public function __construct($cutis = null)
    {
        // Kalau tidak dikirim dari controller, ambil semua data default
        $this->cutis = $cutis ?? Pengajuan_Cuti::with(['user', 'approval'])->get();
    }

    public function collection()
    {
        return $this->cutis->map(function($item){
            return [
                'ID'               => $item->id,
                'Nama Pegawai'     => $item->user->name ?? '-',
                'Jabatan'          => $item->user->jabatan ?? '-',
                'Jenis Cuti'       => $item->jenis_cuti,
                'Tanggal Mulai'    => $item->tanggal_mulai,
                'Tanggal Selesai'  => $item->tanggal_selesai,
                'Alasan'           => $item->alasan,
                'Surat Sakit'      => $item->surat_sakit ?? '-',
                'Approval'         => $item->approval->name ?? '-',
                'Status'           => ucfirst($item->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pegawai',
            'Jabatan',
            'Jenis Cuti',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Alasan',
            'Surat Sakit',
            'Approval',
            'Status',
        ];
    }
}
