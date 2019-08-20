<?php

use Illuminate\Database\Seeder;

class MstEstimatorProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_estimator_profile')->delete();
        
        \DB::table('mst_estimator_profile')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'EPF0001',
                'description' => '',
                'ship_id' => 1,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:50:28',
                'updated_at' => '2019-08-19 19:50:28',
            ),
        ));
        
        
    }
}