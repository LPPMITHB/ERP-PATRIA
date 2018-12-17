<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('pro_project')->insert([
            'number' => 'PROJECT-01',
            'business_unit_id' => 1,
            'project_sequence' => 1,
            'name' => 'Tug Boat Project',
            'description' => 'pertama kali',
            // 'sales_order_id' => 1,
            'ship_id' => 1,
            'customer_id' => 4,
            'planned_start_date' => '2018-8-16',
            'planned_end_date' => '2018-12-30',
            'progress' => 0,
            'planned_duration' => '137',
            'actual_start_date' => '2018-8-17',
            'actual_end_date' => '2018-12-31',
            'actual_duration' => '137',
            'flag' => 'INDONESIA',
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('pro_project')->insert([
            'number' => 'PROJECT-02',
            'business_unit_id' => 1,
            'project_sequence' => 2,
            'name' => 'OIL BARGE 1100KL PROJECT',
            'description' => 'Real Case',
            // 'sales_order_id' => 1,
            'ship_id' => 2,
            'customer_id' => 2,
            'planned_start_date' => '2018-12-29',
            'planned_end_date' => '2019-5-28',
            'progress' => 0,
            'planned_duration' => '151',
            'actual_start_date' => '2018-12-29',
            'actual_end_date' => '2019-5-28',
            'actual_duration' => '151',
            'flag' => 'INDONESIA',
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('pro_project')->insert([
            'number' => 'PROJECT-03',
            'business_unit_id' => 2,
            'project_sequence' => 1,
            'name' => 'Offshore Supply Vessel Project',
            'description' => 'ketiga kali',
            // 'sales_order_id' => 1,
            'ship_id' => 3,
            'customer_id' => 1,
            'planned_start_date' => '2018-8-16',
            'planned_end_date' => '2019-1-16',
            'progress' => 0,
            'planned_duration' => '154',
            'actual_start_date' => '2018-8-16',
            'actual_end_date' => '2019-1-16',
            'actual_duration' => '154',
            'flag' => 'INDONESIA',
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('pro_project')->insert([
            'number' => 'PROJECT-04',
            'business_unit_id' => 2,
            'project_sequence' => 2,
            'name' => 'Deck Cargo Barge Project',
            'description' => 'pertama kali',
            // 'sales_order_id' => 1,
            'ship_id' => 4,
            'customer_id' => 3,
            'planned_start_date' => '2018-8-16',
            'planned_end_date' => '2018-11-16',
            'progress' => 0,
            'planned_duration' => '93',
            'actual_start_date' => '2018-8-20',
            'actual_end_date' => '2018-12-1',
            'actual_duration' => '104',
            'flag' => 'INDONESIA',
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('pro_project')->insert([
            'number' => 'PRO-DUMMY01',
            'business_unit_id' => 1,
            'project_sequence' => 3,
            'name' => 'Project Dummy 01',
            'description' => 'Project Dummy 01',
            // 'sales_order_id' => 1,
            'ship_id' => 1,
            'customer_id' => 20,
            'planned_start_date' => '2018-12-16',
            'planned_end_date' => '2018-1-31',
            'progress' => 0,
            'planned_duration' => '47',
            // 'actual_start_date' => '2018-8-20',
            // 'actual_end_date' => '2018-12-1',
            // 'actual_duration' => '104',
            'flag' => 'DUMMY - INDONESIA',
            'class_name' => 'DUMMY - BKI',
            'class_contact_person_name' => 'DUMMY - Aldies',
            'class_contact_person_phone' => '0896531332',
            'class_contact_person_email' => 'dummy.aldies@dummy.com',
            'status' => 1,
            'user_id' => 5,
            'branch_id' => 1,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
