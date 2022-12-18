<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;
use Session;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_id = Session::get('admin_id');
        $cities = ['Chennai','Thrissur','Vijayawada'];
        $state_ids = Session::get('states_id');
        foreach($cities as $key => $city){
            $res = City::create([
                'admin_id'  => $admin_id,
                'state_id'  => $state_ids[$key],
                'name'      => $city
            ]);
            $city_id[] = $res->id;
        }

        Session::put('city_id', $city_id);

        Session::forget('admin_id');
        Session::forget('city_id');
        Session::forget('states_id');
    }
}
