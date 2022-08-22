<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityTrip extends Model
{
    use HasFactory;
    protected $table = 'city_trip';

    public function trip(){
        return $this->belongsTo(Trip::class);
    }
}
