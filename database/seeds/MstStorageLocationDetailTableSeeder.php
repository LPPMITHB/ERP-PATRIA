<?php

use Illuminate\Database\Seeder;

class MstStorageLocationDetailTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mst_storage_location_detail')->delete();
        
        \DB::table('mst_storage_location_detail')->insert(array (
            0 => 
            array (
                'id' => 1,
                'material_id' => 332,
                'quantity' => 200.0,
                'value' => 5000000.0,
                'goods_receipt_detail_id' => 1,
                'storage_location_id' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            1 => 
            array (
                'id' => 2,
                'material_id' => 2189,
                'quantity' => 200.0,
                'value' => 5000000.0,
                'goods_receipt_detail_id' => 2,
                'storage_location_id' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            2 => 
            array (
                'id' => 3,
                'material_id' => 399,
                'quantity' => 200.0,
                'value' => 5000000.0,
                'goods_receipt_detail_id' => 3,
                'storage_location_id' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
            3 => 
            array (
                'id' => 4,
                'material_id' => 306,
                'quantity' => 200.0,
                'value' => 5000000.0,
                'goods_receipt_detail_id' => 4,
                'storage_location_id' => 1,
                'created_at' => '2019-08-06 13:32:18',
                'updated_at' => '2019-08-06 13:32:18',
            ),
        ));
        
        
    }
}