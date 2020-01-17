<?php

use Illuminate\Database\Seeder;
use App\Models\Menu; 

class CustomerPortalSidenavSeeder extends Seeder
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


        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        /**
         * ========================================================================
         * =                                ALL STAGE
         * ========================================================================
         */

        // Customer Portal
        $showProjectProgress = Menu::where('route_name', 'customer_portal.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $showProjectProgress,
            'route_name' => 'customer_portal.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $showProjectProgress,
            'route_name' => 'customer_portal.showProject',
        ]);

        $postReply = Menu::where('route_name', 'customer_portal.selectProjectReply')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $postReply,
            'route_name' => 'customer_portal.selectProjectReply',
        ]);

        $postComplaints = Menu::where('route_name', 'customer_portal.selectProjectPost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $postComplaints,
            'route_name' => 'customer_portal.selectProjectPost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $postComplaints,
            'route_name' => 'customer_portal.createPost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $postComplaints,
            'route_name' => 'customer_portal.selectPost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $postComplaints,
            'route_name' => 'customer_portal.showPost',
        ]);
    }
}
