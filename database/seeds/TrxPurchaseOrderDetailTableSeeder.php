<?php

use Illuminate\Database\Seeder;

class TrxPurchaseOrderDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_order_detail')->delete();
        
        \DB::table('trx_purchase_order_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_order_id' => 1,
                'purchase_requisition_detail_id' => 9,
                'quantity' => 15,
                'received' => 0,
                'material_id' => 2,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'total_price' => 37500000,
                'created_at' => '2019-01-17 04:35:15',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            1 => 
            array (
                'id' => 2,
                'purchase_order_id' => 1,
                'purchase_requisition_detail_id' => 11,
                'quantity' => 3,
                'received' => 0,
                'material_id' => 33,
                'resource_id' => NULL,
                'wbs_id' => 6,
                'total_price' => 114000000,
                'created_at' => '2019-01-17 04:35:15',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            2 => 
            array (
                'id' => 3,
                'purchase_order_id' => 2,
                'purchase_requisition_detail_id' => 13,
                'quantity' => 2,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 2,
                'wbs_id' => 4,
                'total_price' => 3000000,
                'created_at' => '2019-01-17 04:35:44',
                'updated_at' => '2019-01-17 06:49:44',
            ),
            3 => 
            array (
                'id' => 4,
                'purchase_order_id' => 3,
                'purchase_requisition_detail_id' => 22,
                'quantity' => 8,
                'received' => 0,
                'material_id' => 5,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'total_price' => 6000000,
                'created_at' => '2019-01-17 04:43:52',
                'updated_at' => '2019-01-17 04:43:52',
            ),
            4 => 
            array (
                'id' => 5,
                'purchase_order_id' => 3,
                'purchase_requisition_detail_id' => 23,
                'quantity' => 5,
                'received' => 0,
                'material_id' => 19,
                'resource_id' => NULL,
                'wbs_id' => 13,
                'total_price' => 300000000,
                'created_at' => '2019-01-17 04:43:53',
                'updated_at' => '2019-01-17 04:43:53',
            ),
            5 => 
            array (
                'id' => 6,
                'purchase_order_id' => 4,
                'purchase_requisition_detail_id' => 27,
                'quantity' => 3,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 4,
                'wbs_id' => 13,
                'total_price' => 10500000,
                'created_at' => '2019-01-17 04:44:29',
                'updated_at' => '2019-01-17 04:44:29',
            ),
            6 => 
            array (
                'id' => 7,
                'purchase_order_id' => 5,
                'purchase_requisition_detail_id' => 35,
                'quantity' => 15,
                'received' => 0,
                'material_id' => 36,
                'resource_id' => NULL,
                'wbs_id' => 5,
                'total_price' => 690000000,
                'created_at' => '2019-01-17 06:55:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            7 => 
            array (
                'id' => 8,
                'purchase_order_id' => 5,
                'purchase_requisition_detail_id' => 36,
                'quantity' => 12,
                'received' => 0,
                'material_id' => 30,
                'resource_id' => NULL,
                'wbs_id' => 6,
                'total_price' => 2640000,
                'created_at' => '2019-01-17 06:55:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            8 => 
            array (
                'id' => 9,
                'purchase_order_id' => 5,
                'purchase_requisition_detail_id' => 37,
                'quantity' => 5,
                'received' => 0,
                'material_id' => 33,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'total_price' => 190000000,
                'created_at' => '2019-01-17 06:55:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            9 => 
            array (
                'id' => 10,
                'purchase_order_id' => 5,
                'purchase_requisition_detail_id' => 38,
                'quantity' => 2,
                'received' => 0,
                'material_id' => 43,
                'resource_id' => NULL,
                'wbs_id' => 7,
                'total_price' => 57000000,
                'created_at' => '2019-01-17 06:55:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            10 => 
            array (
                'id' => 11,
                'purchase_order_id' => 5,
                'purchase_requisition_detail_id' => 39,
                'quantity' => 5,
                'received' => 0,
                'material_id' => 38,
                'resource_id' => NULL,
                'wbs_id' => 6,
                'total_price' => 12500000,
                'created_at' => '2019-01-17 06:55:05',
                'updated_at' => '2019-01-17 06:55:05',
            ),
            11 => 
            array (
                'id' => 12,
                'purchase_order_id' => 6,
                'purchase_requisition_detail_id' => 40,
                'quantity' => 4,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 2,
                'wbs_id' => 4,
                'total_price' => 6000000,
                'created_at' => '2019-01-17 06:55:37',
                'updated_at' => '2019-01-17 06:55:37',
            ),
            12 => 
            array (
                'id' => 13,
                'purchase_order_id' => 6,
                'purchase_requisition_detail_id' => 41,
                'quantity' => 3,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 1,
                'wbs_id' => 6,
                'total_price' => 3000000,
                'created_at' => '2019-01-17 06:55:38',
                'updated_at' => '2019-01-17 06:55:38',
            ),
            13 => 
            array (
                'id' => 14,
                'purchase_order_id' => 6,
                'purchase_requisition_detail_id' => 42,
                'quantity' => 2,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 3,
                'wbs_id' => 7,
                'total_price' => 5000000,
                'created_at' => '2019-01-17 06:55:38',
                'updated_at' => '2019-01-17 06:55:38',
            ),
            14 => 
            array (
                'id' => 15,
                'purchase_order_id' => 6,
                'purchase_requisition_detail_id' => 43,
                'quantity' => 3,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 4,
                'wbs_id' => 7,
                'total_price' => 10500000,
                'created_at' => '2019-01-17 06:55:38',
                'updated_at' => '2019-01-17 06:55:38',
            ),
            15 => 
            array (
                'id' => 16,
                'purchase_order_id' => 7,
                'purchase_requisition_detail_id' => 53,
                'quantity' => 5,
                'received' => 0,
                'material_id' => 32,
                'resource_id' => NULL,
                'wbs_id' => 13,
                'total_price' => 80000000,
                'created_at' => '2019-01-17 07:01:56',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            16 => 
            array (
                'id' => 17,
                'purchase_order_id' => 7,
                'purchase_requisition_detail_id' => 54,
                'quantity' => 15,
                'received' => 0,
                'material_id' => 68,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'total_price' => 64500,
                'created_at' => '2019-01-17 07:01:56',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            17 => 
            array (
                'id' => 18,
                'purchase_order_id' => 7,
                'purchase_requisition_detail_id' => 55,
                'quantity' => 12,
                'received' => 0,
                'material_id' => 41,
                'resource_id' => NULL,
                'wbs_id' => 15,
                'total_price' => 26400000,
                'created_at' => '2019-01-17 07:01:56',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            18 => 
            array (
                'id' => 19,
                'purchase_order_id' => 7,
                'purchase_requisition_detail_id' => 56,
                'quantity' => 8,
                'received' => 0,
                'material_id' => 3,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'total_price' => 2400000,
                'created_at' => '2019-01-17 07:01:56',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            19 => 
            array (
                'id' => 20,
                'purchase_order_id' => 7,
                'purchase_requisition_detail_id' => 57,
                'quantity' => 10,
                'received' => 0,
                'material_id' => 17,
                'resource_id' => NULL,
                'wbs_id' => 13,
                'total_price' => 2000000,
                'created_at' => '2019-01-17 07:01:56',
                'updated_at' => '2019-01-17 07:01:56',
            ),
            20 => 
            array (
                'id' => 21,
                'purchase_order_id' => 8,
                'purchase_requisition_detail_id' => 58,
                'quantity' => 5,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 2,
                'wbs_id' => 12,
                'total_price' => 7500000,
                'created_at' => '2019-01-17 07:02:17',
                'updated_at' => '2019-01-17 07:02:17',
            ),
            21 => 
            array (
                'id' => 22,
                'purchase_order_id' => 8,
                'purchase_requisition_detail_id' => 59,
                'quantity' => 3,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 3,
                'wbs_id' => 13,
                'total_price' => 7500000,
                'created_at' => '2019-01-17 07:02:17',
                'updated_at' => '2019-01-17 07:02:17',
            ),
            22 => 
            array (
                'id' => 23,
                'purchase_order_id' => 8,
                'purchase_requisition_detail_id' => 60,
                'quantity' => 5,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 4,
                'wbs_id' => 12,
                'total_price' => 17500000,
                'created_at' => '2019-01-17 07:02:17',
                'updated_at' => '2019-01-17 07:02:17',
            ),
            23 => 
            array (
                'id' => 24,
                'purchase_order_id' => 8,
                'purchase_requisition_detail_id' => 61,
                'quantity' => 3,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 1,
                'wbs_id' => 15,
                'total_price' => 3000000,
                'created_at' => '2019-01-17 07:02:17',
                'updated_at' => '2019-01-17 07:02:17',
            ),
        ));
        
        
    }
}