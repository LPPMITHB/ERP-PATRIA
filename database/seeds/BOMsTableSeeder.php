<?php

use Illuminate\Database\Seeder;

class BOMsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mst_bom')->insert([
            'code' => 'BOM180001',
            'description' => 'BOM pertama',
            'project_id' => 1,
            'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180002',
            'description' => 'BOM kedua',
            'project_id' => 1,
            'work_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180003',
            'description' => 'BOM ketiga',
            'project_id' => 1,
            'wbs_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180004',
            'description' => 'BOM keempat',
            'project_id' => 1,
            'work_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180005',
            'description' => 'BOM kelima',
            'project_id' => 1,
            'work_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180006',
            'description' => 'BOM keenam',
            'project_id' => 1,
            'work_id' => 6,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180007',
            'description' => 'BOM ketujuh',
            'project_id' => 1,
            'work_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180008',
            'description' => 'BOM kedelapan',
            'project_id' => 1,
            'work_id' => 8,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180009',
            'description' => 'BOM kesembilan',
            'project_id' => 1,
            'work_id' => 9,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
    }
}
