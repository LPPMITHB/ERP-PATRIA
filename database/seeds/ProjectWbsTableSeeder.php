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
            'code' => 'WBS181010001',
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
            'code' => 'WBS181010002',
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
            'code' => 'WBS181010003',
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
            'code' => 'WBS181010004',
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
            'code' => 'WBS181010005',
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
            'code' => 'WBS181010006',
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
            'code' => 'WBS181010007',
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
            'code' => 'WBS181010008',
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
            'code' => 'WBS181010009',
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
            'code' => 'WBS181010010',
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
            'code' => 'WBS181010011',
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
            'code' => 'WBS181010012',
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
            'code' => 'WBS181010013',
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
            'code' => 'WBS181010014',
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
            'code' => 'WBS181010015',
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
            'code' => 'WBS181010016',
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
            'code' => 'WBS181010017',
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
            'code' => 'WBS181010018',
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
            'code' => 'WBS181010019',
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
            'code' => 'WBS181010020',
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
            'code' => 'WBS181020001',
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
            'code' => 'WBS181020002',
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
            'code' => 'WBS181020003',
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
            'code' => 'WBS181020004',
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
            'code' => 'WBS181020005',
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
            'code' => 'WBS181020006',
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
            'code' => 'WBS181020007',
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
            'code' => 'WBS181020008',
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
            'code' => 'WBS181020009',
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
            'code' => 'WBS181020010',
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
            'code' => 'WBS181020011',
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
            'code' => 'WBS181020012',
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
            'code' => 'WBS181020013',
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
            'code' => 'WBS181020014',
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
            'code' => 'WBS181020015',
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
            'code' => 'WBS181020016',
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

        // 37
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020017',
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
            'code' => 'WBS181020018',
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
            'code' => 'WBS181020019',
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
            'code' => 'WBS181020020',
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
            'code' => 'WBS181020036',
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
            'code' => 'WBS181020037',
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
            'code' => 'WBS181020038',
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
            'code' => 'WBS181020039',
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
            'code' => 'WBS181020040',
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
            'code' => 'WBS181020041',
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
            'code' => 'WBS181020042',
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
            'code' => 'WBS181020043',
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
            'code' => 'WBS181020044',
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
            'code' => 'WBS181020046',
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
            'code' => 'WBS181020047',
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
            'code' => 'WBS181020048',
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
            'code' => 'WBS181020049',
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
            'code' => 'WBS181020050',
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

        //55
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020051',
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

        //56
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020052',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 55,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020053',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 55,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020054',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 55,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020055',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 55,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020056',
            'name' => 'Block 5 (Fr. 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 55,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020057',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 55,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //62
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020058',
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
            'code' => 'WBS181020059',
            'name' => 'Blok 1 (Fr. 0-15)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020060',
            'name' => 'Master Block 2 (Fr. 15-21)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020061',
            'name' => 'Block 3 (Fr. 21-25)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020062',
            'name' => 'Block 4 (Fr. 25-30)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020063',
            'name' => 'Block 5 (Fr. 30-34)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020064',
            'name' => 'Block 6 (Fr. 34-40)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-17',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020065',
            'name' => 'Block 8 (deck house)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-13',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020066',
            'name' => 'Block 9 (winch house)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-13',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020067',
            'name' => 'Block 7 (skeg)',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-9',
            'progress' => 0,
            'wbs_id' => 62,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //72
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020068',
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

        //73
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020069',
            'name' => 'Fabrication',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 72,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //74
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020070',
            'name' => 'Installation',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 72,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //75
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020071',
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

        //76
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020072',
            'name' => 'Cargo System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //77
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020073',
            'name' => 'General Service & Fire Fighting System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //78
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020074',
            'name' => 'Bilge & OWS System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //79
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020075',
            'name' => 'Emergency Fire Fighting System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //80
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020076',
            'name' => 'Freshwater & Sea Water System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020077',
            'name' => 'Fuel Oil System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);
    
        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020078',
            'name' => 'Holding Tank & Sewage System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020021',
            'name' => 'Air Compressor & Air Pressure',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020079',
            'name' => 'CO2 Fixed System',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 75,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //85
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020080',
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

        //86
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020081',
            'name' => 'Electric Installation',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-24',
            'progress' => 0,
            'wbs_id' => 85,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //87
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020082',
            'name' => 'Mechanic Installation',
            'description' => '',
            'deliverables' => 'Level 4',
            'project_id' => 2,
            'status' => 1,
            'planned_deadline' => '2019-4-6',
            'progress' => 0,
            'wbs_id' => 85,
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        //88
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020083',
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

        //89
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020084',
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

        //90
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020085',
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

        //91
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020086',
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

        //92
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181020087',
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

        //93
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030001',
            'name' => 'DUMMY - Hull',
            'description' => 'DUMMY',
            'deliverables' => 'Hull',
            'project_id' => 5,
            'status' => 1,
            'planned_deadline' => '2019-1-15',
            'weight' => 50,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //94
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030002',
            'name' => 'DUMMY - Outfitting',
            'description' => 'DUMMY',
            'deliverables' => 'Outfitting',
            'project_id' => 5,
            'status' => 1,
            'planned_deadline' => '2019-1-22',
            'weight' => 50,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //95
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030003',
            'name' => 'DUMMY - Lambung',
            'description' => 'DUMMY',
            'deliverables' => 'Lambung',
            'project_id' => 5,
            'wbs_id' => 93,
            'status' => 1,
            'planned_deadline' => '2019-1-8',
            'weight' => 25,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030004',
            'name' => 'DUMMY - Portside',
            'description' => 'DUMMY',
            'deliverables' => 'Portside',
            'project_id' => 5,
            'wbs_id' => 93,
            'status' => 1,
            'planned_deadline' => '2019-1-10',
            'weight' => 15,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //97
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030005',
            'name' => 'DUMMY - Bulbous Bow',
            'description' => 'DUMMY',
            'deliverables' => 'Bulbous Bow',
            'project_id' => 5,
            'wbs_id' => 93,
            'status' => 1,
            'planned_deadline' => '2019-1-14',
            'weight' => 10,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //98
        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030006',
            'name' => 'DUMMY - Fabrication',
            'description' => 'DUMMY',
            'deliverables' => 'Fabrication',
            'project_id' => 5,
            'wbs_id' => 94,
            'status' => 1,
            'planned_deadline' => '2019-1-25',
            'weight' => 25,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('pro_wbs')->insert([
            'code' => 'WBS181030007',
            'name' => 'DUMMY - Installation',
            'description' => 'DUMMY',
            'deliverables' => 'Installation',
            'project_id' => 5,
            'wbs_id' => 94,
            'status' => 1,
            'planned_deadline' => '2019-1-28',
            'weight' => 25,
            'progress' => 0,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


    }
}
