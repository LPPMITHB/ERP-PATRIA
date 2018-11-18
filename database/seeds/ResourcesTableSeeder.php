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
            'description' => '',
            'uom_id' => 5,
            'status' => 1,
            'branch_id' => 1,
            'category_id' => 1,
            'type' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0002',
            'name' => 'Forklift',
            'description' => '',
            'uom_id' => 5,
            'status' => 1,
            'branch_id' => 1,
            'category_id' => 2,
            'type' => 0,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0003',
            'name' => 'Wheel Loader',
            'description' => '',
            'uom_id' => 5,
            'status' => 1,
            'branch_id' => 1,
            'category_id' => 2,
            'type' => 0,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0004',
            'name' => 'Marine Rubber Airbag',
            'description' => '',
            'uom_id' => 5,
            'status' => 1,
            'branch_id' => 1,
            'category_id' => 2,
            'type' => 0,
            'user_id' => 4,
        ]);

        DB::table('mst_resource')->insert([
            'code' => 'RSC0005',
            'name' => 'Excavator',
            'description' => '',
            'uom_id' => 5,
            'status' => 1,
            'branch_id' => 1,
            'category_id' => 1,
            'type' => 1,
            'user_id' => 4,
        ]);
    }
}
