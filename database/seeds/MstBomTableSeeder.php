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
        
        \DB::table('mst_bom')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'BOM19040001',
                'description' => 'BOM Untuk BG. BENGKU',
                'project_id' => 5,
                'wbs_id' => NULL,
                'branch_id' => 2,
                'user_id' => 3,
                'status' => 1,
                'created_at' => '2019-04-12 10:06:11',
                'updated_at' => '2019-04-12 10:06:26',
            ),
        ));
        
        
    }
}