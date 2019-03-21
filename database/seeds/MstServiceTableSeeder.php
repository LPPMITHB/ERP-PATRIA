<?php

use Illuminate\Database\Seeder;

class MstServiceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_service')->delete();
        
        \DB::table('mst_service')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'SRV0001',
                'name' => 'Replating',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'SRV0002',
                'name' => 'Replating (Minimal Charge)',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'SRV0003',
                'name' => 'Rewelding',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'SRV0004',
                'name' => 'Manhole',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'SRV0005',
                'name' => 'Draft',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'SRV0006',
                'name' => 'Bollard',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'SRV0007',
                'name' => 'Winch House',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'SRV0008',
                'name' => 'Tangga',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'SRV0009',
                'name' => 'Barcket Smithc',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'SRV0010',
                'name' => 'Panama Chock',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'SRV0011',
                'name' => 'Drain Hole',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'SRV0012',
                'name' => 'Sounding plug',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'SRV0013',
                'name' => 'Lampu Navigasi',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'SRV0014',
                'name' => 'Kupingan Tarik',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'SRV0015',
                'name' => 'Ban Dapra',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'SRV0016',
                'name' => 'Gate Door',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'SRV0017',
                'name' => 'Mufler',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'SRV0018',
                'name' => 'Zinc Anode',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'SRV0019',
                'name' => 'Keramik',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'SRV0020',
                'name' => 'Perancah',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'SRV0021',
                'name' => 'Penyesetan',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'SRV0022',
                'name' => 'Emergency Floating',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'SRV0023',
                'name' => 'Scraping',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'SRV0024',
                'name' => 'Blasting (Full Blasting)',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'SRV0025',
                'name' => 'Blasting (Soft Primer Material Baru)',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'SRV0026',
                'name' => 'Blasting (Sweep Blasting)',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'SRV0027',
                'name' => 'Coating',
                'ship_id' => NULL,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'SRV0028',
                'name' => 'Replating',
                'ship_id' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'SRV0029',
                'name' => 'Replating (Minimal Charge)',
                'ship_id' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'SRV0030',
                'name' => 'Rewelding',
                'ship_id' => 1,
                'branch_id' => 1,
                'user_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}