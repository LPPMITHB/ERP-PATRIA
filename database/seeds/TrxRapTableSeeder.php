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
                'total_price' => 117600000.0,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-01-15 09:56:21',
                'updated_at' => '2019-01-15 09:56:22',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'RAP-1900002',
                'project_id' => 2,
                'bom_id' => 4,
                'total_price' => 0.0,
                'user_id' => 1,
                'branch_id' => 1,
                'created_at' => '2019-02-27 14:53:58',
                'updated_at' => '2019-02-27 14:53:59',
            ),
        ));
        
        
    }
}