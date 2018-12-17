<?php

use Illuminate\Database\Seeder;
use App\Models\Menu; 

class SidenavsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dashboard = Menu::where('route_name','index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $dashboard,
            'route_name' => '.index',
        ]);

        $manageProject = Menu::where('route_name','project.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.ganttChart',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'wbs.createWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'wbs.createSubWBS',
        ]);
    
        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'wbs.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.listWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'activity.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'activity.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'activity.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'activity.manageNetwork',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.projectCE',
        ]);

        $manageProjectRepair = Menu::where('route_name','project_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.ganttChart',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'wbs_repair.createWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'wbs_repair.createSubWBS',
        ]);
    
        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'wbs_repair.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.listWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'activity_repair.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'activity_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'activity_repair.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'activity_repair.manageNetwork',
        ]);


        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.projectCE',
        ]);

        $confirmActivityRepair = Menu::where('route_name','activity_repair.indexConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivityRepair,
            'route_name' => 'activity_repair.indexConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivityRepair,
            'route_name' => 'activity_repair.selectWbs',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivityRepair,
            'route_name' => 'activity_repair.confirmActivity',
        ]);

        $confirmActivityBuilding = Menu::where('route_name','activity.indexConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivityBuilding,
            'route_name' => 'activity.indexConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivityBuilding,
            'route_name' => 'activity.selectWbs',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivityBuilding,
            'route_name' => 'activity.confirmActivity',
        ]);

        $projectConfig = Menu::where('route_name','project.selectProjectConfig')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $projectConfig,
            'route_name' => 'project.selectProjectConfig',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $projectConfig,
            'route_name' => 'project.selectProjectConfig',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $projectConfig,
            'route_name' => 'project.configWbsEstimator',
        ]);

        $manageBos = Menu::where('route_name','bos.indexProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageBos,
            'route_name' => 'bos.indexProject',
        ]);

         DB::table('sidenav')->insert([
            'menu_id' => $manageBos,
            'route_name' => 'bos.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBos,
            'route_name' => 'bos.indexBos',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBos,
            'route_name' => 'bos.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBos,
            'route_name' => 'bos.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBos,
            'route_name' => 'bos.edit',
        ]);

        $manageBom = Menu::where('route_name','bom.indexProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.indexProject',
        ]);

         DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.indexBom',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.edit',
        ]);

        $assignBom = Menu::where('route_name','bom.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignBom,
            'route_name' => 'bom.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $assignBom,
            'route_name' => 'bom.assignBom',
        ]);

        // bom repair
        $manageBomRepair = Menu::where('route_name','bom_repair.indexProjectRepair')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageBomRepair,
            'route_name' => 'bom_repair.indexProject',
        ]);

         DB::table('sidenav')->insert([
            'menu_id' => $manageBomRepair,
            'route_name' => 'bom_repair.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBomRepair,
            'route_name' => 'bom_repair.indexBom',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBomRepair,
            'route_name' => 'bom_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBomRepair,
            'route_name' => 'bom_repair.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBomRepair,
            'route_name' => 'bom_repair.edit',
        ]);

        $assignBom = Menu::where('route_name','bom_repair.selectProjectRepair')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignBom,
            'route_name' => 'bom_repair.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $assignBom,
            'route_name' => 'bom_repair.assignBom',
        ]);

        $viewRap = Menu::where('route_name','rap.indexSelectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap.indexSelectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap.index',
        ]);

        $createCost = Menu::where('route_name','rap.selectProjectCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap.selectProjectCost',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap.createCost',
        ]);

        $inputActualOtherCost = Menu::where('route_name','rap.selectProjectActualOtherCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap.selectProjectActualOtherCost',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap.inputActualOtherCost',
        ]);

        $viewPlannedCost = Menu::where('route_name','rap.selectProjectViewCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap.selectProjectViewCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap.viewPlannedCost',
        ]);

        $viewRemainingMaterial = Menu::where('route_name','rap.selectProjectViewRM')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRemainingMaterial,
            'route_name' => 'rap.selectProjectViewRM',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRemainingMaterial,
            'route_name' => 'rap.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRemainingMaterial,
            'route_name' => 'rap.showMaterialEvaluation',
        ]);

        // repair
        $viewRap = Menu::where('route_name','rap_repair.indexSelectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap_repair.indexSelectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap_repair.index',
        ]);

        $createCost = Menu::where('route_name','rap_repair.selectProjectCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap_repair.selectProjectCost',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap_repair.createCost',
        ]);

        $inputActualOtherCost = Menu::where('route_name','rap_repair.selectProjectActualOtherCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap_repair.selectProjectActualOtherCost',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap_repair.inputActualOtherCost',
        ]);

        $viewPlannedCost = Menu::where('route_name','rap_repair.selectProjectViewCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap_repair.selectProjectViewCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap_repair.viewPlannedCost',
        ]);

        $viewRemainingMaterial = Menu::where('route_name','rap_repair.selectProjectViewRM')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRemainingMaterial,
            'route_name' => 'rap_repair.selectProjectViewRM',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRemainingMaterial,
            'route_name' => 'rap_repair.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRemainingMaterial,
            'route_name' => 'rap_repair.showMaterialEvaluation',
        ]);

        $createPr = Menu::where('route_name','purchase_requisition.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPr,
            'route_name' => 'purchase_requisition.create',
        ]);

        $indexApprovePR = Menu::where('route_name','purchase_requisition.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePR,
            'route_name' => 'purchase_requisition.indexApprove',
        ]);

        $viewPr = Menu::where('route_name','purchase_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.index',
        ]);

        $createPo = Menu::where('route_name','purchase_order.selectPR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order.selectPR',
        ]);

        $indexApprovePO = Menu::where('route_name','purchase_order.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order.indexApprove',
        ]);

        $viewPo = Menu::where('route_name','purchase_order.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order.index',
        ]);

        $createGiWithRef = Menu::where('route_name','goods_issue.createGiWithRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGiWithRef,
            'route_name' => 'goods_issue.createGiWithRef',
        ]);

        /* $createGiWithoutRef = Menu::where('route_name','goods_issue.createGiWithoutRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGiWithoutRef,
            'route_name' => 'goods_issue.createGiWithoutRef',
        ]); */

        $viewGi = Menu::where('route_name','goods_issue.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGi,
            'route_name' => 'goods_issue.index',
        ]);

        $viewGr = Menu::where('route_name','goods_receipt.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGr,
            'route_name' => 'goods_receipt.index',
        ]);

        $createMrManually = Menu::where('route_name','material_requisition.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createMrManually,
            'route_name' => 'material_requisition.create',
        ]);

        $indexApproveMR = Menu::where('route_name','material_requisition.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMR,
            'route_name' => 'material_requisition.indexApprove',
        ]);

        $viewMr = Menu::where('route_name','material_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewMr,
            'route_name' => 'material_requisition.index',
        ]);
        
        $createGrWithRef = Menu::where('route_name','goods_receipt.createGrWithRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGrWithRef,
            'route_name' => 'goods_receipt.createGrWithRef',
        ]);

        // $createGrWithoutRef = Menu::where('route_name','goods_receipt.createGrWithoutRef')->select('id')->first()->id;
        // DB::table('sidenav')->insert([
        //     'menu_id' => $createGrWithoutRef,
        //     'route_name' => 'goods_receipt.createGrWithoutRef',
        // ]);
        
        $snapshot = Menu::where('route_name','physical_inventory.indexSnapshot')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $snapshot,
            'route_name' => 'physical_inventory.indexSnapshot',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $snapshot,
            'route_name' => 'physical_inventory.displaySnapshot',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $snapshot,
            'route_name' => 'physical_inventory.showSnapshot',
        ]);

        $countStock = Menu::where('route_name','physical_inventory.indexCountStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $countStock,
            'route_name' => 'physical_inventory.indexCountStock',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $countStock,
            'route_name' => 'physical_inventory.countStock',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $countStock,
            'route_name' => 'physical_inventory.showCountStock',
        ]);

        $adjustStock = Menu::where('route_name','physical_inventory.indexAdjustStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStock,
            'route_name' => 'physical_inventory.indexAdjustStock',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStock,
            'route_name' => 'physical_inventory.showConfirmCountStock',
        ]);

        $materialWriteOff = Menu::where('route_name','material_write_off.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOff,
            'route_name' => 'material_write_off.create',
        ]);

        $goodsMovementIndex = Menu::where('route_name','goods_movement.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $goodsMovementIndex,
            'route_name' => 'goods_movement.index',
        ]);

        $createProductionOrder = Menu::where('route_name','production_order.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createProductionOrder,
            'route_name' => 'production_order.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createProductionOrder,
            'route_name' => 'production_order.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createProductionOrder,
            'route_name' => 'production_order.create',
        ]);

        $releaseProductionOrder = Menu::where('route_name','production_order.selectProjectRelease')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order.selectProjectRelease',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order.selectWO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order.release',
        ]);

        $confirmProductionOrder = Menu::where('route_name','production_order.selectProjectConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.selectProjectConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.confirmWO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.confirm',
        ]);

        $reportProductionOrder = Menu::where('route_name','production_order.selectProjectReport')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order.selectProjectReport',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order.selectWOReport',
        ]);

        $show = Menu::where('name','Production Planning & Execution')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $show,
            'route_name' => 'production_order.index',
        ]);

        $yardPlan = Menu::where('route_name','yard_plan.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yardPlan,
            'route_name' => 'yard_plan.index',
        ]);

        
        $ship = Menu::where('route_name','ship.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.index',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.edit',
        ]);

        $branch = Menu::where('route_name','branch.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.edit',
        ]);

        $business_unit = Menu::where('route_name','business_unit.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $business_unit,
            'route_name' => 'business_unit.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $business_unit,
            'route_name' => 'business_unit.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $business_unit,
            'route_name' => 'business_unit.edit',
        ]);
        
        $company = Menu::where('route_name','company.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.index',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.edit',
        ]);

        $storageLocation = Menu::where('route_name','storage_location.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.edit',
        ]);

        $customer = Menu::where('route_name','customer.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.edit',
        ]);

        $material = Menu::where('route_name','material.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.edit',
        ]);

        $uom = Menu::where('route_name','unit_of_measurement.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $uom,
            'route_name' => 'unit_of_measurement.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $uom,
            'route_name' => 'unit_of_measurement.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $uom,
            'route_name' => 'unit_of_measurement.edit',
        ]);

        $vendor = Menu::where('route_name','vendor.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.edit',
        ]);

        $warehouse = Menu::where('route_name','warehouse.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $warehouse,
            'route_name' => 'warehouse.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $warehouse,
            'route_name' => 'warehouse.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $warehouse,
            'route_name' => 'warehouse.edit',
        ]);

        $yard = Menu::where('route_name','yard.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yard,
            'route_name' => 'yard.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $yard,
            'route_name' => 'yard.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $yard,
            'route_name' => 'yard.edit',
        ]);

        $menus = Menu::where('route_name','menus.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.edit',
        ]);

        $appearance = Menu::where('route_name','appearance.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $appearance,
            'route_name' => 'appearance.index',
        ]);

        $changeDefaultPassword = Menu::where('route_name','user.changeDefaultPassword')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $changeDefaultPassword,
            'route_name' => 'user.changeDefaultPassword',
        ]);

        $user = Menu::where('route_name','user.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.change_password',
        ]);

        $role = Menu::where('route_name','role.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.edit',
        ]);

        $permission = Menu::where('route_name','permission.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.edit',
        ]);

        $stockManagement = Menu::where('route_name','stock_management.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $stockManagement,
            'route_name' => 'stock_management.index',
        ]);

        $manageResource = Menu::where('route_name','resource.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.edit',
        ]);

        $manageService = Menu::where('route_name','service.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageService,
            'route_name' => 'service.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageService,
            'route_name' => 'service.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageService,
            'route_name' => 'service.edit',
        ]);

        $assignResource = Menu::where('route_name','resource.assignResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignResource,
            'route_name' => 'resource.assignResource',
        ]); 
         
        $yardPlan = Menu::where('route_name','yard_plan.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yardPlan,
            'route_name' => 'yard_plan.index',
        ]);

        $currencies = Menu::where('route_name','currencies.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.edit',
        ]);
    }
}
