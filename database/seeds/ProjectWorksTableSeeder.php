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
            'code' => 'WBS180001',
            'name' => 'WBS 1',
            'description' => 'WBS 1',
            'deliverables' => 'Satu',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180002',
            'name' => 'WBS 1.1',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'wbs_id' => 1,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180003',
            'name' => 'WBS 1.2',
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
            'code' => 'WBS180004',
            'name' => 'WBS 1.1.1',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'wbs_id' => 3,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180005',
            'name' => 'WBS 1.1.1.1',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'wbs_id' => 4,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180006',
            'name' => 'WBS 1.1.1.1.1',
            'description' => '',
            'deliverables' => 'Level 5',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'work_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180007',
            'name' => 'WBS 2',
            'description' => '',
            'deliverables' => 'WBS 2 Level 1',                
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-10',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180008',
            'name' => 'WBS 2.1',
            'description' => '',
            'deliverables' => 'Level 2',                
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-11-15',
            'progress' => 0,
            'work_id' => 7,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180009',
            'name' => 'WBS 3',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-12-22',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);     
        
        DB::table('pro_project_work')->insert([
            'code' => 'WBS180010',
            'name' => 'WBS2 1',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-2-22',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180011',
            'name' => 'WBS2 1.2',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-1-5',
            'progress' => 0,
            'work_id' => 10,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180012',
            'name' => 'WBS2 2',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-3-15',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180013',
            'name' => 'WBS2 2.1',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-2-25',
            'progress' => 0,
            'work_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180014',
            'name' => 'WBS2 2.2',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-3-7',
            'progress' => 0,
            'work_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180015',
            'name' => 'WBS2 3',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-6-18',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180016',
            'name' => 'WBS2 3.1',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-6-6',
            'progress' => 0,
            'work_id' => 15,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180017',
            'name' => 'WBS3 1',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 3,
            'status' => 1,
            'planned_deadline' => '2018-11-27',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180018',
            'name' => 'WBS3 2',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 3,
            'status' => 1,
            'planned_deadline' => '2018-10-15',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180019',
            'name' => 'WBS4 1',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 4,
            'status' => 1,
            'planned_deadline' => '2018-9-9',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_project_work')->insert([
            'code' => 'WBS180020',
            'name' => 'WBS4 2',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 4,
            'status' => 1,
            'planned_deadline' => '2018-10-29',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 
    }
}
