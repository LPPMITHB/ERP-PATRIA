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
                'quantity' => 8.0,
                'price' => 68000000.0,
                'created_at' => '2019-01-15 09:56:22',
                'updated_at' => '2019-01-15 09:56:22',
            ),
            1 => 
            array (
                'id' => 2,
                'rap_id' => 1,
                'material_id' => 76,
                'service_id' => NULL,
                'quantity' => 124.0,
                'price' => 49600000.0,
                'created_at' => '2019-01-15 09:56:22',
                'updated_at' => '2019-01-15 09:56:22',
            ),
            2 => 
            array (
                'id' => 3,
                'rap_id' => 2,
                'material_id' => 443,
                'service_id' => NULL,
                'quantity' => 1.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            3 => 
            array (
                'id' => 4,
                'rap_id' => 2,
                'material_id' => 132,
                'service_id' => NULL,
                'quantity' => 10.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            4 => 
            array (
                'id' => 5,
                'rap_id' => 2,
                'material_id' => 133,
                'service_id' => NULL,
                'quantity' => 5.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            5 => 
            array (
                'id' => 6,
                'rap_id' => 2,
                'material_id' => 134,
                'service_id' => NULL,
                'quantity' => 5.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            6 => 
            array (
                'id' => 7,
                'rap_id' => 2,
                'material_id' => 135,
                'service_id' => NULL,
                'quantity' => 5.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            7 => 
            array (
                'id' => 8,
                'rap_id' => 2,
                'material_id' => 460,
                'service_id' => NULL,
                'quantity' => 1.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            8 => 
            array (
                'id' => 9,
                'rap_id' => 2,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            9 => 
            array (
                'id' => 10,
                'rap_id' => 2,
                'material_id' => 109,
                'service_id' => NULL,
                'quantity' => 6.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            10 => 
            array (
                'id' => 11,
                'rap_id' => 2,
                'material_id' => 459,
                'service_id' => NULL,
                'quantity' => 6.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            11 => 
            array (
                'id' => 12,
                'rap_id' => 2,
                'material_id' => 415,
                'service_id' => NULL,
                'quantity' => 6.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
            12 => 
            array (
                'id' => 13,
                'rap_id' => 2,
                'material_id' => 107,
                'service_id' => NULL,
                'quantity' => 4.0,
                'price' => 0.0,
                'created_at' => '2019-02-27 14:53:59',
                'updated_at' => '2019-02-27 14:53:59',
            ),
        ));
        
        
    }
}