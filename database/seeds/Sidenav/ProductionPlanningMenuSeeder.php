<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class ProductionPlanningMenuSeeder extends Seeder
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

        // Building - Production Planning - Production Order
        $createProductionOrder = Menu::where('route_name', 'production_order.selectProject')->select('id')->first()->id;
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

        $releaseProductionOrder = Menu::where('route_name', 'production_order.selectProjectRelease')->select('id')->first()->id;
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

        $confirmProductionOrder = Menu::where('route_name', 'production_order.selectProjectConfirm')->select('id')->first()->id;
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

        $reportProductionOrder = Menu::where('route_name', 'production_order.selectProjectReport')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order.selectProjectReport',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order.selectWOReport',
        ]);

        $indexProductionOrder = Menu::where('route_name', 'production_order.selectProjectIndex')->select('id')->first()->id;
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

        /// Building - Production Planning - Yard Plan
        $yardPlan = Menu::where('route_name', 'yard_plan.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yardPlan,
            'route_name' => 'yard_plan.index',
        ]);
        $manageYardPlan = Menu::where('route_name', 'yard_plan.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageYardPlan,
            'route_name' => 'yard_plan.create',
        ]);


        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        // Repairing - Production Planning - Production Order
        $createProductionOrder = Menu::where('route_name', 'production_order_repair.selectProject')->select('id')->first()->id;
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

        $releaseProductionOrder = Menu::where('route_name', 'production_order_repair.selectProjectRelease')->select('id')->first()->id;
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

        $confirmProductionOrder = Menu::where('route_name', 'production_order_repair.selectProjectConfirm')->select('id')->first()->id;
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

        $reportProductionOrder = Menu::where('route_name', 'production_order_repair.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order_repair.selectProjectReport',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $reportProductionOrder,
            'route_name' => 'production_order_repair.selectWOReport',
        ]);

        $indexProductionOrderRepair = Menu::where('route_name', 'production_order_repair.selectProjectIndex')->select('id')->first()->id;
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

        $yardPlanRepair = Menu::where('route_name', 'yard_plan_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yardPlanRepair,
            'route_name' => 'yard_plan_repair.index',
        ]);

        $manageYardPlanRepair = Menu::where('route_name', 'yard_plan_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageYardPlan,
            'route_name' => 'yard_plan_repair.create',
        ]);
        
    }
}
