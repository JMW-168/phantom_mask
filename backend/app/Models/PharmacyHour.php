<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ 正確 namespace
use Illuminate\Database\Eloquent\Model;

class PharmacyHour extends Model
{
    use HasFactory;

    protected $fillable = ['pharmacy_id', 'weekday', 'open_time', 'close_time'];
}
