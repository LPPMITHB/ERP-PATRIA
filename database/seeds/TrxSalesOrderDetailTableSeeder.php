<?php

use Illuminate\Database\Seeder;

class TrxSalesOrderDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_sales_order_detail')->delete();
        
        \DB::table('trx_sales_order_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sales_order_id' => 1,
                'cost_standard_id' => 1,
                'value' => 10.0,
                'price' => 1000000,
                'created_at' => '2019-08-26 07:51:12',
                'updated_at' => '2019-08-26 07:51:12',
            ),
            1 => 
            array (
                'id' => 2,
                'sales_order_id' => 1,
                'cost_standard_id' => 2,
                'value' => 10.0,
                'price' => 500000,
                'created_at' => '2019-08-26 07:51:12',
                'updated_at' => '2019-08-26 07:51:12',
            ),
            2 => 
            array (
                'id' => 3,
                'sales_order_id' => 1,
                'cost_standard_id' => 3,
                'value' => 10.0,
                'price' => 1000000,
                'created_at' => '2019-08-26 07:51:12',
                'updated_at' => '2019-08-26 07:51:12',
            ),
            3 => 
            array (
                'id' => 4,
                'sales_order_id' => 1,
                'cost_standard_id' => 4,
                'value' => 10.0,
                'price' => 2000000,
                'created_at' => '2019-08-26 07:51:12',
                'updated_at' => '2019-08-26 07:51:12',
            ),
        ));
        
        
    }
}