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
            'branch_id' => 1,
            'user_id' => 4,
            'cost_standard_price' => 1000000
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0002',
            'name' => 'Forklift',
            'branch_id' => 1,
            'user_id' => 4,
            'cost_standard_price' => 1500000
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0003',
            'name' => 'Wheel Loader',
            'branch_id' => 1,
            'user_id' => 4,
            'cost_standard_price' => 2500000
        ]);

    }
}
