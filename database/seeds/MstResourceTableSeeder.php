<?php

use Illuminate\Database\Seeder;

class MstResourceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_resource')->delete();
        
        \DB::table('mst_resource')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'RSC001',
                'name' => 'Generating Set 500 Kva',
                'description' => 'SA63-PTAA',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'RSC002',
                'name' => 'Generating Set 80 Kva',
                'description' => '2516/1500',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'RSC003',
                'name' => 'Generating Set 35 Kva',
                'description' => 'EDW 610D',
                'cost_standard_price' => 70063804,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'RSC004',
                'name' => 'Compressor 12 Bar',
                'description' => 'DLT0704',
                'cost_standard_price' => 241594043,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'RSC005',
                'name' => 'Compressor 430 KW',
                'description' => 'PDS390S-4B1',
                'cost_standard_price' => 275000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'RSC006',
                'name' => 'Excavator 20T',
                'description' => 'PC200-8m0',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'RSC007',
                'name' => 'Mobile Crane 55T',
                'description' => 'SCX550E',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'RSC008',
                'name' => 'Vibrating Roller',
                'description' => 'SW352S-1',
                'cost_standard_price' => 517000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'RSC009',
                'name' => 'Wheel Loader 180-3',
                'description' => 'WA 180-3',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'RSC010',
                'name' => 'Wheel Loader 200-5',
                'description' => 'WA 200-5',
                'cost_standard_price' => 1045000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'RSC011',
                'name' => 'Winch Machine 20T',
                'description' => 'Electric Winch JM20M',
                'cost_standard_price' => 1049256340,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'RSC012',
                'name' => 'Winch Machine 40T',
                'description' => 'Hydrolic Winch JM40M',
                'cost_standard_price' => '2720696798',
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'RSC013',
                'name' => 'Welding Machine GMAW',
                'description' => 'YD-500KR2',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'RSC014',
            'name' => 'Welding (ARC) Argon Inverter',
                'description' => NULL,
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'RSC015',
            'name' => 'Welding (ARC) LCF 1200A',
                'description' => 'Inverter LCF 1200',
                'cost_standard_price' => 187900000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'RSC016',
            'name' => 'Welding (ARC) Buddy 400i',
                'description' => 'Inverter BuddyARC400i',
                'cost_standard_price' => 7800000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'RSC017',
            'name' => 'Welding (ARC) Buddy 500i',
                'description' => 'Inverter BuddyMIG500i',
                'cost_standard_price' => 22400000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'RSC018',
                'name' => 'Overhead Crane 10T',
                'description' => 'Overhead Crane 10 Ton',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'RSC019',
                'name' => 'Bending Press Brake 8,5KW',
                'description' => 'PPLB-H-135/30',
                'cost_standard_price' => 10000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'RSC020',
                'name' => 'C Press Brake 20,5KW',
                'description' => 'Hydrolic Press',
                'cost_standard_price' => 7500000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'RSC021',
                'name' => 'Plasma Cutting 2,4MPA',
                'description' => NULL,
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'RSC022',
                'name' => 'Radial Drilling 12,4KVA',
                'description' => NULL,
                'cost_standard_price' => 5000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'RSC023',
                'name' => 'Straightening Press 200T',
                'description' => NULL,
                'cost_standard_price' => 5000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'RSC024',
                'name' => 'Roll Sertom',
                'description' => NULL,
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'RSC025',
                'name' => 'Shearing Cutting',
                'description' => NULL,
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'RSC026',
                'name' => 'Jib Crane 1T',
                'description' => NULL,
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'RSC027',
                'name' => 'Jib Crane 3,5T',
                'description' => '32TX5M',
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'RSC028',
                'name' => 'Kelotok',
                'description' => 'Kendaraan',
                'cost_standard_price' => 52000000,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'RSC029',
                'name' => 'WTP ',
                'description' => 'Water Supply ',
                'cost_standard_price' => 1981167159,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'RSC030',
                'name' => 'Water Blasting',
                'description' => NULL,
                'cost_standard_price' => 0,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}