<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mask extends Model
{
    protected $fillable = [
        'name',
        'price',
        'pharmacy_id',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
