<?php

use Illuminate\Database\Seeder;
use App\Models\Material; 
use App\Models\StorageLocationDetail;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sloc_details = StorageLocationDetail::all()->groupBy('material_id');
        foreach($sloc_details as $material_id =>$sloc_detail){
            $quantity = $sloc_detail->sum('quantity');
            $reserved = rand(1,$quantity);
            DB::table('mst_stock')->insert([
                'material_id' => $material_id,
                'quantity' => $quantity,
                'reserved' => $reserved,
                'branch_id' => 1, 
            ]);
        }
    }
}
