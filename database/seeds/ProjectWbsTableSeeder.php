<?php

use Illuminate\Database\Seeder;

class ProjectWbsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('pro_wbs')->insert([
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

        DB::table('pro_wbs')->insert([
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

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180003',
            'name' => 'WBS 1.2',
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

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180004',
            'name' => 'WBS 1.1.1',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'wbs_id' => 2,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_wbs')->insert([
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

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180006',
            'name' => 'WBS 1.1.1.1.1',
            'description' => '',
            'deliverables' => 'Level 5',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-30',
            'progress' => 0,
            'wbs_id' => 5,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_wbs')->insert([
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

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180008',
            'name' => 'WBS 2.1',
            'description' => '',
            'deliverables' => 'Level 2',                
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-12-22',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);             

        DB::table('pro_wbs')->insert([
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
        
        DB::table('pro_wbs')->insert([
            'code' => 'WBS180010',
            'name' => 'WBS2 1',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-2-22',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180011',
            'name' => 'WBS2 1.2',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-1-5',
            'progress' => 0,
            'wbs_id' => 10,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180012',
            'name' => 'WBS2 2',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-3-15',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180013',
            'name' => 'WBS2 2.1',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-2-25',
            'progress' => 0,
            'wbs_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180014',
            'name' => 'WBS2 2.2',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-3-7',
            'progress' => 0,
            'wbs_id' => 12,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180015',
            'name' => 'WBS2 3',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-6-18',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180016',
            'name' => 'WBS2 3.1',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2019-6-6',
            'progress' => 0,
            'wbs_id' => 15,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180017',
            'name' => 'WBS3 1',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-11-27',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180018',
            'name' => 'WBS3 2',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-10-15',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180019',
            'name' => 'WBS4 1',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-9-9',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        DB::table('pro_wbs')->insert([
            'code' => 'WBS180020',
            'name' => 'WBS4 2',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 1,
            'status' => 1,
            'planned_deadline' => '2018-10-29',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        //21
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820001',
            'name' => 'CONTRACT SIGN',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2018-12-29',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        //22
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820002',
            'name' => 'APPROVED DESIGN, SPECIFICATION & SHIP DOCUMENT',
            'description' => '',
            'deliverables' => 'Level 1', 
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2018-12-29',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]); 

        //23
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820003',
            'name' => 'Design Drawings & Submission',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-1-31',
            'progress' => 0,
            'wbs_id' => 22,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //24
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820004',
            'name' => 'Distribution DWG to stakeholder',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-28',
            'progress' => 0,
            'wbs_id' => 22,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //25
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820005',
            'name' => 'Procurement Process',
            'description' => '',
            'deliverables' => 'Level 1',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-10',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //26
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820006',
            'name' => 'Production Process',
            'description' => '',
            'deliverables' => 'Level 1',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-21',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //27
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820007',
            'name' => 'Hull Structure',
            'description' => '',
            'deliverables' => 'Level 2',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-21',
            'progress' => 0,
            'wbs_id' => 26,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //28
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820008',
            'name' => 'Bottom',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //29
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820009',
            'name' => 'Transom',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-2-26',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //30
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820010',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //31
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820011',
            'name' => 'Master Block 2 (frame 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820012',
            'name' => 'Block 3 (frame 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820013',
            'name' => 'Block 4 (frame 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820014',
            'name' => 'Block 5 (frame 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820015',
            'name' => 'Block 6 (frame 34-43)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-2',
            'progress' => 0,
            'wbs_id' => 28,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //36
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820016',
            'name' => 'Tank top',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820017',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 36,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820018',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 36,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820019',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 36,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820020',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 36,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820036',
            'name' => 'Block 5 (Fr. 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 36,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820037',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-8',
            'progress' => 0,
            'wbs_id' => 36,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //43
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820038',
            'name' => 'Transbulkhead',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //44
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820039',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 43,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820040',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 43,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820041',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 43,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820042',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 43,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820043',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 43,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //49
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820044',
            'name' => 'Longbulkhead',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820045',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 49,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820046',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 49,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820047',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 49,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820048',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 49,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820049',
            'name' => 'Block 5 (Fr. 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 49,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820050',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-3',
            'progress' => 0,
            'wbs_id' => 49,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //56
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820051',
            'name' => 'Side sheel',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //57
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820052',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 56,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820053',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 56,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820054',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 56,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820055',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 56,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820056',
            'name' => 'Block 5 (Fr. 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 56,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820057',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 56,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //63
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820058',
            'name' => 'Main deck',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820059',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820060',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820061',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820062',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820063',
            'name' => 'Block 5 (Fr. 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820064',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820065',
            'name' => 'Block 8 (deck house)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-13',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820066',
            'name' => 'Block 9 (winch house)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-13',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820067',
            'name' => 'Block 7 (skeg)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-9',
            'progress' => 0,
            'wbs_id' => 63,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //73
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820068',
            'name' => 'Outfitting Hull',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //74
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820069',
            'name' => 'Fabrication',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 73,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //75
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820070',
            'name' => 'Installation',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 73,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //76
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820071',
            'name' => 'Piping & Safety System',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //77
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820072',
            'name' => 'Cargo System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //78
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820073',
            'name' => 'General Service & Fire Fighting System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //79
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820074',
            'name' => 'Bilge & OWS System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //80
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820075',
            'name' => 'Emergency Fire Fighting System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820076',
            'name' => 'Freshwater & Sea Water System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820077',
            'name' => 'Fuel Oil System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
    
        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820078',
            'name' => 'Holding Tank & Sewage System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820021',
            'name' => 'Air Compressor & Air Pressure',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820079',
            'name' => 'CO2 Fixed System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 76,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //86
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820080',
            'name' => 'Electric & Mechanic',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //87
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820081',
            'name' => 'Electric Installation',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 86,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //88
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820082',
            'name' => 'Mechanic Installation',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-6',
            'progress' => 0,
            'wbs_id' => 86,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //89
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820083',
            'name' => 'Coating',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-8',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //90
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820084',
            'name' => 'Interior and Furniture',
            'description' => '',
            'deliverables' => 'Level 3',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-21',
            'progress' => 0,
            'wbs_id' => 27,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //91
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820085',
            'name' => 'Launching',
            'description' => '',
            'deliverables' => 'Level 1',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-27',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //92
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820086',
            'name' => 'Testing Commisioning and Familirisasion',
            'description' => '',
            'deliverables' => 'Level 1',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-15',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //93
        DB::table('pro_wbs')->insert([
            'code' => 'WBS1820087',
            'name' => 'DELIVERY',
            'description' => '',
            'deliverables' => 'Level 1',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-5-28',
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

    }
}
