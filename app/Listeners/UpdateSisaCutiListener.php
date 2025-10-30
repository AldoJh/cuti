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

        $lama = Carbon::parse($cuti->tanggal_mulai)
                    ->diffInDays(Carbon::parse($cuti->tanggal_selesai)) + 1;

        if ($cuti->jenis_cuti === 'tahunan') {
            $user->sisa_cuti_tahunan = max(0, $user->sisa_cuti_tahunan - $lama);
        } elseif ($cuti->jenis_cuti === 'sakit') {
            $user->sisa_cuti_sakit = max(0, $user->sisa_cuti_sakit - $lama);
        }

        $user->save();
    }
}
