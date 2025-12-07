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

        $mulai = Carbon::parse($cuti->tanggal_mulai)->startOfDay();
        $selesai = Carbon::parse($cuti->tanggal_selesai)->startOfDay();

        $lama = $mulai->diffInDays($selesai) + 1;

        switch ($cuti->jenis_cuti) {
            case 'tahunan':
                $user->sisa_cuti_tahunan = max(0, ($user->sisa_cuti_tahunan ?? 0) - $lama);
                break;

            case 'sakit':
                $user->sisa_cuti_sakit = max(0, ($user->sisa_cuti_sakit ?? 0) - $lama);
                break;

            case 'alasan_penting':
                $user->sisa_cuti_alasan_penting = max(0, ($user->sisa_cuti_alasan_penting ?? 0) - $lama);
                break;

            case 'besar':
                $user->sisa_cuti_besar = max(0, ($user->sisa_cuti_besar ?? 0) - $lama);
                break;

            case 'melahirkan':
                $user->sisa_cuti_melahirkan = max(0, ($user->sisa_cuti_melahirkan ?? 0) - $lama);
                break;

            case 'cltn':
                $user->sisa_cuti_cltn = max(0, ($user->sisa_cuti_cltn ?? 0) - $lama);
                break;

            default:
                break;
        }

        $user->save();
    }
}
