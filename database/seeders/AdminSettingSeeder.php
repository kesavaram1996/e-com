<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminSetting;
use App\Models\CutOff;
use Session;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_id = Session::get('admin_id');

            AdminSetting::create([
                'admin_id'      => $admin_id,
                'display_name'  => 'delivery_charge',
                'key'           => 'km',
                'value'         => '20',
                'status'        => 1
            ]);
            AdminSetting::create([
                'admin_id'      => $admin_id,
                'display_name'  => 'cut_off',
                'key'           => 'cut_off',
                'value'         => 'cut_off',
                'status'        => 1
            ]);
            AdminSetting::create([
                'admin_id'      => $admin_id,
                'display_name'  => 'contact',
                'key'           => 'contact',
                'value'         => '',
                'status'        => 1
            ]);
            AdminSetting::create([
                'admin_id'      => $admin_id,
                'display_name'  => 'about',
                'key'           => 'about',
                'value'         => '',
                'status'        => 1
            ]);
            AdminSetting::create([
                'admin_id'      => $admin_id,
                'display_name'  => 'privacy_policy',
                'key'           => 'privacy_policy',
                'value'         => '',
                'status'        => 1
            ]);
            AdminSetting::create([
                'admin_id'      => $admin_id,
                'display_name'  => 'terms_conditions',
                'key'           => 'terms_conditions',
                'value'         => '',
                'status'        => 1
            ]);

            $weekdays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
            foreach($weekdays as $weekday){
                CutOff::create([
                    'admin_id'      => $admin_id,
                    'day'           => $weekday,
                    'time'          => '00.00',
                    'status'        => 1
                ]);
            }
    }
}
