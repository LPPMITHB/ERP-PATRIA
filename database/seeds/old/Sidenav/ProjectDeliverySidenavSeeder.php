<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class ProjectDeliverySidenavSeeder extends Seeder
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
        // Delivery Documents
        $manageDeliveryDocuments = Menu::where('route_name', 'delivery_document.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageDeliveryDocuments,
            'route_name' => 'delivery_document.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageDeliveryDocuments,
            'route_name' => 'delivery_document.manage',
        ]);
        // Delivery Documents
        $showDeliveryDocuments = Menu::where('route_name', 'delivery_document.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $showDeliveryDocuments,
            'route_name' => 'delivery_document.selectProjectIndex',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $showDeliveryDocuments,
            'route_name' => 'delivery_document.index',
        ]);
        // Close Project
        $closeProject = Menu::where('route_name', 'close_project.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $closeProject,
            'route_name' => 'close_project.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $closeProject,
            'route_name' => 'close_project.index',
        ]);
        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */
        // Delivery Documents
        $manageDeliveryDocumentsRepair = Menu::where('route_name', 'delivery_document_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageDeliveryDocumentsRepair,
            'route_name' => 'delivery_document_repair.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageDeliveryDocumentsRepair,
            'route_name' => 'delivery_document_repair.manage',
        ]);
        // Delivery Documents
        $showDeliveryDocumentsRepair = Menu::where('route_name', 'delivery_document_repair.selectProjectIndex')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $showDeliveryDocumentsRepair,
            'route_name' => 'delivery_document_repair.selectProjectIndex',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $showDeliveryDocumentsRepair,
            'route_name' => 'delivery_document_repair.index',
        ]);
        // Close Project
        $closeProjectRepair = Menu::where('route_name', 'close_project_repair.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $closeProjectRepair,
            'route_name' => 'close_project_repair.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $closeProjectRepair,
            'route_name' => 'close_project_repair.index',
        ]);
    }
}
