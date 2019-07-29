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
                'quantity' => 10.0,
                'returned' => 0.0,
                'received_date' => '2019-07-29',
                'material_id' => 1780,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:49:38',
                'updated_at' => '2019-07-29 16:49:38',
            ),
            1 => 
            array (
                'id' => 2,
                'goods_receipt_id' => 1,
                'quantity' => 21.0,
                'returned' => 0.0,
                'received_date' => '2019-07-29',
                'material_id' => 293,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:49:38',
                'updated_at' => '2019-07-29 16:49:38',
            ),
            2 => 
            array (
                'id' => 3,
                'goods_receipt_id' => 2,
                'quantity' => 50.0,
                'returned' => 0.0,
                'received_date' => '2019-07-30',
                'material_id' => 1780,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:50:16',
                'updated_at' => '2019-07-29 16:50:16',
            ),
            3 => 
            array (
                'id' => 4,
                'goods_receipt_id' => 2,
                'quantity' => 24.0,
                'returned' => 0.0,
                'received_date' => '2019-07-30',
                'material_id' => 332,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:50:16',
                'updated_at' => '2019-07-29 16:50:16',
            ),
            4 => 
            array (
                'id' => 5,
                'goods_receipt_id' => 3,
                'quantity' => 50.0,
                'returned' => 0.0,
                'received_date' => '2019-07-31',
                'material_id' => 1780,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:50:45',
                'updated_at' => '2019-07-29 16:50:45',
            ),
            5 => 
            array (
                'id' => 6,
                'goods_receipt_id' => 3,
                'quantity' => 1.0,
                'returned' => 0.0,
                'received_date' => '2019-07-31',
                'material_id' => 332,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:50:45',
                'updated_at' => '2019-07-29 16:50:45',
            ),
            6 => 
            array (
                'id' => 7,
                'goods_receipt_id' => 4,
                'quantity' => 5.5,
                'returned' => 0.0,
                'received_date' => '2019-08-02',
                'material_id' => 1780,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:51:26',
                'updated_at' => '2019-07-29 16:51:26',
            ),
            7 => 
            array (
                'id' => 8,
                'goods_receipt_id' => 4,
                'quantity' => 4.0,
                'returned' => 0.0,
                'received_date' => '2019-08-03',
                'material_id' => 293,
                'resource_detail_id' => NULL,
                'storage_location_id' => 1,
                'production_order_detail_id' => NULL,
                'item_OK' => 1,
                'created_at' => '2019-07-29 16:51:26',
                'updated_at' => '2019-07-29 16:51:26',
            ),
        ));
        
        
    }
}