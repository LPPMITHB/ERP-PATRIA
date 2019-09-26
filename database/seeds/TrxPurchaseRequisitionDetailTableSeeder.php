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
                'wbs_material_id' => NULL,
                'job_order' => NULL,
                'alocation' => 'Stock',
                'status' => NULL,
                'user_id' => 2,
                'project_id' => NULL,
                'created_at' => '2019-07-31 15:31:29',
                'updated_at' => '2019-07-31 15:31:58',
            ),
            1 => 
            array (
                'id' => 2,
                'purchase_requisition_id' => 2,
                'required_date' => '2019-08-01',
                'quantity' => 200.0,
                'reserved' => 200.0,
                'material_id' => 332,
                'resource_id' => NULL,
                'wbs_id' => NULL,
                'wbs_material_id' => NULL,
                'job_order' => NULL,
                'alocation' => 'Stock',
                'status' => NULL,
                'user_id' => 2,
                'project_id' => 5,
                'created_at' => '2019-08-06 13:31:05',
                'updated_at' => '2019-08-06 13:31:35',
            ),
            2 => 
            array (
                'id' => 3,
                'purchase_requisition_id' => 2,
                'required_date' => '2019-08-01',
                'quantity' => 200.0,
                'reserved' => 200.0,
                'material_id' => 2189,
                'resource_id' => NULL,
                'wbs_id' => NULL,
                'wbs_material_id' => NULL,
                'job_order' => NULL,
                'alocation' => 'Stock',
                'status' => NULL,
                'user_id' => 2,
                'project_id' => 5,
                'created_at' => '2019-08-06 13:31:05',
                'updated_at' => '2019-08-06 13:31:35',
            ),
            3 => 
            array (
                'id' => 4,
                'purchase_requisition_id' => 2,
                'required_date' => '2019-08-01',
                'quantity' => 200.0,
                'reserved' => 200.0,
                'material_id' => 399,
                'resource_id' => NULL,
                'wbs_id' => NULL,
                'wbs_material_id' => NULL,
                'job_order' => NULL,
                'alocation' => 'Stock',
                'status' => NULL,
                'user_id' => 2,
                'project_id' => 5,
                'created_at' => '2019-08-06 13:31:05',
                'updated_at' => '2019-08-06 13:31:35',
            ),
            4 => 
            array (
                'id' => 5,
                'purchase_requisition_id' => 2,
                'required_date' => '2019-08-01',
                'quantity' => 200.0,
                'reserved' => 200.0,
                'material_id' => 306,
                'resource_id' => NULL,
                'wbs_id' => NULL,
                'wbs_material_id' => NULL,
                'job_order' => NULL,
                'alocation' => 'Stock',
                'status' => NULL,
                'user_id' => 2,
                'project_id' => 5,
                'created_at' => '2019-08-06 13:31:05',
                'updated_at' => '2019-08-06 13:31:35',
            ),
        ));
        
        
    }
}