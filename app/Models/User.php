<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'atasan_id',
        'ttd_path',
        'role',
        'nip',
        'jabatan',
        'unit_kerja',
        'no_telp',
        'golongan',
        'tanggal_masuk',
        'sisa_cuti_sakit_bulan_lalu',
        'sisa_cuti_tahunan_bulan_lalu',
        'sisa_cuti_tahunan',
        'sisa_cuti_sakit',
        'status',
        'is_ketua_pengganti',
        'is_plh_panitera',       // PLH Panitera
        'is_plh_sekretaris',     // PLH Sekretaris
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_ketua_pengganti' => 'boolean',
            'is_plh_panitera' => 'boolean',
            'is_plh_sekretaris' => 'boolean',
        ];
    }

    /**
     * Relasi ke atasan langsung
     */
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    /**
     * Relasi ke bawahan
     */
    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }

    /**
     * Relasi ke pengajuan cuti
     */
    public function pengajuanCuti()
    {
        return $this->hasMany(\App\Models\Pengajuan_Cuti::class, 'user_id');
    }

    /**
     * Scope untuk Ketua
     */
    public function scopeKetua($query)
    {
        return $query->where('role', 'ketua');
    }

    /**
     * Scope untuk Panitera
     */
    public function scopePanitera($query)
    {
        return $query->where('role', 'panitera');
    }

    /**
     * Scope untuk Sekretaris
     */
    public function scopeSekretaris($query)
    {
        return $query->where('role', 'sekretaris');
    }
}
