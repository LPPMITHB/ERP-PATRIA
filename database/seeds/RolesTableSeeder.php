<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'ADMIN',
            'description' => 'All Access',
            'permissions' => json_encode([
                'show-dashboard' => true,
                'create-menu' => true,'index-menu' => true,'show-menu' => true,'edit-menu' => true,
                'create-user' => true,'index-user' => true,'show-user' => true,'edit-user' => true,'edit-password' => true,'change-role'=>true,'change-branch'=>true,'change-status'=>true,
                'create-permission' => true,'index-permission' => true,'show-permission' => true,'edit-permission' => true,
                'create-role' => true,'index-role' => true,'show-role' => true,'edit-role' => true,
                'create-ship' => true,'index-ship' => true,'show-ship' => true,'edit-ship' => true,
                'create-company' => true,'index-company' => true,'show-company' => true,'edit-company' => true,
                'create-storage-location' => true,'index-storage-location' => true,'show-storage-location' => true,'edit-storage-location' => true,
                'create-branch' => true,'index-branch' => true,'show-branch' => true,'edit-branch' => true,
                'create-business-unit' => true,'index-business-unit' => true,'show-business-unit' => true,'edit-business-unit' => true,
                'create-customer' => true,'index-customer' => true,'show-customer' => true,'edit-customer' => true,
                'create-currencies' => true,'index-currencies' => true,'show-currencies' => true,'edit-currencies' => true,
                'create-material' => true,'index-material' => true,'show-material' => true,'edit-material' => true,
                'create-resource' => true,'index-resource' => true,'show-resource' => true,'edit-resource' => true,
                'create-service' => true,'index-service' => true,'show-service' => true,'edit-service' => true,
                'create-unit-of-measurement' => true,'index-unit-of-measurement' => true,'show-unit-of-measurement' => true,'edit-unit-of-measurement' => true,
                'create-vendor' => true,'index-vendor' => true,'show-vendor' => true,'edit-vendor' => true,
                'create-bom' => true,'index-bom' => true,'show-bom' => true,'edit-bom' => true,
                'create-bom-repair' => true,'index-bom-repair' => true,'show-bom-repair' => true,'edit-bom-repair' => true,
                'create-bos' => true,'index-bos' => true,'show-bos' => true,'edit-bos' => true,
                'index-rap' => true,'show-rap' => true,'edit-rap' => true,
                'create-project' => true,'index-project' => true,'show-project' => true,'edit-project' => true,
                'create-project-repair' => true,'index-project-repair' => true,'show-project-repair' => true,'edit-project-repair' => true,
                'create-purchase-requisition' => true,'index-purchase-requisition' => true,'show-purchase-requisition' => true,'edit-purchase-requisition' => true,
                'create-purchase-order' => true,'index-purchase-order' => true,'show-purchase-order' => true,'edit-purchase-order' => true,
                'create-goods-movement' => true,'index-goods-movement' => true,'show-goods-movement' => true,'edit-goods-movement' => true,
                'create-production-order' => true,'index-production-order' => true,'show-production-order' => true,'edit-production-order' => true,
                'create-warehouse' => true,'index-warehouse' => true,'show-warehouse' => true,'edit-warehouse' => true,
                'create-yard' => true,'index-yard' => true,'show-yard' => true,'edit-yard' => true,
                'index-appearence' => true, 'edit-appearence' => true,
                'index-stock-management' => true, 
                'create-material-write-off' => true,

                ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'branch_id' => 1,
        ]);

        DB::table('roles')->insert([
            'name' => 'USER',
            'description' => 'No Access',
            'permissions' => json_encode([
                'show-dashboard' => true,
                'show-user' => true,'edit-user' => true,'change-role'=>true,
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            'branch_id' => 1,
        ]);

        DB::table('roles')->insert([
            'name' => 'CUSTOMER',
            'description' => 'Customer Access',
            'permissions' => json_encode([
                'show-dashboard' => true,
                'show-user' => true,'edit-user' => true,        
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('roles')->insert([
            'name' => 'PMP',
            'description' => 'PMP Access',
            'permissions' => json_encode([
                'show-dashboard' => true,
                'create-menu' => true,'index-menu' => true,'show-menu' => true,'edit-menu' => true,
                'create-user' => true,'index-user' => true,'show-user' => true,'edit-user' => true,'edit-password' => true,'change-role'=>true,'change-branch'=>true,'change-status'=>true,
                'create-permission' => true,'index-permission' => true,'show-permission' => true,'edit-permission' => true,
                'create-role' => true,'index-role' => true,'show-role' => true,'edit-role' => true,
                'create-ship' => true,'index-ship' => true,'show-ship' => true,'edit-ship' => true,
                'create-company' => true,'index-company' => true,'show-company' => true,'edit-company' => true,
                'create-storage-location' => true,'index-storage-location' => true,'show-storage-location' => true,'edit-storage-location' => true,
                'create-branch' => true,'index-branch' => true,'show-branch' => true,'edit-branch' => true,
                'create-business-unit' => true,'index-business-unit' => true,'show-business-unit' => true,'edit-business-unit' => true,
                'create-customer' => true,'index-customer' => true,'show-customer' => true,'edit-customer' => true,
                'create-currencies' => true,'index-currencies' => true,'show-currencies' => true,'edit-currencies' => true,
                'create-material' => true,'index-material' => true,'show-material' => true,'edit-material' => true,
                'create-resource' => true,'index-resource' => true,'show-resource' => true,'edit-resource' => true,
                'create-unit-of-measurement' => true,'index-unit-of-measurement' => true,'show-unit-of-measurement' => true,'edit-unit-of-measurement' => true,
                'create-vendor' => true,'index-vendor' => true,'show-vendor' => true,'edit-vendor' => true,
                'create-bom' => true,'index-bom' => true,'show-bom' => true,'edit-bom' => true,
                'index-rap' => true,'show-rap' => true,'edit-rap' => true,
                'create-project' => true,'index-project' => true,'show-project' => true,'edit-project' => true,
                'create-purchase-requisition' => true,'index-purchase-requisition' => true,'show-purchase-requisition' => true,'edit-purchase-requisition' => true,
                'create-purchase-order' => true,'index-purchase-order' => true,'show-purchase-order' => true,'edit-purchase-order' => true,
                'create-goods-movement' => true,'index-goods-movement' => true,'show-goods-movement' => true,'edit-goods-movement' => true,
                'create-production-order' => true,'index-production-order' => true,'show-production-order' => true,'edit-production-order' => true,
                'create-warehouse' => true,'index-warehouse' => true,'show-warehouse' => true,'edit-warehouse' => true,
                'create-yard' => true,'index-yard' => true,'show-yard' => true,'edit-yard' => true,
                'index-appearence' => true, 'edit-appearence' => true,
                'index-stock-management' => true, 
                'create-material-write-off' => true,      
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('roles')->insert([
            'name' => 'PAMI',
            'description' => 'PAMI Access',
            'permissions' => json_encode([
                'show-dashboard' => true,
                'create-menu' => true,'index-menu' => true,'show-menu' => true,'edit-menu' => true,
                'create-user' => true,'index-user' => true,'show-user' => true,'edit-user' => true,'edit-password' => true,'change-role'=>true,'change-branch'=>true,'change-status'=>true,
                'create-permission' => true,'index-permission' => true,'show-permission' => true,'edit-permission' => true,
                'create-role' => true,'index-role' => true,'show-role' => true,'edit-role' => true,
                'create-ship' => true,'index-ship' => true,'show-ship' => true,'edit-ship' => true,
                'create-company' => true,'index-company' => true,'show-company' => true,'edit-company' => true,
                'create-storage-location' => true,'index-storage-location' => true,'show-storage-location' => true,'edit-storage-location' => true,
                'create-branch' => true,'index-branch' => true,'show-branch' => true,'edit-branch' => true,
                'create-business-unit' => true,'index-business-unit' => true,'show-business-unit' => true,'edit-business-unit' => true,
                'create-customer' => true,'index-customer' => true,'show-customer' => true,'edit-customer' => true,
                'create-currencies' => true,'index-currencies' => true,'show-currencies' => true,'edit-currencies' => true,
                'create-material' => true,'index-material' => true,'show-material' => true,'edit-material' => true,
                'create-resource' => true,'index-resource' => true,'show-resource' => true,'edit-resource' => true,
                'create-service' => true,'index-service' => true,'show-service' => true,'edit-service' => true,
                'create-unit-of-measurement' => true,'index-unit-of-measurement' => true,'show-unit-of-measurement' => true,'edit-unit-of-measurement' => true,
                'create-vendor' => true,'index-vendor' => true,'show-vendor' => true,'edit-vendor' => true,
                'create-bom-repair' => true,'index-bom-repair' => true,'show-bom-repair' => true,'edit-bom-repair' => true,
                'create-project-repair' => true,'index-project-repair' => true,'show-project-repair' => true,'edit-project-repair' => true,
                'create-bos' => true,'index-bos' => true,'show-bos' => true,'edit-bos' => true,
                'create-warehouse' => true,'index-warehouse' => true,'show-warehouse' => true,'edit-warehouse' => true,
                'index-appearence' => true, 'edit-appearence' => true,
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}