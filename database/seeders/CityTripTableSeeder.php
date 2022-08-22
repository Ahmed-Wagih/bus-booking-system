<?php

namespace Database\Seeders;

use App\Models\CityTrip;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CityTripTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trip = Trip::first();
        $cities = unserialize($trip->cities);
        $fromToCitiesArray = [];
        foreach ($cities as $index => $city) {
            for ($x = 0; $x < count($cities) - ($index + 1); $x++) {
                $fromToCitiesArray[] = [
                    'trip_id' => 1,
                    'from_city' => $city,
                    'to_city' => array_reverse($cities)[$x],
                ];
            }
        }
        CityTrip::insert($fromToCitiesArray);
    }
}
