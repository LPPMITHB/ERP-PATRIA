<?php

use Illuminate\Database\Seeder;
use App\Models\Material; 

class StocksTableSeeder extends Seeder
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
            $reserved = rand(1,$quantity);
            DB::table('mst_stock')->insert([
                'material_id' => $material->id,
                'quantity' => $quantity,
                'reserved' => $reserved,
                'branch_id' => 1, 
            ]);
        }
    }
}
