<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan_Cuti extends Model
{
    /** @use HasFactory<\Database\Factories\PengajuanCutiFactory> */
    use HasFactory;

    protected $table = 'pengajuan_cutis';
    
    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'surat_sakit',
        'status',
        'current_approval_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approval()
{
    return $this->belongsTo(User::class, 'current_approval_id');
}

}
