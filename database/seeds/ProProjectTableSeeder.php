<?php

use Illuminate\Database\Seeder;

class ProProjectTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pro_project')->delete();
        
        \DB::table('pro_project')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'PRO-DUMMY01',
                'drawing' => NULL,
                'business_unit_id' => 1,
                'project_sequence' => 1,
                'ship_id' => 5,
                'customer_id' => 1,
                'name' => 'Kapal Dummy Boat',
                'description' => 'Dummy 19 Desember 2018',
                'sales_order_id' => NULL,
                'planned_start_date' => '2018-12-19',
                'planned_end_date' => '2019-04-23',
                'planned_duration' => '126',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 0.0,
                'flag' => 'DUMMY - Indonesia',
                'class_name' => 'DUMMY - BKI',
                'class_contact_person_name' => 'DUMMY - Berdaus',
                'class_contact_person_phone' => '08923157231',
                'class_contact_person_email' => 'dummy.berdaus@dummy.com',
                'status' => 1,
                'user_id' => 5,
                'branch_id' => 1,
                'created_at' => '2018-12-19 09:25:42',
                'updated_at' => '2018-12-19 09:25:42',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PRO2-DUMMY2',
                'drawing' => NULL,
                'business_unit_id' => 2,
                'project_sequence' => 2,
                'ship_id' => 3,
                'customer_id' => 2,
                'name' => 'Repair Dummy',
                'description' => 'Repair Dummy 19 Desember 2018',
                'sales_order_id' => NULL,
                'planned_start_date' => '2018-12-28',
                'planned_end_date' => '2019-01-28',
                'planned_duration' => '32',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 0.0,
                'flag' => NULL,
                'class_name' => NULL,
                'class_contact_person_name' => NULL,
                'class_contact_person_phone' => NULL,
                'class_contact_person_email' => NULL,
                'status' => 1,
                'user_id' => 5,
                'branch_id' => 1,
                'created_at' => '2018-12-19 10:13:50',
                'updated_at' => '2018-12-19 10:13:50',
            ),
        ));
        
        
    }
}