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
            'bom_id'=> 1,
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
            'bom_id'=> 3,
            'total_price' => 20000000,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000004',
            'project_id' => 1,
            'bom_id'=> 4,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000005',
            'project_id' => 1,
            'bom_id'=> 5,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000006',
            'project_id' => 1,
            'bom_id'=> 6,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000007',
            'project_id' => 1,
            'bom_id'=> 7,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000008',
            'project_id' => 1,
            'bom_id'=> 8,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

                DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000009',
            'project_id' => 1,
            'bom_id'=> 9,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000010',
            'project_id' => 1,
            'bom_id'=> 10,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000011',
            'project_id' => 1,
            'bom_id'=> 11,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('trx_rap')->insert([
            'number' => 'RAP-1801000012',
            'project_id' => 1,
            'bom_id'=> 12,
            'total_price' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
    }
}
