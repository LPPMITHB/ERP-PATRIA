<?php

use Illuminate\Database\Seeder;

class MstResourceStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_resource_standard')->delete();
        
        \DB::table('mst_resource_standard')->insert(array (
            0 => 
            array (
                'id' => 1,
                'project_standard_id' => 1,
                'wbs_standard_id' => 5,
                'resource_id' => 1,
                'quantity' => 5,
                'created_at' => '2019-09-19 14:54:21',
                'updated_at' => '2019-09-19 14:54:21',
            ),
            1 => 
            array (
                'id' => 2,
                'project_standard_id' => 1,
                'wbs_standard_id' => 8,
                'resource_id' => 1,
                'quantity' => 2,
                'created_at' => '2019-09-19 14:54:40',
                'updated_at' => '2019-09-19 14:54:40',
            ),
            2 => 
            array (
                'id' => 3,
                'project_standard_id' => 1,
                'wbs_standard_id' => 8,
                'resource_id' => 4,
                'quantity' => 2,
                'created_at' => '2019-09-19 14:54:40',
                'updated_at' => '2019-09-19 14:54:40',
            ),
        ));
        
        
    }
}