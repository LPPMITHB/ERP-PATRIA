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
            'quantity' => 1,
            'description' => NULL,
            'category_id' => '3',
            // 'machine_type' => '2',
            'cost_standard_price' =>NULL,
            'manufactured_date' => '2018-08-30',
            'purchasing_date' => '2018-08-31',
            'cost_standard_price' => 1000000,
            'purchasing_price' => 1000000,
            'lifetime' => NULL,
            'depreciation_method' => NULL,
            'accumulated_depreciation' => NULL,
            'running_hours' => NULL,
            'cost_per_hour'=>NULL,
            'utilization'=>0,
            'performance'=>NULL,
            'productivity'=>0,
            'status'=>1,
            'vendor_id' => 1,
            'uom_id'=>5,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0002',
            'name' => 'Forklift',
            'brand' => '',
            'quantity' => 1,
            'description' => NULL,
            'category_id' => '3',
            // 'machine_type' => '2',
            'cost_standard_price' =>NULL,
            'manufactured_date' => '2018-08-30',
            'purchasing_date' => '2018-08-31',
            'purchasing_price' => 1000000,
            'cost_standard_price' => 1000000,
            'lifetime' => NULL,
            'depreciation_method' => NULL,
            'accumulated_depreciation' => NULL,
            'running_hours' => NULL,
            'cost_per_hour'=>NULL,
            'utilization'=>0,
            'performance'=>NULL,
            'productivity'=>0,
            'status'=>1,
            'vendor_id' => 1,
            'uom_id'=>5,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0003',
            'name' => 'Wheel Loader',
            'brand' => '',
            'quantity' => 1,
            'description' => NULL,
            'category_id' => '3',
            // 'machine_type' => '1',
            'cost_standard_price' =>NULL,
            'manufactured_date' => '2018-08-30',
            'purchasing_date' => '2018-08-31',
            'purchasing_price' => 1000000,
            'cost_standard_price' => 1000000,
            'lifetime' => NULL,
            'depreciation_method' => NULL,
            'accumulated_depreciation' => NULL,
            'running_hours' => NULL,
            'cost_per_hour'=>NULL,
            'utilization'=>0,
            'performance'=>NULL,
            'productivity'=>0,
            'status'=>1,
            'vendor_id' => 1,
            'uom_id'=>5,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

    }
}
