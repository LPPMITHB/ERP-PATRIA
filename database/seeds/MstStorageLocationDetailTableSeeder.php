<?php

use Illuminate\Database\Seeder;

class MstStorageLocationDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_storage_location_detail')->delete();
        
        \DB::table('mst_storage_location_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'material_id' => 1780,
                'quantity' => 15.5,
                'value' => 100000.0,
                'goods_receipt_detail_id' => 1,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:49:38',
                'updated_at' => '2019-07-29 16:49:38',
            ),
            1 => 
            array (
                'id' => 2,
                'material_id' => 293,
                'quantity' => 25.0,
                'value' => 250000.0,
                'goods_receipt_detail_id' => 2,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:49:38',
                'updated_at' => '2019-07-29 16:49:38',
            ),
            2 => 
            array (
                'id' => 3,
                'material_id' => 1780,
                'quantity' => 100.0,
                'value' => 10000.0,
                'goods_receipt_detail_id' => 3,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:50:16',
                'updated_at' => '2019-07-29 16:50:16',
            ),
            3 => 
            array (
                'id' => 4,
                'material_id' => 332,
                'quantity' => 25.0,
                'value' => 100000.0,
                'goods_receipt_detail_id' => 4,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:50:16',
                'updated_at' => '2019-07-29 16:50:16',
            ),
            4 => 
            array (
                'id' => 5,
                'material_id' => 1780,
                'quantity' => 50.0,
                'value' => 20000.0,
                'goods_receipt_detail_id' => 5,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:50:45',
                'updated_at' => '2019-07-29 16:50:45',
            ),
            5 => 
            array (
                'id' => 6,
                'material_id' => 332,
                'quantity' => 1.0,
                'value' => 2500000.0,
                'goods_receipt_detail_id' => 6,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:50:45',
                'updated_at' => '2019-07-29 16:50:45',
            ),
            6 => 
            array (
                'id' => 7,
                'material_id' => 1780,
                'quantity' => 5.5,
                'value' => 281818.1818181818,
                'goods_receipt_detail_id' => 7,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:51:26',
                'updated_at' => '2019-07-29 16:51:26',
            ),
            7 => 
            array (
                'id' => 8,
                'material_id' => 293,
                'quantity' => 4.0,
                'value' => 1562500.0,
                'goods_receipt_detail_id' => 8,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:51:26',
                'updated_at' => '2019-07-29 16:51:26',
            ),
            8 => 
            array (
                'id' => 9,
                'material_id' => 1709,
                'quantity' => 100.0,
                'value' => 200000.0,
                'goods_receipt_detail_id' => 9,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:59:24',
                'updated_at' => '2019-07-29 16:59:24',
            ),
            9 => 
            array (
                'id' => 10,
                'material_id' => 1709,
                'quantity' => 50.0,
                'value' => 400000.0,
                'goods_receipt_detail_id' => 10,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:59:37',
                'updated_at' => '2019-07-29 16:59:37',
            ),
            10 => 
            array (
                'id' => 11,
                'material_id' => 1709,
                'quantity' => 25.0,
                'value' => 800000.0,
                'goods_receipt_detail_id' => 11,
                'storage_location_id' => 1,
                'created_at' => '2019-07-29 16:59:45',
                'updated_at' => '2019-07-29 16:59:45',
            ),
        ));
        
        
    }
}