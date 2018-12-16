<?php

use Illuminate\Database\Seeder;

class YardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_yard')->insert([
            'code' => 'YRD0001',
            'name' => 'Yard A',
            'area' => '400',
            'description' => 'Ini adalah Yard 1',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 5,
            ]);
        DB::table('mst_yard')->insert([
            'code' => 'YRD0002',
            'name' => 'Yard B',
            'area' => '200',
            'description' => 'Ini adalah Yard 2',
            'status' => 2,
            'branch_id' => 1,
            'user_id' => 5,
            ]);
    }
}
