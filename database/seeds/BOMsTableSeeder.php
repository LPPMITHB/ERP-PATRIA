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
            'work_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0002',
        //     'description' => 'BOM kedua',
        //     'project_id' => 1,
        //     'work_id' => 2,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0003',
        //     'description' => 'BOM ketiga',
        //     'project_id' => 1,
        //     'work_id' => 3,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0004',
        //     'description' => 'BOM keempat',
        //     'project_id' => 1,
        //     'work_id' => 4,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0005',
        //     'description' => 'BOM kelima',
        //     'project_id' => 1,
        //     'work_id' => 5,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0006',
        //     'description' => 'BOM keenam',
        //     'project_id' => 1,
        //     'work_id' => 6,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0007',
            'description' => 'BOM ketujuh',
            'project_id' => 1,
            'work_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0008',
            'description' => 'BOM kedelapan',
            'project_id' => 1,
            'work_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0009',
            'description' => 'BOM kesembilan',
            'project_id' => 2,
            'work_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0010',
            'description' => 'BOM kesepuluh',
            'project_id' => 2,
            'work_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
        
        DB::table('mst_bom')->insert([
            'code' => 'BOM0011',
            'description' => 'BOM kesebelas',
            'project_id' => 2,
            'work_id' => 6,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('mst_bom')->insert([
            'code' => 'BOM0012',
            'description' => 'BOM keduabelas',
            'project_id' => 3,
            'work_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);


        DB::table('mst_bom')->insert([
            'code' => 'BOM0013',
            'description' => 'BOM ketigabelas',
            'project_id' => 3,
            'work_id' => 8,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0014',
        //     'description' => 'BOM keempatbelas',
        //     'project_id' => 3,
        //     'work_id' => 14,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0015',
        //     'description' => 'BOM kelimabelas',
        //     'project_id' => 3,
        //     'work_id' => 15,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0016',
        //     'description' => 'BOM keenambelas',
        //     'project_id' => 3,
        //     'work_id' => 16,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0017',
        //     'description' => 'BOM 17',
        //     'project_id' => 3,
        //     'work_id' => 17,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0018',
        //     'description' => 'BOM 18',
        //     'project_id' => 3,
        //     'work_id' => 18,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0019',
        //     'description' => 'BOM 19',
        //     'project_id' => 3,
        //     'work_id' => 19,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0020',
        //     'description' => 'BOM 20',
        //     'project_id' => 3,
        //     'work_id' => 20,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0021',
        //     'description' => 'BOM 21',
        //     'project_id' => 3,
        //     'work_id' => 21,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0022',
        //     'description' => 'BOM 22',
        //     'project_id' => 3,
        //     'work_id' => 22,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0023',
        //     'description' => 'BOM 23',
        //     'project_id' => 3,
        //     'work_id' => 23,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0024',
        //     'description' => 'BOM 24',
        //     'project_id' => 3,
        //     'work_id' => 24,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0025',
        //     'description' => 'BOM 25',
        //     'project_id' => 3,
        //     'work_id' => 25,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

        // DB::table('mst_bom')->insert([
        //     'code' => 'BOM0026',
        //     'description' => 'BOM 26',
        //     'project_id' => 3,
        //     'work_id' => 26,
        //     'user_id' => 5,
        //     'branch_id' => 1,
        // ]);

    }
}
