<?php

namespace Database\Seeders;

use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [1, 2, 3, 4, 5, 6];
        // $cities = [6, 5, 4, 3, 2, 1];
        Trip::create([
            'title' => 'From Cairo to Aswan',
            'cities' => serialize($cities),
            'start_at' => now()
        ]);
    }
}

