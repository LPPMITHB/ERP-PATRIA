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
                'quantity' => 1351,
                'reserved' => 0,
                'material_id' => 5,
                'resource_id' => NULL,
                'wbs_id' => 12,
                'alocation' => NULL,
                'created_at' => '2019-01-15 09:57:55',
                'updated_at' => '2019-01-15 09:57:55',
            ),
        ));
        
        
    }
}