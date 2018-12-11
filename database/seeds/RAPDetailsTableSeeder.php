<?php

use Illuminate\Database\Seeder;
use App\Models\BomDetail; 
use App\Models\Rap; 


class RAPDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelBD = BomDetail::all();
        foreach($modelBD as $bd){
            DB::table('trx_rap_detail')->insert([
                'rap_id' => $bd->bom_id,
                'material_id' => $bd->material_id,
                'quantity' => $bd->quantity,
                'price' => $bd->material->cost_standard_price * $bd->quantity
            ]);
        }

        $modelRap = Rap::all();
        foreach($modelRap as $rap){
            $total_price = 0;
            foreach($rap->rapDetails as $rd){
                $total_price += $rd->price;
            }
            $rap->total_price = $total_price;
            $rap->update();
        }
    }
}
