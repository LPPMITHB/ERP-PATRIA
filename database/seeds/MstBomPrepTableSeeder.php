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
                'project_id' => 3,
                'activity_id' => 45,
                'quantity' => 200.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-03-18 10:35:00',
                'updated_at' => '2019-03-18 10:35:00',
            ),
            1 => 
            array (
                'id' => 2,
                'material_id' => 2,
                'project_id' => 3,
                'activity_id' => 45,
                'quantity' => 30.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-03-18 10:35:00',
                'updated_at' => '2019-03-18 10:35:00',
            ),
            2 => 
            array (
                'id' => 3,
                'material_id' => 3030,
                'project_id' => 3,
                'activity_id' => 45,
                'quantity' => 1.0,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-03-18 10:56:00',
                'updated_at' => '2019-03-18 10:56:00',
            ),
        ));
        
        
    }
}