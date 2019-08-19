<?php

use Illuminate\Database\Seeder;

class MstWbsStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_wbs_standard')->delete();
        
        \DB::table('mst_wbs_standard')->insert(array (
            0 => 
            array (
                'id' => 3,
                'number' => '1',
                'description' => '1',
                'deliverables' => '1',
                'duration' => 1,
                'project_standard_id' => 1,
                'wbs_id' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-15 14:56:20',
                'updated_at' => '2019-08-15 14:56:20',
            ),
            1 => 
            array (
                'id' => 4,
                'number' => '1.1',
                'description' => '1.1',
                'deliverables' => '1.1',
                'duration' => 1,
                'project_standard_id' => 1,
                'wbs_id' => 3,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-15 15:15:26',
                'updated_at' => '2019-08-15 15:15:26',
            ),
            2 => 
            array (
                'id' => 5,
                'number' => '1.1.1',
                'description' => '1.1.1',
                'deliverables' => '1.1.1',
                'duration' => 1,
                'project_standard_id' => 1,
                'wbs_id' => 4,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-15 15:23:20',
                'updated_at' => '2019-08-15 15:23:20',
            ),
            3 => 
            array (
                'id' => 6,
                'number' => '2',
                'description' => '2',
                'deliverables' => '2',
                'duration' => 2,
                'project_standard_id' => 1,
                'wbs_id' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-16 09:30:34',
                'updated_at' => '2019-08-16 09:30:34',
            ),
            4 => 
            array (
                'id' => 7,
                'number' => '1.2',
                'description' => '1.2',
                'deliverables' => '1.2',
                'duration' => 2,
                'project_standard_id' => 1,
                'wbs_id' => 3,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-16 12:11:49',
                'updated_at' => '2019-08-16 12:11:49',
            ),
            5 => 
            array (
                'id' => 8,
                'number' => '1.2.1',
                'description' => '1.2.1',
                'deliverables' => '1.2.1',
                'duration' => 2,
                'project_standard_id' => 1,
                'wbs_id' => 7,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-08-16 12:11:59',
                'updated_at' => '2019-08-16 12:11:59',
            ),
        ));
        
        
    }
}