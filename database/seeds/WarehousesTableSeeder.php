<?php

use Illuminate\Database\Seeder;

class WarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_warehouse')->insert([
            'code' => 'WRH0001',
            'name' => 'Warehouse 1',
            'description' => 'Gudang pertama',
            'status' => '1',
            'branch_id' => '1',
            'user_id' => 5,                    
            ]);

        DB::table('mst_warehouse')->insert([
            'code' => 'WRH0002',
            'name' => 'Warehouse 2',
            'description' => 'Gudang kedua',
            'status' => '1',
            'branch_id' => '1',
            'user_id' => 5,                    
            ]);

        DB::table('mst_warehouse')->insert([
            'code' => 'WRH0003',
            'name' => 'Warehouse 3',
            'description' => 'Gudang ketiga',
            'status' => '1',
            'branch_id' => '1',
            'user_id' => 5,                    
            ]);

        DB::table('mst_warehouse')->insert([
            'code' => 'WRH0004',
            'name' => 'Warehouse 4',
            'description' => 'Gudang keempat',
            'status' => '1',
            'branch_id' => '1',
            'user_id' => 5,                    
            ]);
            
        DB::table('mst_warehouse')->insert([
            'code' => 'WRH0005',
            'name' => 'Warehouse 5',
            'description' => 'Gudang kelima',
            'status' => '1',
            'branch_id' => '1',
            'user_id' => 5,                    
            ]);

        DB::table('mst_warehouse')->insert([
            'code' => 'WRH0006',
            'name' => 'Warehouse 6',
            'description' => 'Gudang keenam',
            'status' => '1',
            'branch_id' => '1',
            'user_id' => 5,                    
            ]);

    }
}
