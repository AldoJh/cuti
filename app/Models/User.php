<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang bisa diisi mass-assignment.
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
        'is_plh_panitera',
        'is_plh_sekretaris',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data casting otomatis.
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
     * Relasi ke atasan langsung (self relation).
     */
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    /**
     * Relasi ke bawahan (self relation).
     */
    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }

    /**
     * Relasi ke tabel pengajuan cuti.
     */
    public function pengajuanCuti()
    {
        return $this->hasMany(\App\Models\Pengajuan_Cuti::class, 'user_id');
    }

    /**
     * Scope untuk Ketua.
     */
    public function scopeKetua($query)
    {
        return $query->where('role', 'ketua');
    }

    /**
     * Scope untuk Panitera.
     */
    public function scopePanitera($query)
    {
        return $query->where('role', 'panitera');
    }

    /**
     * Scope untuk Sekretaris.
     */
    public function scopeSekretaris($query)
    {
        return $query->where('role', 'sekretaris');
    }

    /**
     * 🔹 Fungsi untuk menentukan siapa yang harus menyetujui pengajuan cuti.
     * 
     * Logika:
     * - Ketua → otomatis disetujui.
     * - Panitera → PLH Panitera kalau ada, kalau tidak Ketua.
     * - Sekretaris → PLH Sekretaris kalau ada, kalau tidak Ketua.
     * - Pegawai biasa → atasan langsung, tapi kalau atasannya Ketua maka cek Ketua Pengganti.
     */
    
    public function getActiveApprover()
    {
        // Jika user adalah Ketua → tidak perlu approval
        if ($this->role === 'ketua' || $this->is_ketua_pengganti) {
            return null;
        }

        // Ambil data pejabat struktural
        $ketua = User::where('role', 'ketua')->first();
        $ketuaPengganti = User::where('is_ketua_pengganti', true)->first();
        $panitera = User::where('role', 'panitera')->first();
        $plhPanitera = User::where('is_plh_panitera', true)->first();
        $sekretaris = User::where('role', 'sekretaris')->first();
        $plhSekretaris = User::where('is_plh_sekretaris', true)->first();

        // 🔹 Jika user Panitera → lanjut ke Ketua / Ketua Pengganti
        if ($this->role === 'panitera') {
            return $ketuaPengganti?->id ?? $ketua?->id;
        }

        // 🔹 Jika user Sekretaris → lanjut ke Ketua / Ketua Pengganti
        if ($this->role === 'sekretaris') {
            return $ketuaPengganti?->id ?? $ketua?->id;
        }

        // 🔹 Jika user adalah PLH Panitera → lanjut ke Ketua / Ketua Pengganti
        if ($this->is_plh_panitera) {
            return $ketuaPengganti?->id ?? $ketua?->id;
        }

        // 🔹 Jika user adalah PLH Sekretaris → lanjut ke Ketua / Ketua Pengganti
        if ($this->is_plh_sekretaris) {
            return $ketuaPengganti?->id ?? $ketua?->id;
        }

        // 🔹 Jika pegawai biasa → tentukan atasan langsung
        if ($this->atasan_id == $panitera?->id) {
            return $plhPanitera?->id ?? $panitera?->id;
        }

        if ($this->atasan_id == $sekretaris?->id) {
            return $plhSekretaris?->id ?? $sekretaris?->id;
        }

        if ($this->atasan_id == $ketua?->id) {
            return $ketuaPengganti?->id ?? $ketua?->id;
        }

        // Default fallback
        return $this->atasan_id;
    }
}
