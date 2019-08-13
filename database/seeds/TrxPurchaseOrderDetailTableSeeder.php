<?php

use Illuminate\Database\Seeder;

class TrxPurchaseOrderDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_order_detail')->delete();
        
        \DB::table('trx_purchase_order_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'purchase_order_id' => 1,
                'purchase_requisition_detail_id' => 1,
                'discount' => 0.0,
                'quantity' => 211.0,
                'received' => 0.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 6,
                'resource_id' => NULL,
                'project_id' => NULL,
                'activity_detail_id' => NULL,
                'job_order' => NULL,
                'total_price' => 211000000.0,
                'delivery_date' => '2019-07-31',
                'created_at' => '2019-07-31 15:31:58',
                'updated_at' => '2019-07-31 15:32:46',
            ),
            1 => 
            array (
                'id' => 2,
                'purchase_order_id' => 2,
                'purchase_requisition_detail_id' => 2,
                'discount' => 0.0,
                'quantity' => 200.0,
                'received' => 200.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 332,
                'resource_id' => NULL,
                'project_id' => 5,
                'activity_detail_id' => NULL,
                'job_order' => NULL,
                'total_price' => 1000000000.0,
                'delivery_date' => '2019-08-01',
                'created_at' => '2019-08-06 13:31:35',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            2 => 
            array (
                'id' => 3,
                'purchase_order_id' => 2,
                'purchase_requisition_detail_id' => 3,
                'discount' => 0.0,
                'quantity' => 200.0,
                'received' => 200.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 2189,
                'resource_id' => NULL,
                'project_id' => 5,
                'activity_detail_id' => NULL,
                'job_order' => NULL,
                'total_price' => 1000000000.0,
                'delivery_date' => '2019-08-01',
                'created_at' => '2019-08-06 13:31:35',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            3 => 
            array (
                'id' => 4,
                'purchase_order_id' => 2,
                'purchase_requisition_detail_id' => 4,
                'discount' => 0.0,
                'quantity' => 200.0,
                'received' => 200.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 399,
                'resource_id' => NULL,
                'project_id' => 5,
                'activity_detail_id' => NULL,
                'job_order' => NULL,
                'total_price' => 1000000000.0,
                'delivery_date' => '2019-08-01',
                'created_at' => '2019-08-06 13:31:35',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            4 => 
            array (
                'id' => 5,
                'purchase_order_id' => 2,
                'purchase_requisition_detail_id' => 5,
                'discount' => 0.0,
                'quantity' => 200.0,
                'received' => 200.0,
                'returned' => 0.0,
                'remark' => NULL,
                'material_id' => 306,
                'resource_id' => NULL,
                'project_id' => 5,
                'activity_detail_id' => NULL,
                'job_order' => NULL,
                'total_price' => 1000000000.0,
                'delivery_date' => '2019-08-01',
                'created_at' => '2019-08-06 13:31:35',
                'updated_at' => '2019-08-06 13:32:18',
            ),
        ));
        
        
    }
}