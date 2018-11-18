<?php

use Illuminate\Database\Seeder;

class StorageLocationDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 14,
            'quantity' => 10,
            'reserved' => 1,
            'storage_location_id' => 1,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 14,
            'quantity' => 10,
            'reserved' => 5,
            'storage_location_id' => 2,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 15,
            'quantity' => 5,
            'reserved' => 2,  
            'storage_location_id' => 3,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 15,
            'quantity' => 15,
            'reserved' => 2,  
            'storage_location_id' => 4,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 16,
            'quantity' => 5,
            // 'reserved' => 2,  
            'storage_location_id' => 5,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 16,
            'quantity' => 5,
            // 'reserved' => 2,  
            'storage_location_id' => 6,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 16,
            'quantity' => 5,
            // 'reserved' => 2,  
            'storage_location_id' => 7,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 16,
            'quantity' => 5,
            // 'reserved' => 2,  
            'storage_location_id' => 1,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 17,
            'quantity' => 3,
            'reserved' => 3,    
            'storage_location_id' => 2,       
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 17,
            'quantity' => 17,
            'reserved' => 3,    
            'storage_location_id' => 1,       
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 20,
            'quantity' => 4,
            'reserved' => 4,    
            'storage_location_id' => 1,        
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 20,
            'quantity' => 4,
            // 'reserved' => 4,    
            'storage_location_id' => 2,        
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 20,
            'quantity' => 6,
            'reserved' => 4,    
            'storage_location_id' => 3,        
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 20,
            'quantity' => 6,
            'reserved' => 2,    
            'storage_location_id' => 4,        
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 22,
            'quantity' => 13,
            // 'reserved' => 4,       
            'storage_location_id' => 3,   
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 22,
            'quantity' => 7,
            'reserved' => 4,       
            'storage_location_id' => 3,   
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 25,
            'quantity' => 20,
            'reserved' => 2,     
            'storage_location_id' => 4, 
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 28,
            'quantity' => 20,
            'reserved' => 5,
            'storage_location_id' => 1,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 37,
            'quantity' => 20,
            'reserved' => 1, 
            'storage_location_id' => 3,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 34,
            'quantity' => 20,
            'reserved' => 2, 
            'storage_location_id' => 5,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 44,
            'quantity' => 20,
            'reserved' => 3, 
            'storage_location_id' => 4,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 40,
            'quantity' => 20,
            'reserved' => 6,  
            'storage_location_id' => 6,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 39,
            'quantity' => 20,
            'reserved' => 1, 
            'storage_location_id' => 7,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 11,
            'quantity' => 20,
            'reserved' => 2, 
            'storage_location_id' => 1,
        ]);

        DB::table('mst_storage_location_detail')->insert([
            'material_id' => 10,
            'quantity' => 20,
            'reserved' => 5,  
            'storage_location_id' => 2,
        ]);
    }
}
