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
                'currency' => 'Rupiah',
                'value' => 1,
                'description' => 'PO DUMMY PIR 1',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 75000000.0,
                'delivery_terms' => 'partially',
                'payment_terms' => 'transfer',
                'total_price' => 13860000.0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'created_at' => '2019-03-08 17:49:52',
                'updated_at' => '2019-03-08 17:50:24',
            ),
            1 => 
            array (
                'id' => 10,
                'number' => 'PO-1900002',
                'purchase_requisition_id' => 19,
                'vendor_id' => 24,
                'currency' => 'Rupiah',
                'value' => 1,
                'description' => 'PO DUMMY PIR 2',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 5000000.0,
                'delivery_terms' => 'direct',
                'payment_terms' => 'cash',
                'total_price' => 243594043.0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'created_at' => '2019-03-08 17:52:26',
                'updated_at' => '2019-03-08 17:52:34',
            ),
            2 => 
            array (
                'id' => 11,
                'number' => 'PO-1900003',
                'purchase_requisition_id' => 20,
                'vendor_id' => 19,
                'currency' => 'Rupiah',
                'value' => 1,
                'description' => 'PO DUMMY PIR PAMI 1',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 15000000.0,
                'delivery_terms' => 'same day',
                'payment_terms' => 'cash',
                'total_price' => 38902500.0,
                'branch_id' => 2,
                'user_id' => 3,
                'approved_by' => 3,
                'created_at' => '2019-03-08 17:57:16',
                'updated_at' => '2019-03-08 17:58:43',
            ),
            3 => 
            array (
                'id' => 12,
                'number' => 'PO-1900004',
                'purchase_requisition_id' => 21,
                'vendor_id' => 42,
                'currency' => 'Rupiah',
                'value' => 1,
                'description' => 'PO DUMMY PIR PAMI 2',
                'revision_description' => '',
                'status' => 2,
                'tax' => 5.0,
                'estimated_freight' => 250000000.0,
                'delivery_terms' => 'same day',
                'payment_terms' => 'cash',
                'total_price' => 189700000.0,
                'branch_id' => 2,
                'user_id' => 3,
                'approved_by' => 3,
                'created_at' => '2019-03-08 17:58:31',
                'updated_at' => '2019-03-08 17:58:49',
            ),
        ));
        
        
    }
}