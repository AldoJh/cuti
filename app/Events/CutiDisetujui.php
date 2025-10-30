<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengajuan_Cuti;

class CutiDisetujui
{
    use Dispatchable, SerializesModels;

    public $cuti;

    public function __construct(Pengajuan_Cuti $cuti)
    {
        $this->cuti = $cuti;
    }
}
