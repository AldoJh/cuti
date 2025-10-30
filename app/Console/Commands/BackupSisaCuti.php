<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\BackupSisaCuti as BackupModel;
use Carbon\Carbon;

class BackupSisaCuti extends Command
{
    protected $signature = 'cuti:backup';
    protected $description = 'Backup otomatis sisa cuti tahunan dan sakit setiap bulan, serta carry-over di awal tahun';

    public function handle()
    {
        ini_set('memory_limit', '512M'); // aman untuk user banyak
        $tahun = now()->year;
        $this->info("Memulai backup sisa cuti untuk tahun {$tahun}...");

        // Gunakan chunk supaya tidak load semua user sekaligus
        User::where('status', 'aktif')->chunk(100, function ($users) use ($tahun) {

            foreach ($users as $user) {
                // 1️⃣ Backup data sisa cuti saat ini
                BackupModel::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'tahun'   => $tahun,
                    ],
                    [
                        'sisa_cuti_tahunan' => $user->sisa_cuti_tahunan ?? 0,
                        'sisa_cuti_sakit'   => $user->sisa_cuti_sakit ?? 0,
                        'updated_at'        => now(),
                    ]
                );
            }

            // 2️⃣ Jalankan logika carry-over di awal tahun
            if (now()->isStartOfYear()) {
                foreach ($users as $user) {
                    $tahun_lalu = $tahun - 1;

                    $sisa_cuti_lalu = BackupModel::where('user_id', $user->id)
                        ->where('tahun', $tahun_lalu)
                        ->value('sisa_cuti_tahunan') ?? 0;

                    $carry_over = min($sisa_cuti_lalu, 5);
                    $jatah_tahunan_baru = 12;
                    $total_baru = $jatah_tahunan_baru + $carry_over;

                    $user->update([
                        'jatah_cuti_tahunan' => $jatah_tahunan_baru,
                        'sisa_cuti_tahunan'  => $total_baru,
                    ]);

                    $this->info("↪️ {$user->nama} : sisa tahun lalu {$sisa_cuti_lalu}, dibawa {$carry_over}, total baru " . $total_baru);
                }
            }
        });

        $this->info('✅ Backup bulanan selesai disimpan ke tabel backup_sisa_cutis.');
        if (now()->isStartOfYear()) {
            $this->info('✅ Carry-over selesai untuk semua user.');
        }

        return Command::SUCCESS;
    }
}
