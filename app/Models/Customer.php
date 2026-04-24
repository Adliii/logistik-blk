<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customers_id'; // BARIS INI WAJIB ADA
    protected $guarded = [];
}
