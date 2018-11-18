<?php

use Illuminate\Database\Seeder;

class RABDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('ref_rab_detail')->insert([
            'rab_id' => 1,
            'bom_id' => 1,
            'material_id' => 1,
            'quantity' => 6,
            'price' => 840000,
        ]);
        
        DB::table('ref_rab_detail')->insert([
            'rab_id' => 1,
            'bom_id' => 1,
            'material_id' => 3,
            'quantity' => 9,
            'price' => 2700000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 1,
            'bom_id' => 1,
            'material_id' => 4,
            'quantity' => 12,
            'price' => 768000000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 1,
            'bom_id' => 1,
            'material_id' => 8,
            'quantity' => 20,
            'price' => 2000000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 1,
            'bom_id' => 1,
            'material_id' => 18,
            'quantity' => 8,
            'price' => 68000000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 1,
            'bom_id' => 1,
            'material_id' => 30,
            'quantity' => 3,
            'price' => 660000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 2,
            'bom_id' => 5,
            'material_id' => 2,
            'quantity' => 10,
            'price' => 25000000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 2,
            'bom_id' => 5,
            'material_id' => 7,
            'quantity' => 5,
            'price' => 250000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 2,
            'bom_id' => 5,
            'material_id' => 10,
            'quantity' => 8,
            'price' => 44000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 2,
            'bom_id' => 5,
            'material_id' => 8,
            'quantity' => 18,
            'price' => 1800000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 2,
            'bom_id' => 5,
            'material_id' => 33,
            'quantity' => 6,
            'price' => 228000000,
        ]);

        DB::table('ref_rab_detail')->insert([
            'rab_id' => 3,
            'bom_id' => 11,
            'material_id' => 11,
            'quantity' => 5,
            'price' => 20000000,
        ]);
    }
}
