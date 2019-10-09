<?php

use Illuminate\Database\Seeder;

class MstPartDetailStandardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_part_detail_standard')->delete();
        
        \DB::table('mst_part_detail_standard')->insert(array (
            0 => 
            array (
                'id' => 1,
                'description' => 'S1',
                'material_standard_id' => 1,
                'dimensions_value' => '[{"name":"Length","uom_id":11,"value_input":"1,000"},{"name":"Width","uom_id":11,"value_input":"10"},{"name":"Height","uom_id":11,"value_input":"10"}]',
                'weight' => 0.79,
                'quantity' => 1,
                'created_at' => '2019-10-09 01:33:31',
                'updated_at' => '2019-10-09 01:33:31',
            ),
            1 => 
            array (
                'id' => 2,
                'description' => 'S2',
                'material_standard_id' => 1,
                'dimensions_value' => '[{"name":"Length","uom_id":11,"value_input":"100"},{"name":"Width","uom_id":11,"value_input":"10"},{"name":"Height","uom_id":11,"value_input":"1"}]',
                'weight' => 7.85,
                'quantity' => 1000,
                'created_at' => '2019-10-09 01:33:31',
                'updated_at' => '2019-10-09 01:33:31',
            ),
        ));
        
        
    }
}