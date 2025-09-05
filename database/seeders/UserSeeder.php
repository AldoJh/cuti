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
        User::create([
            'name' => 'Admin Kepegawaian',
            'email' => 'admin@cuti.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Ketua
        User::create([
            'name' => 'Ketua Pengadilan',
            'email' => 'ketua@cuti.com',
            'password' => Hash::make('password'),
            'role' => 'ketua',
        ]);

        // Atasan
        User::create([
            'name' => 'Atasan Langsung',
            'email' => 'atasan@cuti.com',
            'password' => Hash::make('password'),
            'role' => 'atasan',
        ]);

        // Pegawai
        User::create([
            'name' => 'Pegawai Biasa',
            'email' => 'pegawai@cuti.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);
    }
}
