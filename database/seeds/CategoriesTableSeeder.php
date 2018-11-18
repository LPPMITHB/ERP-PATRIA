<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_category')->insert([
            'code' => 'CT0001',
            'name' => 'CRANE',
            'description' => 'Tipe dari crane',
            'used_for' => 'RESOURCE',
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_category')->insert([
            'code' => 'CT0002',
            'name' => 'FORKLIFT',
            'description' => 'Tipe dari forklift',
            'used_for' => 'RESOURCE',
            'branch_id' => 1,
            'user_id' => 1,
        ]);
    }
}

