<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class RepairMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Repair
        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Ship Repair',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $repair =  Menu::where('name', 'Ship Repair')->select('id')->first()->id;

        // Repair - Marketing & Sales
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Marketing & Sales',
            'icon' => 'fa-money',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $marketing_sales =  Menu::where('name', 'Marketing & Sales')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Marketing & Sales - Estimator Configuration
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Estimator Configuration',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $configuration = Menu::where('name', 'Estimator Configuration')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Repair - Marketing & Sales - Estimator Configuration - WBS Cost Estimation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'WBS Cost Estimation',
            'icon' => 'fa-wrench',
            'route_name' => 'estimator_repair.indexEstimatorWbs',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Estimator Configuration - Cost Standard
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Cost Standard',
            'icon' => 'fa-wrench',
            'route_name' => 'estimator_repair.indexEstimatorCostStandard',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Estimator Configuration - Estimator Profile
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Estimator Profile',
            'icon' => 'fa-wrench',
            'route_name' => 'estimator_repair.indexEstimatorProfile',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Quotation
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Quotation',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $quotation = Menu::where('name', 'Quotation')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Repair - Marketing & Sales - Quotation - Create Quotation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Quotation',
            'icon' => 'fa-wrench',
            'route_name' => 'quotation_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $quotation,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Quotation - View & Edit Quotation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Quotation',
            'icon' => 'fa-wrench',
            'route_name' => 'quotation_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $quotation,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Sales Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Sales Order',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $sales_order = Menu::where('name', 'Sales Order')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Repair - Marketing & Sales - Sales Order - Create Sales Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Sales Order',
            'icon' => 'fa-wrench',
            'route_name' => 'sales_order_repair.selectQT',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $sales_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Sales Order - View & Edit Sales Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Sales Order',
            'icon' => 'fa-wrench',
            'route_name' => 'sales_order_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $sales_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Invoice
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Invoice',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $invoice = Menu::where('name', 'Invoice')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Repair - Marketing & Sales - Invoice - Create Invoice
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Invoice',
            'icon' => 'fa-wrench',
            'route_name' => 'invoice_repair.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $invoice,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Invoice - View Invoice
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Invoice',
            'icon' => 'fa-wrench',
            'route_name' => 'invoice_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $invoice,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Payment Receipt
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Payment Receipt',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $payment = Menu::where('name', 'Payment Receipt')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Repair - Marketing & Sales - Payment Receipt - Manage Payment Receipt
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Payment Receipt',
            'icon' => 'fa-wrench',
            'route_name' => 'payment_repair.selectInvoice',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $payment,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Payment Receipt - View Payment Receipt
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Payment Receipt',
            'icon' => 'fa-wrench',
            'route_name' => 'payment_repair.selectInvoiceView',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $payment,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing & Sales - Sales Plan
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Sales Plan',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'sales_plan_repair.index',
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Marketing and Sales - Sales Plan - Customer Call / Visit
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Customer Call / Visit',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'customer_visit_repair.index',
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Project Management
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Project Management',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $project_management =  Menu::where('name', 'Project Management')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Project Management - Manage Projects
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Projects',
            'icon' => 'fa-calendar',
            'route_name' => 'project_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $project_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Project Management - Manage WBS Profile
        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Manage WBS Profile',
        //     'icon' => 'fa-briefcase',
        //     'route_name'=> 'wbs_repair.createWbsProfile',
        //     'is_active' => true,
        //     'roles' => 'ADMIN,PAMI',
        //     'menu_id'=> $project_management,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        // Repair - Project Management - Project Standard
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Project Standard',
            'icon' => 'fa-briefcase',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $project_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $project_standard =  Menu::where('name', 'Project Standard')->where('menu_id', $project_management)->select('id')->first()->id;

        // Repair - Project Management - Project Standard - Manage Project Standard
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Project Standard',
            'icon' => 'fa-briefcase',
            'route_name' => 'project_standard.createProjectStandard',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $project_standard,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Project Management - Project Standard - Manage Material Standard
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Material Standard',
            'icon' => 'fa-briefcase',
            'route_name' => 'project_standard.selectProjectMaterial',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $project_standard,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Project Management - Project Standard - Manage Resource Standard
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Resource Standard',
            'icon' => 'fa-briefcase',
            'route_name' => 'project_standard.selectProjectResource',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $project_standard,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Bill of Material
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Bill of Material',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $bom =  Menu::where('name', 'Bill of Material')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Bill of Material - Manage BOM / BOS
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage BOM / BOS',
            'icon' => 'fa-file-text-o',
            'route_name' => 'bom_repair.selectProjectManage',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $bom,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Bill of Material - Material Requirement Summary
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Requirement Summary',
            'icon' => 'fa-file-text-o',
            'route_name' => 'bom_repair.selectProjectSum',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $bom,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Bill of Material - Manage BOM
        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Manage BOM',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'bom_repair.indexProject',
        //     'is_active' => true,
        //     'roles' => 'ADMIN,PAMI',
        //     'menu_id'=> $bomRepair,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        // Repair - Bill of Material - View BOM
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View BOM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'bom_repair.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $bom,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Cost Plan
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Cost Plan',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $cost_plan =  Menu::where('name', 'Cost Plan')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Cost Plan - Manage RAP
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage RAP',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap_repair.indexSelectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Cost Plan - Create Other Cost
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap_repair.selectProjectCost',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Cost Plan - Input Actual Other Cost
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Input Actual Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap_repair.selectProjectActualOtherCost',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Cost Plan - View Planned Cost
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Planned Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap_repair.selectProjectViewCost',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Cost Plan - View Remaining Material
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Remaining Material',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap_repair.selectProjectViewRM',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material Management',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);


        $material_management =  Menu::where('name', 'Material Management')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Material Management - Purchase Requisition
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Purchase Requisition',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $purchase_requisition =  Menu::where('name', 'Purchase Requisition')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Purchase Requisition - Create PR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create PR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Requisition - Approve PR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve PR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Requisition - View & Edit PR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit PR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Requisition - Repeat Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Repeat Order',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition_repair.repeatOrder',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Requisition - PR Consolidation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'PR Consolidation',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition_repair.indexConsolidation',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Purchase Order',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $purchase_order =  Menu::where('name', 'Purchase Order')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Purchase Order - Create PO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create PO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_order_repair.selectPR',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Order - Approve PO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve PO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_order_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Purchase Order - View & Edit PO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit PO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_order_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $purchase_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Receipt
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Receipt',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_receipt =  Menu::where('name', 'Goods Receipt')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Goods Receipt - Create GR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_receipt_repair.selectPO',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_receipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Receipt - Create GR without reference
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GR without reference',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_receipt_repair.createGrWithoutRef',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_receipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Receipt - View GR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View GR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_receipt_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_receipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Return
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Return',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_return =  Menu::where('name', 'Goods Return')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Goods Return - Based On Goods Receipt
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Based On Goods Receipt',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return_repair.selectGR',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Return - Based On Purchase Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Based On Purchase Order',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return_repair.selectPO',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Return - Approve Goods Return
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve Goods Return',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Return - View & Edit Goods Return
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Goods Return',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Material Requisition
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Requisition',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $material_requisition_repair =  Menu::where('name', 'Material Requisition')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Material Requisition - Create MR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create MR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_requisition_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_requisition_repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Material Requisition - Approve MR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve MR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_requisition_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_requisition_repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Material Requisition - View & Edit MR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit MR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_requisition_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_requisition_repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Issue
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Issue',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_issue =  Menu::where('name', 'Goods Issue')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Goods Issue - Create GI
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GI',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_issue_repair.selectMR',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_issue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Issue - View GI
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View GI',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_issue_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_issue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Movement
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Movement',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_movement =  Menu::where('name', 'Goods Movement')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Goods Movement - Create GM
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_movement_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_movement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Goods Movement - View GM
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View GM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_movement_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $goods_movement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Stock Taking
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Stock Taking',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $physical_inventory =  Menu::where('name', 'Stock Taking')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Stock Taking - Create Stock Take
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Stock Take',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory_repair.indexSnapshot',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Stock Taking - Count Stock
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Count Stock',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory_repair.indexCountStock',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Stock Taking - Adjust Stock
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Adjust Stock',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory_repair.indexAdjustStock',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Stock Taking - View Adjustment History
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Adjustment History',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory_repair.viewAdjustmentHistory',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Stock Management
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Stock Management',
            'icon' => 'fa-file-text-o',
            'route_name' => 'stock_management_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Material Write Off
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Write Off',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $material_write_off =  Menu::where('name', 'Material Write Off')->where('menu_id', $material_management)->select('id')->first()->id;

        // Repair - Material Management - Material Write Off - Create Material Write Off
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_write_off_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_write_off,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Material Write Off - Approve Material Write Off
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_write_off_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_write_off,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Material Management - Material Write Off - View & Edit Material Write Off
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_write_off_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $material_write_off,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Work In Progress(WIP)
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'WIP',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $wip = Menu::where('name', 'WIP')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Work In Progress(WIP) - Work Request
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Work Request',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $wip,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $work_request =  Menu::where('name', 'Work Request')->where('menu_id', $wip)->select('id')->first()->id;

        // Repair - Work In Progress(WIP) - Work Request - Create WR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create WR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_request_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $work_request,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Work In Progress(WIP) - Work Request - Approve WR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve WR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_request_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $work_request,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Work In Progress(WIP) - Work Request - View & Edit WR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit WR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_request_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $work_request,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Work In Progress(WIP) - Work Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Work Order',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $wip,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $work_order_repair =  Menu::where('name', 'Work Order')->where('menu_id', $wip)->select('id')->first()->id;

        // Repair - Work In Progress(WIP) - Work Order - Create WO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create WO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_order_repair.selectWR',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $work_order_repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Work In Progress(WIP) - Work Order - Approve WO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve WO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_order_repair.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $work_order_repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Work In Progress(WIP) - Work Order - View & Edit WO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit WO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_order_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $work_order_repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Resource Management',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $resource_management = Menu::where('name', 'Resource Management')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Resource Management - Manage Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management - Assign Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Assign Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.assignResource',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management - Receive Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Receive Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.selectPO',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management - View Received Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Received Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.indexReceived',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management - Issue Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Issue Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.issueResource',
            'is_active' => true,
            'menu_id' => $resource_management,
            'roles' => 'ADMIN,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management - View Issued Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Issued Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.indexIssued',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Resource Management - Resource Schedule
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Resource Schedule',
            'icon' => 'fa-wrench',
            'route_name' => 'resource_repair.resourceSchedule',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Production Planning & Execution
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Production Planning & Execution',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $ppe =  Menu::where('name', 'Production Planning & Execution')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Production Planning & Execution - Create Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order_repair.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Production Planning & Execution - View Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order_repair.selectProjectIndex',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Production Planning & Execution - Release Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Release Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order_repair.selectProjectRelease',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Production Planning & Execution - Confirm Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Confirm Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order_repair.selectProjectConfirm',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Production Planning & Execution - Yard Plan
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Yard Plan',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $yard_plan = Menu::where('name', 'Yard Plan')->where('menu_id', $ppe)->select('id')->first()->id;

        // Repair - Production Planning & Execution - Yard Plan - Manage Yard Plan
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Yard Plan',
            'icon' => 'fa-wrench',
            'route_name' => 'yard_plan_repair.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $yard_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Production Planning & Execution - Yard Plan - View Yard Plan
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Yard Plan',
            'icon' => 'fa-wrench',
            'route_name' => 'yard_plan_repair.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $yard_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Quality Control(QC)
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Quality Control',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $repair,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $quality_control = Menu::where('name', 'Quality Control')->where('menu_id', $repair)->select('id')->first()->id;

        // Repair - Quality Control(QC) - QC Task
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'QC Task',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $quality_control_task =  Menu::where('name', 'QC Task')->where('menu_id', $quality_control)->select('id')->first()->id;

        // Repair - Quality Control(QC) - QC Task - Create QC Task
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create QC Task',
            'icon' => 'fa-wrench',
            'route_name' => 'qc_task_repair.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control_task,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Quality Control(QC) - QC Task - View & Edit QC Task
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit QC Task',
            'icon' => 'fa-wrench',
            'route_name' => 'qc_task_repair.selectProjectIndex',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control_task,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Quality Control(QC) - QC Task Confirmation
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'QC Task Confirmation',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control,
            'route_name' => 'qc_task_repair.selectProjectConfirm',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Repair - Quality Control(QC) - QC Summary Report
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'QC Summary Report',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control,
            'route_name' => 'qc_task_repair.selectProjectSummary',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
