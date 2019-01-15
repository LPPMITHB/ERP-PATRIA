<?php

use Illuminate\Database\Seeder;

class MstBomTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_bom')->delete();
        
        \DB::table('mst_bom')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'BOM18010001',
                'description' => 'DUMMY',
                'project_id' => 1,
                'wbs_id' => 4,
                'branch_id' => 1,
                'user_id' => 5,
                'status' => 1,
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:21',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'BOM18010002',
                'description' => 'DUMMY',
                'project_id' => 1,
                'wbs_id' => 5,
                'branch_id' => 1,
                'user_id' => 5,
                'status' => 1,
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'BOM18010003',
                'description' => 'DUMMY',
                'project_id' => 1,
                'wbs_id' => 6,
                'branch_id' => 1,
                'user_id' => 5,
                'status' => 1,
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'BOM18020001',
                'description' => 'DUMMY',
                'project_id' => 2,
                'wbs_id' => 12,
                'branch_id' => 1,
                'user_id' => 5,
                'status' => 1,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:59',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'BOM18020002',
                'description' => 'DUMMY',
                'project_id' => 2,
                'wbs_id' => 13,
                'branch_id' => 1,
                'user_id' => 5,
                'status' => 1,
                'created_at' => '2019-01-15 09:58:19',
                'updated_at' => '2019-01-15 09:58:19',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'BOM18020003',
                'description' => 'DUMMY',
                'project_id' => 2,
                'wbs_id' => 14,
                'branch_id' => 1,
                'user_id' => 5,
                'status' => 1,
                'created_at' => '2019-01-15 09:58:45',
                'updated_at' => '2019-01-15 09:58:45',
            ),
        ));
        
        
    }
}