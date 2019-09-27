<?php

use Illuminate\Database\Seeder;

class ProWbsMaterialTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pro_wbs_material')->delete();
        
        \DB::table('pro_wbs_material')->insert(array (
            0 => 
            array (
                'id' => 1,
                'wbs_id' => 53,
                'material_id' => 1780,
                'quantity' => 2,
                'dimensions_value' => NULL,
                'weight' => NULL,
                'bom_prep_id' => NULL,
                'source' => NULL,
                'created_at' => '2019-09-27 15:52:03',
                'updated_at' => '2019-09-27 15:52:03',
            ),
            1 => 
            array (
                'id' => 2,
                'wbs_id' => 55,
                'material_id' => 1781,
                'quantity' => 2,
                'dimensions_value' => NULL,
                'weight' => NULL,
                'bom_prep_id' => NULL,
                'source' => NULL,
                'created_at' => '2019-09-27 15:52:03',
                'updated_at' => '2019-09-27 15:52:03',
            ),
            2 => 
            array (
                'id' => 3,
                'wbs_id' => 55,
                'material_id' => 1782,
                'quantity' => 2,
                'dimensions_value' => NULL,
                'weight' => NULL,
                'bom_prep_id' => NULL,
                'source' => NULL,
                'created_at' => '2019-09-27 15:52:03',
                'updated_at' => '2019-09-27 15:52:03',
            ),
        ));
        
        
    }
}