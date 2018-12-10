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
            'work_id' => 1,
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
            'work_id' => 3,
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

        DB::table('mst_bom')->insert([
            'code' => 'BOM180010',
            'description' => 'BOM kesepuluh',
            'project_id' => 2,
            'work_id' => 10,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180011',
            'description' => 'BOM kesebelas',
            'project_id' => 2,
            'work_id' => 11,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180012',
            'description' => 'BOM keduabelas',
            'project_id' => 2,
            'work_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180013',
            'description' => 'BOM ketigabelas',
            'project_id' => 2,
            'work_id' => 13,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180014',
            'description' => 'BOM keempatbelas',
            'project_id' => 2,
            'work_id' => 14,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180015',
            'description' => 'BOM kelimabelas',
            'project_id' => 2,
            'work_id' => 15,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180016',
            'description' => 'BOM keenambelas',
            'project_id' => 2,
            'work_id' => 16,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180017',
            'description' => 'BOM ketujuhbelas',
            'project_id' => 3,
            'work_id' => 17,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180018',
            'description' => 'BOM kedelapanbelas',
            'project_id' => 3,
            'work_id' => 18,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180019',
            'description' => 'BOM kesembilanbelas',
            'project_id' => 4,
            'work_id' => 19,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM180020',
            'description' => 'BOM keduapuluh',
            'project_id' => 4,
            'work_id' => 20,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
    }
}
