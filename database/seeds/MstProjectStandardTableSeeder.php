<?php

use Illuminate\Database\Seeder;

class MstProjectStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_project_standard')->delete();
        
        \DB::table('mst_project_standard')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'TB1',
                'description' => '1',
                'ship_id' => 1,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-15 14:20:47',
                'updated_at' => '2019-08-15 14:20:47',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'TB2',
                'description' => '2',
                'ship_id' => 1,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-16 09:30:27',
                'updated_at' => '2019-08-16 09:30:27',
            ),
        ));
        
        
    }
}