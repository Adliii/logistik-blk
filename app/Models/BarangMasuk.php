<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'suppliers_id');
    }

    // Robot Penjaga Stok (Pintu Masuk)
    protected static function booted()
    {
        static::created(function ($barangMasuk) {
            if ($barangMasuk->product) {
                $barangMasuk->product->increment('stok', $barangMasuk->jumlah);
            }
        });

        static::deleted(function ($barangMasuk) {
            if ($barangMasuk->product) {
                $barangMasuk->product->decrement('stok', $barangMasuk->jumlah);
            }
        });
    }
}