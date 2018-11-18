<?php

use Illuminate\Database\Seeder;

class ProductionOrderDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 1,
            'material_id' => 4,
            'quantity' => 25,
            'actual' => 25,
            ]);
        
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 1,
            'material_id' => 6,
            'quantity' => 100,
            'actual' => 25,
            ]);
        
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 1,
            'material_id' => 8,
            'quantity' => 150,
            'actual' => 25,
            ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 1,
            'material_id' => 9,
            'quantity' => 50,
            'actual' => 25,
        ]);

        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 1,
            'resource_id' => 3,
            'quantity' => 0,
            'actual' => 25,
        ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 2,
            'material_id' => 13,
            'quantity' => 5,
            'actual' => 25,
        ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 2,
            'resource_id' => 2,
            'quantity' => 0,
            'actual' => 25,
        ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 2,
            'material_id' => 15,
            'quantity' => 5,
            'actual' => 25,
        ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 2,
            'material_id' => 16,
            'quantity' => 4,
            'actual' => 25,
        ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 3,
            'material_id' => 54,
            'quantity' => 8,
            'actual' => 25,
        ]);
            
        DB::table('trx_production_order_detail')->insert([
            'production_order_id' => 3,
            'material_id' => 55,
            'quantity' => 2,
            'actual' => 25,
        ]);
    }
}
