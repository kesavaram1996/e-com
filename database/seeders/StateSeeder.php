<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use Session;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_id = Session::get('admin_id');
        $states = ['Tamil Nadu','Kerala','Andra Pradesh'];

        foreach($states as $state){
            $res = State::create([
                'admin_id'  => $admin_id,
                'name'      => $state
            ]);
            $states_id[] = $res->id;
        }
        Session::put('states_id', $states_id);
    }
}
