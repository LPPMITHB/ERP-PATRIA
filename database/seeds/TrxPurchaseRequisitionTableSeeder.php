<?php

use Illuminate\Database\Seeder;

class TrxPurchaseRequisitionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_requisition')->delete();
        
        \DB::table('trx_purchase_requisition')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'PR-1900001',
                'required_date' => NULL,
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => '',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-07-31',
                'created_at' => '2019-07-31 15:31:29',
                'updated_at' => '2019-07-31 15:31:58',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PR-1900002',
                'required_date' => NULL,
                'type' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'business_unit_id' => 1,
                'description' => 'Test',
                'revision_description' => '',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 2,
                'approved_by' => 2,
                'approval_date' => '2019-08-06',
                'created_at' => '2019-08-06 13:31:05',
                'updated_at' => '2019-08-06 13:31:35',
            ),
        ));
        
        
    }
}