<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class ResourceManagementSidenavSeeder extends Seeder
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

        // Building - Resource
        $manageResource = Menu::where('route_name', 'resource.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.edit',
        ]);

        $selectPOResource = Menu::where('route_name', 'resource.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResource,
            'route_name' => 'resource.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResource,
            'route_name' => 'resource.createGR',
        ]);

        $indexReceived = Menu::where('route_name', 'resource.indexReceived')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexReceived,
            'route_name' => 'resource.indexReceived',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexReceived,
            'route_name' => 'resource.showGR',
        ]);

        $indexIssued = Menu::where('route_name', 'resource.indexIssued')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexIssued,
            'route_name' => 'resource.indexIssued',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexIssued,
            'route_name' => 'resource.showGI',
        ]);

        $issueResource = Menu::where('route_name', 'resource.issueResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $issueResource,
            'route_name' => 'resource.issueResource',
        ]);

        $resourceSchedule = Menu::where('route_name', 'resource.resourceSchedule')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $resourceSchedule,
            'route_name' => 'resource.resourceSchedule',
        ]);


        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */


         //Repairing - Resource
        $manageResourceRepair = Menu::where('route_name', 'resource_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageResourceRepair,
            'route_name' => 'resource_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResourceRepair,
            'route_name' => 'resource_repair.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResourceRepair,
            'route_name' => 'resource_repair.edit',
        ]);

        $assignResourceRepair = Menu::where('route_name', 'resource_repair.assignResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignResourceRepair,
            'route_name' => 'resource_repair.assignResource',
        ]);

        $selectPOResourceRepair = Menu::where('route_name', 'resource_repair.selectPO')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResourceRepair,
            'route_name' => 'resource_repair.selectPO',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $selectPOResourceRepair,
            'route_name' => 'resource_repair.createGR',
        ]);

        $indexReceivedRepair = Menu::where('route_name', 'resource_repair.indexReceived')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexReceivedRepair,
            'route_name' => 'resource_repair.indexReceived',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexReceivedRepair,
            'route_name' => 'resource_repair.showGR',
        ]);

        $indexIssuedRepair = Menu::where('route_name', 'resource_repair.indexIssued')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexIssuedRepair,
            'route_name' => 'resource_repair.indexIssued',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexIssuedRepair,
            'route_name' => 'resource_repair.showGI',
        ]);

        $issueResourceRepair = Menu::where('route_name', 'resource_repair.issueResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $issueResourceRepair,
            'route_name' => 'resource_repair.issueResource',
        ]);

        $resourceScheduleRepair = Menu::where('route_name', 'resource_repair.resourceSchedule')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $resourceScheduleRepair,
            'route_name' => 'resource_repair.resourceSchedule',
        ]);



        $assignResource = Menu::where('route_name', 'resource.assignResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignResource,
            'route_name' => 'resource.assignResource',
        ]);

        /**
         * ========================================================================
         * =                                ALL STAGE
         * ========================================================================
         */
    }
}
