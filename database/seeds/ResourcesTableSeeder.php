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
            'name' => 'Tower Crane 100 ton',
            'branch_id' => 1,
            'user_id' => 1,
            'cost_standard_price' => 1000000
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0002',
            'name' => 'Mobile Crane 50 ton',
            'branch_id' => 1,
            'user_id' => 1,
            'cost_standard_price' => 1500000
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0003',
            'name' => 'Forklift Electric',
            'branch_id' => 1,
            'user_id' => 1,
            'cost_standard_price' => 2500000
        ]);
        
        DB::table('mst_resource')->insert([
            'code' => 'RSC0004',
            'name' => 'Forklift Reach Truck',
            'branch_id' => 1,
            'user_id' => 1,
            'cost_standard_price' => 3500000
        ]);
    }
}
