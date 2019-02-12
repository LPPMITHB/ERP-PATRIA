<?php

use Illuminate\Database\Seeder;

class MstActivityProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_activity_profile')->delete();
        
        \DB::table('mst_activity_profile')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Activity Profile 1',
                'description' => 'Activity Profile 1',
                'wbs_id' => 3,
                'duration' => 20,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-02-12 10:40:04',
                'updated_at' => '2019-02-12 10:40:22',
            ),
        ));
        
        
    }
}