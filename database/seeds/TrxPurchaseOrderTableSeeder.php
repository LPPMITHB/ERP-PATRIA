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
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 1,
                'description' => 'PO DUMMY 1',
                'status' => 1,
                'total_price' => 151500000,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:35:15',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PO-1900002',
                'purchase_requisition_id' => 5,
                'vendor_id' => 35,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 1,
                'description' => 'PO DUMMY 2 (RESOURCE)',
                'status' => 1,
                'total_price' => 3000000,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:35:44',
                'updated_at' => '2019-01-17 06:49:44',
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'PO-1900003',
                'purchase_requisition_id' => 8,
                'vendor_id' => 38,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 2,
                'description' => 'PO DUMMY 1 PAMI',
                'status' => 1,
                'total_price' => 306000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:43:52',
                'updated_at' => '2019-01-17 04:44:06',
            ),
            3 => 
            array (
                'id' => 4,
                'number' => 'PO-1900004',
                'purchase_requisition_id' => 9,
                'vendor_id' => 10,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 2,
                'description' => 'PO DUMMY 2 PAMI',
                'status' => 1,
                'total_price' => 10500000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 04:44:29',
                'updated_at' => '2019-01-17 04:44:29',
            ),
            4 => 
            array (
                'id' => 5,
                'number' => 'PO-1900005',
                'purchase_requisition_id' => 12,
                'vendor_id' => 9,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 1,
                'description' => 'PO DUMMY PMP',
                'status' => 2,
                'total_price' => 952140000,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:55:05',
                'updated_at' => '2019-01-17 06:55:54',
            ),
            5 => 
            array (
                'id' => 6,
                'number' => 'PO-1900006',
                'purchase_requisition_id' => 13,
                'vendor_id' => 17,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 1,
                'description' => 'PO DUMMY RESOURCE',
                'status' => 2,
                'total_price' => 24500000,
                'branch_id' => 2,
                'user_id' => 1,
                'created_at' => '2019-01-17 06:55:37',
                'updated_at' => '2019-01-17 06:56:06',
            ),
            6 => 
            array (
                'id' => 7,
                'number' => 'PO-1900007',
                'purchase_requisition_id' => 16,
                'vendor_id' => 17,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 2,
                'description' => 'PO DUMMY PAMI 3',
                'status' => 2,
                'total_price' => 110864500,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 07:01:56',
                'updated_at' => '2019-01-17 07:02:37',
            ),
            7 => 
            array (
                'id' => 8,
                'number' => 'PO-1900008',
                'purchase_requisition_id' => 17,
                'vendor_id' => 11,
                'required_date' => '2019-02-18',
                'currency' => 'Rupiah',
                'value' => 1,
                'project_id' => 2,
                'description' => 'PO DUMMY PAMI 4 (RESOURCE)',
                'status' => 2,
                'total_price' => 35500000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => '2019-01-17 07:02:17',
                'updated_at' => '2019-01-17 07:02:41',
            ),
        ));
        
        
    }
}