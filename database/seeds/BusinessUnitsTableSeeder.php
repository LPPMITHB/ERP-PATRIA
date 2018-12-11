<?php

use Illuminate\Database\Seeder;

class BusinessUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_business_unit')->insert([
            'name' => 'Building',
            'description' => 'Pembuatan Kapal Laut',
        ]);

        DB::table('mst_business_unit')->insert([
            'name' => 'Repair',
            'description' => 'Perbaikan Kapal Laut',
        ]);

        DB::table('mst_business_unit')->insert([
            'name' => 'Trading',
            'description' => 'Penjualan Spare Part Kapal Laut',
        ]);

    }
}
