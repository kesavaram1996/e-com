<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;
use Session;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_id = Session::get('admin_id');
        $areas = ['Saidapet','Akathiyoor','Gandhi Colony'];
        $pincodes = ['600015','680517','251001'];
        $city_ids = Session::get('city_id');
        $state_ids = Session::get('states_id');

        foreach($areas as $key => $area){
            Area::create([
                'admin_id'  => $admin_id,
                'state_id'  => $state_ids[$key],
                'city_id'   => $city_ids[$key],
                'name'      => $area,
                'pincode'   => $pincodes[$key],
            ]);
        }
        Session::flush('admin_id');
        Session::flush('city_id');
        Session::flush('states_id');
    }
}
