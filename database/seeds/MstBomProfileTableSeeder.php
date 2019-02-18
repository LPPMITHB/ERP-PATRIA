<?php

use Illuminate\Database\Seeder;

class MstBomProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_bom_profile')->delete();
        
        \DB::table('mst_bom_profile')->insert(array (
            0 => 
            array (
                'id' => 1,
                'wbs_id' => 2,
                'material_id' => 1780,
                'service_id' => NULL,
                'quantity' => 1,
                'source' => 'Stock',
                'created_at' => '2019-02-14 15:03:50',
                'updated_at' => '2019-02-14 15:03:50',
            ),
            1 => 
            array (
                'id' => 2,
                'wbs_id' => 2,
                'material_id' => 1781,
                'service_id' => NULL,
                'quantity' => 2,
                'source' => 'Stock',
                'created_at' => '2019-02-14 15:03:54',
                'updated_at' => '2019-02-14 15:03:54',
            ),
        ));
        
        
    }
}