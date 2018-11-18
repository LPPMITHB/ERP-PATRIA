<?php

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('mst_stock')->insert([
            'material_id' => 14,
            'quantity' => 20,
            'reserved' => 1,
            'branch_id' => 1, 
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 15,
            'quantity' => 20,
            'reserved' => 2,
            'branch_id' => 1,  
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 16,
            'quantity' => 20,
            'reserved' => 2,
            'branch_id' => 1,  
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 17,
            'quantity' => 20,
            'reserved' => 3,
            'branch_id' => 1,           
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 20,
            'quantity' => 20,
            'reserved' => 4,
            'branch_id' => 1,            
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 22,
            'quantity' => 20,
            'reserved' => 4,
            'branch_id' => 1,          
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 25,
            'quantity' => 20,
            'reserved' => 2,
            'branch_id' => 1,      
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 28,
            'quantity' => 20,
            'reserved' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 37,
            'quantity' => 20,
            'reserved' => 1,
            'branch_id' => 1, 
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 34,
            'quantity' => 20,
            'reserved' => 2,
            'branch_id' => 1, 
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 44,
            'quantity' => 20,
            'reserved' => 3,
            'branch_id' => 1, 
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 40,
            'quantity' => 20,
            'reserved' => 6,
            'branch_id' => 1,  
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 39,
            'quantity' => 20,
            'reserved' => 1,
            'branch_id' => 1, 
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 11,
            'quantity' => 20,
            'reserved' => 2,
            'branch_id' => 1, 
        ]);

        DB::table('mst_stock')->insert([
            'material_id' => 10,
            'quantity' => 20,
            'reserved' => 5,
            'branch_id' => 1,  
        ]);
    }
}
