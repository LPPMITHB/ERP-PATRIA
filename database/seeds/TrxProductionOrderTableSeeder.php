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
        
        
        
    }
}