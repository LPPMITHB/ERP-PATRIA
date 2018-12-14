<?php

use Illuminate\Database\Seeder;

class PRTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current_date = today();
        $valid_to = $current_date->addDays(7);
        $valid_to = $valid_to->toDateString();

        DB::table('trx_purchase_requisition')->insert([
            'number' => 'PR00001',
            'valid_date' => $valid_to,
            'project_id' => 1,
            'description' => 'purchase requisition pertama',
            'status' => 0,
            'branch_id' => 1,
            'user_id' => 4,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('trx_purchase_requisition')->insert([
            'number' => 'PR00002',
            'valid_date' => $valid_to,
            'project_id' => 1,
            'description' => 'purchase requisition kedua',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
