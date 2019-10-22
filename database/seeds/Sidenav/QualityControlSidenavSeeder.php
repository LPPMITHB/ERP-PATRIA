<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class QualityControlSidenavSeeder extends Seeder
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

        // Building - Quality Control - Task
        $viewQcTaskBuilding = Menu::where('route_name', 'qc_task.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewQcTaskBuilding,
            'route_name' => 'qc_task.index',
        ]);

        $createQcTaskBuilding = Menu::where('route_name', 'qc_task.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createQcTaskBuilding,
            'route_name' => 'qc_task.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQcTaskBuilding,
            'route_name' => 'qc_task.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQcTaskBuilding,
            'route_name' => 'qc_task.selectProjectIndex',
        ]);

        $confirmQcTaskSPCBuilding = Menu::where('route_name', 'qc_task.selectProjectConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcTaskSPCBuilding,
            'route_name' => 'qc_task.selectProjectConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcTaskSPCBuilding,
            'route_name' => 'qc_task.confirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcTaskSPCBuilding,
            'route_name' => 'qc_task.selectQcTask',
        ]);

        $confirmQcTaskPSBuilding = Menu::where('route_name', 'qc_task.selectProjectSummary')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcTaskPSBuilding,
            'route_name' => 'qc_task.selectProjectSummary',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcTaskPSBuilding,
            'route_name' => 'qc_task.summaryReport',
        ]);

        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        // Repairing - Quality Control - Task
        $viewQcTaskRepair = Menu::where('route_name', 'qc_task_repair.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewQcTaskRepair,
            'route_name' => 'qc_task_repair.index',
        ]);

        $createQcTaskRepair = Menu::where('route_name', 'qc_task_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createQcTaskRepair,
            'route_name' => 'qc_task_repair.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQcTaskRepair,
            'route_name' => 'qc_task_repair.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewQcTaskRepair,
            'route_name' => 'qc_task_repair.selectProjectIndex',
        ]);

        $confirmQcSPCTaskRepair = Menu::where('route_name', 'qc_task_repair.selectProjectConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcSPCTaskRepair,
            'route_name' => 'qc_task_repair.selectProjectConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcSPCTaskRepair,
            'route_name' => 'qc_task_repair.confirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcSPCTaskRepair,
            'route_name' => 'qc_task_repair.selectQcTask',
        ]);

        $confirmQcPSTaskRepair = Menu::where('route_name', 'qc_task_repair.selectProjectSummary')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcPSTaskRepair,
            'route_name' => 'qc_task_repair.selectProjectSummary',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmQcPSTaskRepair,
            'route_name' => 'qc_task_repair.summaryReport',
        ]);
    }
}
