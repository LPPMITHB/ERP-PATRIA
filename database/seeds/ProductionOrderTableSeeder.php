<?php

use Illuminate\Database\Seeder;

class ProductionOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trx_production_order')->insert([
            'number' => 'PrO-1800000001',
            'project_id' => 1,
            'work_id' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
            ]);

        DB::table('trx_production_order')->insert([
            'number' => 'PrO-1800000002',
            'project_id' => 1,
            'work_id' => 2,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
            ]);    
            
        DB::table('trx_production_order')->insert([
            'number' => 'PrO-1800000003',
            'project_id' => 2,
            'work_id' => 5,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
            ]);
    }
}
