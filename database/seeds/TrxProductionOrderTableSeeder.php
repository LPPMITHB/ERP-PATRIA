<?php

use Illuminate\Database\Seeder;

class TrxProductionOrderTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_production_order')->delete();
        
        \DB::table('trx_production_order')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'PRO00001',
                'project_id' => 1,
                'wbs_id' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PRO00002',
                'project_id' => 1,
                'wbs_id' => 2,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'PRO00003',
                'project_id' => 2,
                'wbs_id' => 5,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}