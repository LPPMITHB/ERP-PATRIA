<?php

use Illuminate\Database\Seeder;

class TrxGoodsReceiptDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_goods_receipt_detail')->delete();
        
        \DB::table('trx_goods_receipt_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'goods_receipt_id' => 1,
                'quantity' => 200.0,
                'returned' => 0.0,
                'received_date' => '2019-08-30',
                'material_id' => 332,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            1 => 
            array (
                'id' => 2,
                'goods_receipt_id' => 1,
                'quantity' => 200.0,
                'returned' => 0.0,
                'received_date' => '2019-08-30',
                'material_id' => 2189,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            2 => 
            array (
                'id' => 3,
                'goods_receipt_id' => 1,
                'quantity' => 200.0,
                'returned' => 0.0,
                'received_date' => '2019-08-30',
                'material_id' => 399,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            3 => 
            array (
                'id' => 4,
                'goods_receipt_id' => 1,
                'quantity' => 200.0,
                'returned' => 0.0,
                'received_date' => '2019-08-30',
                'material_id' => 306,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
        ));
        
        
    }
}