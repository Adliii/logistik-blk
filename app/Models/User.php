<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 1. TAMBAHKAN 2 BARIS INI
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// 2. TAMBAHKAN "implements FilamentUser" DI UJUNG BARIS INI
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 3. TAMBAHKAN FUNGSI INI DI PALING BAWAH (SEBELUM KURUNG TUTUP TERAKHIR)
    public function canAccessPanel(Panel $panel): bool
    {
        // Return true artinya kita mengizinkan semua akun yang terdaftar untuk masuk
        return true; 
    }
}