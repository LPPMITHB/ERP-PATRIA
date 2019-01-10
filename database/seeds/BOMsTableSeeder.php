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
            'code' => 'BOM18010001',
            'description' => 'BOM pertama',
            'project_id' => 1,
            'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010002',
            'description' => 'BOM kedua',
            'project_id' => 1,
            'wbs_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010003',
            'description' => 'BOM ketiga',
            'project_id' => 1,
            'wbs_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010004',
            'description' => 'BOM keempat',
            'project_id' => 1,
            'wbs_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010005',
            'description' => 'BOM kelima',
            'project_id' => 1,
            'wbs_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010006',
            'description' => 'BOM keenam',
            'project_id' => 1,
            'wbs_id' => 6,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010007',
            'description' => 'BOM ketujuh',
            'project_id' => 1,
            'wbs_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010008',
            'description' => 'BOM kedelapan',
            'project_id' => 1,
            'wbs_id' => 8,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010009',
            'description' => 'BOM kesembilan',
            'project_id' => 1,
            'wbs_id' => 9,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010010',
            'description' => 'BOM kesepuluh',
            'project_id' => 1,
            'wbs_id' => 10,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010011',
            'description' => 'BOM kesebelas',
            'project_id' => 1,
            'wbs_id' => 11,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010012',
            'description' => 'BOM keduabelas',
            'project_id' => 1,
            'wbs_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010013',
            'description' => 'BOM ketigabelas',
            'project_id' => 1,
            'wbs_id' => 13,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010014',
            'description' => 'BOM keempatbelas',
            'project_id' => 1,
            'wbs_id' => 14,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010015',
            'description' => 'BOM kelimabelas',
            'project_id' => 1,
            'wbs_id' => 15,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010016',
            'description' => 'BOM keenambelas',
            'project_id' => 1,
            'wbs_id' => 16,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010017',
            'description' => 'BOM ketujuhbelas',
            'project_id' => 1,
            'wbs_id' => 17,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010018',
            'description' => 'BOM kedelapanbelas',
            'project_id' => 1,
            'wbs_id' => 18,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010019',
            'description' => 'BOM kesembilanbelas',
            'project_id' => 1,
            'wbs_id' => 19,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18010020',
            'description' => 'BOM keduapuluh',
            'project_id' => 1,
            'wbs_id' => 20,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //21
        DB::table('mst_bom')->insert([
            'code' => 'BOM18020022',
            'description' => 'test',
            'project_id' => 2,
            'wbs_id' => 95,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18020025',
            'description' => 'test',
            'project_id' => 2,
            'wbs_id' => 96,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18020028',
            'description' => 'test',
            'project_id' => 2,
            'wbs_id' => 97,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18020031',
            'description' => 'test',
            'project_id' => 2,
            'wbs_id' => 98,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM18020034',
            'description' => 'test',
            'project_id' => 2,
            'wbs_id' => 99,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
    }
}
