<?php

use Illuminate\Database\Seeder;

class TrxPurchaseRequisitionDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_requisition_detail')->delete();
        
        \DB::table('trx_purchase_requisition_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_requisition_id' => 1,
                'quantity' => 1351,
                'reserved' => 0,
                'material_id' => 5,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'alocation' => NULL,
                'created_at' => '2019-01-15 09:57:55',
                'updated_at' => '2019-01-15 09:57:55',
            ),
            1 => 
            array (
                'id' => 2,
                'purchase_requisition_id' => 2,
                'quantity' => 23,
                'reserved' => 0,
                'material_id' => 5,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            2 => 
            array (
                'id' => 3,
                'purchase_requisition_id' => 2,
                'quantity' => 15,
                'reserved' => 0,
                'material_id' => 4,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            3 => 
            array (
                'id' => 4,
                'purchase_requisition_id' => 2,
                'quantity' => 8,
                'reserved' => 0,
                'material_id' => 1,
                'resource_id' => NULL,
                'wbs_id' => 6,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            4 => 
            array (
                'id' => 5,
                'purchase_requisition_id' => 2,
                'quantity' => 12,
                'reserved' => 0,
                'material_id' => 7,
                'resource_id' => NULL,
                'wbs_id' => 6,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            5 => 
            array (
                'id' => 6,
                'purchase_requisition_id' => 2,
                'quantity' => 3,
                'reserved' => 0,
                'material_id' => 25,
                'resource_id' => NULL,
                'wbs_id' => 5,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            6 => 
            array (
                'id' => 7,
                'purchase_requisition_id' => 3,
                'quantity' => 2,
                'reserved' => 0,
                'material_id' => NULL,
                'resource_id' => 1,
                'wbs_id' => 4,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:31:13',
                'updated_at' => '2019-01-17 04:31:13',
            ),
            7 => 
            array (
                'id' => 8,
                'purchase_requisition_id' => 3,
                'quantity' => 3,
                'reserved' => 0,
                'material_id' => NULL,
                'resource_id' => 3,
                'wbs_id' => 4,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:31:13',
                'updated_at' => '2019-01-17 04:31:13',
            ),
            8 => 
            array (
                'id' => 9,
                'purchase_requisition_id' => 4,
                'quantity' => 15,
                'reserved' => 15,
                'material_id' => 2,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            9 => 
            array (
                'id' => 10,
                'purchase_requisition_id' => 4,
                'quantity' => 8,
                'reserved' => 0,
                'material_id' => 3,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 04:33:59',
            ),
            10 => 
            array (
                'id' => 11,
                'purchase_requisition_id' => 4,
                'quantity' => 3,
                'reserved' => 3,
                'material_id' => 33,
                'resource_id' => NULL,
                'wbs_id' => 6,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            11 => 
            array (
                'id' => 12,
                'purchase_requisition_id' => 4,
                'quantity' => 2,
                'reserved' => 0,
                'material_id' => 39,
                'resource_id' => NULL,
                'wbs_id' => 4,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 04:33:59',
            ),
            12 => 
            array (
                'id' => 13,
                'purchase_requisition_id' => 5,
                'quantity' => 3,
                'reserved' => 1,
                'material_id' => NULL,
                'resource_id' => 2,
                'wbs_id' => 4,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:34:34',
                'updated_at' => '2019-01-17 04:35:44',
            ),
            13 => 
            array (
                'id' => 14,
                'purchase_requisition_id' => 5,
                'quantity' => 1,
                'reserved' => 0,
                'material_id' => NULL,
                'resource_id' => 4,
                'wbs_id' => 6,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:34:34',
                'updated_at' => '2019-01-17 04:34:34',
            ),
            14 => 
            array (
                'id' => 15,
                'purchase_requisition_id' => 6,
                'quantity' => 15,
                'reserved' => 0,
                'material_id' => 36,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:40:37',
                'updated_at' => '2019-01-17 04:40:37',
            ),
            15 => 
            array (
                'id' => 16,
                'purchase_requisition_id' => 6,
                'quantity' => 5,
                'reserved' => 0,
                'material_id' => 44,
                'resource_id' => NULL,
                'wbs_id' => 14,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:40:37',
                'updated_at' => '2019-01-17 04:40:37',
            ),
            16 => 
            array (
                'id' => 17,
                'purchase_requisition_id' => 6,
                'quantity' => 8,
                'reserved' => 0,
                'material_id' => 35,
                'resource_id' => NULL,
                'wbs_id' => 13,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:40:38',
                'updated_at' => '2019-01-17 04:40:38',
            ),
            17 => 
            array (
                'id' => 18,
                'purchase_requisition_id' => 6,
                'quantity' => 5,
                'reserved' => 0,
                'material_id' => 46,
                'resource_id' => NULL,
                'wbs_id' => 14,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:40:38',
                'updated_at' => '2019-01-17 04:40:38',
            ),
            18 => 
            array (
                'id' => 19,
                'purchase_requisition_id' => 7,
                'quantity' => 2,
                'reserved' => 0,
                'material_id' => NULL,
                'resource_id' => 2,
                'wbs_id' => 12,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:41:15',
                'updated_at' => '2019-01-17 04:41:15',
            ),
            19 => 
            array (
                'id' => 20,
                'purchase_requisition_id' => 7,
                'quantity' => 3,
                'reserved' => 0,
                'material_id' => NULL,
                'resource_id' => 3,
                'wbs_id' => 13,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:41:15',
                'updated_at' => '2019-01-17 04:41:15',
            ),
            20 => 
            array (
                'id' => 21,
                'purchase_requisition_id' => 8,
                'quantity' => 15,
                'reserved' => 0,
                'material_id' => 4,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:42:14',
                'updated_at' => '2019-01-17 04:42:14',
            ),
            21 => 
            array (
                'id' => 22,
                'purchase_requisition_id' => 8,
                'quantity' => 8,
                'reserved' => 8,
                'material_id' => 5,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:42:15',
                'updated_at' => '2019-01-17 04:43:52',
            ),
            22 => 
            array (
                'id' => 23,
                'purchase_requisition_id' => 8,
                'quantity' => 5,
                'reserved' => 5,
                'material_id' => 19,
                'resource_id' => NULL,
                'wbs_id' => 13,
                'alocation' => 'Stock',
                'created_at' => '2019-01-17 04:42:15',
                'updated_at' => '2019-01-17 04:43:53',
            ),
            23 => 
            array (
                'id' => 24,
                'purchase_requisition_id' => 8,
                'quantity' => 5,
                'reserved' => 0,
                'material_id' => 21,
                'resource_id' => NULL,
                'wbs_id' => 13,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:42:15',
                'updated_at' => '2019-01-17 04:42:15',
            ),
            24 => 
            array (
                'id' => 25,
                'purchase_requisition_id' => 8,
                'quantity' => 2,
                'reserved' => 0,
                'material_id' => 16,
                'resource_id' => NULL,
                'wbs_id' => 14,
                'alocation' => 'Consumption',
                'created_at' => '2019-01-17 04:42:15',
                'updated_at' => '2019-01-17 04:42:15',
            ),
            25 => 
            array (
                'id' => 26,
                'purchase_requisition_id' => 9,
                'quantity' => 3,
                'reserved' => 0,
                'material_id' => NULL,
                'resource_id' => 1,
                'wbs_id' => 12,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:42:47',
                'updated_at' => '2019-01-17 04:42:47',
            ),
            26 => 
            array (
                'id' => 27,
                'purchase_requisition_id' => 9,
                'quantity' => 5,
                'reserved' => 3,
                'material_id' => NULL,
                'resource_id' => 4,
                'wbs_id' => 13,
                'alocation' => NULL,
                'created_at' => '2019-01-17 04:42:47',
                'updated_at' => '2019-01-17 04:44:29',
            ),
        ));
        
        
    }
}