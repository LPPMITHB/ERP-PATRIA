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
            'code' => 'WBS18010001',
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
            'code' => 'WBS18010002',
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
            'code' => 'WBS18010003',
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
            'code' => 'WBS18010004',
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
            'code' => 'WBS18010005',
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
            'code' => 'WBS18010006',
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
            'code' => 'WBS18010007',
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
            'code' => 'WBS18010008',
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
            'code' => 'WBS18010009',
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
            'code' => 'WBS18010010',
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
            'code' => 'WBS18010011',
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
            'code' => 'WBS18010012',
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
            'code' => 'WBS18010013',
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
            'code' => 'WBS18010014',
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
            'code' => 'WBS18010015',
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
            'code' => 'WBS18010016',
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
            'code' => 'WBS18010017',
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
            'code' => 'WBS18010018',
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
            'code' => 'WBS18010019',
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
            'code' => 'WBS18010020',
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
            'code' => 'WBS18020001',
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
            'code' => 'WBS18020002',
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
            'code' => 'WBS18020003',
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
            'code' => 'WBS18020004',
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
            'code' => 'WBS18020005',
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
            'code' => 'WBS18020006',
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
            'code' => 'WBS18020007',
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
            'code' => 'WBS18020008',
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
            'code' => 'WBS18020009',
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
            'code' => 'WBS18020010',
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
            'code' => 'WBS18020011',
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
            'code' => 'WBS18020012',
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
            'code' => 'WBS18020013',
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
            'code' => 'WBS18020014',
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
            'code' => 'WBS18020015',
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
            'code' => 'WBS18020016',
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
            'code' => 'WBS18020017',
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
            'code' => 'WBS18020018',
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
            'code' => 'WBS18020019',
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
            'code' => 'WBS18020020',
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
            'code' => 'WBS18020036',
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
            'code' => 'WBS18020037',
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
            'code' => 'WBS18020038',
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
            'code' => 'WBS18020039',
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
            'code' => 'WBS18020040',
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
            'code' => 'WBS18020041',
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
            'code' => 'WBS18020042',
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
            'code' => 'WBS18020043',
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
            'code' => 'WBS18020044',
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
            'code' => 'WBS18020046',
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
            'code' => 'WBS18020047',
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
            'code' => 'WBS18020048',
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
            'code' => 'WBS18020049',
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
            'code' => 'WBS18020050',
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
            'code' => 'WBS18020051',
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
            'code' => 'WBS18020052',
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
            'code' => 'WBS18020053',
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
            'code' => 'WBS18020054',
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
            'code' => 'WBS18020055',
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
            'code' => 'WBS18020056',
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
            'code' => 'WBS18020057',
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
            'code' => 'WBS18020058',
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
            'code' => 'WBS18020059',
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
            'code' => 'WBS18020060',
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
            'code' => 'WBS18020061',
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
            'code' => 'WBS18020062',
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
            'code' => 'WBS18020063',
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
            'code' => 'WBS18020064',
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
            'code' => 'WBS18020065',
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
            'code' => 'WBS18020066',
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
            'code' => 'WBS18020067',
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
            'code' => 'WBS18020068',
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
            'code' => 'WBS18020069',
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
            'code' => 'WBS18020070',
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
            'code' => 'WBS18020071',
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
            'code' => 'WBS18020072',
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
            'code' => 'WBS18020073',
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
            'code' => 'WBS18020074',
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
            'code' => 'WBS18020075',
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
            'code' => 'WBS18020076',
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
            'code' => 'WBS18020077',
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
            'code' => 'WBS18020078',
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
            'code' => 'WBS18020021',
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
            'code' => 'WBS18020079',
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
            'code' => 'WBS18020080',
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
            'code' => 'WBS18020081',
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
            'code' => 'WBS18020082',
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
            'code' => 'WBS18020083',
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
            'code' => 'WBS18020084',
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
            'code' => 'WBS18020085',
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
            'code' => 'WBS18020086',
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
            'code' => 'WBS18020087',
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
