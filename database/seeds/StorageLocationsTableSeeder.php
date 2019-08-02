<?php

use Illuminate\Database\Seeder;

class StorageLocationsTableSeeder extends Seeder
{
    /**
 * Run the database seeds.
 *
 * @return void
 */
    public function run()
{
        DB::table('mst_storage_location')->insert([
            'code' => 'SL0001',
            'name' => 'SLoc A',
            'area' => '400',
            'description' => 'StorLoc 1',
            'status' => 1,
            'warehouse_id' => 1,
            'branch_id' => 1,
            'user_id' => 5,
            ]);
            
        DB::table('mst_storage_location')->insert([
            'code' => 'SL0002',
            'name' => 'SLoc B',
            'area' => '440',
            'description' => 'StorLoc 2',
            'status' => 1,
            'warehouse_id' => 1,
            'branch_id' => 1,
            'user_id' => 5,
            ]);

        DB::table('mst_storage_location')->insert([
            'code' => 'SL0003',
            'name' => 'SLoc C',
            'area' => '250',
            'description' => 'StorLoc 3',
            'status' => 1,
            'warehouse_id' => 1,
            'branch_id' => 1,
            'user_id' => 5,
            ]);

        DB::table('mst_storage_location')->insert([
            'code' => 'SL0004',
            'name' => 'SLoc D',
            'area' => '100',
            'description' => 'StorLoc 4',
            'status' => 1,
            'warehouse_id' => 2,
            'branch_id' => 1,
            'user_id' => 5,
            ]);

        DB::table('mst_storage_location')->insert([
            'code' => 'SL0005',
            'name' => 'SLoc E',
            'area' => '725',
            'description' => 'StorLoc 5',
            'status' => 1,
            'warehouse_id' => 2,
            'branch_id' => 1,
            'user_id' => 5,
            ]);

        DB::table('mst_storage_location')->insert([
            'code' => 'SL0006',
            'name' => 'SLoc F',
            'area' => '320',
            'description' => 'StorLoc 6',
            'status' => 1,
            'warehouse_id' => 3,
            'branch_id' => 1,
            'user_id' => 5,
            ]);

        DB::table('mst_storage_location')->insert([
            'code' => 'SL0007',
            'name' => 'SLoc G',
            'area' => '250',
            'description' => 'StorLoc 7',
            'status' => 1,
            'warehouse_id' => 4,
            'branch_id' => 1,
            'user_id' => 5,
            ]);
    }
}