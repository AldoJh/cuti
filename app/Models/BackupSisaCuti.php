<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupSisaCuti extends Model
{
    use HasFactory;

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
