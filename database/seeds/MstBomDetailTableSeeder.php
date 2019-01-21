<?php

use Illuminate\Database\Seeder;

class MstBomDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_bom_detail')->delete();
        
        \DB::table('mst_bom_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bom_id' => 1,
                'material_id' => 18,
                'service_id' => NULL,
                'quantity' => 8,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:21',
            ),
            1 => 
            array (
                'id' => 2,
                'bom_id' => 1,
                'material_id' => 76,
                'service_id' => NULL,
                'quantity' => 124,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:21',
            ),
            2 => 
            array (
                'id' => 3,
                'bom_id' => 2,
                'material_id' => 30,
                'service_id' => NULL,
                'quantity' => 1351,
                'source' => 'WIP',
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            3 => 
            array (
                'id' => 4,
                'bom_id' => 2,
                'material_id' => 54,
                'service_id' => NULL,
                'quantity' => 5,
                'source' => 'WIP',
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            4 => 
            array (
                'id' => 5,
                'bom_id' => 3,
                'material_id' => 5,
                'service_id' => NULL,
                'quantity' => 1243,
                'source' => 'WIP',
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            5 => 
            array (
                'id' => 6,
                'bom_id' => 3,
                'material_id' => 6,
                'service_id' => NULL,
                'quantity' => 231,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            6 => 
            array (
                'id' => 7,
                'bom_id' => 4,
                'material_id' => 21,
                'service_id' => NULL,
                'quantity' => 6,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            7 => 
            array (
                'id' => 8,
                'bom_id' => 4,
                'material_id' => 5,
                'service_id' => NULL,
                'quantity' => 1351,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            8 => 
            array (
                'id' => 9,
                'bom_id' => 5,
                'material_id' => NULL,
                'service_id' => 2,
                'quantity' => 1,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:58:19',
                'updated_at' => '2019-01-15 09:58:19',
            ),
            9 => 
            array (
                'id' => 10,
                'bom_id' => 5,
                'material_id' => NULL,
                'service_id' => 9,
                'quantity' => 1,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:58:20',
                'updated_at' => '2019-01-15 09:58:20',
            ),
            10 => 
            array (
                'id' => 11,
                'bom_id' => 6,
                'material_id' => 63,
                'service_id' => NULL,
                'quantity' => 135,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:58:45',
                'updated_at' => '2019-01-15 09:58:45',
            ),
            11 => 
            array (
                'id' => 12,
                'bom_id' => 6,
                'material_id' => NULL,
                'service_id' => 7,
                'quantity' => 1,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:58:45',
                'updated_at' => '2019-01-15 09:58:45',
            ),
        ));
        
        
    }
}