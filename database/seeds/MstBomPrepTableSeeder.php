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
                'weight' => 2196.55,
                'quantity' => NULL,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:35:34',
                'updated_at' => '2019-04-11 23:53:31',
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
            3 => 
            array (
                'id' => 4,
                'material_id' => 53,
                'project_id' => 5,
                'weight' => NULL,
                'quantity' => 3.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:50:55',
                'updated_at' => '2019-04-11 23:54:53',
            ),
            4 => 
            array (
                'id' => 6,
                'material_id' => 2369,
                'project_id' => 5,
                'weight' => NULL,
                'quantity' => 1.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:55:33',
                'updated_at' => '2019-04-11 23:55:33',
            ),
        ));
        
        
    }
}