<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class CostPlanMenuSeeder extends Seeder
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

        // Building - CostPlan - RAP
        $viewRap = Menu::where('route_name', 'rap.indexSelectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap.indexSelectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap.index',
        ]);

        $createCost = Menu::where('route_name', 'rap.selectProjectCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap.selectProjectCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap.createCost',
        ]);

        $inputActualOtherCost = Menu::where('route_name', 'rap.selectProjectActualOtherCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap.selectProjectActualOtherCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap.inputActualOtherCost',
        ]);

        $projectPlanOtherCost = Menu::where('route_name', 'rap.selectProjectPlanOtherCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $projectPlanOtherCost,
            'route_name' => 'rap.selectProjectPlanOtherCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $projectPlanOtherCost,
            'route_name' => 'rap.inputApprovalProjectPlanOtherCost',
        ]);

        $viewPlannedCost = Menu::where('route_name', 'rap.selectProjectViewCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap.selectProjectViewCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap.viewPlannedCost',
        ]);

        $viewRemainingMaterial = Menu::where('route_name', 'rap.selectProjectViewRM')->select('id')->first()->id;
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

        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        // Repairing - CostPlan - RAP
        $viewRap = Menu::where('route_name', 'rap_repair.indexSelectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap_repair.indexSelectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRap,
            'route_name' => 'rap_repair.index',
        ]);

        $createCost = Menu::where('route_name', 'rap_repair.selectProjectCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap_repair.selectProjectCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rap_repair.createCost',
        ]);

        $inputActualOtherCost = Menu::where('route_name', 'rap_repair.selectProjectActualOtherCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap_repair.selectProjectActualOtherCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $inputActualOtherCost,
            'route_name' => 'rap_repair.inputActualOtherCost',
        ]);

        $viewPlannedCost = Menu::where('route_name', 'rap_repair.selectProjectViewCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap_repair.selectProjectViewCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rap_repair.viewPlannedCost',
        ]);

        $viewRemainingMaterial = Menu::where('route_name', 'rap_repair.selectProjectViewRM')->select('id')->first()->id;
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
    }
}
