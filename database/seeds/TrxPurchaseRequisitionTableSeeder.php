<?php

use Illuminate\Database\Seeder;

class TrxPurchaseRequisitionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trx_purchase_requisition')->delete();
        
        \DB::table('trx_purchase_requisition')->insert(array (
            0 => 
            array (
                'id' => 1,
                'number' => 'PR-1900001',
                'type' => 1,
                'valid_date' => '2019-01-22',
                'project_id' => 2,
                'bom_id' => 4,
                'purchase_requisition_id' => NULL,
                'description' => 'AUTO PR FOR PRO2-DUMMY2',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 5,
                'created_at' => '2019-01-15 09:57:54',
                'updated_at' => '2019-01-15 09:57:54',
            ),
            1 => 
            array (
                'id' => 2,
                'number' => 'PR-1900002',
                'type' => 1,
                'valid_date' => '2019-01-24',
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'description' => 'PR DUMMY 1',
                'status' => 1,
                'branch_id' => 2,
                'user_id' => 2,
                'created_at' => '2019-01-17 04:30:38',
                'updated_at' => '2019-01-17 04:30:38',
            ),
            2 => 
            array (
                'id' => 3,
                'number' => 'PR-1900003',
                'type' => 2,
                'valid_date' => '2019-01-24',
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
            'description' => 'PR DUMMY 2 (RESOURCE)',
                'status' => 1,
                'branch_id' => 2,
                'user_id' => 2,
                'created_at' => '2019-01-17 04:31:13',
                'updated_at' => '2019-01-17 04:31:13',
            ),
            3 => 
            array (
                'id' => 4,
                'number' => 'PR-1900004',
                'type' => 1,
                'valid_date' => '2019-01-24',
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'description' => 'PR DUMMY 3 -> PO',
                'status' => 7,
                'branch_id' => 2,
                'user_id' => 2,
                'created_at' => '2019-01-17 04:33:59',
                'updated_at' => '2019-01-17 04:35:15',
            ),
            4 => 
            array (
                'id' => 5,
                'number' => 'PR-1900005',
                'type' => 2,
                'valid_date' => '2019-01-24',
                'project_id' => 1,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'description' => 'PR DUMMY 4 -> PO',
                'status' => 7,
                'branch_id' => 2,
                'user_id' => 2,
                'created_at' => '2019-01-17 04:34:34',
                'updated_at' => '2019-01-17 04:35:44',
            ),
            5 => 
            array (
                'id' => 6,
                'number' => 'PR-1900006',
                'type' => 1,
                'valid_date' => '2019-01-24',
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'description' => 'PR DUMMY PAMI 1',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 3,
                'created_at' => '2019-01-17 04:40:37',
                'updated_at' => '2019-01-17 04:40:37',
            ),
            6 => 
            array (
                'id' => 7,
                'number' => 'PR-1900007',
                'type' => 2,
                'valid_date' => '2019-01-24',
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
            'description' => 'PR DUMMY PAMI 2 (RESOURCE)',
                'status' => 1,
                'branch_id' => 1,
                'user_id' => 3,
                'created_at' => '2019-01-17 04:41:15',
                'updated_at' => '2019-01-17 04:41:15',
            ),
            7 => 
            array (
                'id' => 8,
                'number' => 'PR-1900008',
                'type' => 1,
                'valid_date' => '2019-01-24',
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
                'description' => 'PR DUMMY PAMI 3 -> PO',
                'status' => 0,
                'branch_id' => 1,
                'user_id' => 3,
                'created_at' => '2019-01-17 04:42:14',
                'updated_at' => '2019-01-17 04:44:06',
            ),
            8 => 
            array (
                'id' => 9,
                'number' => 'PR-1900009',
                'type' => 2,
                'valid_date' => '2019-01-24',
                'project_id' => 2,
                'bom_id' => NULL,
                'purchase_requisition_id' => NULL,
            'description' => 'PR DUMMY PAMI 4 -> PO (RESOURCE)',
                'status' => 7,
                'branch_id' => 1,
                'user_id' => 3,
                'created_at' => '2019-01-17 04:42:47',
                'updated_at' => '2019-01-17 04:44:29',
            ),
        ));
        
        
    }
}