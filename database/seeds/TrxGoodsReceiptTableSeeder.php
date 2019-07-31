<?php

use Illuminate\Database\Seeder;

class TrxGoodsReceiptTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_goods_receipt')->delete();
        
        \DB::table('trx_goods_receipt')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'GR-1901000001',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 9,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:49:38',
                'updated_at' => '2019-07-29 16:49:38',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'GR-1901000002',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 13,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:50:16',
                'updated_at' => '2019-07-29 16:50:16',
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'GR-1901000003',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 13,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:50:45',
                'updated_at' => '2019-07-29 16:50:45',
            ),
            3 => 
            array (
                'id' => 4,
                'number' => 'GR-1901000004',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 9,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:51:26',
                'updated_at' => '2019-07-29 16:51:26',
            ),
            4 => 
            array (
                'id' => 5,
                'number' => 'GR-1901000005',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 14,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:59:24',
                'updated_at' => '2019-07-29 16:59:24',
            ),
            5 => 
            array (
                'id' => 6,
                'number' => 'GR-1901000006',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 14,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:59:37',
                'updated_at' => '2019-07-29 16:59:37',
            ),
            6 => 
            array (
                'id' => 7,
                'number' => 'GR-1901000007',
                'business_unit_id' => 1,
                'production_order_id' => NULL,
                'purchase_order_id' => 14,
                'work_order_id' => NULL,
                'vendor_id' => NULL,
                'ship_date' => NULL,
                'description' => '',
                'type' => 1,
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 2,
                'created_at' => '2019-07-29 16:59:45',
                'updated_at' => '2019-07-29 16:59:45',
            ),
        ));
        
        
    }
}