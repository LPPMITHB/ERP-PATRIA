<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class ProjectDeliveryMenuSeeder extends Seeder
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
    }
}
