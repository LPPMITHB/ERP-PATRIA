<?php

use Illuminate\Database\Seeder;

class MstEstimatorWbsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_estimator_wbs')->delete();
        
        \DB::table('mst_estimator_wbs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'EWBS0001',
                'name' => 'Hull',
                'description' => NULL,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:48:46',
                'updated_at' => '2019-08-19 19:48:46',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'EWBS0002',
                'name' => 'Painting',
                'description' => NULL,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:48:53',
                'updated_at' => '2019-08-19 19:48:53',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'EWBS0003',
                'name' => 'Piping',
                'description' => NULL,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:49:00',
                'updated_at' => '2019-08-19 19:49:00',
            ),
        ));
        
        
    }
}