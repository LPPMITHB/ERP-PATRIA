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
                'production_order_id' => 1,
                'material_id' => 4,
                'resource_id' => NULL,
                'quantity' => 25,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'production_order_id' => 1,
                'material_id' => 6,
                'resource_id' => NULL,
                'quantity' => 100,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'production_order_id' => 1,
                'material_id' => 8,
                'resource_id' => NULL,
                'quantity' => 150,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'production_order_id' => 1,
                'material_id' => 9,
                'resource_id' => NULL,
                'quantity' => 50,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'production_order_id' => 1,
                'material_id' => NULL,
                'resource_id' => 3,
                'quantity' => 0,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'production_order_id' => 2,
                'material_id' => 13,
                'resource_id' => NULL,
                'quantity' => 5,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'production_order_id' => 2,
                'material_id' => NULL,
                'resource_id' => 2,
                'quantity' => 0,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'production_order_id' => 2,
                'material_id' => 15,
                'resource_id' => NULL,
                'quantity' => 5,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'production_order_id' => 2,
                'material_id' => 16,
                'resource_id' => NULL,
                'quantity' => 4,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'production_order_id' => 3,
                'material_id' => 54,
                'resource_id' => NULL,
                'quantity' => 8,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'production_order_id' => 3,
                'material_id' => 55,
                'resource_id' => NULL,
                'quantity' => 2,
                'actual' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}