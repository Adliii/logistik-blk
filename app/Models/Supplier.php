<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'suppliers_id'; // Tambahkan ini!
    protected $guarded = [];
}