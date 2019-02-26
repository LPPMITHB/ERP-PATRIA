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
                'person_in_charge' => NULL,
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
                'project_type' => 4,
                'status' => 1,
                'user_id' => 5,
                'branch_id' => 1,
                'created_at' => '2018-12-19 09:25:42',
                'updated_at' => '2018-12-19 09:25:42',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'RP000101',
                'drawing' => NULL,
                'business_unit_id' => 2,
                'project_sequence' => 1,
                'ship_id' => 3,
                'customer_id' => 4,
                'name' => 'BARAN',
                'person_in_charge' => NULL,
                'description' => 'Project PAMI - DUMMY',
                'sales_order_id' => NULL,
                'planned_start_date' => '2019-04-01',
                'planned_end_date' => '2019-04-25',
                'planned_duration' => '25',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 0.0,
                'flag' => NULL,
                'class_name' => NULL,
                'class_contact_person_name' => NULL,
                'class_contact_person_phone' => NULL,
                'class_contact_person_email' => NULL,
                'project_type' => 1,
                'status' => 1,
                'user_id' => 3,
                'branch_id' => 2,
                'created_at' => '2019-02-25 17:02:53',
                'updated_at' => '2019-02-25 17:02:53',
            ),
        ));
        
        
    }
}