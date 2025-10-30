<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\CutiDisetujui::class => [
            \App\Listeners\UpdateSisaCutiListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
