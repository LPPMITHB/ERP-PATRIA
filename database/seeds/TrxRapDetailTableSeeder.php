<?php

use Illuminate\Database\Seeder;

class TrxRapDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_rap_detail')->delete();
        
        \DB::table('trx_rap_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'rap_id' => 1,
                'material_id' => 18,
                'service_id' => NULL,
                'quantity' => 8,
                'price' => 68000000,
                'created_at' => '2019-01-15 09:56:22',
                'updated_at' => '2019-01-15 09:56:22',
            ),
            1 => 
            array (
                'id' => 2,
                'rap_id' => 1,
                'material_id' => 76,
                'service_id' => NULL,
                'quantity' => 124,
                'price' => 49600000,
                'created_at' => '2019-01-15 09:56:22',
                'updated_at' => '2019-01-15 09:56:22',
            ),
            2 => 
            array (
                'id' => 3,
                'rap_id' => 2,
                'material_id' => 30,
                'service_id' => NULL,
                'quantity' => 1351,
                'price' => 202650000,
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            3 => 
            array (
                'id' => 4,
                'rap_id' => 2,
                'material_id' => 54,
                'service_id' => NULL,
                'quantity' => 5,
                'price' => 750000,
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            4 => 
            array (
                'id' => 5,
                'rap_id' => 3,
                'material_id' => 5,
                'service_id' => NULL,
                'quantity' => 1243,
                'price' => 186450000,
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            5 => 
            array (
                'id' => 6,
                'rap_id' => 3,
                'material_id' => 6,
                'service_id' => NULL,
                'quantity' => 231,
                'price' => 50820000,
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            6 => 
            array (
                'id' => 7,
                'rap_id' => 4,
                'material_id' => 21,
                'service_id' => NULL,
                'quantity' => 6,
                'price' => 2100000000,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            7 => 
            array (
                'id' => 8,
                'rap_id' => 4,
                'material_id' => 5,
                'service_id' => NULL,
                'quantity' => 1351,
                'price' => 1013250000,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            8 => 
            array (
                'id' => 9,
                'rap_id' => 5,
                'material_id' => NULL,
                'service_id' => 2,
                'quantity' => 1,
                'price' => 12000,
                'created_at' => '2019-01-15 09:58:20',
                'updated_at' => '2019-01-15 09:58:20',
            ),
            9 => 
            array (
                'id' => 10,
                'rap_id' => 5,
                'material_id' => NULL,
                'service_id' => 9,
                'quantity' => 1,
                'price' => 12000,
                'created_at' => '2019-01-15 09:58:20',
                'updated_at' => '2019-01-15 09:58:20',
            ),
            10 => 
            array (
                'id' => 11,
                'rap_id' => 6,
                'material_id' => 63,
                'service_id' => NULL,
                'quantity' => 135,
                'price' => 74250000,
                'created_at' => '2019-01-15 09:58:45',
                'updated_at' => '2019-01-15 09:58:45',
            ),
            11 => 
            array (
                'id' => 12,
                'rap_id' => 6,
                'material_id' => NULL,
                'service_id' => 7,
                'quantity' => 1,
                'price' => 12000,
                'created_at' => '2019-01-15 09:58:46',
                'updated_at' => '2019-01-15 09:58:46',
            ),
        ));
        
        
    }
}