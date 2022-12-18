<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PriceSlab;
use Session;

class PriceSlabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_id = Session::get('admin_id');
        $price_Slabs = ['Price1','Price2','Price3','Price4'];
        foreach($price_Slabs as $key => $price_Slab){
            PriceSlab::create([
                'admin_id'      => $admin_id,
                'title'         => $price_Slab,
                'status'        => 1
            ]);
        }
    }
}
