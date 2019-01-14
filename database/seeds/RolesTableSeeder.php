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
                'create-purchase-requisition' => true,'list-purchase-requisition' => true,'show-purchase-requisition' => true,'edit-purchase-requisition' => true,'approve-purchase-requisition' => true,'consolidation-purchase-requisition' => true,
                'create-purchase-requisition-repair' => true,'list-purchase-requisition-repair' => true,'show-purchase-requisition-repair' => true,'edit-purchase-requisition-repair' => true,'approve-purchase-requisition-repair' => true,'consolidation-purchase-requisition-repair' => true,
                'create-material-requisition' => true,'list-material-requisition' => true,'show-material-requisition' => true,'edit-material-requisition' => true,
                'create-material-requisition-repair' => true,'list-material-requisition-repair' => true,'show-material-requisition-repair' => true,'edit-material-requisition-repair' => true,
                'create-purchase-order' => true,'list-purchase-order' => true,'show-purchase-order' => true,'edit-purchase-order' => true,'approve-purchase-order' => true,
                'create-purchase-order-repair' => true,'list-purchase-order-repair' => true,'show-purchase-order-repair' => true,'edit-purchase-order-repair' => true,'approve-purchase-order-repair' => true,
                'create-goods-issue' => true,'list-goods-issue' => true,'show-goods-issue' => true,'edit-goods-issue' => true,
                'create-goods-issue-repair' => true,'list-goods-issue-repair' => true,'show-goods-issue-repair' => true,'edit-goods-issue-repair' => true,
                'create-goods-receipt' => true,'create-goods-receipt-without-ref' => true,'list-goods-receipt' => true,'show-goods-receipt' => true,
                'create-goods-receipt-repair' => true,'create-goods-receipt-without-ref-repair' => true,'list-goods-receipt-repair' => true,'show-goods-receipt-repair' => true,
                'create-goods-movement' => true,'list-goods-movement' => true,'view-goods-movement' => true,'edit-goods-movement' => true,
                'create-goods-movement-repair' => true,'list-goods-movement-repair' => true,'view-goods-movement-repair' => true,'edit-goods-movement-repair' => true,
                'create-snapshot' => true,'count-stock' => true,'adjust-stock' => true,'list-adjustment-history' => true,'show-adjustment-history' => true,'show-snapshot' => true, 
                'create-snapshot-repair' => true,'show-snapshot-repair' => true,'count-stock-repair' => true,'adjust-stock-repair' => true,'list-adjustment-history-repair' => true,'show-adjustment-history-repair' => true, 
                'create-production-order' => true,'list-production-order' => true,'show-production-order' => true,'edit-production-order' => true,
                'create-work-request' => true,'list-work-request' => true,'show-work-request' => true,'edit-work-request' => true,  'approve-work-request' => true,
                'create-work-request-repair' => true,'list-work-request-repair' => true,'show-work-request-repair' => true,'edit-work-request-repair' => true, 'approve-work-request-repair' => true,
                'create-work-order' => true,'list-work-order' => true,'show-work-order' => true,'edit-work-order' => true,  'approve-work-order' => true,
                'create-work-order-repair' => true,'list-work-order-repair' => true,'show-work-order-repair' => true,'edit-work-order-repair' => true,  'approve-work-order-repair' => true,
                'create-warehouse' => true,'list-warehouse' => true,'show-warehouse' => true,'edit-warehouse' => true,
                'create-yard' => true,'list-yard' => true,'show-yard' => true,'edit-yard' => true,
                'list-appearence' => true, 'edit-appearence' => true,
                'show-stock-management' => true, 
                'show-stock-management-repair' => true, 
                'create-material-write-off' => true,
                'create-material-write-off-repair' => true,
                'approve-material-requisition' => true,

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
                'create-purchase-requisition' => true,'list-purchase-requisition' => true,'show-purchase-requisition' => true,'edit-purchase-requisition' => true,'approve-purchase-requisition' => true,'consolidation-purchase-requisition' => true,
                'create-purchase-order' => true,'list-purchase-order' => true,'show-purchase-order' => true,'edit-purchase-order' => true,'approve-purchase-order' => true,
                'create-goods-movement' => true,'list-goods-movement' => true,'view-goods-movement' => true,'edit-goods-movement' => true,
                'create-work-order' => true,'list-work-order' => true,'show-work-order' => true,'edit-work-order' => true,  'approve-work-order' => true,
            ]),
            'created_at' => date('Y-m-d'),
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
                'create-purchase-requisition-repair' => true,'list-purchase-requisition-repair' => true,'show-purchase-requisition-repair' => true,'edit-purchase-requisition-repair' => true,'approve-purchase-requisition-repair' => true,'consolidation-purchase-requisition-repair' => true,
                'create-purchase-order-repair' => true,'list-purchase-order-repair' => true,'show-purchase-order-repair' => true,'edit-purchase-order-repair' => true,'approve-purchase-order-repair' => true,
                'create-goods-movement-repair' => true,'list-goods-movement-repair' => true,'view-goods-movement-repair' => true,'edit-goods-movement-repair' => true,
                'create-material-requisition-repair' => true,'list-material-requisition-repair' => true,'show-material-requisition-repair' => true,'edit-material-requisition-repair' => true,
                'create-goods-issue-repair' => true,'list-goods-issue-repair' => true,'show-goods-issue-repair' => true,'edit-goods-issue-repair' => true,
                'create-snapshot-repair' => true,'show-snapshot-repair' => true,'count-stock-repair' => true,'adjust-stock-repair' => true,'list-adjustment-history-repair' => true,'show-adjustment-history-repair' => true, 
                'create-work-request-repair' => true,'list-work-request-repair' => true,'show-work-request-repair' => true,'edit-work-request-repair' => true, 'approve-work-request-repair' => true,
                'create-material-write-off-repair' => true,
                'show-stock-management-repair' => true, 
                'create-goods-receipt-repair' => true,'create-goods-receipt-without-ref-repair' => true,'list-goods-receipt-repair' => true,'show-goods-receipt-repair' => true,
                'create-work-order-repair' => true,'list-work-order-repair' => true,'show-work-order-repair' => true,'edit-work-order-repair' => true,  'approve-work-order-repair' => true,
            ]),
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}