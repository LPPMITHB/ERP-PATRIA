<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class BuildingMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Dashboard',
            'icon' => 'fa-dashboard',
            'route_name' => 'index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

       

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Ship Building',
            'icon' => 'fa-ship',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
        
        $building = Menu::where('name', 'Ship Building')->select('id')->first()->id;

        // Building - Marketing and Sales
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Marketing & Sales',
            'icon' => 'fa-money',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $marketing_sales =  Menu::where('name', 'Marketing & Sales')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Marketing and Sales - Estimator
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Estimator Configuration',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $cost_estimator_configuration = Menu::where('name', 'Estimator Configuration')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Building - Marketing and Sales - Estimator - WBS Cost Estimation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'WBS Cost Estimation',
            'icon' => 'fa-wrench',
            'route_name' => 'estimator.indexEstimatorWbs',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_estimator_configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Estimator - Cost Standard
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Cost Standard',
            'icon' => 'fa-wrench',
            'route_name' => 'estimator.indexEstimatorCostStandard',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_estimator_configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Estimator - Estimator Profile
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Estimator Profile',
            'icon' => 'fa-wrench',
            'route_name' => 'estimator.indexEstimatorProfile',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_estimator_configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Quotation
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Quotation',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $quotation = Menu::where('name', 'Quotation')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Building - Marketing and Sales - Quotation - Create Quotation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Quotation',
            'icon' => 'fa-wrench',
            'route_name' => 'quotation.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quotation,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        //Building - Marketing and Sales - Quotation - View & Edit Quotation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Quotation',
            'icon' => 'fa-wrench',
            'route_name' => 'quotation.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quotation,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Sales Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Sales Order',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $sales_order = Menu::where('name', 'Sales Order')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Building - Marketing and Sales - Sales Order - Create Sales Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Sales Order',
            'icon' => 'fa-wrench',
            'route_name' => 'sales_order.selectQT',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $sales_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Sales Order - View & Edit Sales Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Sales Order',
            'icon' => 'fa-wrench',
            'route_name' => 'sales_order.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $sales_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Invoice
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Invoice',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $invoice = Menu::where('name', 'Invoice')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Building - Marketing and Sales - Invoice - Create Invoice
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Invoice',
            'icon' => 'fa-wrench',
            'route_name' => 'invoice.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $invoice,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Invoice - View Invoice
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Invoice',
            'icon' => 'fa-wrench',
            'route_name' => 'invoice.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $invoice,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Payment Receipt
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Payment Receipt',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $payment = Menu::where('name', 'Payment Receipt')->where('menu_id', $marketing_sales)->select('id')->first()->id;

        // Building - Marketing and Sales - Payment Receipt - Manage Payment Receipt
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Payment Receipt',
            'icon' => 'fa-wrench',
            'route_name' => 'payment.selectInvoice',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $payment,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Payment Receipt - View Payment Receipt
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Payment Receipt',
            'icon' => 'fa-wrench',
            'route_name' => 'payment.selectInvoiceView',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $payment,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Sales Plan
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Sales Plan',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'sales_plan.index',
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Marketing and Sales - Sales Plan - Customer Call / Visit
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Customer Call / Visit',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'customer_visit.index',
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $marketing_sales,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Management
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Project Management',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $project_management =  Menu::where('name', 'Project Management')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Project Management - Manage Projects
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Projects',
            'icon' => 'fa-calendar',
            'route_name' => 'project.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $project_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Management - Manage Drawings
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Drawings',
            'icon' => 'fa-calendar',
            'route_name' => 'wbs.manageWbsImages',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $project_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Management - Manage WBS Profile
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage WBS Profile',
            'icon' => 'fa-briefcase',
            'route_name' => 'wbs.createWbsProfile',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $project_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Management - WBS & Estimator Configuration
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'WBS & Estimator Configuration',
            'icon' => 'fa-clock-o',
            'route_name' => 'project.selectProjectConfig',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $project_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Bill of Material
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Bill Of Material',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $bill_of_material =  Menu::where('name', 'Bill Of Material')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Bill of Material - Manage BOM
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage BOM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'bom.indexProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $bill_of_material,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Bill of Material - Material Requirement Summary
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Requirement Summary',
            'icon' => 'fa-file-text-o',
            'route_name' => 'bom.selectProjectSum',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $bill_of_material,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Bill of Material - View BOM
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View BOM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'bom.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $bill_of_material,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Cost Plan
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Cost Plan',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $cost_plan =  Menu::where('name', 'Cost Plan')->where('menu_id', $building)->select('id')->first()->id;

        // //Building - Cost Plan - Create RAP
        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Create RAP',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'rap.selectProject',
        //     'is_active' => true,
        //     'roles' => 'ADMIN',
        //     'menu_id'=>$cost_plan,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        // Building - Cost Plan - Manage RAP
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage RAP',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap.indexSelectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Cost Plan - Manage Other Cost
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Other Cost',
            'icon' => 'fa-file-text-o',
            // 'route_name' => 'rap.selectProjectCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $other_cost =  Menu::where('name', 'Manage Other Cost')->where('menu_id', $cost_plan)->select('id')->first()->id;

        // Building - Cost Plan - Manage Other Cost - Plan Other Cost
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Plan Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap.selectProjectCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $other_cost,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Cost Plan - Manage Other Cost - Actual Other Cost
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Actual Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap.selectProjectActualOtherCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $other_cost,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Cost Plan - Manage Other Cost - Approve Plan Other Cost
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve Plan Other Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap.selectProjectPlanOtherCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $other_cost,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // // Building - Cost Plan - Manage Other Cost - Manage Actual Other Cost
        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Manage Actual Other Cost',
        //     'icon' => 'fa-file-text-o',
        //     'route_name' => 'rap.selectProjectActualOtherCost',
        //     'is_active' => true,
        //     'roles' => 'ADMIN,PMP,PAMI',
        //     'menu_id' => $costPlan,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        // // Building - Cost Plan - Manage Other Cost - Assign Cost
        // DB::table('menus')->insert([
        //     'level' => 3,
        //     'name' => 'Assign Cost',
        //     'icon' => 'fa-file-text-o',
        //     'route_name'=> 'rap.selectProjectAssignCost',
        //     'is_active' => true,
        //     'roles' => 'ADMIN',
        //     'menu_id'=>$costPlan,
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d')
        // ]);

        // Building - Cost Plan - View Planned Cost
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Planned Cost',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap.selectProjectViewCost',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Cost Plan - View Remaining Material
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Remaining Material',
            'icon' => 'fa-file-text-o',
            'route_name' => 'rap.selectProjectViewRM',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $cost_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material Management',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $material_management =  Menu::where('name', 'Material Management')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Material Management - Purchase Requisition
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Purchase Requisition',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $purchase_requisition =  Menu::where('name', 'Purchase Requisition')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Purchase Requisition - Create PR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create PR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Purchase Requisition - Approve PR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve PR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Purchase Requisition - View & Edit PR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit PR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Purchase Requisition - PR Consolidation
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'PR Consolidation',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_requisition.indexConsolidation',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id' => $purchase_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Purchase Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Purchase Order',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $purchase_order =  Menu::where('name', 'Purchase Order')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Purchase Order - Create PO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create PO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_order.selectPR',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $purchase_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Purchase Order - Approve PO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve PO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_order.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $purchase_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Purchase Order - View & Edit PO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit PO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'purchase_order.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $purchase_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Receipt
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Receipt',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_receipt =  Menu::where('name', 'Goods Receipt')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Goods Receipt - Create GR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_receipt.selectPO',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_receipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Receipt - Create GR without reference
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GR without reference',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_receipt.createGrWithoutRef',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_receipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Receipt - View GR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View GR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_receipt.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_receipt,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Return
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Return',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_return =  Menu::where('name', 'Goods Return')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Goods Return - Based On Goods Receipt
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Based On Goods Receipt',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return.selectGR',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Return - Based On Purchase Order
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Based On Purchase Order',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return.selectPO',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Return - Based On Goods Issue
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Based On Goods Issue',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return.selectGI',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Return - Approve Goods Return
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve Goods Return',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Return - View & Edit Goods Return
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Goods Return',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_return.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_return,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Material Requisition
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Material Requisition',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $material_requisition =  Menu::where('name', 'Material Requisition')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Material Requisition - Create MR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create MR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_requisition.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Material Requisition - Approve MR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve MR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_requisition.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Material Requisition - View & Edit MR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit MR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_requisition.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_requisition,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Issue
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Issue',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_issue =  Menu::where('name', 'Goods Issue')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Goods Issue - Create GI
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GI',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_issue.selectMR',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_issue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Issue - View GI
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View GI',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_issue.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_issue,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Stock Taking
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Stock Taking',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $physical_inventory =  Menu::where('name', 'Stock Taking')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Stock Taking - Create Stock Take
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Stock Take',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory.indexSnapshot',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Stock Taking - Count Stock
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Count Stock',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory.indexCountStock',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Stock Taking - Adjust Stock
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Adjust Stock',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory.indexAdjustStock',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Stock Taking - View Adjustment History
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Adjustment History',
            'icon' => 'fa-file-text-o',
            'route_name' => 'physical_inventory.viewAdjustmentHistory',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $physical_inventory,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Stock Management
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Stock Management',
            'icon' => 'fa-file-text-o',
            'route_name' => 'stock_management.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Material Write Off
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material Write Off',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $material_write_off =  Menu::where('name', 'Material Write Off')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Material Write Off - Create Material Write Off
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_write_off.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_write_off,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Material Write Off - Approve Material Write Off
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_write_off.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_write_off,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Material Write Off - View & Edit Material Write Off
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Material Write Off',
            'icon' => 'fa-file-text-o',
            'route_name' => 'material_write_off.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_write_off,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Movement
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Goods Movement',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $goods_movement =  Menu::where('name', 'Goods Movement')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Goods Movement - Create GM
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create GM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_movement.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_movement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Goods Movement - View GM
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View GM',
            'icon' => 'fa-file-text-o',
            'route_name' => 'goods_movement.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $goods_movement,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Reverse Transaction
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Reverse Transaction',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $material_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $reverse_transaction =  Menu::where('name', 'Reverse Transaction')->where('menu_id', $material_management)->select('id')->first()->id;

        // Building - Material Management - Reverse Transaction - Create Reverse Transaction
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create Reverse Transaction',
            'icon' => 'fa-file-text-o',
            'route_name' => 'reverse_transaction.selectDocument',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $reverse_transaction,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Reverse Transaction - Approve Reverse Transaction
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve Reverse Transaction',
            'icon' => 'fa-file-text-o',
            'route_name' => 'reverse_transaction.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $reverse_transaction,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Material Management - Reverse Transaction - View & Edit Reverse Transaction
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit Reverse Transaction',
            'icon' => 'fa-file-text-o',
            'route_name' => 'reverse_transaction.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $reverse_transaction,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Work In Progress(WIP)
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'WIP',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $wip = Menu::where('name', 'WIP')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Work In Progress(WIP) - Work Request
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Work Request',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $wip,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $work_request =  Menu::where('name', 'Work Request')->where('menu_id', $wip)->select('id')->first()->id;

        // Building - Work In Progress(WIP) - Work Request - Create WR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create WR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_request.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $work_request,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Work In Progress(WIP) - Work Request - Approve WR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve WR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_request.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $work_request,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Work In Progress(WIP) - Work Request - View & Edit WR
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit WR',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_request.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $work_request,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Work In Progress(WIP) - Work Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Work Order',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $wip,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $work_order =  Menu::where('name', 'Work Order')->where('menu_id', $wip)->select('id')->first()->id;

        // Building - Work In Progress(WIP) - Work Order - Create WO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create WO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_order.selectWR',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $work_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Work In Progress(WIP) - Work Order - Approve WO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Approve WO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_order.indexApprove',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $work_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Work In Progress(WIP) - Work Order - View & Edit WO
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit WO',
            'icon' => 'fa-file-text-o',
            'route_name' => 'work_order.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $work_order,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management 
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Resource Management',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $resource_management = Menu::where('name', 'Resource Management')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Resource Management - Manage Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management - Assign Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Assign Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.assignResource',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management - Receive Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Receive Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.selectPO',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management - View Received Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Received Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.indexReceived',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management - Issue Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Issue Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.issueResource',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management - View Issued Resource
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Issued Resource',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.indexIssued',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Resource Management - Resource Schedule
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Resource Schedule',
            'icon' => 'fa-wrench',
            'route_name' => 'resource.resourceSchedule',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $resource_management,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Production Planning & Execution',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $ppe =  Menu::where('name', 'Production Planning & Execution')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Production Planning & Execution - Create Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution - Release Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Release Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order.selectProjectRelease',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution - Confirm Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Confirm Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order.selectProjectConfirm',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution - Production Order Actual Cost Report
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Production Order Actual Cost Report',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order.selectProjectReport',
            'is_active' => true,
            'roles' => 'ADMIN',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution - View Production Order
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Production Order',
            'icon' => 'fa-wrench',
            'route_name' => 'production_order.selectProjectIndex',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $ppe,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution - Yard Plan
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

        // Building - Production Planning & Execution - Yard Plan - Manage Yard Plan
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Manage Yard Plan',
            'icon' => 'fa-wrench',
            'route_name' => 'yard_plan.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $yard_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Production Planning & Execution - Yard Plan - View Yard Plan
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Yard Plan',
            'icon' => 'fa-wrench',
            'route_name' => 'yard_plan.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $yard_plan,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Quality Control(QC)
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Quality Control',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $quality_control = Menu::where('name', 'Quality Control')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Quality Control(QC) - QC Task
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

        // Building - Quality Control(QC) - QC Task - Create QC Task
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create QC Task',
            'icon' => 'fa-wrench',
            'route_name' => 'qc_task.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control_task,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Quality Control(QC) - QC Task - View & Edit QC Task
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit QC Task',
            'icon' => 'fa-wrench',
            'route_name' => 'qc_task.selectProjectIndex',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control_task,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Quality Control(QC) - QC Task Confirmation
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'QC Task Confirmation',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control,
            'route_name' => 'qc_task.selectProjectConfirm',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Quality Control(QC) - QC Summary Report
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'QC Summary Report',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $quality_control,
            'route_name' => 'qc_task.selectProjectSummary',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Delivery
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Project Delivery',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $building,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $delivery = Menu::where('name', 'Project Delivery')->where('menu_id', $building)->select('id')->first()->id;

        // Building - Project Delivery - Manage Delivery Document
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Manage Delivery Document',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'delivery_document.selectProject',
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $delivery,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Delivery - View Delivery Document
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View Delivery Document',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'delivery_document.selectProjectIndex',
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $delivery,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        // Building - Project Delivery - Close Project
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Close Project',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'route_name' => 'close_project.selectProject',
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $delivery,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
