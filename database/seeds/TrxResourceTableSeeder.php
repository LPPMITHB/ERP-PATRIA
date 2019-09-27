<?php

use Illuminate\Database\Seeder;

class TrxResourceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_resource')->delete();
        
        \DB::table('trx_resource')->insert(array (
            0 => 
            array (
                'id' => 1,
                'resource_id' => 1,
                'resource_detail_id' => NULL,
                'category_id' => NULL,
                'project_id' => 6,
                'wbs_id' => 53,
                'quantity' => 5,
                'start_date' => NULL,
                'end_date' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-09-27 15:52:03',
                'updated_at' => '2019-09-27 15:52:03',
            ),
            1 => 
            array (
                'id' => 2,
                'resource_id' => 1,
                'resource_detail_id' => NULL,
                'category_id' => NULL,
                'project_id' => 6,
                'wbs_id' => 55,
                'quantity' => 2,
                'start_date' => NULL,
                'end_date' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-09-27 15:52:03',
                'updated_at' => '2019-09-27 15:52:03',
            ),
            2 => 
            array (
                'id' => 3,
                'resource_id' => 4,
                'resource_detail_id' => NULL,
                'category_id' => NULL,
                'project_id' => 6,
                'wbs_id' => 55,
                'quantity' => 2,
                'start_date' => NULL,
                'end_date' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-09-27 15:52:03',
                'updated_at' => '2019-09-27 15:52:03',
            ),
        ));
        
        
    }
}