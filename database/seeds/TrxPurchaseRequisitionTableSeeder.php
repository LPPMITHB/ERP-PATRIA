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
                'type' => 1,
                'valid_date' => '2019-01-22',
                'project_id' => 2,
                'bom_id' => 4,
                'purchase_requisition_id' => NULL,
                'description' => 'AUTO PR FOR PRO2-DUMMY2',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 5,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
        ));
        
        
    }
}