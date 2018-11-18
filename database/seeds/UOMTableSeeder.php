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
            'name' => 'panjang',
            'unit' => 'meter',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0002',
            'name' => 'berat',
            'unit' => 'kilogram',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0003',
            'name' => 'kecepatan',
            'unit' => 'mile per hour',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0004',
            'name' => 'Man Hours',
            'unit' => 'hour',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0005',
            'name' => 'usage time',
            'unit' => 'hour',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 4,
        ]);
    }
}
