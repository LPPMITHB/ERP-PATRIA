<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class MarketingSalesSidenavSeeder extends Seeder
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
        // Marketing & Sales - WBS Cost Estimation
        $wbsCostEstimationBuilding = Menu::where('route_name', 'estimator.indexEstimatorWbs')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $wbsCostEstimationBuilding,
            'route_name' => 'estimator.indexEstimatorWbs',
        ]);
        DB::table('sidenav')->insert([
            'menu_id' => $wbsCostEstimationBuilding,
            'route_name' => 'estimator.createWbs',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsCostEstimationBuilding,
            'route_name' => 'estimator.editWbs',
        ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsCostEstimation,
        //     'route_name' => 'estimator.showWbs',
        // ]);

        // Marketing & Sales - Cost Standard
        $CostStandardBuilding = Menu::where('route_name', 'estimator.indexEstimatorCostStandard')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardBuilding,
            'route_name' => 'estimator.indexEstimatorCostStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardBuilding,
            'route_name' => 'estimator.createCostStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardBuilding,
            'route_name' => 'estimator.editCostStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardBuilding,
            'route_name' => 'estimator.showCostStandard',
        ]);

        // Marketing & Sales - Estimator Profile
        $EstimatorProfile = Menu::where('route_name', 'estimator.indexEstimatorProfile')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator.indexEstimatorProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator.createProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator.editProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator.showProfile',
        ]);

        // Marketing & Sales - Quotation
        $createQuotation = Menu::where('route_name', 'quotation.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createQuotation,
            'route_name' => 'quotation.create',
        ]);

        $viewQuotation = Menu::where('route_name', 'quotation.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewQuotation,
            'route_name' => 'quotation.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQuotation,
            'route_name' => 'quotation.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQuotation,
            'route_name' => 'quotation.edit',
        ]);

        // Marketing & Sales - Sales Order
        $createSO = Menu::where('route_name', 'sales_order.selectQT')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createSO,
            'route_name' => 'sales_order.selectQT',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createSO,
            'route_name' => 'sales_order.create',
        ]);

        $viewSO = Menu::where('route_name', 'sales_order.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewSO,
            'route_name' => 'sales_order.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewSO,
            'route_name' => 'sales_order.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewSO,
            'route_name' => 'sales_order.edit',
        ]);

        // Marketing & Sales - Invoice
        $createInvoice = Menu::where('route_name', 'invoice.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createInvoice,
            'route_name' => 'invoice.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createInvoice,
            'route_name' => 'invoice.create',
        ]);

        $viewInvoice = Menu::where('route_name', 'invoice.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewInvoice,
            'route_name' => 'invoice.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewInvoice,
            'route_name' => 'invoice.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewInvoice,
            'route_name' => 'invoice.edit',
        ]);

        // Marketing & Sales - Payment
        $managePayment = Menu::where('route_name', 'payment.selectInvoice')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $managePayment,
            'route_name' => 'payment.selectInvoice',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $managePayment,
            'route_name' => 'payment.manage',
        ]);

        $viewPayment = Menu::where('route_name', 'payment.selectInvoiceView')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPayment,
            'route_name' => 'payment.selectInvoiceView',
        ]);

        // Marketing & Sales - Sales Plan
        $manageSalesPlan = Menu::where('route_name', 'sales_plan.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageSalesPlan,
            'route_name' => 'sales_plan.index',
        ]);

        // Marketing & Sales - Customer Visit
        $manageCustomerVisit = Menu::where('route_name', 'customer_visit.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageCustomerVisit,
            'route_name' => 'customer_visit.index',
        ]);



        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */
        // Marketing & Sales - WBS Cost Estimation Repair
        $wbsCostEstimationRepair = Menu::where('route_name', 'estimator_repair.indexEstimatorWbs')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $wbsCostEstimationRepair,
            'route_name' => 'estimator_repair.indexEstimatorWbs',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsCostEstimationRepair,
            'route_name' => 'estimator_repair.createWbs',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $wbsCostEstimationRepair,
            'route_name' => 'estimator_repair.editWbs',
        ]);



        // Marketing & Sales - Cost Standard Repair
        $CostStandardRepair = Menu::where('route_name', 'estimator_repair.indexEstimatorCostStandard')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardRepair,
            'route_name' => 'estimator_repair.indexEstimatorCostStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardRepair,
            'route_name' => 'estimator_repair.createCostStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardRepair,
            'route_name' => 'estimator_repair.editCostStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $CostStandardRepair,
            'route_name' => 'estimator_repair.showCostStandard',
        ]);

        // Marketing & Sales - Estimator Profile Repair
        $EstimatorProfile = Menu::where('route_name', 'estimator_repair.indexEstimatorProfile')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator_repair.indexEstimatorProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator_repair.createEstimatorProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator_repair.editEstimatorProfile',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $EstimatorProfile,
            'route_name' => 'estimator_repair.showEstimatorProfile',
        ]);

        // Marketing & Sales - Quotation Repair
        $createQuotation = Menu::where('route_name', 'quotation_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createQuotation,
            'route_name' => 'quotation_repair.create',
        ]);

        $viewQuotation = Menu::where('route_name', 'quotation_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewQuotation,
            'route_name' => 'quotation_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQuotation,
            'route_name' => 'quotation_repair.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQuotation,
            'route_name' => 'quotation_repair.edit',
        ]);

        // Marketing & Sales - Sales Order Repair
        $createSO = Menu::where('route_name', 'sales_order_repair.selectQT')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createSO,
            'route_name' => 'sales_order_repair.selectQT',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createSO,
            'route_name' => 'sales_order_repair.create',
        ]);

        $viewSO = Menu::where('route_name', 'sales_order_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewSO,
            'route_name' => 'sales_order_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewSO,
            'route_name' => 'sales_order_repair.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewSO,
            'route_name' => 'sales_order_repair.edit',
        ]);

        // Marketing & Sales -  Invoice Repair
        $createInvoice = Menu::where('route_name', 'invoice_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createInvoice,
            'route_name' => 'invoice_repair.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createInvoice,
            'route_name' => 'invoice_repair.create',
        ]);

        $viewInvoice = Menu::where('route_name', 'invoice_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewInvoice,
            'route_name' => 'invoice_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewInvoice,
            'route_name' => 'invoice_repair.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewInvoice,
            'route_name' => 'invoice_repair.edit',
        ]);

        // Marketing & Sales - Payment Repair
        $managePayment = Menu::where('route_name', 'payment_repair.selectInvoice')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $managePayment,
            'route_name' => 'payment_repair.selectInvoice',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $managePayment,
            'route_name' => 'payment_repair.manage',
        ]);

        //  // Sales Plan Repair
        //  $manageSalesPlanRepair = Menu::where('route_name','sales_plan_repair.index')->select('id')->first()->id;
        //  DB::table('sidenav')->insert([
        //      'menu_id' => $manageSalesPlanRepair,
        //      'route_name' => 'sales_plan_repair.index',
        //  ]);
        // DB::table('sidenav')->insert([
        //     'menu_id' => $wbsCostEstimation,
        //     'route_name' => 'estimator_repair.showWbs',
        // ]);
        // // Customer Visit Repair
        // $manageCustomerVisitRepair = Menu::where('route_name','customer_visit_repair.index')->select('id')->first()->id;
        // DB::table('sidenav')->insert([
        //     'menu_id' => $manageCustomerVisitRepair,
        //     'route_name' => 'customer_visit_repair.index',
        // ]);
    }
}
