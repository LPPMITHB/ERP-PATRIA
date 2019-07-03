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
                'code' => 'BOM19020001',
                'description' => '',
                'project_id' => 2,
                'wbs_id' => 16,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:11',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'BOM19020002',
                'description' => '',
                'project_id' => 2,
                'wbs_id' => 19,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 11:52:26',
                'updated_at' => '2019-04-03 11:52:31',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'BOM19020003',
                'description' => '',
                'project_id' => 2,
                'wbs_id' => 20,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:05',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'BOM19020004',
                'description' => '',
                'project_id' => 2,
                'wbs_id' => 21,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:48',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'BOM19020005',
                'description' => '',
                'project_id' => 2,
                'wbs_id' => 22,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:20',
            ),
        ));

        // projecet 5
        \DB::table('mst_bom')->insert(array (
            0 => 
            array (
                'id' => 6,
                'code' => 'BOM19050001',
                'description' => '',
                'project_id' => 5,
                'wbs_id' => 34,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:11',
            ),
            1 => 
            array (
                'id' => 7,
                'code' => 'BOM19050002',
                'description' => '',
                'project_id' => 5,
                'wbs_id' => 37,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 11:52:26',
                'updated_at' => '2019-04-03 11:52:31',
            ),
            2 => 
            array (
                'id' => 8,
                'code' => 'BOM19050003',
                'description' => '',
                'project_id' => 5,
                'wbs_id' => 38,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:05',
            ),
            3 => 
            array (
                'id' => 9,
                'code' => 'BOM19050004',
                'description' => '',
                'project_id' => 5,
                'wbs_id' => 39,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:48',
            ),
            4 => 
            array (
                'id' => 10,
                'code' => 'BOM19050005',
                'description' => '',
                'project_id' => 5,
                'wbs_id' => 40,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:20',
            ),
        ));
        
        // projecet 4
        \DB::table('mst_bom')->insert(array (
            0 => 
            array (
                'id' => 11,
                'code' => 'BOM19040001',
                'description' => '',
                'project_id' => 4,
                'wbs_id' => 43,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:11',
            ),
            1 => 
            array (
                'id' => 12,
                'code' => 'BOM19040002',
                'description' => '',
                'project_id' => 4,
                'wbs_id' => 46,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 11:52:26',
                'updated_at' => '2019-04-03 11:52:31',
            ),
            2 => 
            array (
                'id' => 13,
                'code' => 'BOM19040003',
                'description' => '',
                'project_id' => 4,
                'wbs_id' => 47,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:05',
            ),
            3 => 
            array (
                'id' => 14,
                'code' => 'BOM19040004',
                'description' => '',
                'project_id' => 4,
                'wbs_id' => 48,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:48',
            ),
            4 => 
            array (
                'id' => 15,
                'code' => 'BOM19040005',
                'description' => '',
                'project_id' => 4,
                'wbs_id' => 49,
                'branch_id' => 1,
                'user_id' => 2,
                'status' => 0,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:20',
            ),
        ));
    }
}