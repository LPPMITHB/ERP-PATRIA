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
                'weight' => 3034.14,
                'status' => 1,
                'source' => 'Stock',
                'created_at' => '2019-03-22 14:48:29',
                'updated_at' => '2019-03-22 14:49:00',
            ),
        ));
        
        
    }
}