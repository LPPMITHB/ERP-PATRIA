<?php

use Illuminate\Database\Seeder;

class MstBomTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_bom')->delete();
        
        
    }
}