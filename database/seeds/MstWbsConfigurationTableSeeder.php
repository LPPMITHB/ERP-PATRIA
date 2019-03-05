<?php

use Illuminate\Database\Seeder;

class MstWbsConfigurationTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_wbs_configuration')->delete();
        
        \DB::table('mst_wbs_configuration')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'T',
                'description' => 'T',
                'deliverables' => 'T',
                'duration' => 2,
                'wbs_id' => NULL,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-03-04 17:44:19',
                'updated_at' => '2019-03-04 17:44:19',
            ),
            1 => 
            array (
                'id' => 3,
                'number' => 'T1',
                'description' => 'T1',
                'deliverables' => 'T1',
                'duration' => 1,
                'wbs_id' => 1,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-03-04 18:00:38',
                'updated_at' => '2019-03-04 18:00:38',
            ),
            2 => 
            array (
                'id' => 4,
                'number' => 'T2',
                'description' => 'T2',
                'deliverables' => 'T2',
                'duration' => 2,
                'wbs_id' => 1,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-03-04 18:01:12',
                'updated_at' => '2019-03-04 18:06:58',
            ),
        ));
        
        
    }
}