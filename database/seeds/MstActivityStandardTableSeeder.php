<?php

use Illuminate\Database\Seeder;

class MstActivityStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_activity_standard')->delete();
        
        \DB::table('mst_activity_standard')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Satu',
                'description' => 'Satu',
                'wbs_id' => 5,
                'duration' => 1,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-15 15:36:47',
                'updated_at' => '2019-08-15 15:36:47',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'b',
                'description' => 'b',
                'wbs_id' => 8,
                'duration' => 2,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-16 12:12:05',
                'updated_at' => '2019-08-16 12:12:05',
            ),
        ));
        
        
    }
}