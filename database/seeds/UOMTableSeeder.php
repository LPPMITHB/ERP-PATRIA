<?php

use Illuminate\Database\Seeder;

class UOMTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_uom')->insert([
            'code' => 'UOM0001',
            'name' => 'meter',
            'unit' => 'm',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0002',
            'name' => 'kilogram',
            'unit' => 'kg',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0003',
            'name' => 'mile per hour',
            'unit' => 'mph',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0004',
            'name' => 'hour',
            'unit' => 'hr',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0005',
            'name' => 'gram',
            'unit' => 'g',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);
    }
}
