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
                'quantity' => 1,
                'received' => 0,
                'material_id' => NULL,
                'resource_id' => 2,
                'wbs_id' => 4,
                'total_price' => 1500000,
                'created_at' => '2019-01-17 04:35:44',
                'updated_at' => '2019-01-17 04:35:44',
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
        ));
        
        
    }
}