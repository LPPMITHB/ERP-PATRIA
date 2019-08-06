<?php

use Illuminate\Database\Seeder;

class TrxGoodsReceiptTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_goods_receipt')->delete();
        
        \DB::table('trx_goods_receipt')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'GR-1901000001',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 2,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => '2019-08-01',
                'description' => 'Test',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
        ));
        
        
    }
}