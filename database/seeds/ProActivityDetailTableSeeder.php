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
                'id' => 4,
                'activity_id' => 1,
                'material_id' => 1,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => 7110.0,
                'width' => 3650.0,
                'height' => 10.0,
                'weight' => 2037.19,
                'dimension_uom_id' => 11,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:35:34',
                'updated_at' => '2019-04-11 16:35:34',
            ),
            1 => 
            array (
                'id' => 6,
                'activity_id' => 3,
                'material_id' => 2,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 5,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 2,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:55:17',
                'updated_at' => '2019-04-11 16:55:17',
            ),
            2 => 
            array (
                'id' => 7,
                'activity_id' => 4,
                'material_id' => 257,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 3,
                'source' => 'Stock',
                'created_at' => '2019-04-11 16:56:22',
                'updated_at' => '2019-04-11 16:56:22',
            ),
            3 => 
            array (
                'id' => 8,
                'activity_id' => 5,
                'material_id' => 1,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => 1450.0,
                'width' => 700.0,
                'height' => 10.0,
                'weight' => 79.68,
                'dimension_uom_id' => 11,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:49:34',
                'updated_at' => '2019-04-11 23:49:34',
            ),
            4 => 
            array (
                'id' => 9,
                'activity_id' => 6,
                'material_id' => 53,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 4,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:50:55',
                'updated_at' => '2019-04-11 23:50:55',
            ),
            5 => 
            array (
                'id' => 10,
                'activity_id' => 7,
                'material_id' => 53,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 4,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:51:27',
                'updated_at' => '2019-04-11 23:51:27',
            ),
            6 => 
            array (
                'id' => 11,
                'activity_id' => 8,
                'material_id' => 1,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => 1450.0,
                'width' => 700.0,
                'height' => 10.0,
                'weight' => 79.68,
                'dimension_uom_id' => 11,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 1,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:53:31',
                'updated_at' => '2019-04-11 23:53:31',
            ),
            7 => 
            array (
                'id' => 13,
                'activity_id' => 9,
                'material_id' => 53,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 4,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:54:53',
                'updated_at' => '2019-04-11 23:54:53',
            ),
            8 => 
            array (
                'id' => 14,
                'activity_id' => 10,
                'material_id' => 2369,
                'service_detail_id' => NULL,
                'vendor_id' => NULL,
                'quantity_material' => 1,
                'length' => NULL,
                'width' => NULL,
                'height' => NULL,
                'weight' => NULL,
                'dimension_uom_id' => NULL,
                'area' => NULL,
                'area_uom_id' => NULL,
                'bom_prep_id' => 6,
                'source' => 'Stock',
                'created_at' => '2019-04-11 23:55:33',
                'updated_at' => '2019-04-11 23:55:33',
            ),
        ));
        
        
    }
}