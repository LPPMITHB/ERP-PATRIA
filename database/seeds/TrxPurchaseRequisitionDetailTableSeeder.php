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
                'required_date' => '2019-07-31',
                'quantity' => 211.0,
                'reserved' => 211.0,
                'material_id' => 6,
                'resource_id' => NULL,
                'wbs_id' => NULL,
                'activity_detail_id' => NULL,
                'job_order' => NULL,
                'alocation' => 'Stock',
                'status' => NULL,
                'user_id' => 2,
                'project_id' => NULL,
                'created_at' => '2019-07-31 15:31:29',
                'updated_at' => '2019-07-31 15:31:58',
            ),
        ));
        
        
    }
}