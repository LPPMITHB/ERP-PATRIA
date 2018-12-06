<?php

use Illuminate\Database\Seeder;

class RAPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000001',
            'project_id' => 1,
            'bom_id'=>1,
            'total_price' => 842200000,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000002',
            'project_id' => 1,
            'bom_id'=> 2,
            'total_price' => 255094000,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000003',
            'project_id' => 1,
            'bom_id'=>3,
            'total_price' => 20000000,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
    }
}
