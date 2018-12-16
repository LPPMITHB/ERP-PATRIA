<?php

use Illuminate\Database\Seeder;

class POTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('trx_purchase_order')->insert([
            'number' => 'PO1800001',
            'purchase_requisition_id' => 1,
            'vendor_id' => 1,
            'project_id' => 1,
            'description' => 'purchase order pertama',
            'status' => 1,
            'user_id' => 4,
            'branch_id' => 1,
        ]);
    }
}
