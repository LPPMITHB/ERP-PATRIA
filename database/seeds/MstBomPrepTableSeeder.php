<?php

use Illuminate\Database\Seeder;

class MstBomPrepTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_bom_prep')->delete();
        
        \DB::table('mst_bom_prep')->insert(array (
            0 => 
            array (
                'id' => 1,
                'material_id' => 1,
                'project_id' => 5,
                'weight' => 2037.19,
                'quantity' => NULL,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:35:34',
                'updated_at' => '2019-04-11 16:35:34',
            ),
            1 => 
            array (
                'id' => 2,
                'material_id' => 2,
                'project_id' => 5,
                'weight' => NULL,
                'quantity' => 5.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:55:17',
                'updated_at' => '2019-04-11 16:55:17',
            ),
            2 => 
            array (
                'id' => 3,
                'material_id' => 257,
                'project_id' => 5,
                'weight' => NULL,
                'quantity' => 1.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:56:22',
                'updated_at' => '2019-04-11 16:56:22',
            ),
        ));
        
        
    }
}