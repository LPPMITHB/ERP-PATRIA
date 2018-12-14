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
            'description' => 'Ship Building',
        ]);

        DB::table('mst_business_unit')->insert([
            'name' => 'Repair',
            'description' => 'Ship Repair',
        ]);

        DB::table('mst_business_unit')->insert([
            'name' => 'Trading',
            'description' => 'Ship Spare Parts Trading',
        ]);

    }
}
