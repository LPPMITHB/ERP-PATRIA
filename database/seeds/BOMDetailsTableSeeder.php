<?php

use Illuminate\Database\Seeder;

class BOMDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => 1,
            'quantity' => 6,
        ]);
        
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => 3,
            'quantity' => 9,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => 4,
            'quantity' => 12,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => 8,
            'quantity' => 20,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => 18,
            'quantity' => 8,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => 30,
            'quantity' => 3,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => 2,
            'quantity' => 10,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => 7,
            'quantity' => 5,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => 10,
            'quantity' => 8,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => 8,
            'quantity' => 18,
        ]); 

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => 33,
            'quantity' => 6,
        ]); 

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => 11,
            'quantity' => 5,
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => 12,
            'quantity' => 3,
        ]);
        
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => 27,
            'quantity' => 16,
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => 30,
            'quantity' => 15,
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => 21,
            'quantity' => 3,
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => 23,
            'quantity' => 3,
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => 24,
            'quantity' => 1,
        ]);
        
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => 4,
            'quantity' => 13,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => 34,
            'quantity' => 8,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => 18,
            'quantity' => 18,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => 31,
            'quantity' => 5,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => 27,
            'quantity' => 15,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => 2,
            'quantity' => 2,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => 1,
            'quantity' => 12,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 6,
            'material_id' => 15,
            'quantity' => 5,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 7,
            'material_id' => 25,
            'quantity' => 15,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 8,
            'material_id' => 13,
            'quantity' => 3,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 9,
            'material_id' => 24,
            'quantity' => 18,
        ]);  

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 10,
            'material_id' => 37,
            'quantity' => 11,
        ]);  

    }
}
