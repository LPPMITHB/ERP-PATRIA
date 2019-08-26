<?php

use Illuminate\Database\Seeder;

class TrxQuotationDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_quotation_detail')->delete();
        
        \DB::table('trx_quotation_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'quotation_id' => 1,
                'cost_standard_id' => 1,
                'value' => 10.0,
                'price' => 1000000,
                'created_at' => '2019-08-26 07:51:04',
                'updated_at' => '2019-08-26 07:51:04',
            ),
            1 => 
            array (
                'id' => 2,
                'quotation_id' => 1,
                'cost_standard_id' => 2,
                'value' => 10.0,
                'price' => 500000,
                'created_at' => '2019-08-26 07:51:04',
                'updated_at' => '2019-08-26 07:51:04',
            ),
            2 => 
            array (
                'id' => 3,
                'quotation_id' => 1,
                'cost_standard_id' => 3,
                'value' => 10.0,
                'price' => 1000000,
                'created_at' => '2019-08-26 07:51:04',
                'updated_at' => '2019-08-26 07:51:04',
            ),
            3 => 
            array (
                'id' => 4,
                'quotation_id' => 1,
                'cost_standard_id' => 4,
                'value' => 10.0,
                'price' => 2000000,
                'created_at' => '2019-08-26 07:51:04',
                'updated_at' => '2019-08-26 07:51:04',
            ),
        ));
        
        
    }
}