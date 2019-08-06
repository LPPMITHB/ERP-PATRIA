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
                'purchase_requisition_id' => 1,
                'vendor_id' => 2,
                'currency' => 1,
                'value' => 1,
                'description' => '',
                'revision_description' => '',
                'status' => 2,
                'tax' => 0.0,
                'estimated_freight' => 0.0,
                'delivery_term' => NULL,
                'payment_term' => NULL,
                'total_price' => 211000000.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-07-31',
                'created_at' => '2019-07-31 15:31:58',
                'updated_at' => '2019-07-31 15:32:46',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PO-1900002',
                'purchase_requisition_id' => 2,
                'vendor_id' => 2,
                'currency' => 1,
                'value' => 1,
                'description' => '',
                'revision_description' => '',
                'status' => 0,
                'tax' => 0.0,
                'estimated_freight' => 0.0,
                'delivery_term' => NULL,
                'payment_term' => NULL,
                'total_price' => 4000000000.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-08-06',
                'created_at' => '2019-08-06 13:31:35',
                'updated_at' => '2019-08-06 13:32:18',
            ),
        ));
        
        
    }
}