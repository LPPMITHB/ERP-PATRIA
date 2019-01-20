<?php

use Illuminate\Database\Seeder;

class TrxRapTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_rap')->delete();
        
        \DB::table('trx_rap')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'RAP-1900001',
                'project_id' => 1,
                'bom_id' => 1,
                'total_price' => 117600000,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:22',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'RAP-1900002',
                'project_id' => 1,
                'bom_id' => 2,
                'total_price' => 203400000,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:56:50',
                'updated_at' => '2019-01-15 09:56:51',
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'RAP-1900003',
                'project_id' => 1,
                'bom_id' => 3,
                'total_price' => 237270000,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:57:19',
                'updated_at' => '2019-01-15 09:57:19',
            ),
            3 => 
            array (
                'id' => 4,
                'number' => 'RAP-1900004',
                'project_id' => 2,
                'bom_id' => 4,
                'total_price' => '3113250000',
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            4 => 
            array (
                'id' => 5,
                'number' => 'RAP-1900005',
                'project_id' => 2,
                'bom_id' => 5,
                'total_price' => 24000,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:58:20',
                'updated_at' => '2019-01-15 09:58:20',
            ),
            5 => 
            array (
                'id' => 6,
                'number' => 'RAP-1900006',
                'project_id' => 2,
                'bom_id' => 6,
                'total_price' => 74262000,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:58:45',
                'updated_at' => '2019-01-15 09:58:46',
            ),
        ));
        
        
    }
}