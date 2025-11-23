<?php

namespace App\Listeners;

use App\Events\CutiDisetujui;
use Carbon\Carbon;

class UpdateSisaCutiListener
{
    public function handle(CutiDisetujui $event)
    {
        $cuti = $event->cuti;
        $user = $cuti->user;

        // Normalisasi tanggal supaya jam tidak mempengaruhi diff
        $mulai = Carbon::parse($cuti->tanggal_mulai)->startOfDay();
        $selesai = Carbon::parse($cuti->tanggal_selesai)->startOfDay();

        // Hitung hari cuti secara akurat
        $lama = $mulai->diffInDays($selesai) + 1;

        // Kurangi kuota sesuai jenis cuti
        if ($cuti->jenis_cuti === 'tahunan') {
            $user->sisa_cuti_tahunan = max(0, $user->sisa_cuti_tahunan - $lama);
        } elseif ($cuti->jenis_cuti === 'sakit') {
            $user->sisa_cuti_sakit = max(0, $user->sisa_cuti_sakit - $lama);
        }

        $user->save();
    }
}
