<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class MaterialManagementSidenavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * ========================================================================
         * =                              BUILDING STAGE
         * ========================================================================
         */

        // Building - Material Management - Purchase Requisition
        $createPr = Menu::where('route_name', 'purchase_requisition.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPr,
            'route_name' => 'purchase_requisition.create',
        ]);

        $indexApprovePR = Menu::where('route_name', 'purchase_requisition.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePR,
            'route_name' => 'purchase_requisition.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePR,
            'route_name' => 'purchase_requisition.showApprove',
        ]);

        $viewPr = Menu::where('route_name', 'purchase_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.edit',
        ]);

        $indexConsolidation = Menu::where('route_name', 'purchase_requisition.indexConsolidation')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexConsolidation,
            'route_name' => 'purchase_requisition.indexConsolidation',
        ]);

        // Building - Material Management - Purchase Order
        $createPo = Menu::where('route_name', 'purchase_order.selectPR')->select('id')->first()->id;
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

        $indexApprovePO = Menu::where('route_name', 'purchase_order.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order.showApprove',
        ]);

        $viewPo = Menu::where('route_name', 'purchase_order.index')->select('id')->first()->id;
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

        // Building - Material Management - Goods Receipt
        $selectPO = Menu::where('route_name', 'goods_receipt.selectPO')->select('id')->first()->id;
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

        $viewGr = Menu::where('route_name', 'goods_receipt.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGr,
            'route_name' => 'goods_receipt.index',
        ]);

        $createGrWithoutRef = Menu::where('route_name', 'goods_receipt.createGrWithoutRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGrWithoutRef,
            'route_name' => 'goods_receipt.createGrWithoutRef',
        ]);

        // Building - Material Management - Goods Return
        $selectGR = Menu::where('route_name', 'goods_return.selectGR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectGR,
            'route_name' => 'goods_return.selectGR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectGR,
            'route_name' => 'goods_return.createGoodsReturnGR',
        ]);

        $selectPO = Menu::where('route_name', 'goods_return.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_return.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPO,
            'route_name' => 'goods_return.createGoodsReturnPO',
        ]);

        $selectGI = Menu::where('route_name', 'goods_return.selectGI')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectGI,
            'route_name' => 'goods_return.selectGI',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectGI,
            'route_name' => 'goods_return.createGoodsReturnGI',
        ]);

        $viewReturn = Menu::where('route_name', 'goods_return.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewReturn,
            'route_name' => 'goods_return.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewReturn,
            'route_name' => 'goods_return.edit',
        ]);

        $indexApproveGReturn = Menu::where('route_name', 'goods_return.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturn,
            'route_name' => 'goods_return.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturn,
            'route_name' => 'goods_return.showApprove',
        ]);

        // Building - Material Management - Goods Issue
        $selectMR = Menu::where('route_name', 'goods_issue.selectMR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectMR,
            'route_name' => 'goods_issue.selectMR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectMR,
            'route_name' => 'goods_issue.createGiWithRef',
        ]);

        $viewGi = Menu::where('route_name', 'goods_issue.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGi,
            'route_name' => 'goods_issue.index',
        ]);

        // Building - Material Management - Material Requisition
        $createMrManually = Menu::where('route_name', 'material_requisition.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createMrManually,
            'route_name' => 'material_requisition.create',
        ]);

        $indexApproveMR = Menu::where('route_name', 'material_requisition.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMR,
            'route_name' => 'material_requisition.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMR,
            'route_name' => 'material_requisition.showApprove',
        ]);

        $viewMr = Menu::where('route_name', 'material_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewMr,
            'route_name' => 'material_requisition.index',
        ]);

        // Building - Material Management - Physical Inventory (Stock Taking)
        $snapshot = Menu::where('route_name', 'physical_inventory.indexSnapshot')->select('id')->first()->id;
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

        $countStock = Menu::where('route_name', 'physical_inventory.indexCountStock')->select('id')->first()->id;
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

        $adjustStock = Menu::where('route_name', 'physical_inventory.indexAdjustStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStock,
            'route_name' => 'physical_inventory.indexAdjustStock',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $adjustStock,
            'route_name' => 'physical_inventory.showConfirmCountStock',
        ]);

        $viewAdjustmentHistory = Menu::where('route_name', 'physical_inventory.viewAdjustmentHistory')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistory,
            'route_name' => 'physical_inventory.viewAdjustmentHistory',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistory,
            'route_name' => 'physical_inventory.showPI',
        ]);

        // Building - Material Management - Stock Management
        $stockManagement = Menu::where('route_name', 'stock_management.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $stockManagement,
            'route_name' => 'stock_management.index',
        ]);

        // Building - Material Management - Material Write Off
        $materialWriteOff = Menu::where('route_name', 'material_write_off.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOff,
            'route_name' => 'material_write_off.create',
        ]);

        $approveMaterialWriteOff = Menu::where('route_name', 'material_write_off.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOff,
            'route_name' => 'material_write_off.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOff,
            'route_name' => 'material_write_off.showApprove',
        ]);

        $materialWriteOffIndex = Menu::where('route_name', 'material_write_off.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffIndex,
            'route_name' => 'material_write_off.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffIndex,
            'route_name' => 'material_write_off.edit',
        ]);
        // Building - Material Management - Goods Movement
        $goodsMovementIndex = Menu::where('route_name', 'goods_movement.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $goodsMovementIndex,
            'route_name' => 'goods_movement.index',
        ]);

        $goodsMovementCreate = Menu::where('route_name', 'goods_movement.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $goodsMovementCreate,
            'route_name' => 'goods_movement.create',
        ]);

        // Building - Material Management - Reverse Transaction
        // Reverse Transaction
        $createReverse = Menu::where('route_name', 'reverse_transaction.selectDocument')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createReverse,
            'route_name' => 'reverse_transaction.selectDocument',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createReverse,
            'route_name' => 'reverse_transaction.create',
        ]);

        $approveReverse = Menu::where('route_name', 'reverse_transaction.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveReverse,
            'route_name' => 'reverse_transaction.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveReverse,
            'route_name' => 'reverse_transaction.showApprove',
        ]);

        $indexReverse = Menu::where('route_name', 'reverse_transaction.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexReverse,
            'route_name' => 'reverse_transaction.index',
        ]);
        

        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        // Repairing - Material Management - Purchase Requisition
        $createPrRepair = Menu::where('route_name', 'purchase_requisition_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPrRepair,
            'route_name' => 'purchase_requisition_repair.create',
        ]);

        $indexApprovePRRepair = Menu::where('route_name', 'purchase_requisition_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePRRepair,
            'route_name' => 'purchase_requisition_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePRRepair,
            'route_name' => 'purchase_requisition_repair.showApprove',
        ]);

        $viewPr = Menu::where('route_name', 'purchase_requisition_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition_repair.edit',
        ]);

        $indexConsolidation = Menu::where('route_name', 'purchase_requisition_repair.indexConsolidation')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexConsolidation,
            'route_name' => 'purchase_requisition_repair.indexConsolidation',
        ]);

        // Repairing - Material Management - Purchase Order
        $createPo = Menu::where('route_name', 'purchase_order_repair.selectPR')->select('id')->first()->id;
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

        $indexApprovePO = Menu::where('route_name', 'purchase_order_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApprovePO,
            'route_name' => 'purchase_order_repair.showApprove',
        ]);

        $viewPo = Menu::where('route_name', 'purchase_order_repair.index')->select('id')->first()->id;
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

        // Repairing - Material Management - Goods Receipt Repair
        $selectPORepair = Menu::where('route_name', 'goods_receipt_repair.selectPO')->select('id')->first()->id;
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

        $viewGrRepair = Menu::where('route_name', 'goods_receipt_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGrRepair,
            'route_name' => 'goods_receipt_repair.index',
        ]);

        $createGrWithoutRefRepair = Menu::where('route_name', 'goods_receipt_repair.createGrWithoutRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGrWithoutRefRepair,
            'route_name' => 'goods_receipt_repair.createGrWithoutRef',
        ]);

        // Repairing - Material Management - Goods Return
        $selectGRRepair = Menu::where('route_name', 'goods_return_repair.selectGR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectGRRepair,
            'route_name' => 'goods_return_repair.selectGR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectGRRepair,
            'route_name' => 'goods_return_repair.createGoodsReturnGR',
        ]);

        $selectPORepair = Menu::where('route_name', 'goods_return_repair.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_return_repair.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPORepair,
            'route_name' => 'goods_return_repair.createGoodsReturnPO',
        ]);

        $selectGIRepair = Menu::where('route_name', 'goods_return_repair.selectGI')->select('id')->first();
        DB::table('sidenav')->insert([
            'menu_id' => $selectGIRepair,
            'route_name' => 'goods_return_repair.selectGI',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectGIRepair,
            'route_name' => 'goods_return_repair.createGoodsReturnGI',
        ]);

        $viewReturnRepair = Menu::where('route_name', 'goods_return_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewReturnRepair,
            'route_name' => 'goods_return_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewReturnRepair,
            'route_name' => 'goods_return_repair.edit',
        ]);

        $indexApproveGReturnRepair = Menu::where('route_name', 'goods_return_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturnRepair,
            'route_name' => 'goods_return_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveGReturnRepair,
            'route_name' => 'goods_return_repair.showApprove',
        ]);

        // Repairing - Material Management - Goods Issue
        $selectMRRepair = Menu::where('route_name', 'goods_issue_repair.selectMR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectMRRepair,
            'route_name' => 'goods_issue_repair.selectMR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectMRRepair,
            'route_name' => 'goods_issue_repair.createGiWithRef',
        ]);

        $viewGiRepair = Menu::where('route_name', 'goods_issue_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGiRepair,
            'route_name' => 'goods_issue_repair.index',
        ]);

        // Repairing - Material Management - Material Requisition
        $createMrRepairManually = Menu::where('route_name', 'material_requisition_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createMrRepairManually,
            'route_name' => 'material_requisition_repair.create',
        ]);

        $indexApproveMRRepair = Menu::where('route_name', 'material_requisition_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMRRepair,
            'route_name' => 'material_requisition_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveMRRepair,
            'route_name' => 'material_requisition_repair.showApprove',
        ]);

        $viewMrRepair = Menu::where('route_name', 'material_requisition_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewMrRepair,
            'route_name' => 'material_requisition_repair.index',
        ]);

        // Repairing - Material Management - Physical Inventory (Stock Taking)
        $snapshot_repair = Menu::where('route_name', 'physical_inventory_repair.indexSnapshot')->select('id')->first()->id;
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

        $countStockRepair = Menu::where('route_name', 'physical_inventory_repair.indexCountStock')->select('id')->first()->id;
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

        $adjustStockRepair = Menu::where('route_name', 'physical_inventory_repair.indexAdjustStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStockRepair,
            'route_name' => 'physical_inventory_repair.indexAdjustStock',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $adjustStockRepair,
            'route_name' => 'physical_inventory_repair.showConfirmCountStock',
        ]);

        $viewAdjustmentHistoryRepair = Menu::where('route_name', 'physical_inventory_repair.viewAdjustmentHistory')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistoryRepair,
            'route_name' => 'physical_inventory_repair.viewAdjustmentHistory',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewAdjustmentHistoryRepair,
            'route_name' => 'physical_inventory_repair.showPI',
        ]);

        // Repairing - Material Management - Stock Management
        $stockManagementRepair = Menu::where('route_name', 'stock_management_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $stockManagementRepair,
            'route_name' => 'stock_management_repair.index',
        ]);

        // Repairing - Material Management - Material Write Off
        $materialWriteOffRepair = Menu::where('route_name', 'material_write_off_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffRepair,
            'route_name' => 'material_write_off_repair.create',
        ]);

        $approveMaterialWriteOffRepair = Menu::where('route_name', 'material_write_off_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOffRepair,
            'route_name' => 'material_write_off_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveMaterialWriteOffRepair,
            'route_name' => 'material_write_off_repair.showApprove',
        ]);

        $materialWriteOffRepairIndex = Menu::where('route_name', 'material_write_off_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffRepairIndex,
            'route_name' => 'material_write_off_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOffRepairIndex,
            'route_name' => 'material_write_off_repair.edit',
        ]);

        // Repairing - Material Management - Goods Movement
        $GMIndexRepair = Menu::where('route_name', 'goods_movement_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $GMIndexRepair,
            'route_name' => 'goods_movement_repair.index',
        ]);

        $GMCreateRepair = Menu::where('route_name', 'goods_movement_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $GMCreateRepair,
            'route_name' => 'goods_movement_repair.create',
        ]);
    }
}
