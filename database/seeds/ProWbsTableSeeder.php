<?php

use Illuminate\Database\Seeder;

class ProWbsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pro_wbs')->delete();
        
        \DB::table('pro_wbs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'WBS192040001',
                'number' => 'Docking',
            'description' => 'Docking (Pengedokan)',
                'deliverables' => 'Docking',
                'project_id' => 5,
                'wbs_id' => NULL,
                'wbs_configuration_id' => 1,
                'status' => 1,
                'planned_duration' => 3,
                'planned_start_date' => '2019-04-25',
                'planned_end_date' => '2019-04-27',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 12.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 12:56:17',
                'updated_at' => '2019-04-12 09:31:16',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'WBS192040002',
                'number' => 'General Services',
            'description' => 'General Services (Pelayanan Umum)',
                'deliverables' => 'General Services',
                'project_id' => 5,
                'wbs_id' => NULL,
                'wbs_configuration_id' => 2,
                'status' => 1,
                'planned_duration' => 6,
                'planned_start_date' => '2019-05-24',
                'planned_end_date' => '2019-05-29',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 12.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 12:56:35',
                'updated_at' => '2019-04-12 09:31:56',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'WBS192040003',
                'number' => 'Working',
                'description' => 'Working ',
                'deliverables' => 'Working ',
                'project_id' => 5,
                'wbs_id' => NULL,
                'wbs_configuration_id' => 3,
                'status' => 1,
                'planned_duration' => 28,
                'planned_start_date' => '2019-04-27',
                'planned_end_date' => '2019-05-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 70.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 13:35:57',
                'updated_at' => '2019-04-12 09:32:00',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'WBS192040004',
                'number' => 'Replating',
            'description' => 'Penggantian Plat (Replating)',
                'deliverables' => 'Replating',
                'project_id' => 5,
                'wbs_id' => 3,
                'wbs_configuration_id' => 5,
                'status' => 1,
                'planned_duration' => 14,
                'planned_start_date' => '2019-04-27',
                'planned_end_date' => '2019-05-10',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 35.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 13:37:00',
                'updated_at' => '2019-04-12 09:34:41',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'WBS192040005',
                'number' => 'Out Fitting',
                'description' => 'Out Fitting',
                'deliverables' => 'Out Fitting',
                'project_id' => 5,
                'wbs_id' => 3,
                'wbs_configuration_id' => 68,
                'status' => 1,
                'planned_duration' => 14,
                'planned_start_date' => '2019-05-11',
                'planned_end_date' => '2019-05-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 35.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 13:37:12',
                'updated_at' => '2019-04-12 09:34:44',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'WBS192040006',
                'number' => 'Sideboard Forward',
                'description' => 'Sideboard Forward',
                'deliverables' => 'Sideboard Forward',
                'project_id' => 5,
                'wbs_id' => 4,
                'wbs_configuration_id' => 6,
                'status' => 1,
                'planned_duration' => 14,
                'planned_start_date' => '2019-04-27',
                'planned_end_date' => '2019-05-10',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 35.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 13:38:00',
                'updated_at' => '2019-04-12 09:35:00',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'WBS192040007',
                'number' => 'Panel Block F1',
                'description' => 'Panel Block F1',
                'deliverables' => 'Panel Block F1',
                'project_id' => 5,
                'wbs_id' => 6,
                'wbs_configuration_id' => 85,
                'status' => 1,
                'planned_duration' => 14,
                'planned_start_date' => '2019-04-27',
                'planned_end_date' => '2019-05-10',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 35.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 13:38:55',
                'updated_at' => '2019-04-12 09:35:50',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'WBS192040008',
                'number' => 'Winch House',
                'description' => 'Winch House',
                'deliverables' => 'Winch House',
                'project_id' => 5,
                'wbs_id' => 5,
                'wbs_configuration_id' => 87,
                'status' => 1,
                'planned_duration' => 14,
                'planned_start_date' => '2019-05-11',
                'planned_end_date' => '2019-05-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 35.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 23:18:57',
                'updated_at' => '2019-04-12 09:35:10',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'WBS192040009',
                'number' => 'Pembuatan 2 Pintu Besar',
                'description' => 'Pembuatan 2 Pintu Besar',
                'deliverables' => 'Pembuatan 2 Pintu Besar',
                'project_id' => 5,
                'wbs_id' => 8,
                'wbs_configuration_id' => 88,
                'status' => 1,
                'planned_duration' => 7,
                'planned_start_date' => '2019-05-11',
                'planned_end_date' => '2019-05-17',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 17.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 23:28:58',
                'updated_at' => '2019-04-12 09:37:53',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'WBS192040010',
                'number' => 'Pintu Sekat',
                'description' => 'Pintu Sekat',
                'deliverables' => 'Pintu Sekat',
                'project_id' => 5,
                'wbs_id' => 8,
                'wbs_configuration_id' => 91,
                'status' => 1,
                'planned_duration' => 7,
                'planned_start_date' => '2019-05-18',
                'planned_end_date' => '2019-05-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 17.5,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-11 23:29:28',
                'updated_at' => '2019-04-12 09:37:48',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'WBS192040011',
                'number' => 'Docking',
            'description' => 'Docking (Pengedokan)',
                'deliverables' => 'Docking',
                'project_id' => 5,
                'wbs_id' => NULL,
                'wbs_configuration_id' => 1,
                'status' => 1,
                'planned_duration' => 1,
                'planned_start_date' => '2019-05-24',
                'planned_end_date' => '2019-05-24',
                'actual_duration' => NULL,
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'progress' => 0.0,
                'weight' => 5.0,
                'user_id' => 3,
                'branch_id' => 2,
                'process_cost' => NULL,
                'other_cost' => NULL,
                'created_at' => '2019-04-12 09:20:55',
                'updated_at' => '2019-04-12 09:31:44',
            ),
        ));
        
        
    }
}