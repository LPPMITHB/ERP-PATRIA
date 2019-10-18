<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class ProjectManagementMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dashboard = Menu::where('route_name', 'index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $dashboard,
            'route_name' => '.index',
        ]);
        /**
         * ========================================================================
         * =                              BUILDING STAGE
         * ========================================================================
         */
        // Project Management
        $manageProject = Menu::where('route_name', 'project.index')->select('id')->first()->id;
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

        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */
        $manageProjectRepair = Menu::where('route_name', 'project_repair.index')->select('id')->first()->id;
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
            'route_name' => 'project_repair.selectStructure',
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

        $wbsProfile = Menu::where('route_name', 'wbs.createWbsProfile')->select('id')->first()->id;
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

        $project_standard = Menu::where('route_name', 'project_standard.createProjectStandard')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $project_standard,
            'route_name' => 'project_standard.createProjectStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $project_standard,
            'route_name' => 'project_standard.createWbsStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $project_standard,
            'route_name' => 'project_standard.createSubWbsStandard',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $project_standard,
            'route_name' => 'project_standard.createActivityStandard',
        ]);

        $material_standard = Menu::where('route_name', 'project_standard.selectProjectMaterial')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $material_standard,
            'route_name' => 'project_standard.selectProject.material',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material_standard,
            'route_name' => 'project_standard.selectWBS.material',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material_standard,
            'route_name' => 'project_standard.manageMaterial',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material_standard,
            'route_name' => 'project_standard.showMaterialStandard',
        ]);

        $resource_standard = Menu::where('route_name', 'project_standard.selectProjectResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $resource_standard,
            'route_name' => 'project_standard.selectProject.resource',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $resource_standard,
            'route_name' => 'project_standard.selectWBS.resource',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $resource_standard,
            'route_name' => 'project_standard.manageResource',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $resource_standard,
            'route_name' => 'project_standard.showResourceStandard',
        ]);

        $projectConfig = Menu::where('route_name', 'project.selectProjectConfig')->select('id')->first()->id;
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

        

        
    }
}
