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
                'material_id' => 1780,
                'quantity' => 30.5,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            1 => 
            array (
                'id' => 2,
                'bom_id' => 1,
                'material_id' => 837,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            2 => 
            array (
                'id' => 3,
                'bom_id' => 1,
                'material_id' => 6,
                'quantity' => 50.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            3 => 
            array (
                'id' => 4,
                'bom_id' => 2,
                'material_id' => 1780,
                'quantity' => 30.5,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            4 => 
            array (
                'id' => 5,
                'bom_id' => 2,
                'material_id' => 837,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            5 => 
            array (
                'id' => 6,
                'bom_id' => 2,
                'material_id' => 6,
                'quantity' => 50.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            6 => 
            array (
                'id' => 7,
                'bom_id' => 3,
                'material_id' => 1781,
                'quantity' => 600.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            7 => 
            array (
                'id' => 8,
                'bom_id' => 3,
                'material_id' => 1784,
                'quantity' => 10.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            8 => 
            array (
                'id' => 9,
                'bom_id' => 3,
                'material_id' => 50,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            9 => 
            array (
                'id' => 10,
                'bom_id' => 4,
                'material_id' => 1781,
                'quantity' => 600.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            10 => 
            array (
                'id' => 11,
                'bom_id' => 4,
                'material_id' => 1784,
                'quantity' => 10.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            11 => 
            array (
                'id' => 12,
                'bom_id' => 4,
                'material_id' => 50,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            12 => 
            array (
                'id' => 13,
                'bom_id' => 5,
                'material_id' => 1050,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            13 => 
            array (
                'id' => 14,
                'bom_id' => 5,
                'material_id' => 3113,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            14 => 
            array (
                'id' => 15,
                'bom_id' => 5,
                'material_id' => 1709,
                'quantity' => 3.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            15 => 
            array (
                'id' => 16,
                'bom_id' => 5,
                'material_id' => 332,
                'quantity' => 100.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
        ));
        
        // project 5
        \DB::table('mst_bom_detail')->insert(array (
            0 => 
            array (
                'id' => 17,
                'bom_id' => 6,
                'material_id' => 1780,
                'quantity' => 30.5,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            1 => 
            array (
                'id' => 18,
                'bom_id' => 6,
                'material_id' => 837,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            2 => 
            array (
                'id' => 19,
                'bom_id' => 6,
                'material_id' => 6,
                'quantity' => 50.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            3 => 
            array (
                'id' => 20,
                'bom_id' => 7,
                'material_id' => 1780,
                'quantity' => 30.5,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            4 => 
            array (
                'id' => 21,
                'bom_id' => 7,
                'material_id' => 837,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            5 => 
            array (
                'id' => 22,
                'bom_id' => 7,
                'material_id' => 6,
                'quantity' => 50.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            6 => 
            array (
                'id' => 23,
                'bom_id' => 8,
                'material_id' => 1781,
                'quantity' => 600.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            7 => 
            array (
                'id' => 24,
                'bom_id' => 8,
                'material_id' => 1784,
                'quantity' => 10.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            8 => 
            array (
                'id' => 25,
                'bom_id' => 8,
                'material_id' => 50,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            9 => 
            array (
                'id' => 26,
                'bom_id' => 9,
                'material_id' => 1781,
                'quantity' => 600.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            10 => 
            array (
                'id' => 27,
                'bom_id' => 9,
                'material_id' => 1784,
                'quantity' => 10.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            11 => 
            array (
                'id' => 28,
                'bom_id' => 9,
                'material_id' => 50,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            12 => 
            array (
                'id' => 29,
                'bom_id' => 10,
                'material_id' => 1050,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            13 => 
            array (
                'id' => 30,
                'bom_id' => 10,
                'material_id' => 3113,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            14 => 
            array (
                'id' => 31,
                'bom_id' => 10,
                'material_id' => 1709,
                'quantity' => 3.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            15 => 
            array (
                'id' => 32,
                'bom_id' => 10,
                'material_id' => 332,
                'quantity' => 100.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
        ));
        
        // project 4
        \DB::table('mst_bom_detail')->insert(array (
            0 => 
            array (
                'id' => 33,
                'bom_id' => 11,
                'material_id' => 1780,
                'quantity' => 30.5,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            1 => 
            array (
                'id' => 34,
                'bom_id' => 11,
                'material_id' => 837,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            2 => 
            array (
                'id' => 35,
                'bom_id' => 11,
                'material_id' => 6,
                'quantity' => 50.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:49:06',
                'updated_at' => '2019-04-03 11:49:06',
            ),
            3 => 
            array (
                'id' => 36,
                'bom_id' => 12,
                'material_id' => 1780,
                'quantity' => 30.5,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            4 => 
            array (
                'id' => 37,
                'bom_id' => 12,
                'material_id' => 837,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            5 => 
            array (
                'id' => 38,
                'bom_id' => 12,
                'material_id' => 6,
                'quantity' => 50.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 11:52:27',
                'updated_at' => '2019-04-03 11:52:27',
            ),
            6 => 
            array (
                'id' => 39,
                'bom_id' => 13,
                'material_id' => 1781,
                'quantity' => 600.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            7 => 
            array (
                'id' => 40,
                'bom_id' => 13,
                'material_id' => 1784,
                'quantity' => 10.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            8 => 
            array (
                'id' => 41,
                'bom_id' => 13,
                'material_id' => 50,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:02',
                'updated_at' => '2019-04-03 12:12:02',
            ),
            9 => 
            array (
                'id' => 42,
                'bom_id' => 14,
                'material_id' => 1781,
                'quantity' => 600.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            10 => 
            array (
                'id' => 43,
                'bom_id' => 14,
                'material_id' => 1784,
                'quantity' => 10.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            11 => 
            array (
                'id' => 44,
                'bom_id' => 14,
                'material_id' => 50,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:12:45',
                'updated_at' => '2019-04-03 12:12:45',
            ),
            12 => 
            array (
                'id' => 45,
                'bom_id' => 15,
                'material_id' => 1050,
                'quantity' => 5.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            13 => 
            array (
                'id' => 46,
                'bom_id' => 15,
                'material_id' => 3113,
                'quantity' => 20.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            14 => 
            array (
                'id' => 47,
                'bom_id' => 15,
                'material_id' => 1709,
                'quantity' => 3.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
            15 => 
            array (
                'id' => 48,
                'bom_id' => 15,
                'material_id' => 332,
                'quantity' => 100.0,
                'source' => 'Stock',
                'pr_quantity' => NULL,
                'created_at' => '2019-04-03 12:14:16',
                'updated_at' => '2019-04-03 12:14:16',
            ),
        ));
    }
}