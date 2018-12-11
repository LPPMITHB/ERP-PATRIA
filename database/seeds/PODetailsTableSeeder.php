<?php

use Illuminate\Database\Seeder;

class PODetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trx_purchase_order_detail')->insert([
            'purchase_order_id' => 1,
            'wbs_id' => 1,
            'purchase_requisition_detail_id' => 1,
            'quantity' => 10,
            'material_id' => 3,
        ]);
        
        DB::table('trx_purchase_order_detail')->insert([
            'purchase_order_id' => 1,
            'wbs_id' => 2,
            'purchase_requisition_detail_id' => 2,
            'quantity' => 12,
            'material_id' => 6,
        ]);
        
    }
}
