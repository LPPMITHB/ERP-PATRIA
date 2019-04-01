<?php

use Illuminate\Database\Seeder;

class TrxProductionOrderDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_production_order_detail')->delete();
        
        
    }
}