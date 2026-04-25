<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup-kiela', function () {
    // 1. Bersihkan seluruh cache internal Laravel
    Artisan::call('optimize:clear');
    
    // 2. Paksa Migration ke MySQL
    Artisan::call('migrate:fresh', ['--force' => true]);
    
    // 3. Buat Akun Kiela
    $user = User::updateOrCreate(
        ['email' => 'kiela@gmail.com'],
        [
            'name' => 'Kiela',
            'password' => '123456789'
        ]
    );
    
    return "SUKSES FINAL! Database sekarang pakai: " . env('DB_CONNECTION') . " | Akun siap digunakan.";
});