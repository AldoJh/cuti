<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupCutiTahunan extends Model
{
    use HasFactory;

    protected $table = 'backup_cuti_tahunan';

    protected $fillable = [
        'user_id',
        'tahun',
        'sisa_cuti_tahunan',
        'sisa_cuti_sakit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
