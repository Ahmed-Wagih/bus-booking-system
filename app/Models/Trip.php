<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'start_at'];

    public function cities(){
        return $this->hasMany(CityTrip::class);
    }
}
