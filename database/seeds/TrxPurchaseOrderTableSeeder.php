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
                'id' => 9,
                'number' => 'PO-1900001',
                'purchase_requisition_id' => 18,
                'vendor_id' => 13,
                'currency' => 1,
                'value' => 1,
                'description' => 'PO DUMMY PIR 1',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 75000000.0,
                'delivery_term' => 1,
                'payment_term' => 1,
                'total_price' => 13860000.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:49:52',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            1 => 
            array (
                'id' => 10,
                'number' => 'PO-1900002',
                'purchase_requisition_id' => 19,
                'vendor_id' => 24,
                'currency' => 1,
                'value' => 1,
                'description' => 'PO DUMMY PIR 2',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 5000000.0,
                'delivery_term' => 1,
                'payment_term' => 1,
                'total_price' => 243594043.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:52:26',
                'updated_at' => '2019-03-08 17:52:34',
            ),
            2 => 
            array (
                'id' => 11,
                'number' => 'PO-1900003',
                'purchase_requisition_id' => 20,
                'vendor_id' => 19,
                'currency' => 1,
                'value' => 1,
                'description' => 'PO DUMMY PIR PAMI 1',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 15000000.0,
                'delivery_term' => 1,
                'payment_term' => 1,
                'total_price' => 38902500.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 2,
                'user_id' => 3,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            3 => 
            array (
                'id' => 12,
                'number' => 'PO-1900004',
                'purchase_requisition_id' => 21,
                'vendor_id' => 42,
                'currency' => 1,
                'value' => 1,
                'description' => 'PO DUMMY PIR PAMI 2',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 250000000.0,
                'delivery_term' => 1,
                'payment_term' => 1,
                'total_price' => 189700000.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 2,
                'user_id' => 3,
                'approved_by' => 3,
                'approval_date' => NULL,
                'created_at' => '2019-03-08 17:58:31',
                'updated_at' => '2019-03-08 17:58:49',
            ),
            4 => 
            array (
                'id' => 13,
                'number' => 'PO-1900005',
                'purchase_requisition_id' => 22,
                'vendor_id' => 1,
                'currency' => 1,
                'value' => 1,
                'description' => 'TEst',
                'revision_description' => '',
                'status' => 0,
                'tax' => 0.0,
                'estimated_freight' => 0.0,
                'delivery_term' => NULL,
                'payment_term' => NULL,
                'total_price' => 3500000.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-07-29',
                'created_at' => '2019-07-29 16:49:13',
                'updated_at' => '2019-07-29 16:50:45',
            ),
            5 => 
            array (
                'id' => 14,
                'number' => 'PO-1900006',
                'purchase_requisition_id' => 23,
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
                'total_price' => 20000000.0,
                'delivery_date' => NULL,
                'project_id' => NULL,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-07-29',
                'created_at' => '2019-07-29 16:59:00',
                'updated_at' => '2019-07-29 16:59:45',
            ),
        ));
        
        
    }
}