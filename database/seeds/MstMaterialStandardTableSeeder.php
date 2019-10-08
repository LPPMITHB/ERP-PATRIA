<?php

use Illuminate\Database\Seeder;

class MstMaterialStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_material_standard')->delete();
        
        \DB::table('mst_material_standard')->insert(array (
            0 => 
            array (
                'id' => 1,
                'project_standard_id' => 1,
                'wbs_standard_id' => 5,
                'material_id' => 1780,
                'quantity' => 11.0,
                'created_at' => '2019-09-19 14:28:51',
                'updated_at' => '2019-10-09 01:33:31',
            ),
            1 => 
            array (
                'id' => 2,
                'project_standard_id' => 1,
                'wbs_standard_id' => 8,
                'material_id' => 1781,
                'quantity' => 2.0,
                'created_at' => '2019-09-19 14:44:33',
                'updated_at' => '2019-09-19 14:44:33',
            ),
            2 => 
            array (
                'id' => 3,
                'project_standard_id' => 1,
                'wbs_standard_id' => 8,
                'material_id' => 1782,
                'quantity' => 2.0,
                'created_at' => '2019-09-19 14:44:33',
                'updated_at' => '2019-09-19 14:44:33',
            ),
            3 => 
            array (
                'id' => 4,
                'project_standard_id' => 1,
                'wbs_standard_id' => 5,
                'material_id' => 1781,
                'quantity' => 10.0,
                'created_at' => '2019-10-09 01:33:31',
                'updated_at' => '2019-10-09 01:33:31',
            ),
        ));
        
        
    }
}