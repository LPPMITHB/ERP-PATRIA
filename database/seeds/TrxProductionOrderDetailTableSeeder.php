<?php

use Illuminate\Database\Seeder;

class TrxProductionOrderDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_production_order_detail')->delete();
        
        \DB::table('trx_production_order_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'production_order_id' => 17,
                'production_order_detail_id' => NULL,
                'material_id' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => 1,
                'source' => 'Stock',
                'resource_id' => NULL,
                'resource_detail_id' => NULL,
                'service_id' => NULL,
                'quantity' => 50,
                'actual' => NULL,
                'performance' => NULL,
                'performance_uom_id' => NULL,
                'morale' => NULL,
                'usage' => NULL,
                'status' => NULL,
                'created_at' => '2019-03-27 15:17:19',
                'updated_at' => '2019-03-27 15:17:44',
            ),
        ));
        
        
    }
}