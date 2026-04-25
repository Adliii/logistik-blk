<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::get('/setup-kiela', function () {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('migrate:fresh', ['--force' => true]);
            
            $user = User::create([
                'name' => 'Kiela',
                'email' => 'kiela@gmail.com',
                'password' => Hash::make('123456789')
            ]);
            
            return "SUKSES BERAT! Akun berhasil dibuat: " . $user->email;
        } catch (\Exception $e) {
            return "GAGAL TOTAL. Ini errornya: " . $e->getMessage();
        }
    });
