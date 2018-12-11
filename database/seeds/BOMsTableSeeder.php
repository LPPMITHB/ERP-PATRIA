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
            'code' => 'BOM0001',
            'description' => 'BOM pertama',
            'project_id' => 1,
            'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
        DB::table('mst_bom')->insert([
            'code' => 'BOM0002',
            'description' => 'BOM kedua',
            'project_id' => 1,
            'wbs_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0003',
            'description' => 'BOM ketiga',
            'project_id' => 1,
            'wbs_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0004',
            'description' => 'BOM keempat',
            'project_id' => 1,
            'wbs_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0005',
            'description' => 'BOM kelima',
            'project_id' => 2,
            'wbs_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0006',
            'description' => 'BOM keenam',
            'project_id' => 2,
            'wbs_id' => 6,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0007',
            'description' => 'BOM ketujuh',
            'project_id' => 2,
            'wbs_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0008',
            'description' => 'BOM kedelapan',
            'project_id' => 2,
            'wbs_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0009',
            'description' => 'BOM kesembilan',
            'project_id' => 3,
            'wbs_id' => 10,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0010',
            'description' => 'BOM kesepuluh',
            'project_id' => 3,
            'wbs_id' => 11,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
        DB::table('mst_bom')->insert([
            'code' => 'BOM0011',
            'description' => 'BOM kesebelas',
            'project_id' => 3,
            'wbs_id' => 8,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0012',
            'description' => 'BOM keduabelas',
            'project_id' => 3,
            'wbs_id' => 9,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        /*
        DB::table('mst_bom')->insert([
            'code' => 'BOM0013',
            'description' => 'BOM ketigabelas',
            'project_id' => 4,
            // 'wbs_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0014',
            'description' => 'BOM keempatbelas',
            'project_id' => 4,
            // 'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0015',
            'description' => 'BOM kelimabelas',
            'project_id' => 4,
            // 'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0016',
            'description' => 'BOM keenambelas',
            'project_id' => 4,
            // 'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        */
    }
}
