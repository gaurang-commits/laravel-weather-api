<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'city_id', 'weather_data', 'date'];
    
    protected $casts = [
        'weather_data' => 'array',
    ];
}
