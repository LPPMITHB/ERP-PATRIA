<?php

use Illuminate\Database\Seeder;
use App\Models\Material; 

class BOMDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 1;
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);
        
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]); 

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 6,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]); 

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 6,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 7,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);
        
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 7,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 8,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 9,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 10,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 11,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);
        
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 12,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 13,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 14,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 15,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 16,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 17,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 18,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 19,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 20,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 20,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 19,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 18,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 17,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 16,
            'material_id' => $material->id,
            'quantity' => $quantity,
            'source' => 'Stock'
        ]);

        //33
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 21,
            'material_id' => 2,
            'quantity' => 2,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 21,
            'material_id' => 3,
            'quantity' => 5,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 22,
            'material_id' => 5,
            'quantity' => 2,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 22,
            'material_id' => 3,
            'quantity' => 5,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 23,
            'material_id' => 4,
            'quantity' => 2,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 23,
            'material_id' => 1,
            'quantity' => 5,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 24,
            'material_id' => 5,
            'quantity' => 4,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 24,
            'material_id' => 3,
            'quantity' => 3,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 25,
            'material_id' => 4,
            'quantity' => 1,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 25,
            'material_id' => 2,
            'quantity' => 2,
            'source' => 'Stock'
        ]);

        DB::table('mst_bom_detail')->insert([
            'bom_id' => 21,
            'material_id' => 1,
            'quantity' => 5,
            'source' => 'Stock'
        ]);
    }
}
