<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
       // Admin
    $admin = User::create([
        'name' => 'Admin Kepegawaian',
        'email' => 'admin@cuti.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'atasan_id' => null,
    ]);

    // // Ketua
    // $ketua = User::create([
    //     'name' => 'Ketua Pengadilan',
    //     'email' => 'ketua@cuti.com',
    //     'password' => Hash::make('password'),
    //     'role' => 'ketua',
    //     'atasan_id' => null, // Ketua tidak punya atasan
    // ]);

    // // Panitera (atasan pegawai)
    // $panitera = User::create([
    //     'name' => 'Panitera',
    //     'email' => 'panitera@cuti.com',
    //     'password' => Hash::make('password'),
    //     'role' => 'panitera',
    //     'atasan_id' => $ketua->id, // panitera dibawah ketua
    // ]);

    // // Sekretaris (atasan kasubbag)
    // $sekretaris = User::create([
    //     'name' => 'Sekretaris',
    //     'email' => 'sekretaris@cuti.com',
    //     'password' => Hash::make('password'),
    //     'role' => 'sekretaris',
    //     'atasan_id' => $ketua->id, // sekretaris dibawah ketua
    // ]);

    // // Kasubbag (atasan pegawai staf sekretaris)
    // $kasubbag = User::create([
    //     'name' => 'Kasubbag',
    //     'email' => 'kasubbag@cuti.com',
    //     'password' => Hash::make('password'),
    //     'role' => 'kasubbag',
    //     'atasan_id' => $sekretaris->id,
    // ]);

    // // Pegawai biasa dibawah Panitera
    // $pegawai = User::create([
    //     'name' => 'Pegawai Biasa',
    //     'email' => 'pegawai@cuti.com',
    //     'password' => Hash::make('password'),
    //     'role' => 'pegawai',
    //     'atasan_id' => $panitera->id, // pegawai langsung ke panitera
    // ]);

    // // Pegawai lain dibawah Kasubbag
    // $pegawai2 = User::create([
    //     'name' => 'Pegawai Sekretariat',
    //     'email' => 'pegawai2@cuti.com',
    //     'password' => Hash::make('password'),
    //     'role' => 'pegawai',
    //     'atasan_id' => $kasubbag->id,
    // ]);
    }
}
