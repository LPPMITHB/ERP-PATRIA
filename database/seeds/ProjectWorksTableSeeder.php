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
            'work_id' => 1,
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
            'work_id' => 3,
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
            'work_id' => 4,
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
    }
}
