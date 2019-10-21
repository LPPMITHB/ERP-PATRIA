<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class BillOfMaterialMenuSeeder extends Seeder
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
        $manage_billofmaterial_building = Menu::where('route_name', 'bom.indexProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manage_billofmaterial_building,
            'route_name' => 'bom.indexProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_billofmaterial_building,
            'route_name' => 'bom.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_billofmaterial_building,
            'route_name' => 'bom.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_billofmaterial_building,
            'route_name' => 'bom.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_billofmaterial_building,
            'route_name' => 'bom.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_billofmaterial_building,
            'route_name' => 'bom.manageWbsMaterialBuilding',
        ]);

        $menu_material_requirement_sum = Menu::where('route_name', 'bom.selectProjectSum')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $menu_material_requirement_sum,
            'route_name' => 'bom.selectProjectSum',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menu_material_requirement_sum,
            'route_name' => 'bom.selectWBSSum',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menu_material_requirement_sum,
            'route_name' => 'bom.materialSummaryBuilding',
        ]);
        
        $view_billofmaterial_building = Menu::where('route_name', 'bom.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $view_billofmaterial_building,
            'route_name' => 'bom.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $view_billofmaterial_building,
            'route_name' => 'bom.indexBom',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $view_billofmaterial_building,
            'route_name' => 'bom.show',
        ]);

        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */
        $manage_wbs_material_repair = Menu::where('route_name', 'bom_repair.selectProjectManage')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manage_wbs_material_repair,
            'route_name' => 'bom_repair.selectProjectManage',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_wbs_material_repair,
            'route_name' => 'bom_repair.selectWBSManage',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manage_wbs_material_repair,
            'route_name' => 'bom_repair.manageWbsMaterial',
        ]);

        // bom repair material requirement summary
        $summary_material_repair = Menu::where('route_name', 'bom_repair.selectProjectSum')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $summary_material_repair,
            'route_name' => 'bom_repair.selectProjectSum',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $summary_material_repair,
            'route_name' => 'bom_repair.materialSummary',
        ]);

        $view_bom_repair = Menu::where('route_name', 'bom_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $view_bom_repair,
            'route_name' => 'bom_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $view_bom_repair,
            'route_name' => 'bom_repair.selectProject',
        ]);
    }
}
