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
                'status' => 0,
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
                'code' => 'BOM19010001',
                'description' => 'BOM DUMMY - PAMI 1',
                'project_id' => 2,
                'wbs_id' => 18,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 0,
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-27 14:53:58',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'BOM19010002',
                'description' => 'BOM DUMMY - PAMI 2',
                'project_id' => 2,
                'wbs_id' => 19,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'BOM19010003',
                'description' => 'BOM DUMMY - PAMI 3',
                'project_id' => 2,
                'wbs_id' => 20,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'BOM19010004',
                'description' => 'BOM DUMMY - PAMI 4',
                'project_id' => 2,
                'wbs_id' => 21,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'BOM19010005',
                'description' => 'BOM DUMMY - PAMI 5',
                'project_id' => 2,
                'wbs_id' => 22,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'BOM19010006',
                'description' => 'BOM DUMMY - PAMI 6',
                'project_id' => 2,
                'wbs_id' => 23,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'BOM19010007',
                'description' => 'BOM DUMMY - PAMI 7',
                'project_id' => 2,
                'wbs_id' => 24,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'BOM19010008',
                'description' => 'BOM DUMMY - PAMI 8',
                'project_id' => 2,
                'wbs_id' => 25,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'BOM19020001',
                'description' => 'Test',
                'project_id' => 3,
                'wbs_id' => NULL,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-03-25 21:21:27',
                'updated_at' => '2019-03-25 21:21:27',
            ),
        ));
        
        
    }
}