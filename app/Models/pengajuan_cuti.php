<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuan_cuti extends Model
{
    /** @use HasFactory<\Database\Factories\PengajuanCutiFactory> */
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'surat_sakit',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
