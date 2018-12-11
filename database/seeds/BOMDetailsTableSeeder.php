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
        ]);
        
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 1,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 2,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 3,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 4,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 5,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]); 

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 6,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]); 

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 6,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 7,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);
        
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 7,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 8,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 9,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 10,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 11,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);
        
        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 12,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 13,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 14,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 15,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 16,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 17,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 18,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 19,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 20,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 20,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 19,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 18,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);  

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 17,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

        $quantity = rand(1,1000);
        $material = Material::findOrFail($index++);
        DB::table('mst_bom_detail')->insert([
            'bom_id' => 16,
            'material_id' => $material->id,
            'quantity' => $quantity,
        ]);

    }
}
