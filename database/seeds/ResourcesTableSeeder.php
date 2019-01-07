<?php

use Illuminate\Database\Seeder;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_resource')->insert([
            'code' => 'RSC0001',
            'name' => 'Crane',
            'brand' => '',
            'quantity' => 0,
            'description' => NULL,
            'machine_type' => '',
            'manufactured_date' => '2018-09-30',
            'purchasing_date' => '2018-10-30',
            'purchasing_price' => 1000000,
            'lifetime' => NULL,
            'depreciation_method' => NULL,
            'accumulated_depreciation' => NULL,
            'running_hours' => NULL,
            'cost/hour'=>NULL,
            'utilization'=>0,
            'performance'=>NULL,
            'productivity'=>0,
            'vendor_id' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0002',
            'name' => 'Forklift',
            'brand' => '',
            'quantity' => 0,
            'description' => NULL,
            'machine_type' => '',
            'manufactured_date' => '2018-09-30',
            'purchasing_date' => '2018-10-30',
            'purchasing_price' => 1000000,
            'lifetime' => NULL,
            'depreciation_method' => NULL,
            'accumulated_depreciation' => NULL,
            'running_hours' => NULL,
            'cost/hour'=>NULL,
            'utilization'=>0,
            'performance'=>NULL,
            'productivity'=>0,
            'vendor_id' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0003',
            'name' => 'Wheel Loader',
            'brand' => '',
            'quantity' => 0,
            'description' => NULL,
            'machine_type' => '',
            'manufactured_date' => '2018-09-30',
            'purchasing_date' => '2018-10-30',
            'purchasing_price' => 1000000,
            'lifetime' => NULL,
            'depreciation_method' => NULL,
            'accumulated_depreciation' => NULL,
            'running_hours' => NULL,
            'cost/hour'=>NULL,
            'utilization'=>0,
            'performance'=>NULL,
            'productivity'=>0,
            'vendor_id' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

    }
}
