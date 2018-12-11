<?php

use Illuminate\Database\Seeder;

class ProjectWorkActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('pro_activity')->insert([
            'code' => 'PRA0001',
            'name' => 'PRA 001 001',
            'description' => 'PRA 001 001',
            'status' => 1,
            'wbs_id' => 1,
            'planned_duration' => 7,
            'planned_start_date' => '2018-9-1',
            'planned_end_date' => '2018-9-7',
            'actual_duration' => 14,
            'actual_start_date' => '2018-9-2',
            'actual_end_date' => '2018-9-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0002',
            'name' => 'PRA 001 002',
            'description' => 'PRA 001 002',
            'status' => 1,
            'wbs_id' => 1,
            'planned_duration' => 23,
            'planned_start_date' => '2018-9-12',
            'planned_end_date' => '2018-10-4',
            'actual_duration' => 20,
            'actual_start_date' => '2018-9-13',
            'actual_end_date' => '2018-10-2',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0003',
            'name' => 'PRA 001 003',
            'description' => 'PRA 001 003',
            'status' => 1,
            'wbs_id' => 1,
            'planned_duration' => 25,
            'planned_start_date' => '2018-9-1',
            'planned_end_date' => '2018-9-25',
            'actual_duration' => 16,
            'actual_start_date' => '2018-9-3',
            'actual_end_date' => '2018-9-18',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0004',
            'name' => 'PRA 002 004',
            'description' => 'PRA 002 004',
            'status' => 1,
            'wbs_id' => 2,
            'planned_duration' => 10,
            'planned_start_date' => '2018-9-1',
            'planned_end_date' => '2018-9-10',
            'actual_duration' => 11,
            'actual_start_date' => '2018-9-5',
            'actual_end_date' => '2018-9-15',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0005',
            'name' => 'PRA 002 005',
            'description' => 'PRA 002 005',
            'status' => 1,
            'wbs_id' => 2,
            'planned_duration' => 10,
            'planned_start_date' => '2018-9-2',
            'planned_end_date' => '2018-9-11',
            'actual_duration' => 10,
            'actual_start_date' => '2018-9-2',
            'actual_end_date' => '2018-9-11',
            'user_id' => 5,
            'branch_id' => 1,
        ]);

        DB::table('pro_activity')->insert([
            'code' => 'PRA0006',
            'name' => 'PRA 007 006',
            'description' => 'PRA 007 006',
            'status' => 1,
            'wbs_id' => 7,
            'planned_duration' => 4,
            'planned_start_date' => '2018-9-2',
            'planned_end_date' => '2019-9-5',
            'actual_duration' => 5,
            'actual_start_date' => '2018-9-2',
            'actual_end_date' => '2018-9-6',
            'user_id' => 5,
            'branch_id' => 1,
        ]);
    }
}
