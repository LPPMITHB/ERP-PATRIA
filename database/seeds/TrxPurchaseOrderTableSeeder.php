<?php

use Illuminate\Database\Seeder;

class TrxPurchaseOrderTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_order')->delete();
        
        \DB::table('trx_purchase_order')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'PO-1900001',
                'purchase_requisition_id' => 4,
                'vendor_id' => 17,
                'project_id' => 1,
                'description' => 'PO DUMMY 1',
                'status' => 1,
                'total_price' => 151500000,
                'branch_id' => 2,
                'user_id' => 2,
                'created_at' => '2019-01-17 04:35:15',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PO-1900002',
                'purchase_requisition_id' => 5,
                'vendor_id' => 35,
                'project_id' => 1,
            'description' => 'PO DUMMY 2 (RESOURCE)',
                'status' => 1,
                'total_price' => 1500000,
                'branch_id' => 2,
                'user_id' => 2,
                'created_at' => '2019-01-17 04:35:44',
                'updated_at' => '2019-01-17 04:35:44',
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'PO-1900003',
                'purchase_requisition_id' => 8,
                'vendor_id' => 38,
                'project_id' => 2,
                'description' => 'PO DUMMY 1 PAMI',
                'status' => 1,
                'total_price' => 306000000,
                'branch_id' => 1,
                'user_id' => 3,
                'created_at' => '2019-01-17 04:43:52',
                'updated_at' => '2019-01-17 04:44:06',
            ),
            3 => 
            array (
                'id' => 4,
                'number' => 'PO-1900004',
                'purchase_requisition_id' => 9,
                'vendor_id' => 10,
                'project_id' => 2,
                'description' => 'PO DUMMY 2 PAMI',
                'status' => 1,
                'total_price' => 10500000,
                'branch_id' => 1,
                'user_id' => 3,
                'created_at' => '2019-01-17 04:44:29',
                'updated_at' => '2019-01-17 04:44:29',
            ),
        ));
        
        
    }
}