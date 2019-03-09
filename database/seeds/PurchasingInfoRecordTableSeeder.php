<?php

use Illuminate\Database\Seeder;

class PurchasingInfoRecordTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchasing_info_record')->delete();
        
        \DB::table('purchasing_info_record')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 25,
                'material_id' => 1780,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 15.5,
                'price' => 100000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            1 => 
            array (
                'id' => 2,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 26,
                'material_id' => 293,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 25.0,
                'price' => 250000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            2 => 
            array (
                'id' => 3,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 27,
                'material_id' => 10,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 5.0,
                'price' => 500000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            3 => 
            array (
                'id' => 4,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 28,
                'material_id' => 316,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 7.0,
                'price' => 55000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            4 => 
            array (
                'id' => 5,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 29,
                'material_id' => 1130,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 3.0,
                'price' => 25000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            5 => 
            array (
                'id' => 6,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 30,
                'material_id' => 1070,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 8.0,
                'price' => 75000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            6 => 
            array (
                'id' => 7,
                'purchase_order_id' => 9,
                'purchase_order_detail_id' => 31,
                'material_id' => 1220,
                'resource_id' => NULL,
                'vendor_id' => 13,
                'quantity' => 2.0,
                'price' => 1250000.0,
                'created_at' => '2019-03-08 17:50:24',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            7 => 
            array (
                'id' => 8,
                'purchase_order_id' => 10,
                'purchase_order_detail_id' => 32,
                'material_id' => NULL,
                'resource_id' => 1,
                'vendor_id' => 24,
                'quantity' => 1.0,
                'price' => 1500000.0,
                'created_at' => '2019-03-08 17:52:34',
                'updated_at' => '2019-03-08 17:52:34',
            ),
            8 => 
            array (
                'id' => 9,
                'purchase_order_id' => 10,
                'purchase_order_detail_id' => 33,
                'material_id' => NULL,
                'resource_id' => 7,
                'vendor_id' => 24,
                'quantity' => 1.0,
                'price' => 500000.0,
                'created_at' => '2019-03-08 17:52:34',
                'updated_at' => '2019-03-08 17:52:34',
            ),
            9 => 
            array (
                'id' => 10,
                'purchase_order_id' => 10,
                'purchase_order_detail_id' => 34,
                'material_id' => NULL,
                'resource_id' => 4,
                'vendor_id' => 24,
                'quantity' => 1.0,
                'price' => 241594043.0,
                'created_at' => '2019-03-08 17:52:34',
                'updated_at' => '2019-03-08 17:52:34',
            ),
            10 => 
            array (
                'id' => 11,
                'purchase_order_id' => 11,
                'purchase_order_detail_id' => 35,
                'material_id' => 1824,
                'resource_id' => NULL,
                'vendor_id' => 19,
                'quantity' => 15.0,
                'price' => 75000.0,
                'created_at' => '2019-03-08 17:58:43',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            11 => 
            array (
                'id' => 12,
                'purchase_order_id' => 11,
                'purchase_order_detail_id' => 36,
                'material_id' => 1782,
                'resource_id' => NULL,
                'vendor_id' => 19,
                'quantity' => 7.5,
                'price' => 15000.0,
                'created_at' => '2019-03-08 17:58:43',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            12 => 
            array (
                'id' => 13,
                'purchase_order_id' => 11,
                'purchase_order_detail_id' => 37,
                'material_id' => 320,
                'resource_id' => NULL,
                'vendor_id' => 19,
                'quantity' => 25.0,
                'price' => 250000.0,
                'created_at' => '2019-03-08 17:58:43',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            13 => 
            array (
                'id' => 14,
                'purchase_order_id' => 11,
                'purchase_order_detail_id' => 38,
                'material_id' => 426,
                'resource_id' => NULL,
                'vendor_id' => 19,
                'quantity' => 55.0,
                'price' => 550000.0,
                'created_at' => '2019-03-08 17:58:43',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            14 => 
            array (
                'id' => 15,
                'purchase_order_id' => 11,
                'purchase_order_detail_id' => 39,
                'material_id' => 1045,
                'resource_id' => NULL,
                'vendor_id' => 19,
                'quantity' => 8.0,
                'price' => 125000.0,
                'created_at' => '2019-03-08 17:58:43',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            15 => 
            array (
                'id' => 16,
                'purchase_order_id' => 11,
                'purchase_order_detail_id' => 40,
                'material_id' => 1896,
                'resource_id' => NULL,
                'vendor_id' => 19,
                'quantity' => 3.0,
                'price' => 55000.0,
                'created_at' => '2019-03-08 17:58:43',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            16 => 
            array (
                'id' => 17,
                'purchase_order_id' => 12,
                'purchase_order_detail_id' => 41,
                'material_id' => NULL,
                'resource_id' => 30,
                'vendor_id' => 42,
                'quantity' => 1.0,
                'price' => 1250000.0,
                'created_at' => '2019-03-08 17:58:49',
                'updated_at' => '2019-03-08 17:58:49',
            ),
            17 => 
            array (
                'id' => 18,
                'purchase_order_id' => 12,
                'purchase_order_detail_id' => 42,
                'material_id' => NULL,
                'resource_id' => 6,
                'vendor_id' => 42,
                'quantity' => 1.0,
                'price' => 550000.0,
                'created_at' => '2019-03-08 17:58:49',
                'updated_at' => '2019-03-08 17:58:49',
            ),
            18 => 
            array (
                'id' => 19,
                'purchase_order_id' => 12,
                'purchase_order_detail_id' => 43,
                'material_id' => NULL,
                'resource_id' => 15,
                'vendor_id' => 42,
                'quantity' => 1.0,
                'price' => 187900000.0,
                'created_at' => '2019-03-08 17:58:49',
                'updated_at' => '2019-03-08 17:58:49',
            ),
        ));
        
        
    }
}