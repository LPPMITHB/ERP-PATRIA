<?php

use Illuminate\Database\Seeder;

class MstEstimatorCostStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_estimator_cost_standard')->delete();
        
        \DB::table('mst_estimator_cost_standard')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'ECS0001',
                'name' => 'Length',
                'description' => '',
                'uom_id' => 1,
                'estimator_wbs_id' => 1,
                'value' => 1000000,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:49:17',
                'updated_at' => '2019-08-19 19:49:17',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'ECS0002',
                'name' => 'Weight',
                'description' => '',
                'uom_id' => 2,
                'estimator_wbs_id' => 1,
                'value' => 500000,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:49:32',
                'updated_at' => '2019-08-19 19:49:32',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'ECS0003',
                'name' => '2 Layer',
                'description' => '',
                'uom_id' => 1,
                'estimator_wbs_id' => 2,
                'value' => 1000000,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:49:52',
                'updated_at' => '2019-08-19 19:49:52',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'ECS0004',
                'name' => 'Length',
                'description' => '',
                'uom_id' => 1,
                'estimator_wbs_id' => 3,
                'value' => 2000000,
                'status' => '1',
                'user_id' => 2,
                'branch_id' => 1,
                'created_at' => '2019-08-19 19:50:07',
                'updated_at' => '2019-08-19 19:50:07',
            ),
        ));
        
        
    }
}