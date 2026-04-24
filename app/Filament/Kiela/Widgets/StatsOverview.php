<?php

namespace App\Filament\Kiela\Widgets; // <--- Ini KTP-nya, harus cocok dengan nama folder Kiela

use App\Models\Product;
use App\Models\Customer;
use App\Models\BarangMasuk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Kita matikan mode pemalu-nya agar layarnya langsung muncul
    protected static bool $isLazy = false; 

    protected function getStats(): array
    {
        return [
            Stat::make('Total Jenis Produk', Product::count())
                ->description('Jumlah macam barang di etalase')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success'),
                
            Stat::make('Total Pelanggan', Customer::count())
                ->description('Pelanggan setia toko kita')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
                
            Stat::make('Transaksi Masuk Hari Ini', BarangMasuk::whereDate('tanggal', today())->count())
                ->description('Aktivitas pasokan hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}