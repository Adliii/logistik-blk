<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. TAMBAHKAN BARIS INI

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 2. TAMBAHKAN BARIS INI AGAR CSS-NYA MUNCUL
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}