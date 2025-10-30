<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 🕐 Jadwal otomatis backup sisa cuti tiap awal bulan
// Artisan::command('cuti:backup', function () {
//     $this->call('cuti:backup');
// })->describe('Jalankan backup sisa cuti tiap awal bulan');

app()->booted(function () {
    $schedule = app(Schedule::class);
    $schedule->command('cuti:backup')->monthlyOn(1, '00:00');
});
