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
                'edit-default-password' =>true,
                'create-menu' => true,'list-menu' => true,'show-menu' => true,'edit-menu' => true,
                'create-user' => true,'list-user' => true,'show-user' => true,'edit-user' => true,'edit-password' => true,'change-role'=>true,'change-branch'=>true,'change-status'=>true,
                'create-permission' => true,'list-permission' => true,'show-permission' => true,'edit-permission' => true,
                'create-role' => true,'list-role' => true,'show-role' => true,'edit-role' => true,
                'create-ship' => true,'list-ship' => true,'show-ship' => true,'edit-ship' => true,
                'create-company' => true,'list-company' => true,'show-company' => true,'edit-company' => true,
                'create-storage-location' => true,'list-storage-location' => true,'show-storage-location' => true,'edit-storage-location' => true,
                'create-branch' => true,'list-branch' => true,'show-branch' => true,'edit-branch' => true,
                'create-business-unit' => true,'list-business-unit' => true,'show-business-unit' => true,'edit-business-unit' => true,
                'create-customer' => true,'list-customer' => true,'show-customer' => true,'edit-customer' => true,
                'create-currencies' => true,'list-currencies' => true,'show-currencies' => true,'edit-currencies' => true,
                'create-material' => true,'list-material' => true,'show-material' => true,'edit-material' => true,
                'create-resource' => true,'list-resource' => true,'show-resource' => true,'edit-resource' => true,
                'create-service' => true,'list-service' => true,'show-service' => true,'edit-service' => true,
                'create-unit-of-measurement' => true,'list-unit-of-measurement' => true,'show-unit-of-measurement' => true,'edit-unit-of-measurement' => true,
                'create-vendor' => true,'list-vendor' => true,'show-vendor' => true,'edit-vendor' => true,
                'create-bom' => true,'list-bom' => true,'show-bom' => true,'edit-bom' => true,
                'create-bom-repair' => true,'list-bom-repair' => true,'show-bom-repair' => true,'edit-bom-repair' => true,
                'list-rap' => true,'show-rap' => true,'edit-rap' => true,
                'create-other-cost' => true,'create-actual-other-cost'=> true,'view-planned-cost' => true,'view-remaining-material' => true,
                'create-project' => true,'list-project' => true,'show-project' => true,'edit-project' => true,
                'create-project-repair' => true,'list-project-repair' => true,'show-project-repair' => true,'edit-project-repair' => true,
                'create-purchase-requisition' => true,'list-purchase-requisition' => true,'show-purchase-requisition' => true,'edit-purchase-requisition' => true,
                'create-purchase-order' => true,'list-purchase-order' => true,'show-purchase-order' => true,'edit-purchase-order' => true,
                'create-goods-movement' => true,'list-goods-movement' => true,'show-goods-movement' => true,'edit-goods-movement' => true,
                'create-production-order' => true,'list-production-order' => true,'show-production-order' => true,'edit-production-order' => true,
                'create-warehouse' => true,'list-warehouse' => true,'show-warehouse' => true,'edit-warehouse' => true,
                'create-yard' => true,'list-yard' => true,'show-yard' => true,'edit-yard' => true,
                'list-appearence' => true, 'edit-appearence' => true,
                'list-stock-management' => true, 
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
                'edit-default-password' =>true,
                'create-menu' => true,'list-menu' => true,'show-menu' => true,'edit-menu' => true,
                'create-user' => true,'list-user' => true,'show-user' => true,'edit-user' => true,'edit-password' => true,'change-role'=>true,'change-branch'=>true,'change-status'=>true,
                'create-permission' => true,'list-permission' => true,'show-permission' => true,'edit-permission' => true,
                'create-role' => true,'list-role' => true,'show-role' => true,'edit-role' => true,
                'create-ship' => true,'list-ship' => true,'show-ship' => true,'edit-ship' => true,
                'create-company' => true,'list-company' => true,'show-company' => true,'edit-company' => true,
                'create-branch' => true,'list-branch' => true,'show-branch' => true,'edit-branch' => true,
                'create-business-unit' => true,'list-business-unit' => true,'show-business-unit' => true,'edit-business-unit' => true,
                'create-customer' => true,'list-customer' => true,'show-customer' => true,'edit-customer' => true,
                'create-material' => true,'list-material' => true,'show-material' => true,'edit-material' => true,
                'create-bom' => true,'list-bom' => true,'show-bom' => true,'edit-bom' => true,
                'list-rap' => true,'show-rap' => true,'edit-rap' => true,
                'create-other-cost' => true,'create-actual-other-cost'=> true,'view-planned-cost' => true,'view-remaining-material' => true,
                'create-project' => true,'list-project' => true,'show-project' => true,'edit-project' => true,
                'list-appearence' => true, 'edit-appearence' => true,
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('roles')->insert([
            'name' => 'PAMI',
            'description' => 'PAMI Access',
            'permissions' => json_encode([
                'show-dashboard' => true,
                'edit-default-password' =>true,
                'create-menu' => true,'list-menu' => true,'show-menu' => true,'edit-menu' => true,
                'create-user' => true,'list-user' => true,'show-user' => true,'edit-user' => true,'edit-password' => true,'change-role'=>true,'change-branch'=>true,'change-status'=>true,
                'create-permission' => true,'list-permission' => true,'show-permission' => true,'edit-permission' => true,
                'create-role' => true,'list-role' => true,'show-role' => true,'edit-role' => true,
                'create-ship' => true,'list-ship' => true,'show-ship' => true,'edit-ship' => true,
                'create-company' => true,'list-company' => true,'show-company' => true,'edit-company' => true,
                'create-branch' => true,'list-branch' => true,'show-branch' => true,'edit-branch' => true,
                'create-business-unit' => true,'list-business-unit' => true,'show-business-unit' => true,'edit-business-unit' => true,
                'create-customer' => true,'list-customer' => true,'show-customer' => true,'edit-customer' => true,
                'create-material' => true,'list-material' => true,'show-material' => true,'edit-material' => true,
                'create-service' => true,'list-service' => true,'show-service' => true,'edit-service' => true,
                'create-bom-repair' => true,'list-bom-repair' => true,'show-bom-repair' => true,'edit-bom-repair' => true,
                'create-project-repair' => true,'list-project-repair' => true,'show-project-repair' => true,'edit-project-repair' => true,
                'list-appearence' => true, 'edit-appearence' => true,
                'list-rap-repair' => true,'show-rap-repair' => true,'edit-rap-repair' => true,
                'create-other-cost-repair' => true,'create-actual-other-cost-repair'=> true,'view-planned-cost-repair' => true,'view-remaining-material-repair' => true,
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}