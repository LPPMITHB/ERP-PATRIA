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
            'code' => 'BOM0100001',
            'description' => 'BOM pertama',
            'project_id' => 1,
            'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100002',
            'description' => 'BOM kedua',
            'project_id' => 1,
            'wbs_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100003',
            'description' => 'BOM ketiga',
            'project_id' => 1,
            'wbs_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100004',
            'description' => 'BOM keempat',
            'project_id' => 1,
            'wbs_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100005',
            'description' => 'BOM kelima',
            'project_id' => 1,
            'wbs_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100006',
            'description' => 'BOM keenam',
            'project_id' => 1,
            'wbs_id' => 6,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100007',
            'description' => 'BOM ketujuh',
            'project_id' => 1,
            'wbs_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100008',
            'description' => 'BOM kedelapan',
            'project_id' => 1,
            'wbs_id' => 8,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100009',
            'description' => 'BOM kesembilan',
            'project_id' => 1,
            'wbs_id' => 9,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100010',
            'description' => 'BOM kesepuluh',
            'project_id' => 1,
            'wbs_id' => 10,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100011',
            'description' => 'BOM kesebelas',
            'project_id' => 1,
            'wbs_id' => 11,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100012',
            'description' => 'BOM keduabelas',
            'project_id' => 1,
            'wbs_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100013',
            'description' => 'BOM ketigabelas',
            'project_id' => 1,
            'wbs_id' => 13,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100014',
            'description' => 'BOM keempatbelas',
            'project_id' => 1,
            'wbs_id' => 14,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100015',
            'description' => 'BOM kelimabelas',
            'project_id' => 1,
            'wbs_id' => 15,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100016',
            'description' => 'BOM keenambelas',
            'project_id' => 1,
            'wbs_id' => 16,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100017',
            'description' => 'BOM ketujuhbelas',
            'project_id' => 1,
            'wbs_id' => 17,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100018',
            'description' => 'BOM kedelapanbelas',
            'project_id' => 1,
            'wbs_id' => 18,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100019',
            'description' => 'BOM kesembilanbelas',
            'project_id' => 1,
            'wbs_id' => 19,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0100020',
            'description' => 'BOM keduapuluh',
            'project_id' => 1,
            'wbs_id' => 20,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
    }
}
