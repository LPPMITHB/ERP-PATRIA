<?php

use Illuminate\Database\Seeder;

class ProActivityDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pro_activity_detail')->delete();
        
        \DB::table('pro_activity_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'activity_id' => 45,
                'material_id' => 1,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 200,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'source' => 'Stock',
                'created_at' => '2019-03-18 10:35:00',
                'updated_at' => '2019-03-18 10:35:00',
            ),
            1 => 
            array (
                'id' => 2,
                'activity_id' => 45,
                'material_id' => 2,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 30,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'source' => 'Stock',
                'created_at' => '2019-03-18 10:35:00',
                'updated_at' => '2019-03-18 10:35:00',
            ),
            2 => 
            array (
                'id' => 4,
                'activity_id' => 45,
                'material_id' => 3030,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'source' => 'Stock',
                'created_at' => '2019-03-18 10:56:00',
                'updated_at' => '2019-03-18 10:56:00',
            ),
        ));
        
        
    }
}