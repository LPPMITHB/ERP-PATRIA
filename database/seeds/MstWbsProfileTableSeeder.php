<?php

use Illuminate\Database\Seeder;

class MstWbsProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_wbs_profile')->delete();
        
        \DB::table('mst_wbs_profile')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'WBS Profile 1',
                'description' => 'WBS Profile 1',
                'deliverables' => 'WBS Profile 1',
                'wbs_id' => NULL,
                'user_id' => 1,
                'branch_id' => 1,
                'business_unit_id' => 1,
                'project_type_id' => 1,
                'created_at' => '2019-02-11 13:29:18',
                'updated_at' => '2019-02-11 13:29:18',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'WBS Profile 1.1',
                'description' => 'WBS Profile 1.1',
                'deliverables' => 'WBS Profile 1.1',
                'wbs_id' => 2,
                'user_id' => 1,
                'branch_id' => 1,
                'business_unit_id' => 1,
                'project_type_id' => 2,
                'created_at' => '2019-02-11 14:23:42',
                'updated_at' => '2019-02-11 14:23:42',
            ),
        ));
        
        
    }
}