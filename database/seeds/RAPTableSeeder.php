<?php

use Illuminate\Database\Seeder;
use App\Models\Bom; 

class RAPTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelBoms = Bom::all();
        $number = 1800001;
        foreach($modelBoms as $bom){
            DB::table('trx_rap')->insert([
                'number' => 'RAP-'.$number,
                'project_id' => $bom->project_id,
                'bom_id'=> $bom->id,
                'total_price' => 0,
                'user_id' => $bom->user_id,
                'branch_id' => $bom->branch_id,
            ]);
            $number++;
        }
    }
}
