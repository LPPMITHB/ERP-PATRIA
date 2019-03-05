<?php

use Illuminate\Database\Seeder;

class MstBomDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_bom_detail')->delete();
        
        \DB::table('mst_bom_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bom_id' => 1,
                'material_id' => 18,
                'service_id' => NULL,
                'quantity' => 8.0,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:21',
            ),
            1 => 
            array (
                'id' => 2,
                'bom_id' => 1,
                'material_id' => 76,
                'service_id' => NULL,
                'quantity' => 124.0,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:21',
            ),
            2 => 
            array (
                'id' => 3,
                'bom_id' => 2,
                'material_id' => 30,
                'service_id' => NULL,
                'quantity' => 1351.0,
                'source' => 'WIP',
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            3 => 
            array (
                'id' => 4,
                'bom_id' => 2,
                'material_id' => 54,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'WIP',
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:50',
            ),
            4 => 
            array (
                'id' => 5,
                'bom_id' => 3,
                'material_id' => 5,
                'service_id' => NULL,
                'quantity' => 1243.0,
                'source' => 'WIP',
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            5 => 
            array (
                'id' => 6,
                'bom_id' => 3,
                'material_id' => 6,
                'service_id' => NULL,
                'quantity' => 231.0,
                'source' => 'Stock',
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            6 => 
            array (
                'id' => 7,
                'bom_id' => 4,
                'material_id' => 443,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            7 => 
            array (
                'id' => 8,
                'bom_id' => 4,
                'material_id' => 132,
                'service_id' => NULL,
                'quantity' => 10.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            8 => 
            array (
                'id' => 9,
                'bom_id' => 4,
                'material_id' => 133,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            9 => 
            array (
                'id' => 10,
                'bom_id' => 4,
                'material_id' => 134,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            10 => 
            array (
                'id' => 11,
                'bom_id' => 4,
                'material_id' => 135,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            11 => 
            array (
                'id' => 12,
                'bom_id' => 4,
                'material_id' => 460,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            12 => 
            array (
                'id' => 13,
                'bom_id' => 4,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            13 => 
            array (
                'id' => 14,
                'bom_id' => 4,
                'material_id' => 109,
                'service_id' => NULL,
                'quantity' => 6.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            14 => 
            array (
                'id' => 15,
                'bom_id' => 4,
                'material_id' => 459,
                'service_id' => NULL,
                'quantity' => 6.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            15 => 
            array (
                'id' => 16,
                'bom_id' => 4,
                'material_id' => 415,
                'service_id' => NULL,
                'quantity' => 6.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            16 => 
            array (
                'id' => 17,
                'bom_id' => 4,
                'material_id' => 107,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:28:05',
                'updated_at' => '2019-02-26 11:28:05',
            ),
            17 => 
            array (
                'id' => 18,
                'bom_id' => 5,
                'material_id' => 425,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            18 => 
            array (
                'id' => 19,
                'bom_id' => 5,
                'material_id' => 120,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            19 => 
            array (
                'id' => 20,
                'bom_id' => 5,
                'material_id' => 123,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            20 => 
            array (
                'id' => 21,
                'bom_id' => 5,
                'material_id' => 125,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            21 => 
            array (
                'id' => 22,
                'bom_id' => 5,
                'material_id' => 135,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            22 => 
            array (
                'id' => 23,
                'bom_id' => 5,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            23 => 
            array (
                'id' => 24,
                'bom_id' => 5,
                'material_id' => 105,
                'service_id' => NULL,
                'quantity' => 3.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            24 => 
            array (
                'id' => 25,
                'bom_id' => 5,
                'material_id' => 108,
                'service_id' => NULL,
                'quantity' => 3.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            25 => 
            array (
                'id' => 26,
                'bom_id' => 5,
                'material_id' => 418,
                'service_id' => NULL,
                'quantity' => 3.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            26 => 
            array (
                'id' => 27,
                'bom_id' => 5,
                'material_id' => 106,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:35:21',
                'updated_at' => '2019-02-26 11:35:21',
            ),
            27 => 
            array (
                'id' => 28,
                'bom_id' => 6,
                'material_id' => 425,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            28 => 
            array (
                'id' => 29,
                'bom_id' => 6,
                'material_id' => 125,
                'service_id' => NULL,
                'quantity' => 15.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            29 => 
            array (
                'id' => 30,
                'bom_id' => 6,
                'material_id' => 123,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            30 => 
            array (
                'id' => 31,
                'bom_id' => 6,
                'material_id' => 134,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            31 => 
            array (
                'id' => 32,
                'bom_id' => 6,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            32 => 
            array (
                'id' => 33,
                'bom_id' => 6,
                'material_id' => 109,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            33 => 
            array (
                'id' => 34,
                'bom_id' => 6,
                'material_id' => 458,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            34 => 
            array (
                'id' => 35,
                'bom_id' => 6,
                'material_id' => 415,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:39:51',
                'updated_at' => '2019-02-26 11:39:51',
            ),
            35 => 
            array (
                'id' => 36,
                'bom_id' => 7,
                'material_id' => 452,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            36 => 
            array (
                'id' => 37,
                'bom_id' => 7,
                'material_id' => 120,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            37 => 
            array (
                'id' => 38,
                'bom_id' => 7,
                'material_id' => 119,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            38 => 
            array (
                'id' => 39,
                'bom_id' => 7,
                'material_id' => 129,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            39 => 
            array (
                'id' => 40,
                'bom_id' => 7,
                'material_id' => 125,
                'service_id' => NULL,
                'quantity' => 10.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            40 => 
            array (
                'id' => 41,
                'bom_id' => 7,
                'material_id' => 134,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            41 => 
            array (
                'id' => 42,
                'bom_id' => 7,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            42 => 
            array (
                'id' => 43,
                'bom_id' => 7,
                'material_id' => 106,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            43 => 
            array (
                'id' => 44,
                'bom_id' => 7,
                'material_id' => 108,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            44 => 
            array (
                'id' => 45,
                'bom_id' => 7,
                'material_id' => 418,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:44:50',
                'updated_at' => '2019-02-26 11:44:50',
            ),
            45 => 
            array (
                'id' => 46,
                'bom_id' => 8,
                'material_id' => 443,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            46 => 
            array (
                'id' => 47,
                'bom_id' => 8,
                'material_id' => 120,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            47 => 
            array (
                'id' => 48,
                'bom_id' => 8,
                'material_id' => 123,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            48 => 
            array (
                'id' => 49,
                'bom_id' => 8,
                'material_id' => 125,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            49 => 
            array (
                'id' => 50,
                'bom_id' => 8,
                'material_id' => 129,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            50 => 
            array (
                'id' => 51,
                'bom_id' => 8,
                'material_id' => 134,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            51 => 
            array (
                'id' => 52,
                'bom_id' => 8,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            52 => 
            array (
                'id' => 53,
                'bom_id' => 8,
                'material_id' => 105,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            53 => 
            array (
                'id' => 54,
                'bom_id' => 8,
                'material_id' => 106,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            54 => 
            array (
                'id' => 55,
                'bom_id' => 8,
                'material_id' => 415,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            55 => 
            array (
                'id' => 56,
                'bom_id' => 8,
                'material_id' => 108,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:49:40',
                'updated_at' => '2019-02-26 11:49:40',
            ),
            56 => 
            array (
                'id' => 57,
                'bom_id' => 9,
                'material_id' => 29,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            57 => 
            array (
                'id' => 58,
                'bom_id' => 9,
                'material_id' => 114,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            58 => 
            array (
                'id' => 59,
                'bom_id' => 9,
                'material_id' => 117,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            59 => 
            array (
                'id' => 60,
                'bom_id' => 9,
                'material_id' => 119,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            60 => 
            array (
                'id' => 61,
                'bom_id' => 9,
                'material_id' => 120,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            61 => 
            array (
                'id' => 62,
                'bom_id' => 9,
                'material_id' => 123,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            62 => 
            array (
                'id' => 63,
                'bom_id' => 9,
                'material_id' => 125,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            63 => 
            array (
                'id' => 64,
                'bom_id' => 9,
                'material_id' => 128,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            64 => 
            array (
                'id' => 65,
                'bom_id' => 9,
                'material_id' => 133,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            65 => 
            array (
                'id' => 66,
                'bom_id' => 9,
                'material_id' => 129,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            66 => 
            array (
                'id' => 67,
                'bom_id' => 9,
                'material_id' => 132,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            67 => 
            array (
                'id' => 68,
                'bom_id' => 9,
                'material_id' => 134,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            68 => 
            array (
                'id' => 69,
                'bom_id' => 9,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            69 => 
            array (
                'id' => 70,
                'bom_id' => 9,
                'material_id' => 105,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            70 => 
            array (
                'id' => 71,
                'bom_id' => 9,
                'material_id' => 108,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            71 => 
            array (
                'id' => 72,
                'bom_id' => 9,
                'material_id' => 109,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            72 => 
            array (
                'id' => 73,
                'bom_id' => 9,
                'material_id' => 418,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            73 => 
            array (
                'id' => 74,
                'bom_id' => 9,
                'material_id' => 107,
                'service_id' => NULL,
                'quantity' => 2.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 11:59:31',
                'updated_at' => '2019-02-26 11:59:31',
            ),
            74 => 
            array (
                'id' => 75,
                'bom_id' => 10,
                'material_id' => 426,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            75 => 
            array (
                'id' => 76,
                'bom_id' => 10,
                'material_id' => 128,
                'service_id' => NULL,
                'quantity' => 15.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            76 => 
            array (
                'id' => 77,
                'bom_id' => 10,
                'material_id' => 132,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            77 => 
            array (
                'id' => 78,
                'bom_id' => 10,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            78 => 
            array (
                'id' => 79,
                'bom_id' => 10,
                'material_id' => 106,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            79 => 
            array (
                'id' => 80,
                'bom_id' => 10,
                'material_id' => 108,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            80 => 
            array (
                'id' => 81,
                'bom_id' => 10,
                'material_id' => 415,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            81 => 
            array (
                'id' => 82,
                'bom_id' => 10,
                'material_id' => 105,
                'service_id' => NULL,
                'quantity' => 4.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:02:28',
                'updated_at' => '2019-02-26 12:02:28',
            ),
            82 => 
            array (
                'id' => 83,
                'bom_id' => 11,
                'material_id' => 452,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            83 => 
            array (
                'id' => 84,
                'bom_id' => 11,
                'material_id' => 129,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            84 => 
            array (
                'id' => 85,
                'bom_id' => 11,
                'material_id' => 125,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            85 => 
            array (
                'id' => 86,
                'bom_id' => 11,
                'material_id' => 120,
                'service_id' => NULL,
                'quantity' => 5.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            86 => 
            array (
                'id' => 87,
                'bom_id' => 11,
                'material_id' => 133,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            87 => 
            array (
                'id' => 88,
                'bom_id' => 11,
                'material_id' => 257,
                'service_id' => NULL,
                'quantity' => 1.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            88 => 
            array (
                'id' => 89,
                'bom_id' => 11,
                'material_id' => 106,
                'service_id' => NULL,
                'quantity' => 3.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            89 => 
            array (
                'id' => 90,
                'bom_id' => 11,
                'material_id' => 108,
                'service_id' => NULL,
                'quantity' => 3.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
            90 => 
            array (
                'id' => 91,
                'bom_id' => 11,
                'material_id' => 418,
                'service_id' => NULL,
                'quantity' => 3.0,
                'source' => 'Stock',
                'created_at' => '2019-02-26 12:05:37',
                'updated_at' => '2019-02-26 12:05:37',
            ),
        ));
        
        
    }
}