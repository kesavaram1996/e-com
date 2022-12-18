<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MeasurementUnit;

class MeasurementUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measurement_unit = ['kg','gm','ltr','ml','pack','pc','m'];

        foreach($measurement_unit as $measurement_units){
            MeasurementUnit::create([
                'measurement_unit' => $measurement_units
            ]);
        }
    }
}
