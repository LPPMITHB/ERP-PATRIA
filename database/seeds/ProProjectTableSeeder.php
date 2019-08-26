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

        $date = date("Y-m-d");
        $date = strtotime($date);

        \DB::table('pro_project')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'P-001',
                'drawing' => NULL,
                'business_unit_id' => 1,
                'project_sequence' => 1,
                'ship_id' => 4,
                'customer_id' => 1,
                'name' => 'Patria 01',
                'person_in_charge' => 'Amir',
                'description' => 'Project belum mulai',
                'sales_order_id' => NULL,
                'planned_start_date' => date("Y-m-d",strtotime("+1 day", $date)),
                'planned_end_date' => date("Y-m-d",strtotime("+114 day", $date)),
                'planned_duration' => '113',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 0.0,
                'flag' => 'Indonesia',
                'class_name' => 'BKI',
                'class_contact_person_name' => 'Ahsan',
                'class_contact_person_phone' => '081536662222',
                'class_contact_person_email' => 'Ahsan@bki.com',
                'project_type' => 1,
                'status' => 1,
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => date("Y-m-d",$date),
                'updated_at' => date("Y-m-d",$date),
            ),
        ));

        $date = date("Y-m-d");
        $date = strtotime("-35 day",strtotime($date));

        \DB::table('pro_project')->insert(array (
            0 => 
            array (
                'id' => 2,
                'number' => 'P-002',
                'drawing' => NULL,
                'business_unit_id' => 1,
                'project_sequence' => 2,
                'ship_id' => 4,
                'customer_id' => 1,
                'name' => 'Patria 02',
                'person_in_charge' => 'Ahuy',
                'description' => 'Activity telat tapi aman',
                'sales_order_id' => NULL,
                'planned_start_date' => date("Y-m-d",strtotime("+1 day", $date)),
                'planned_end_date' => date("Y-m-d",strtotime("+114 day", $date)),
                'planned_duration' => '113',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 0.0,
                'flag' => 'Indonesia',
                'class_name' => 'BKI',
                'class_contact_person_name' => 'Ahmed',
                'class_contact_person_phone' => '081536662223',
                'class_contact_person_email' => 'Ahmed@bki.com',
                'project_type' => 1,
                'status' => 1,
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => date("Y-m-d",$date),
                'updated_at' => date("Y-m-d",$date),
            ),
        ));

        $date = date("Y-m-d");
        $date = strtotime("-40 day",strtotime($date));
        \DB::table('pro_project')->insert(array (
            0 => 
            array (
                'id' => 3,
                'number' => 'P-003',
                'drawing' => NULL,
                'business_unit_id' => 1,
                'project_sequence' => 3,
                'ship_id' => 4,
                'customer_id' => 1,
                'name' => 'Patria 03',
                'person_in_charge' => 'Awul',
                'description' => 'Activity telat lebih dari planned end date',
                'sales_order_id' => NULL,
                'planned_start_date' => date("Y-m-d",strtotime("+1 day", $date)),
                'planned_end_date' => date("Y-m-d",strtotime("+114 day", $date)),
                'planned_duration' => '113',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 0.0,
                'flag' => 'Indonesia',
                'class_name' => 'BKI',
                'class_contact_person_name' => 'Farul',
                'class_contact_person_phone' => '081536662224',
                'class_contact_person_email' => 'Farul@bki.com',
                'project_type' => 1,
                'status' => 1,
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => date("Y-m-d",$date),
                'updated_at' => date("Y-m-d",$date),
            ),
        ));

        $date = date("Y-m-d");
        $date = strtotime("-115 day",strtotime($date));

        \DB::table('pro_project')->insert(array (
            0 => 
            array (
                'id' => 4,
                'number' => 'P-004',
                'drawing' => NULL,
                'business_unit_id' => 1,
                'project_sequence' => 4,
                'ship_id' => 4,
                'customer_id' => 1,
                'name' => 'Patria 04',
                'person_in_charge' => 'Hendro',
                'description' => 'Project lewat dari planned end date',
                'sales_order_id' => NULL,
                'planned_start_date' => date("Y-m-d",strtotime("+1 day", $date)),
                'planned_end_date' => date("Y-m-d",strtotime("+114 day", $date)),
                'planned_duration' => '113',
                'actual_start_date' => NULL,
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 21.6,
                'flag' => 'Indonesia',
                'class_name' => 'BKI',
                'class_contact_person_name' => 'Bambang',
                'class_contact_person_phone' => '081536662225',
                'class_contact_person_email' => 'Bambang@bki.com',
                'project_type' => 1,
                'status' => 1,
                'sales_order_id' => 1,
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => date("Y-m-d",$date),
                'updated_at' => date("Y-m-d",$date),
            ),
        ));

        $date = date("Y-m-d");
        $date = strtotime("-35 day",strtotime($date));

        \DB::table('pro_project')->insert(array (
            0 => 
            array (
                'id' => 5,
                'number' => 'P-005',
                'drawing' => NULL,
                'business_unit_id' => 1,
                'project_sequence' => 5,
                'ship_id' => 4,
                'customer_id' => 1,
                'name' => 'Patria 05',
                'person_in_charge' => 'Aseng',
                'description' => 'Sudah ada konfirmasi',
                'sales_order_id' => NULL,
                'planned_start_date' => date("Y-m-d",strtotime("+1 day", $date)),
                'planned_end_date' => date("Y-m-d",strtotime("+114 day", $date)),
                'planned_duration' => '113',
                'actual_start_date' => date("Y-m-d",strtotime("+1 day", $date)),
                'actual_end_date' => NULL,
                'actual_duration' => NULL,
                'progress' => 21.6,
                'flag' => 'Indonesia',
                'class_name' => 'BKI',
                'class_contact_person_name' => 'Aseng',
                'class_contact_person_phone' => '081536662225',
                'class_contact_person_email' => 'Aseng@bki.com',
                'project_type' => 1,
                'status' => 1,
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => date("Y-m-d",$date),
                'updated_at' => date("Y-m-d",$date),
            ),
        ));
    }
}