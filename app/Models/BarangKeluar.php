<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function customer()
    {
        // Ubah 'id' menjadi 'customers_id' di sini:
        return $this->belongsTo(Customer::class, 'customer_id', 'customers_id');
    }

    // Robot Penjaga Stok (Pintu Keluar)
    protected static function booted()
    {
        static::created(function ($barangKeluar) {
            if ($barangKeluar->product) {
                $barangKeluar->product->decrement('stok', $barangKeluar->jumlah);
            }
        });

        static::deleted(function ($barangKeluar) {
            if ($barangKeluar->product) {
                $barangKeluar->product->increment('stok', $barangKeluar->jumlah);
            }
        });
    }
}