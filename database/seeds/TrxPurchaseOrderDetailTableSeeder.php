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
                'received' => 0,
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
        ));
        
        
    }
}