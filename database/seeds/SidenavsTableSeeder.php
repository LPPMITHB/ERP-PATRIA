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
            'route_name' => 'project.indexCopyProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.copyProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.copyProjectStructure',
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
            'route_name' => 'project_repair.indexCopyProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProjectRepair,
            'route_name' => 'project_repair.copyProject',
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

        $wbsProfile = Menu::where('route_name','wbs.createWbsProfile')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $wbsProfile,
            'route_name' => 'wbs.createWbsProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsProfile,
            'route_name' => 'wbs.createSubWbsProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsProfile,
            'route_name' => 'activity.createActivityProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsProfile,
            'route_name' => 'wbs.createBomProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsProfile,
            'route_name' => 'wbs.createResourceProfile',
        ]);

        // $wbsProfileRepair = Menu::where('route_name','wbs_repair.createWbsProfile')->select('id')->first()->id;
        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsProfileRepair,
        //     'route_name' => 'wbs_repair.createWbsProfile',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsProfileRepair,
        //     'route_name' => 'wbs_repair.createSubWbsProfile',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsProfileRepair,
        //     'route_name' => 'activity_repair.createActivityProfile',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsProfileRepair,
        //     'route_name' => 'wbs_repair.createBomProfile',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsProfileRepair,
        //     'route_name' => 'wbs_repair.createResourceProfile',
        // ]);

        $wbsConfigRepair = Menu::where('route_name','wbs_repair.createWbsConfiguration')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $wbsConfigRepair,
            'route_name' => 'wbs_repair.createWbsConfiguration',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsConfigRepair,
            'route_name' => 'wbs_repair.createSubWbsConfiguration',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsConfigRepair,
            'route_name' => 'activity_repair.createActivityConfiguration',
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

        $viewBom = Menu::where('route_name','bom.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewBom,
            'route_name' => 'bom.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewBom,
            'route_name' => 'bom.indexBom',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewBom,
            'route_name' => 'bom.show',
        ]);

        // bom repair
        $summaryMaterialRepair = Menu::where('route_name','bom_repair.selectProjectSum')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $summaryMaterialRepair,
            'route_name' => 'bom_repair.selectProjectSum',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $summaryMaterialRepair,
            'route_name' => 'bom_repair.materialSummary',
        ]);

        $viewBom = Menu::where('route_name','bom_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewBom,
            'route_name' => 'bom_repair.index',
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

        // WR
        $createWr = Menu::where('route_name','work_request.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWr,
            'route_name' => 'work_request.create',
        ]);

        $indexApproveWR = Menu::where('route_name','work_request.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWR,
            'route_name' => 'work_request.indexApprove',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWR,
            'route_name' => 'work_request.showApprove',
        ]);

        $viewWr = Menu::where('route_name','work_request.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWr,
            'route_name' => 'work_request.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewWr,
            'route_name' => 'work_request.edit',
        ]);


        // WR REPAIR
        $createWrRepair = Menu::where('route_name','work_request_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWrRepair,
            'route_name' => 'work_request_repair.create',
        ]);

        $indexApproveWRRepair = Menu::where('route_name','work_request_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWRRepair,
            'route_name' => 'work_request_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWRRepair,
            'route_name' => 'work_request_repair.showApprove',
        ]);

        $viewWrRepair = Menu::where('route_name','work_request_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWrRepair,
            'route_name' => 'work_request_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewWrRepair,
            'route_name' => 'work_request_repair.edit',
        ]);

        // Purchase Requisition
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

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePR,
            'route_name' => 'purchase_requisition.showApprove',
        ]);

        $viewPr = Menu::where('route_name','purchase_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.index',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.edit',
        ]);

        $indexConsolidation = Menu::where('route_name','purchase_requisition.indexConsolidation')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexConsolidation,
            'route_name' => 'purchase_requisition.indexConsolidation',
        ]);

        // Purchase Requisition Repair
        $createPrRepair = Menu::where('route_name','purchase_requisition_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPrRepair,
            'route_name' => 'purchase_requisition_repair.create',
        ]);

        $indexApprovePRRepair = Menu::where('route_name','purchase_requisition_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePRRepair,
            'route_name' => 'purchase_requisition_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePRRepair,
            'route_name' => 'purchase_requisition_repair.showApprove',
        ]);

        $viewPr = Menu::where('route_name','purchase_requisition_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition_repair.index',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition_repair.edit',
        ]);

        $indexConsolidation = Menu::where('route_name','purchase_requisition_repair.indexConsolidation')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexConsolidation,
            'route_name' => 'purchase_requisition_repair.indexConsolidation',
        ]);

        // Purchase Order
        $createPo = Menu::where('route_name','purchase_order.selectPR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order.selectPR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order.selectPRD',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order.create',
        ]);

        $indexApprovePO = Menu::where('route_name','purchase_order.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order.showApprove',
        ]);

        $viewPo = Menu::where('route_name','purchase_order.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order.edit',
        ]);

        // Purchase Order Repair
        $createPo = Menu::where('route_name','purchase_order_repair.selectPR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order_repair.selectPR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order_repair.selectPRD',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order_repair.create',
        ]);

        $indexApprovePO = Menu::where('route_name','purchase_order_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order_repair.showApprove',
        ]);

        $viewPo = Menu::where('route_name','purchase_order_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order_repair.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order_repair.edit',
        ]);

        // Goods Receipt
        $selectPO = Menu::where('route_name','goods_receipt.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_receipt.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_receipt.createGrWithRef',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_receipt.createGrFromWo',
        ]);
        
        $viewGr = Menu::where('route_name','goods_receipt.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGr,
            'route_name' => 'goods_receipt.index',
        ]);

        $createGrWithoutRef = Menu::where('route_name','goods_receipt.createGrWithoutRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGrWithoutRef,
            'route_name' => 'goods_receipt.createGrWithoutRef',
        ]);

        // Goods Receipt Repair
        $selectPORepair = Menu::where('route_name','goods_receipt_repair.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_receipt_repair.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_receipt_repair.createGrWithRef',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_receipt_repair.createGrFromWo',
        ]);
        
        $viewGrRepair = Menu::where('route_name','goods_receipt_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGrRepair,
            'route_name' => 'goods_receipt_repair.index',
        ]);

        $createGrWithoutRefRepair = Menu::where('route_name','goods_receipt_repair.createGrWithoutRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGrWithoutRefRepair,
            'route_name' => 'goods_receipt_repair.createGrWithoutRef',
        ]);

        // Goods Return
        $selectGR = Menu::where('route_name','goods_return.selectGR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectGR,
            'route_name' => 'goods_return.selectGR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectGR,
            'route_name' => 'goods_return.createGoodsReturnGR',
        ]);

        $selectPO = Menu::where('route_name','goods_return.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_return.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_return.createGoodsReturnPO',
        ]);

        $viewReturn = Menu::where('route_name','goods_return.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewReturn,
            'route_name' => 'goods_return.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewReturn,
            'route_name' => 'goods_return.edit',
        ]);

        $indexApproveGReturn = Menu::where('route_name','goods_return.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturn,
            'route_name' => 'goods_return.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturn,
            'route_name' => 'goods_return.showApprove',
        ]);

        $selectGRRepair = Menu::where('route_name','goods_return_repair.selectGR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectGRRepair,
            'route_name' => 'goods_return_repair.selectGR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectGRRepair,
            'route_name' => 'goods_return_repair.createGoodsReturnGR',
        ]);

        $selectPORepair = Menu::where('route_name','goods_return_repair.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_return_repair.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_return_repair.createGoodsReturnPO',
        ]);

        $viewReturnRepair = Menu::where('route_name','goods_return_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewReturnRepair,
            'route_name' => 'goods_return_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewReturnRepair,
            'route_name' => 'goods_return_repair.edit',
        ]);

        $indexApproveGReturnRepair = Menu::where('route_name','goods_return_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturnRepair,
            'route_name' => 'goods_return_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturnRepair,
            'route_name' => 'goods_return_repair.showApprove',
        ]);

        //Goods Issue
        $selectMR = Menu::where('route_name','goods_issue.selectMR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectMR,
            'route_name' => 'goods_issue.selectMR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectMR,
            'route_name' => 'goods_issue.createGiWithRef',
        ]); 

        $viewGi = Menu::where('route_name','goods_issue.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGi,
            'route_name' => 'goods_issue.index',
        ]);

        $selectMRRepair = Menu::where('route_name','goods_issue_repair.selectMR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectMRRepair,
            'route_name' => 'goods_issue_repair.selectMR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectMRRepair,
            'route_name' => 'goods_issue_repair.createGiWithRef',
        ]); 

        $viewGiRepair = Menu::where('route_name','goods_issue_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGiRepair,
            'route_name' => 'goods_issue_repair.index',
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

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMR,
            'route_name' => 'material_requisition.showApprove',
        ]);

        $viewMr = Menu::where('route_name','material_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewMr,
            'route_name' => 'material_requisition.index',
        ]);

        $createMrRepairManually = Menu::where('route_name','material_requisition_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createMrRepairManually,
            'route_name' => 'material_requisition_repair.create',
        ]);

        $indexApproveMRRepair = Menu::where('route_name','material_requisition_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMRRepair,
            'route_name' => 'material_requisition_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMRRepair,
            'route_name' => 'material_requisition_repair.showApprove',
        ]);

        $viewMrRepair = Menu::where('route_name','material_requisition_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewMrRepair,
            'route_name' => 'material_requisition_repair.index',
        ]);
        
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

        $viewAdjustmentHistory = Menu::where('route_name','physical_inventory.viewAdjustmentHistory')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistory,
            'route_name' => 'physical_inventory.viewAdjustmentHistory',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistory,
            'route_name' => 'physical_inventory.showPI',
        ]);

        $snapshot_repair = Menu::where('route_name','physical_inventory_repair.indexSnapshot')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $snapshot_repair,
            'route_name' => 'physical_inventory_repair.indexSnapshot',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $snapshot_repair,
            'route_name' => 'physical_inventory_repair.displaySnapshot',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $snapshot_repair,
            'route_name' => 'physical_inventory_repair.showSnapshot',
        ]);

        $countStockRepair = Menu::where('route_name','physical_inventory_repair.indexCountStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $countStockRepair,
            'route_name' => 'physical_inventory_repair.indexCountStock',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $countStockRepair,
            'route_name' => 'physical_inventory_repair.countStock',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $countStockRepair,
            'route_name' => 'physical_inventory_repair.showCountStock',
        ]);

        $adjustStockRepair = Menu::where('route_name','physical_inventory_repair.indexAdjustStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStockRepair,
            'route_name' => 'physical_inventory_repair.indexAdjustStock',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStockRepair,
            'route_name' => 'physical_inventory_repair.showConfirmCountStock',
        ]);

        $viewAdjustmentHistoryRepair = Menu::where('route_name','physical_inventory_repair.viewAdjustmentHistory')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistoryRepair,
            'route_name' => 'physical_inventory_repair.viewAdjustmentHistory',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistoryRepair,
            'route_name' => 'physical_inventory_repair.showPI',
        ]);

        //Material Write Off Building
        $materialWriteOff = Menu::where('route_name','material_write_off.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOff,
            'route_name' => 'material_write_off.create',
        ]);

        $approveMaterialWriteOff = Menu::where('route_name','material_write_off.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOff,
            'route_name' => 'material_write_off.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOff,
            'route_name' => 'material_write_off.showApprove',
        ]);
        
        $materialWriteOffIndex = Menu::where('route_name','material_write_off.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffIndex,
            'route_name' => 'material_write_off.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffIndex,
            'route_name' => 'material_write_off.edit',
        ]);

        //Material Write Off Repair
        $materialWriteOffRepair = Menu::where('route_name','material_write_off_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffRepair,
            'route_name' => 'material_write_off_repair.create',
        ]);

        $approveMaterialWriteOffRepair = Menu::where('route_name','material_write_off_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOffRepair,
            'route_name' => 'material_write_off_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOffRepair,
            'route_name' => 'material_write_off_repair.showApprove',
        ]);

        $materialWriteOffRepairIndex = Menu::where('route_name','material_write_off_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffRepairIndex,
            'route_name' => 'material_write_off_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffRepairIndex,
            'route_name' => 'material_write_off_repair.edit',
        ]);

        $goodsMovementIndex = Menu::where('route_name','goods_movement.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $goodsMovementIndex,
            'route_name' => 'goods_movement.index',
        ]);

        $goodsMovementCreate = Menu::where('route_name','goods_movement.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $goodsMovementCreate,
            'route_name' => 'goods_movement.create',
        ]);

        $GMIndexRepair = Menu::where('route_name','goods_movement_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $GMIndexRepair,
            'route_name' => 'goods_movement_repair.index',
        ]);

        $GMCreateRepair = Menu::where('route_name','goods_movement_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $GMCreateRepair,
            'route_name' => 'goods_movement_repair.create',
        ]);

        $createWO = Menu::where('route_name','work_order.selectWR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWO,
            'route_name' => 'work_order.selectWR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWO,
            'route_name' => 'work_order.selectWRD',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWO,
            'route_name' => 'work_order.create',
        ]);

        $approveWO = Menu::where('route_name','work_order.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveWO,
            'route_name' => 'work_order.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveWO,
            'route_name' => 'work_order.showApprove',
        ]);
        
        $viewWO = Menu::where('route_name','work_order.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWO,
            'route_name' => 'work_order.index',
        ]);

        //WO REPAIR
        $createWORepair = Menu::where('route_name','work_order_repair.selectWR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWORepair,
            'route_name' => 'work_order_repair.selectWR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWORepair,
            'route_name' => 'work_order_repair.selectWRD',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWORepair,
            'route_name' => 'work_order_repair.create',
        ]);

        $approveWORepair = Menu::where('route_name','work_order_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveWORepair,
            'route_name' => 'work_order_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveWORepair,
            'route_name' => 'work_order_repair.showApprove',
        ]);
        
        $viewWORepair = Menu::where('route_name','work_order_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWORepair,
            'route_name' => 'work_order_repair.index',
        ]);

        // production order
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
            'route_name' => 'production_order.selectPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order.release',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order.showRelease',
        ]);

        $confirmProductionOrder = Menu::where('route_name','production_order.selectProjectConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.selectProjectConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.confirmPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.confirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order.showConfirm',
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

        $indexProductionOrder = Menu::where('route_name','production_order.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrder,
            'route_name' => 'production_order.selectProjectIndex',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrder,
            'route_name' => 'production_order.indexPrO',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrder,
            'route_name' => 'production_order.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrder,
            'route_name' => 'production_order.editPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrder,
            'route_name' => 'production_order.index',
        ]);

        // production order repair
        $createProductionOrder = Menu::where('route_name','production_order_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createProductionOrder,
            'route_name' => 'production_order_repair.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createProductionOrder,
            'route_name' => 'production_order_repair.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createProductionOrder,
            'route_name' => 'production_order_repair.create',
        ]);

        $releaseProductionOrder = Menu::where('route_name','production_order_repair.selectProjectRelease')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order_repair.selectProjectRelease',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order_repair.selectPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order_repair.release',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $releaseProductionOrder,
            'route_name' => 'production_order_repair.showRelease',
        ]);

        $confirmProductionOrder = Menu::where('route_name','production_order_repair.selectProjectConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order_repair.selectProjectConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order_repair.confirmPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order_repair.confirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmProductionOrder,
            'route_name' => 'production_order_repair.showConfirm',
        ]);

        $reportProductionOrder = Menu::where('route_name','production_order_repair.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order_repair.selectProjectReport',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order_repair.selectWOReport',
        ]);

        $indexProductionOrderRepair = Menu::where('route_name','production_order_repair.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrderRepair,
            'route_name' => 'production_order_repair.selectProjectIndex',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrderRepair,
            'route_name' => 'production_order_repair.indexPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexProductionOrderRepair,
            'route_name' => 'production_order_repair.editPrO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order_repair.index',
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
        
        $density = Menu::where('route_name','density.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $density,
            'route_name' => 'density.index',
        ]);

        $materialFamily = Menu::where('route_name','material_family.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialFamily,
            'route_name' => 'material_family.index',
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

        $stockManagementRepair = Menu::where('route_name','stock_management_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $stockManagementRepair,
            'route_name' => 'stock_management_repair.index',
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

        $selectPOResource = Menu::where('route_name','resource.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResource,
            'route_name' => 'resource.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResource,
            'route_name' => 'resource.createGR',
        ]);

        $indexReceived = Menu::where('route_name','resource.indexReceived')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexReceived,
            'route_name' => 'resource.indexReceived',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexReceived,
            'route_name' => 'resource.showGR',
        ]);

        $indexIssued = Menu::where('route_name','resource.indexIssued')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexIssued,
            'route_name' => 'resource.indexIssued',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexIssued,
            'route_name' => 'resource.showGI',
        ]);

        $issueResource = Menu::where('route_name','resource.issueResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $issueResource,
            'route_name' => 'resource.issueResource',
        ]);

        $resourceSchedule = Menu::where('route_name','resource.resourceSchedule')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $resourceSchedule,
            'route_name' => 'resource.resourceSchedule',
        ]);

        //Resource Repair
        $manageResourceRepair = Menu::where('route_name','resource_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageResourceRepair,
            'route_name' => 'resource_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResourceRepair,
            'route_name' => 'resource_repair.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResourceRepair,
            'route_name' => 'resource_repair.edit',
        ]);

        $assignResourceRepair = Menu::where('route_name','resource_repair.assignResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignResourceRepair,
            'route_name' => 'resource_repair.assignResource',
        ]); 

        $selectPOResourceRepair = Menu::where('route_name','resource_repair.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResourceRepair,
            'route_name' => 'resource_repair.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResourceRepair,
            'route_name' => 'resource_repair.createGR',
        ]);

        $indexReceivedRepair = Menu::where('route_name','resource_repair.indexReceived')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexReceivedRepair,
            'route_name' => 'resource_repair.indexReceived',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexReceivedRepair,
            'route_name' => 'resource_repair.showGR',
        ]);

        $indexIssuedRepair = Menu::where('route_name','resource_repair.indexIssued')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexIssuedRepair,
            'route_name' => 'resource_repair.indexIssued',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexIssuedRepair,
            'route_name' => 'resource_repair.showGI',
        ]);

        $issueResourceRepair = Menu::where('route_name','resource_repair.issueResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $issueResourceRepair,
            'route_name' => 'resource_repair.issueResource',
        ]);

        $resourceScheduleRepair = Menu::where('route_name','resource_repair.resourceSchedule')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $resourceScheduleRepair,
            'route_name' => 'resource_repair.resourceSchedule',
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
