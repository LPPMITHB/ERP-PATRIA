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
                'id' => 17,
                'number' => 'PrO-1902000001',
                'project_id' => 3,
                'wbs_id' => 28,
                'status' => 2,
                'branch_id' => 2,
                'user_id' => 3,
                'created_at' => '2019-03-27 15:17:19',
                'updated_at' => '2019-03-27 15:17:44',
            ),
        ));
        
        
    }
}