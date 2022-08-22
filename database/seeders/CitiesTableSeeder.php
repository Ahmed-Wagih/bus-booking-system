<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            array('name' => 'Alexandreia'),
            array('name' => 'Ash Sharqiyah'),
            array('name' => 'Al Gharbiyah'),
            array('name' => 'Ad Daqahliyah'),
            array('name' => 'Al Jizah'),
            array('name' => 'Al Minya'),
            array('name' => 'Kafr ash Shaykh'),
            array('name' => 'Al Buhayrah'),
            array('name' => 'Qina'),
            array('name' => 'Al Qahirah'),
            array('name' => 'Al Iskandariyah'),
            array('name' => 'Al Fayyum'),
            array('name' => 'Asyut'),
            array('name' => 'Al Minufiyah'),
            array('name' => 'Bani Suwayf'),
            array('name' => 'Al Qalyubiyah'),
            array('name' => 'Aswan'),
            array('name' => 'Shamal Sina\''),
            array('name' => 'Al Ismailiyah'),
            array('name' => 'Dumyat'),
            array('name' => 'Matruh'),
            array('name' => 'As Suways'),
            array('name' => 'Al Wadi al Jadid'),
            array('name' => 'Bur Sa\'id'),
        ];

        City::insert($cities);
    }
}
