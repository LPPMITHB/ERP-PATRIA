<?php

use Illuminate\Database\Seeder;

class MstServiceDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_service_detail')->delete();
        
        \DB::table('mst_service_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'service_id' => 1,
                'name' => 'Plate bottom',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'service_id' => 1,
                'name' => 'Plate Bilge / chine',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'service_id' => 1,
                'name' => 'Plate lambung',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'service_id' => 1,
                'name' => 'Plate deck',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'service_id' => 1,
                'name' => 'Plate sideboard/Bulwark',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'service_id' => 1,
                'name' => 'internal',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6461,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'service_id' => 1,
                'name' => 'Haluan dan internalnya',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'service_id' => 1,
                'name' => 'Corner dan internalnya',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6461,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'service_id' => 1,
                'name' => 'Roundbar bilga',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 6000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'service_id' => 2,
                'name' => 'Plate maks 5 kg',
                'uom_id' => 3,
            'description' => ' (Collard,Carling)',
                'cost_standard_price' => 30000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'service_id' => 2,
                'name' => 'Plate 5.5 kg s/d maks 10 kg',
                'uom_id' => 3,
            'description' => '(Bracket,Doubling)',
                'cost_standard_price' => 65000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'service_id' => 2,
                'name' => 'Plate 5.5 kg s/d maks 10 kg',
                'uom_id' => 3,
            'description' => '(Doubling/cropping Sideboard ,Maindeck,Hull)',
                'cost_standard_price' => 150000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'service_id' => 28,
                'name' => 'Plate bottom',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'service_id' => 28,
                'name' => 'Plate lambung',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'service_id' => 28,
                'name' => 'Plate Maindeck',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'service_id' => 28,
                'name' => 'Plate Bulwark',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'service_id' => 28,
                'name' => 'internal',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'service_id' => 28,
                'name' => 'Haluan dan internalnya',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'service_id' => 28,
                'name' => 'Corner dan internalnya',
                'uom_id' => 2,
                'description' => NULL,
                'cost_standard_price' => 7000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'service_id' => 29,
                'name' => 'Plate  5 kg s/d 30 kg',
                'uom_id' => 3,
            'description' => ' (Croping) faktor ketinggian',
                'cost_standard_price' => 250000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'service_id' => 29,
                'name' => 'Plate  5 kg s/d 30 kg',
                'uom_id' => 3,
            'description' => ' (Doubling)',
                'cost_standard_price' => 150000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'service_id' => 29,
                'name' => 'Plate maks 5 kg',
                'uom_id' => 3,
            'description' => ' (Collard,Carling)',
                'cost_standard_price' => 30000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'service_id' => 29,
                'name' => 'Plate 5.5 kg s/d maks 10 kg',
                'uom_id' => 3,
            'description' => ' (Bracket,Doubling)',
                'cost_standard_price' => 65000,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}