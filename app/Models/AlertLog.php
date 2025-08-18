<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertLog extends Model
{
    protected $fillable = [
        'delivery_lat',
        'delivery_lon',
        'alert_radius',
        'distance',
        'is_within_range?'
    ];
}
