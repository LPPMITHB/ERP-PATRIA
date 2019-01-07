<?php

use Illuminate\Database\Seeder;
use App\Models\Material; 

class StorageLocationDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelMaterials = Material::all();
        foreach($modelMaterials as $material){
            $quantity = rand(1,1000);
            DB::table('mst_storage_location_detail')->insert([
                'material_id' => $material->id,
                'quantity' => $quantity,
                'storage_location_id' => rand(1,3),
            ]);

            $quantity = rand(1,1000);
            DB::table('mst_storage_location_detail')->insert([
                'material_id' => $material->id,
                'quantity' => $quantity,
                'storage_location_id' => rand(4,7),
            ]);

        }
    }
}
