<?php

use Illuminate\Database\Seeder;

class PRDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trx_purchase_requisition_detail')->insert([
            'purchase_requisition_id' => 1,
            'quantity' => 10,
            'reserved' => 10,
            'material_id' => 3,
            'work_id' => 1,
        ]);

        DB::table('trx_purchase_requisition_detail')->insert([
            'purchase_requisition_id' => 1,
            'quantity' => 12,
            'reserved' => 12,
            'material_id' => 6,
            'work_id' => 2,
        ]);

        DB::table('trx_purchase_requisition_detail')->insert([
            'purchase_requisition_id' => 2,
            'quantity' => 10,
            'reserved' => 0,
            'material_id' => 3,
            'work_id' => 1,
        ]);

        DB::table('trx_purchase_requisition_detail')->insert([
            'purchase_requisition_id' => 2,
            'quantity' => 22,
            'reserved' => 0,
            'material_id' => 6,
            'work_id' => 2,
        ]);

        DB::table('trx_purchase_requisition_detail')->insert([
            'purchase_requisition_id' => 2,
            'quantity' => 10,
            'reserved' => 0,
            'material_id' => 1,
            'work_id' => 3,
        ]);

        DB::table('trx_purchase_requisition_detail')->insert([
            'purchase_requisition_id' => 2,
            'quantity' => 12,
            'reserved' => 0,
            'material_id' => 2,
            'work_id' => 4,
        ]);
    }
}
