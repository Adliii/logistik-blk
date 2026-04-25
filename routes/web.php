<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Route::get('/setup-kiela', function () {
        // 1. Eksekusi Migration
        Artisan::call('migrate:fresh', ['--force' => true]);
        
        // 2. Bikin Akun Admin
        User::create([
            'name' => 'Kiela',
            'email' => 'kiela@gmail.com',
            'password' => bcrypt('123456789')
        ]);
        
        return 'Gudang MySQL siap, Bos! Akun berhasil dibuat.';
    });
