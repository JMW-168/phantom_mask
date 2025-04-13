<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cash_balance', 'opening_hours'];

    public function hours(): HasMany
    {
        return $this->hasMany(PharmacyHour::class);
    }

    public function masks(): HasMany
    {
        return $this->hasMany(Mask::class);
    }
}
