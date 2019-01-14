<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Dashboard
        $dashboard = Menu::where('name','Dashboard')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Show Dashboard',
            'menu_id' => $dashboard,
            'middleware' => 'show-dashboard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        //Project
        $manageProject = Menu::where('name','Manage Projects')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Project',
            'menu_id' => $manageProject,
            'middleware' => 'list-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Project',
            'menu_id' => $manageProject,
            'middleware' => 'create-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Project',
            'menu_id' => $manageProject,
            'middleware' => 'show-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Project',
            'menu_id' => $manageProject,
            'middleware' => 'edit-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Project Repair
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $projectManagementRepair =  Menu::where('name','Project Management')->where('menu_id',$repair)->select('id')->first()->id;
        $manageProjectRepair = Menu::where('name','Manage Projects')->where('menu_id',$projectManagementRepair)->select('id')->first()->id;
        
        DB::table('permissions')->insert([
            'name' => 'List Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'list-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'create-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'show-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'edit-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //BOM
        $viewBOM = Menu::where('name','View BOM')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Bom',
            'menu_id' => $viewBOM,
            'middleware' => 'list-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $manageBOM = Menu::where('name','Manage BOM')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Manage Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'create-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'show-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'edit-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //BOM Repair
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $bomRepair =  Menu::where('name','BOM / BOS')->where('menu_id',$repair)->select('id')->first()->id;
        $manageBOMRepair = Menu::where('name','Manage BOM / BOS')->where('menu_id',$bomRepair)->select('id')->first()->id;
        $viewBOMRepair = Menu::where('name','View BOM / BOS')->where('menu_id',$bomRepair)->select('id')->first()->id;
        
        DB::table('permissions')->insert([
            'name' => 'List Bom Repair',
            'menu_id' => $viewBOMRepair,
            'middleware' => 'list-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Manage Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'create-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Bom Repair',
            'menu_id' => $viewBOMRepair,
            'middleware' => 'show-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'edit-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //RAP
        $viewRAP = Menu::where('name','Manage RAP')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'list-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'show-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'edit-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // create other cost
        $createOtherCost = Menu::where('name','Create Other Cost')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Other Cost',
            'menu_id' => $createOtherCost,
            'middleware' => 'create-other-cost',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // create actual other cost
        $inputActualOtherCost = Menu::where('name','Input Actual Other Cost')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Input Actual Other Cost',
            'menu_id' => $inputActualOtherCost,
            'middleware' => 'create-actual-other-cost',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // view planned cost
        $viewPlannedCost = Menu::where('name','View Planned Cost')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'View Planned Cost',
            'menu_id' => $viewPlannedCost,
            'middleware' => 'view-planned-cost',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // view material remaining
        $viewRemainingMaterial = Menu::where('name','View Remaining Material')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'View Remaining Material',
            'menu_id' => $viewRemainingMaterial,
            'middleware' => 'view-remaining-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $costPlanRepair =  Menu::where('name','Cost Plan')->where('menu_id',$repair)->select('id')->first()->id;
         //RAP repair
        $manageRAPRepair = Menu::where('name','Manage RAP')->where('menu_id',$costPlanRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Rap Repair',
            'menu_id' => $manageRAPRepair,
            'middleware' => 'list-rap-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Rap Repair',
            'menu_id' => $manageRAPRepair,
            'middleware' => 'show-rap-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Rap Repair',
            'menu_id' => $manageRAPRepair,
            'middleware' => 'edit-rap-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
 
         // create other cost repair
        $createOtherCost = Menu::where('name','Create Other Cost')->where('menu_id',$costPlanRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Other Cost Repair',
            'menu_id' => $createOtherCost,
            'middleware' => 'create-other-cost-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
 
        // create actual other cost repair
        $inputActualOtherCost = Menu::where('name','Input Actual Other Cost')->where('menu_id',$costPlanRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Input Actual Other Cost Repair',
            'menu_id' => $inputActualOtherCost,
            'middleware' => 'create-actual-other-cost-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // view planned cost repair
        $viewPlannedCost = Menu::where('name','View Planned Cost')->where('menu_id',$costPlanRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'View Planned Cost Repair',
            'menu_id' => $viewPlannedCost,
            'middleware' => 'view-planned-cost-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // view material remaining repair
        $viewRemainingMaterial = Menu::where('name','View Remaining Material')->where('menu_id',$costPlanRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'View Remaining Material Repair',
            'menu_id' => $viewRemainingMaterial,
            'middleware' => 'view-remaining-material-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Work Request
        $createWR = Menu::where('name','Create WR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Work Request',
            'menu_id' => $createWR,
            'middleware' => 'create-work-request',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approveWR = Menu::where('name','View & Edit WR')->select('id')->first()->id;        
        DB::table('permissions')->insert([
            'name' => 'Approve Work Request',
            'menu_id' => $approveWR,
            'middleware' => 'approve-work-request',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewWR = Menu::where('name','View & Edit WR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Work Request',
            'menu_id' => $viewWR,
            'middleware' => 'list-work-request',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Work Request',
            'menu_id' => $viewWR,
            'middleware' => 'show-work-request',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Work Request',
            'menu_id' => $viewWR,
            'middleware' => 'edit-work-request',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Work Order
        $createWO = Menu::where('name','Create WO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Work Order',
            'menu_id' => $createWO,
            'middleware' => 'create-work-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approveWO = Menu::where('name','View & Edit WO')->select('id')->first()->id;        
        DB::table('permissions')->insert([
            'name' => 'Approve Work Order',
            'menu_id' => $approveWO,
            'middleware' => 'approve-work-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewWO = Menu::where('name','View & Edit WO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Work Order',
            'menu_id' => $viewWO,
            'middleware' => 'list-work-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Work Order',
            'menu_id' => $viewWO,
            'middleware' => 'show-work-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Work Order',
            'menu_id' => $viewWO,
            'middleware' => 'edit-work-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Work Order Repair
        $wipRepair =  Menu::where('name','WIP')->where('menu_id',$repair)->select('id')->first()->id;
        $woRepair = Menu::where('name','Work Order')->where('menu_id',$wipRepair)->select('id')->first()->id;
        $createWO = Menu::where('name','Create WO')->where('menu_id',$woRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Work Order',
            'menu_id' => $createWO,
            'middleware' => 'create-work-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approveWO = Menu::where('name','View & Edit WO')->where('menu_id',$woRepair)->select('id')->first()->id;        
        DB::table('permissions')->insert([
            'name' => 'Approve Work Order',
            'menu_id' => $approveWO,
            'middleware' => 'approve-work-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewWO = Menu::where('name','View & Edit WO')->where('menu_id',$woRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Work Order',
            'menu_id' => $viewWO,
            'middleware' => 'list-work-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Work Order',
            'menu_id' => $viewWO,
            'middleware' => 'show-work-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Work Order',
            'menu_id' => $viewWO,
            'middleware' => 'edit-work-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Work Request Repair
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $wipRepair =  Menu::where('name','WIP')->where('menu_id',$repair)->select('id')->first()->id;
        $wrRepair = Menu::where('name','Work Request')->where('menu_id',$wipRepair)->select('id')->first()->id;
        $createWRRepair = Menu::where('name','Create WR')->where('menu_id',$wrRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Work Request',
            'menu_id' => $createWRRepair,
            'middleware' => 'create-work-request-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approveWRRepair = Menu::where('name','Approve WR')->where('menu_id',$wrRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Approve Work Request',
            'menu_id' => $approveWRRepair,
            'middleware' => 'approve-work-request-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewWRRepair = Menu::where('name','View & Edit WR')->where('menu_id',$wrRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Work Request',
            'menu_id' => $viewWRRepair,
            'middleware' => 'list-work-request-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Work Request',
            'menu_id' => $viewWRRepair,
            'middleware' => 'show-work-request-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Work Request',
            'menu_id' => $viewWRRepair,
            'middleware' => 'edit-work-request-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        

        //Purchase Requisition
        $createPR = Menu::where('name','Create PR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Purchase Requisition',
            'menu_id' => $createPR,
            'middleware' => 'create-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPR = Menu::where('name','View & Edit PR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'list-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'show-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'edit-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approvePR = Menu::where('name','Approve PR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Approve Purchase Requisition',
            'menu_id' => $approvePR,
            'middleware' => 'approve-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $consolidationPR = Menu::where('name','PR Consolidation')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Consolidation Purchase Requisition',
            'menu_id' => $consolidationPR,
            'middleware' => 'consolidation-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Purchase Requisition Repair
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $materialManagementRepair =  Menu::where('name','Material Management')->where('menu_id',$repair)->select('id')->first()->id;
        $prRepair = Menu::where('name','Purchase Requisition')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        $createPrRepair = Menu::where('name','Create PR')->where('menu_id',$prRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Purchase Requisition Repair',
            'menu_id' => $createPrRepair,
            'middleware' => 'create-purchase-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPrRepair = Menu::where('name','View & Edit PR')->where('menu_id',$prRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Purchase Requisition Repair',
            'menu_id' => $viewPrRepair,
            'middleware' => 'list-purchase-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Purchase Requisition Repair',
            'menu_id' => $viewPrRepair,
            'middleware' => 'show-purchase-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Purchase Requisition Repair',
            'menu_id' => $viewPrRepair,
            'middleware' => 'edit-purchase-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approvePrRepair = Menu::where('name','Approve PR')->where('menu_id',$prRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Approve Purchase Requisition Repair',
            'menu_id' => $approvePrRepair,
            'middleware' => 'approve-purchase-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $consolidationPrRepair = Menu::where('name','PR Consolidation')->where('menu_id',$prRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Consolidation Purchase Requisition Repair',
            'menu_id' => $consolidationPrRepair,
            'middleware' => 'consolidation-purchase-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Material Requisition
        $createMR = Menu::where('name','Create MR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Material Requisition',
            'menu_id' => $createMR,
            'middleware' => 'create-material-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approveMR = Menu::where('name','Approve MR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Approve Material Requisition',
            'menu_id' => $approveMR,
            'middleware' => 'approve-material-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewMR = Menu::where('name','View & Edit MR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Material Requisition',
            'menu_id' => $viewMR,
            'middleware' => 'list-material-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Material Requisition',
            'menu_id' => $viewMR,
            'middleware' => 'show-material-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Material Requisition',
            'menu_id' => $viewMR,
            'middleware' => 'edit-material-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $materialManagementRepair =  Menu::where('name','Material Management')->where('menu_id',$repair)->select('id')->first()->id;
        $mrRepair = Menu::where('name','Material Requisition')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        //Material Requisition Repair
        $createMRRepair = Menu::where('name','Create MR')->where('menu_id',$mrRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Material Requisition',
            'menu_id' => $createMRRepair,
            'middleware' => 'create-material-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $approveMRRepair = Menu::where('name','Approve MR')->where('menu_id',$mrRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Approve Material Requisition',
            'menu_id' => $approveMRRepair,
            'middleware' => 'approve-material-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewMRRepair = Menu::where('name','View & Edit MR')->where('menu_id',$mrRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Material Requisition',
            'menu_id' => $viewMRRepair,
            'middleware' => 'list-material-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Material Requisition',
            'menu_id' => $viewMRRepair,
            'middleware' => 'show-material-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Material Requisition',
            'menu_id' => $viewMRRepair,
            'middleware' => 'edit-material-requisition-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Purchase Order
        $createPO = Menu::where('name','Create PO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Purchase Order',
            'menu_id' => $createPO,
            'middleware' => 'create-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPO = Menu::where('name','View & Edit PO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'list-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'show-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'edit-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Approve Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'approve-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Purchase Order Repair
        $poRepair = Menu::where('name','Purchase Order')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        $createPO = Menu::where('name','Create PO')->where('menu_id',$poRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Purchase Order Repair',
            'menu_id' => $createPO,
            'middleware' => 'create-purchase-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPO = Menu::where('name','View & Edit PO')->where('menu_id',$poRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Purchase Order Repair',
            'menu_id' => $viewPO,
            'middleware' => 'list-purchase-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Purchase Order Repair',
            'menu_id' => $viewPO,
            'middleware' => 'show-purchase-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Purchase Order Repair',
            'menu_id' => $viewPO,
            'middleware' => 'edit-purchase-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPO = Menu::where('name','Approve PO')->where('menu_id',$poRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Approve Purchase Order Repair',
            'menu_id' => $viewPO,
            'middleware' => 'approve-purchase-order-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        //Goods Receipt
        $createGR = Menu::where('name','Create GR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Receipt',
            'menu_id' => $createGR,
            'middleware' => 'create-goods-receipt',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $createGRWOR = Menu::where('name','Create GR without reference')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Receipt Without Ref',
            'menu_id' => $createGRWOR,
            'middleware' => 'create-goods-receipt-without-ref',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewGR = Menu::where('name','View GR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Goods Receipt',
            'menu_id' => $viewGR,
            'middleware' => 'list-goods-receipt',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Goods Receipt',
            'menu_id' => $viewGR,
            'middleware' => 'show-goods-receipt',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Goods Receipt Repair
        $GRRepair = Menu::where('name','Goods Receipt')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        $createGRRepair = Menu::where('name','Create GR')->where('menu_id',$GRRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Receipt Repair',
            'menu_id' => $createGRRepair,
            'middleware' => 'create-goods-receipt-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $createGRWORRepair = Menu::where('name','Create GR without reference')->where('menu_id',$GRRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Receipt Without Ref Repair',
            'menu_id' => $createGRWORRepair,
            'middleware' => 'create-goods-receipt-without-ref-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewGRRepair = Menu::where('name','View GR')->where('menu_id',$GRRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Goods Receipt Repair',
            'menu_id' => $viewGRRepair,
            'middleware' => 'list-goods-receipt-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Goods Receipt Repair',
            'menu_id' => $viewGRRepair,
            'middleware' => 'show-goods-receipt-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Physical Inventory
        $createSnapshot = Menu::where('name','Snapshot')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Snapshot',
            'menu_id' => $createSnapshot,
            'middleware' => 'create-snapshot',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Snapshot',
            'menu_id' => $createSnapshot,
            'middleware' => 'show-snapshot',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $countStock = Menu::where('name','Count Stock')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Count Stock',
            'menu_id' => $countStock,
            'middleware' => 'count-stock',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $adjustStock = Menu::where('name','Adjust Stock')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Adjust Stock',
            'menu_id' => $adjustStock,
            'middleware' => 'adjust-stock',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewAdjustmentHistory = Menu::where('name','View Adjustment History')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'View Adjustment History',
            'menu_id' => $viewAdjustmentHistory,
            'middleware' => 'list-adjustment-history',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Adjustment History',
            'menu_id' => $viewAdjustmentHistory,
            'middleware' => 'show-adjustment-history',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Physical Inventory Repair
        $piRepair = Menu::where('name','Physical Inventory')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        $createSnapshot = Menu::where('name','Snapshot')->where('menu_id',$piRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Snapshot',
            'menu_id' => $createSnapshot,
            'middleware' => 'create-snapshot-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Snapshot',
            'menu_id' => $createSnapshot,
            'middleware' => 'show-snapshot-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $countStock = Menu::where('name','Count Stock')->where('menu_id',$piRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Count Stock',
            'menu_id' => $countStock,
            'middleware' => 'count-stock-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $adjustStock = Menu::where('name','Adjust Stock')->where('menu_id',$piRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Adjust Stock',
            'menu_id' => $adjustStock,
            'middleware' => 'adjust-stock-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewAdjustmentHistory = Menu::where('name','View Adjustment History')->where('menu_id',$piRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'View Adjustment History',
            'menu_id' => $viewAdjustmentHistory,
            'middleware' => 'list-adjustment-history-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Adjustment History',
            'menu_id' => $viewAdjustmentHistory,
            'middleware' => 'show-adjustment-history-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Goods Issue
        $createGI = Menu::where('name','Create GI')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Issue',
            'menu_id' => $createGI,
            'middleware' => 'create-goods-issue',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewGI = Menu::where('name','View & Edit PO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Goods Issue',
            'menu_id' => $viewGI,
            'middleware' => 'list-goods-issue',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Goods Issue',
            'menu_id' => $viewGI,
            'middleware' => 'show-goods-issue',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Goods Issue',
            'menu_id' => $viewGI,
            'middleware' => 'edit-goods-issue',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Goods Issue Repair
        $giRepair = Menu::where('name','Goods Issue')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        $createGI = Menu::where('name','Create GI')->where('menu_id',$giRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Issue',
            'menu_id' => $createGI,
            'middleware' => 'create-goods-issue-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewGIRepair = Menu::where('name','View GI')->where('menu_id',$giRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Goods Issue',
            'menu_id' => $viewGIRepair,
            'middleware' => 'list-goods-issue-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Goods Issue',
            'menu_id' => $viewGIRepair,
            'middleware' => 'show-goods-issue-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Goods Issue',
            'menu_id' => $viewGIRepair,
            'middleware' => 'edit-goods-issue-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Ship
        $ship = Menu::where('name','Ship')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Ship',
            'menu_id' => $ship,
            'middleware' => 'list-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Ship',
            'menu_id' => $ship,
            'middleware' => 'create-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Ship',
            'menu_id' => $ship,
            'middleware' => 'show-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Ship',
            'menu_id' => $ship,
            'middleware' => 'edit-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        //Master Data Branch
        $branch = Menu::where('name','Branch')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Branch',
            'menu_id' => $branch,
            'middleware' => 'list-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Branch',
            'menu_id' => $branch,
            'middleware' => 'create-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Branch',
            'menu_id' => $branch,
            'middleware' => 'show-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Branch',
            'menu_id' => $branch,
            'middleware' => 'edit-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Business Unit
        $businessUnit = Menu::where('name','Business Unit')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'list-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'create-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'show-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'edit-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // Master Data Company
        $company = Menu::where('name','Company')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Company',
            'menu_id' => $company,
            'middleware' => 'list-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Company',
            'menu_id' => $company,
            'middleware' => 'create-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Company',
            'menu_id' => $company,
            'middleware' => 'show-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Company',
            'menu_id' => $company,
            'middleware' => 'edit-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Storage Location
        $storageLocation = Menu::where('name','Storage Location')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'list-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'create-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'show-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'edit-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Customer
        $customer = Menu::where('name','Customer')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Customer',
            'menu_id' => $customer,
            'middleware' => 'list-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Customer',
            'menu_id' => $customer,
            'middleware' => 'create-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Customer',
            'menu_id' => $customer,
            'middleware' => 'show-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Customer',
            'menu_id' => $customer,
            'middleware' => 'edit-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Material
        $material = Menu::where('name','Material')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Material',
            'menu_id' => $material,
            'middleware' => 'list-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Material',
            'menu_id' => $material,
            'middleware' => 'create-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Material',
            'menu_id' => $material,
            'middleware' => 'show-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Material',
            'menu_id' => $material,
            'middleware' => 'edit-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Resource Management
        $resource = Menu::where('name','Manage Resource')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Resource',
            'menu_id' => $resource,
            'middleware' => 'list-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Resource',
            'menu_id' => $resource,
            'middleware' => 'create-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Resource',
            'menu_id' => $resource,
            'middleware' => 'show-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Resource',
            'menu_id' => $resource,
            'middleware' => 'edit-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Service
        $service = Menu::where('name','Service')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Service',
            'menu_id' => $service,
            'middleware' => 'list-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Service',
            'menu_id' => $service,
            'middleware' => 'create-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Service',
            'menu_id' => $service,
            'middleware' => 'show-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Service',
            'menu_id' => $service,
            'middleware' => 'edit-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Unit Of Measurement
        $uom = Menu::where('name','Unit Of Measurement')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'list-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'create-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'show-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'edit-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Vendor
        $vendor = Menu::where('name','Vendor')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Vendor',
            'menu_id' => $vendor,
            'middleware' => 'list-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Vendor',
            'menu_id' => $vendor,
            'middleware' => 'create-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Vendor',
            'menu_id' => $vendor,
            'middleware' => 'show-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Vendor',
            'menu_id' => $vendor,
            'middleware' => 'edit-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Warehouse
        $warehouse = Menu::where('name','Warehouse')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'list-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'create-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'show-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'edit-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Yard
        $yard = Menu::where('name','Yard')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List yard',
            'menu_id' => $yard,
            'middleware' => 'list-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Yard',
            'menu_id' => $yard,
            'middleware' => 'create-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Yard',
            'menu_id' => $yard,
            'middleware' => 'show-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Yard',
            'menu_id' => $yard,
            'middleware' => 'edit-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Menu
        $menu = Menu::where('name','Menus')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Menu',
            'menu_id' => $menu,
            'middleware' => 'list-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Menu',
            'menu_id' => $menu,
            'middleware' => 'create-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Menu',
            'menu_id' => $menu,
            'middleware' => 'show-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Menu',
            'menu_id' => $menu,
            'middleware' => 'edit-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Appearence
        $appearance = Menu::where('name','Appearance')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Appearence',
            'menu_id' => $appearance,
            'middleware' => 'list-appearence',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Appearence',
            'menu_id' => $appearance,
            'middleware' => 'edit-appearence',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Edit Default Password
        $cdp = Menu::where('name','Change Default Password')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Edit Default Password',
            'menu_id' => $cdp,
            'middleware' => 'edit-default-password',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Currencies
        $currencies = Menu::where('name','Currencies')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Currencies',
            'menu_id' => $currencies,
            'middleware' => 'list-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Currencies',
            'menu_id' => $currencies,
            'middleware' => 'create-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Currencies',
            'menu_id' => $currencies,
            'middleware' => 'edit-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Currencies',
            'menu_id' => $currencies,
            'middleware' => 'show-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data User
        $userManagement = Menu::where('name','User Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List User',
            'menu_id' => $userManagement,
            'middleware' => 'list-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create User',
            'menu_id' => $userManagement,
            'middleware' => 'create-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show User',
            'menu_id' => $userManagement,
            'middleware' => 'show-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit User',
            'menu_id' => $userManagement,
            'middleware' => 'edit-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Password',
            'menu_id' => $userManagement,
            'middleware' => 'edit-password',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Change Branch',
            'menu_id' => $userManagement,
            'middleware' => 'change-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Change Role',
            'menu_id' => $userManagement,
            'middleware' => 'change-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Change Status',
            'menu_id' => $userManagement,
            'middleware' => 'change-status',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Role
        $roleManagement = Menu::where('name','Role Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Role',
            'menu_id' => $roleManagement,
            'middleware' => 'list-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Role',
            'menu_id' => $roleManagement,
            'middleware' => 'create-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Role',
            'menu_id' => $roleManagement,
            'middleware' => 'show-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Role',
            'menu_id' => $roleManagement,
            'middleware' => 'edit-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Permission
        $permissionManagement = Menu::where('name','Permission Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'list-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'create-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'show-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'edit-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Stock Management
        $stockManagement = Menu::where('name','Stock Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Stock Management',
            'menu_id' => $stockManagement,
            'middleware' => 'show-stock-management',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Stock Management Repair
        $stockManagement = Menu::where('name','Stock Management')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Stock Management',
            'menu_id' => $stockManagement,
            'middleware' => 'show-stock-management-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Material Write Off
        $materialWriteOff = Menu::where('name','Material Write Off')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Material Write Off',
            'menu_id' => $materialWriteOff,
            'middleware' => 'create-material-write-off',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Material Write Off Repair
        $materialWriteOff = Menu::where('name','Material Write Off')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Material Write Off',
            'menu_id' => $materialWriteOff,
            'middleware' => 'create-material-write-off-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Goods Movement Permission
        $building =  Menu::where('name','Ship Building')->select('id')->first()->id;
        $materialManagement =  Menu::where('name','Material Management')->where('menu_id',$building)->select('id')->first()->id;
        $goodsMovement = Menu::where('name','Goods Movement')->where('menu_id',$materialManagement)->select('id')->first()->id;
        $createGm = Menu::where('name','Create GM')->where('menu_id',$goodsMovement)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Movement',
            'menu_id' => $createGm,
            'middleware' => 'create-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewGm = Menu::where('name','View GM')->where('menu_id',$goodsMovement)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Goods Movement',
            'menu_id' => $viewGm,
            'middleware' => 'list-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Goods Movement',
            'menu_id' => $viewGm,
            'middleware' => 'view-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Goods Movement Permission
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $materialManagementRepair =  Menu::where('name','Material Management')->where('menu_id',$repair)->select('id')->first()->id;
        $goodsMovementRepair = Menu::where('name','Goods Movement')->where('menu_id',$materialManagementRepair)->select('id')->first()->id;
        $createGmRepair = Menu::where('name','Create GM')->where('menu_id',$goodsMovementRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Goods Movement Repair',
            'menu_id' => $createGmRepair,
            'middleware' => 'create-goods-movement-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewGmRepair = Menu::where('name','View GM')->where('menu_id',$goodsMovementRepair)->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Goods Movement Repair',
            'menu_id' => $viewGmRepair,
            'middleware' => 'list-goods-movement-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'View Goods Movement Repair',
            'menu_id' => $viewGmRepair,
            'middleware' => 'view-goods-movement-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Production Order
        $createProductionOrder = Menu::where('name','Create Production Order')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'List Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'list-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'create-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'show-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'edit-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}

