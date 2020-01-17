<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectCaseI extends Seeder
{
    Carbon::create('2000', '01', '01')
    public function run()
    {
        DB::table('pro_project')->insert([
            'id' => 1,
            //form
            'number' => 'Project Test 0001',
            'person_in_charge' => 'Project PIC Test 0001', //project
            'name' => 'Ship Name Test 0001', //ship name
            'project_type' => 1,
            
            'project_standard_id' => NULL,
            'business_unit_id' => 2,
            'project_sequence' => 1,
            'ship_id' => 4,
            'customer_id' => 1,
            
            
            'hull_number' => NULL,
            'description' => 'Project Test Untuk Mendefinisikan fungsi di Manage Wbs',
            'sales_order_id' => NULL,
            'planned_start_date' => '2019-09-28',
            'planned_end_date' => '2020-01-19',
            'planned_duration' => '113',
            'arrival_date' => NULL,
            'actual_start_date' => NULL,
            'actual_end_date' => NULL,
            'actual_duration' => NULL,
            'progress' => 0.0,
            'flag' => 'Indonesia',
            'class_name' => 'BKI',
            'class_name_2' => NULL,
            'class_contact_person_name' => 'Ahsan',
            'class_contact_person_name_2' => NULL,
            'class_contact_person_phone' => '081536662222',
            'class_contact_person_phone_2' => NULL,
            'class_contact_person_email' => 'Ahsan@bki.com',
            'class_contact_person_email_2' => NULL,
            'budget_value' => NULL,
            
            'status' => 1,
            'user_id' => 2,
            'branch_id' => 1,
            'created_at' => '2019-09-27 00:00:00',
            'updated_at' => '2019-09-27 00:00:00',
        ]);

    }

}
