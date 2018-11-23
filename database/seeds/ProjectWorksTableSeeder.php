<?php

use Illuminate\Database\Seeder;

class ProjectWorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('pro_project_work')->insert([
            'code' => 'PRW0001',
            'name' => 'PRW 001 001',
            'description' => 'PRW 001 001',
            'deliverables' => 'Satu',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0016',
            'name' => 'PRW 001 006',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'work_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0017',
            'name' => 'PRW 001 007',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'work_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0018',
            'name' => 'PRW 001 008',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'work_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0019',
            'name' => 'PRW 001 009',
            'description' => '',
            'deliverables' => 'Level 5',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'work_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0002',
            'name' => 'PRW 001 002',
            'description' => 'PRW 001 002',
            'deliverables' => 'Dua',                
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-10',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0003',
            'name' => 'PRW 001 003',
            'description' => 'PRW 001 003',
            'deliverables' => 'Tiga',                
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-11-15',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0004',
            'name' => 'PRW 001 004',
            'description' => 'PRW 001 004',
            'deliverables' => 'Empat', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-12-22',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
                    
        DB::table('pro_project_work')->insert([
            'code' => 'PRW0005',
            'name' => 'PRW 002 005',
            'description' => 'PRW 002 005',
            'deliverables' => 'Lima', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-11',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0006',
            'name' => 'PRW 002 006',
            'description' => 'PRW 002 006',
            'deliverables' => 'Enam', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2018-10-18',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0007',
            'name' => 'PRW 002 007',
            'description' => 'PRW 003 007',
            'deliverables' => 'Tujuh', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-2-2',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0008',
            'name' => 'PRW 301 008',
            'description' => 'PRW 301 008',
            'deliverables' => 'Level 1', 
            'project_id' => 3,
            'status' => 1,
            'planned_deadline' => '2019-1-5',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW0009',
            'name' => 'PRW 301 009',
            'description' => 'PRW 301 009',
            'deliverables' => 'Level 1', 
            'project_id' => 3,
            'status' => 1,
            'planned_deadline' => '2019-1-6',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00010',
            'name' => 'PRW 302 010',
            'description' => 'PRW 302 010',
            'deliverables' => 'Level 2', 
            'project_id' => 3,
            'work_id' => 8,
            'status' => 1,
            'planned_deadline' => '2019-12-29',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00011',
            'name' => 'PRW 302 011',
            'description' => 'PRW 302 011',
            'deliverables' => 'Level 2', 
            'project_id' => 3,
            'work_id' => 8,
            'status' => 1,
            'planned_deadline' => '2019-12-30',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00012',
            'name' => 'PRW 302 012',
            'description' => 'PRW 302 012',
            'deliverables' => 'Level 2', 
            'project_id' => 3,
            'work_id' => 9,
            'status' => 1,
            'planned_deadline' => '2019-12-30',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00013',
            'name' => 'PRW 303 013',
            'description' => 'PRW 303 013',
            'deliverables' => 'Level 3', 
            'project_id' => 3,
            'work_id' => 10,
            'status' => 1,
            'planned_deadline' => '2019-12-23',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00014',
            'name' => 'PRW 303 014',
            'description' => 'PRW 303 014',
            'deliverables' => 'Level 3', 
            'project_id' => 3,
            'work_id' => 10,
            'status' => 1,
            'planned_deadline' => '2019-12-21',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00015',
            'name' => 'PRW 303 015',
            'description' => 'PRW 303 015',
            'deliverables' => 'Level 3', 
            'project_id' => 3,
            'work_id' => 11,
            'status' => 1,
            'planned_deadline' => '2019-12-15',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00023',
            'name' => 'PRW 304 016',
            'description' => 'PRW 304 016',
            'deliverables' => 'Level 4', 
            'project_id' => 3,
            'work_id' => 13,
            'status' => 1,
            'planned_deadline' => '2019-11-28',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00024',
            'name' => 'PRW 304 017',
            'description' => 'PRW 304 017',
            'deliverables' => 'Level 4', 
            'project_id' => 3,
            'work_id' => 13,
            'status' => 1,
            'planned_deadline' => '2019-11-28',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00025',
            'name' => 'PRW 304 018',
            'description' => 'PRW 304 018',
            'deliverables' => 'Level 4', 
            'project_id' => 3,
            'work_id' => 14,
            'status' => 1,
            'planned_deadline' => '2019-11-25',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00026',
            'name' => 'PRW 305 019',
            'description' => 'PRW 305 019',
            'deliverables' => 'Level 5', 
            'project_id' => 3,
            'work_id' => 16,
            'status' => 1,
            'planned_deadline' => '2019-11-11',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00020',
            'name' => 'PRW 305 020',
            'description' => 'PRW 305 020',
            'deliverables' => 'Level 5', 
            'project_id' => 3,
            'work_id' => 16,
            'status' => 1,
            'planned_deadline' => '2019-11-18',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00021',
            'name' => 'PRW 305 021',
            'description' => 'PRW 305 021',
            'deliverables' => 'Level 5', 
            'project_id' => 3,
            'work_id' => 16,
            'status' => 1,
            'planned_deadline' => '2019-11-11',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'PRW00022',
            'name' => 'PRW 305 022',
            'description' => 'PRW 305 022',
            'deliverables' => 'Level 5', 
            'project_id' => 3,
            'work_id' => 17,
            'status' => 1,
            'planned_deadline' => '2019-11-15',
            // 'actual_deadline' => '',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
                    
    }
}
