<?php

use Illuminate\Database\Seeder;

class ProActivityTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pro_activity')->delete();
        
        \DB::table('pro_activity')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'ACT192040001',
                'name' => 'Plate',
                'description' => 'Plate',
                'status' => 1,
                'wbs_id' => 7,
                'activity_configuration_id' => 186,
                'planned_duration' => 7,
                'planned_start_date' => '2019-04-27',
                'planned_end_date' => '2019-05-03',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 9.0,
                'predecessor' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-04-11 16:33:33',
                'updated_at' => '2019-04-11 16:56:31',
            ),
            1 => 
            array (
                'id' => 3,
                'code' => 'ACT192040002',
                'name' => 'Stiffener Line 1-5',
                'description' => 'Stiffener Line 1-5',
                'status' => 1,
                'wbs_id' => 7,
                'activity_configuration_id' => 187,
                'planned_duration' => 4,
                'planned_start_date' => '2019-05-03',
                'planned_end_date' => '2019-05-06',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 6.0,
                'predecessor' => '[[1,"fs"]]',
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-04-11 16:55:17',
                'updated_at' => '2019-04-11 16:55:35',
            ),
            2 => 
            array (
                'id' => 4,
                'code' => 'ACT192040003',
                'name' => 'Roundbar',
                'description' => 'Roundbar',
                'status' => 1,
                'wbs_id' => 7,
                'activity_configuration_id' => 188,
                'planned_duration' => 5,
                'planned_start_date' => '2019-05-06',
                'planned_end_date' => '2019-05-10',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 10.0,
                'predecessor' => '[[3,"fs"]]',
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-04-11 16:56:22',
                'updated_at' => '2019-04-11 16:56:22',
            ),
        ));
        
        
    }
}