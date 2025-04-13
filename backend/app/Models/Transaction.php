<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'pharmacy_id',
        'mask_id',
        'quantity',
        'unit_price',
        'total_price',
        'purchased_at',
    ];
}

