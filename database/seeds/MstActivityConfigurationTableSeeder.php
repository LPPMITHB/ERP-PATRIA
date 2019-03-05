<?php

use Illuminate\Database\Seeder;

class MstActivityConfigurationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_activity_configuration')->delete();
        
        \DB::table('mst_activity_configuration')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'T',
                'description' => 'T',
                'wbs_id' => 1,
                'duration' => 2,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-03-04 19:01:45',
                'updated_at' => '2019-03-04 19:01:45',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'T',
                'description' => 'T',
                'wbs_id' => 3,
                'duration' => 2,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-03-04 19:05:09',
                'updated_at' => '2019-03-04 19:05:09',
            ),
        ));
        
        
    }
}