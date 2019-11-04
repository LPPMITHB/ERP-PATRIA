<?php

use Illuminate\Database\Seeder;
use App\Models\Ship;

class MstQualityControlTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        for ($i = 0; $i <= 100; $i++) {
            $ship_id = rand(1, 19);
            $ship_name = Ship::where('id', $ship_id)->first()->type;
            DB::table('mst_quality_control_type')->insert([
                'ship_id' => $ship_id,
                'name' => 'Quality Controll Type ' . $i . ' for ' . $ship_name,
                'description' => 'This Quality Control Type Assign as Fakkers for Ship ' . $ship_name,
                'user_id' => 1,
                'branch_id' => 1
            ]);
        }
    }
}
