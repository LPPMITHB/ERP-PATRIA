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
            'name' => 'Meter',
            'unit' => 'Mtr',
            'is_decimal' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0002',
            'name' => 'Kilogram',
            'unit' => 'Kg',
            'is_decimal' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0003',
            'name' => 'Pieces',
            'unit' => 'Pcs',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0004',
            'name' => 'Feet',
            'unit' => 'FT',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0005',
            'name' => 'Inch',
            'unit' => 'Inch',
            'is_decimal' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0006',
            'name' => 'Length',
            'unit' => 'Lgh',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0007',
            'name' => 'Liter',
            'unit' => 'Liter',
            'is_decimal' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0008',
            'name' => 'Can',
            'unit' => 'Can',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0009',
            'name' => 'Box',
            'unit' => 'Box',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0010',
            'name' => 'Set',
            'unit' => 'Set',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0011',
            'name' => 'Milimeter',
            'unit' => 'MM',
            'is_decimal' => 1,
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0012',
            'name' => 'Lot',
            'unit' => 'Lot',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('mst_uom')->insert([
            'code' => 'UOM0013',
            'name' => 'Hours',
            'unit' => 'Hours',
            'status' => 1,
            'branch_id' => 1,
            'user_id' => 1,
        ]);
    }
}
