<?php

use Illuminate\Database\Seeder;

class MstEstimatorProfileDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_estimator_profile_detail')->delete();
        
        \DB::table('mst_estimator_profile_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'profile_id' => 1,
                'cost_standard_id' => 1,
                'created_at' => '2019-08-19 19:50:28',
                'updated_at' => '2019-08-19 19:50:28',
            ),
            1 => 
            array (
                'id' => 2,
                'profile_id' => 1,
                'cost_standard_id' => 2,
                'created_at' => '2019-08-19 19:50:28',
                'updated_at' => '2019-08-19 19:50:28',
            ),
            2 => 
            array (
                'id' => 3,
                'profile_id' => 1,
                'cost_standard_id' => 3,
                'created_at' => '2019-08-19 19:50:28',
                'updated_at' => '2019-08-19 19:50:28',
            ),
            3 => 
            array (
                'id' => 4,
                'profile_id' => 1,
                'cost_standard_id' => 4,
                'created_at' => '2019-08-19 19:50:28',
                'updated_at' => '2019-08-19 19:50:28',
            ),
        ));
        
        
    }
}