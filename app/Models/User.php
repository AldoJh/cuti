<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function atasan()
{
    return $this->belongsTo(User::class, 'atasan_id');
}

public function pengajuanCuti()
{
    return $this->hasMany(\App\Models\pengajuan_cuti::class, 'user_id');
}
}
