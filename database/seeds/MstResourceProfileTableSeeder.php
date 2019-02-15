<?php

use Illuminate\Database\Seeder;

class MstResourceProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_resource_profile')->delete();
        
        \DB::table('mst_resource_profile')->insert(array (
            0 => 
            array (
                'id' => 2,
                'wbs_id' => 2,
                'resource_id' => 1,
                'resource_detail_id' => NULL,
                'category_id' => 0,
                'quantity' => 1,
                'created_at' => '2019-02-14 15:04:34',
                'updated_at' => '2019-02-14 15:04:34',
            ),
            1 => 
            array (
                'id' => 3,
                'wbs_id' => 2,
                'resource_id' => 1,
                'resource_detail_id' => NULL,
                'category_id' => 1,
                'quantity' => 2,
                'created_at' => '2019-02-14 15:04:38',
                'updated_at' => '2019-02-14 15:04:38',
            ),
            2 => 
            array (
                'id' => 4,
                'wbs_id' => 2,
                'resource_id' => 1,
                'resource_detail_id' => NULL,
                'category_id' => 2,
                'quantity' => 3,
                'created_at' => '2019-02-14 15:04:42',
                'updated_at' => '2019-02-14 15:04:42',
            ),
            3 => 
            array (
                'id' => 5,
                'wbs_id' => 2,
                'resource_id' => 4,
                'resource_detail_id' => NULL,
                'category_id' => 3,
                'quantity' => 2,
                'created_at' => '2019-02-14 15:04:48',
                'updated_at' => '2019-02-14 15:04:48',
            ),
            4 => 
            array (
                'id' => 6,
                'wbs_id' => 2,
                'resource_id' => 1,
                'resource_detail_id' => NULL,
                'category_id' => 3,
                'quantity' => 1,
                'created_at' => '2019-02-14 15:04:59',
                'updated_at' => '2019-02-14 15:04:59',
            ),
            5 => 
            array (
                'id' => 7,
                'wbs_id' => 2,
                'resource_id' => 2,
                'resource_detail_id' => NULL,
                'category_id' => 0,
                'quantity' => 1,
                'created_at' => '2019-02-14 15:05:11',
                'updated_at' => '2019-02-14 15:05:11',
            ),
            6 => 
            array (
                'id' => 8,
                'wbs_id' => 2,
                'resource_id' => 3,
                'resource_detail_id' => NULL,
                'category_id' => 0,
                'quantity' => 2,
                'created_at' => '2019-02-14 15:05:14',
                'updated_at' => '2019-02-14 15:05:14',
            ),
            7 => 
            array (
                'id' => 9,
                'wbs_id' => 2,
                'resource_id' => 4,
                'resource_detail_id' => NULL,
                'category_id' => 0,
                'quantity' => 2,
                'created_at' => '2019-02-14 15:05:19',
                'updated_at' => '2019-02-14 15:05:19',
            ),
            8 => 
            array (
                'id' => 10,
                'wbs_id' => 2,
                'resource_id' => 2,
                'resource_detail_id' => NULL,
                'category_id' => 1,
                'quantity' => 2,
                'created_at' => '2019-02-14 15:05:30',
                'updated_at' => '2019-02-14 15:05:30',
            ),
        ));
        
        
    }
}