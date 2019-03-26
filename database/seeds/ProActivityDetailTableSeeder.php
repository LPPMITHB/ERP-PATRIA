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
                'quantity_material' => 2,
                'length' => 10.2,
                'width' => 14.3,
                'height' => 13.7,
                'weight' => 2997.42,
                'dimension_uom_id' => 1,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 1,
                'source' => 'Stock',
                'created_at' => '2019-03-22 14:48:29',
                'updated_at' => '2019-03-22 14:48:29',
            ),
            1 => 
            array (
                'id' => 2,
                'activity_id' => 46,
                'material_id' => 1,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => 2.0,
                'width' => 2.4,
                'height' => 10.2,
                'weight' => 36.72,
                'dimension_uom_id' => 1,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 1,
                'source' => 'Stock',
                'created_at' => '2019-03-22 14:49:00',
                'updated_at' => '2019-03-22 14:49:00',
            ),
            2 => 
            array (
                'id' => 3,
                'activity_id' => 45,
                'material_id' => NULL,
                'service_detail_id' => 1,
                'vendor_id' => 1,
                'quantity_material' => NULL,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => 10000.0,
                'area_uom_id' => 2,
                'bom_prep_id' => NULL,
                'source' => NULL,
                'created_at' => '2019-03-25 21:13:39',
                'updated_at' => '2019-03-25 21:13:39',
            ),
        ));
        
        
    }
}