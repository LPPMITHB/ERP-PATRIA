<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class WipSidenavSeeder extends Seeder
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

        // Building - WIP - Work Order
        $createWO = Menu::where('route_name', 'work_order.selectWR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWO,
            'route_name' => 'work_order.selectWR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWO,
            'route_name' => 'work_order.selectWRD',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWO,
            'route_name' => 'work_order.create',
        ]);

        $approveWO = Menu::where('route_name', 'work_order.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveWO,
            'route_name' => 'work_order.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveWO,
            'route_name' => 'work_order.showApprove',
        ]);

        $viewWO = Menu::where('route_name', 'work_order.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWO,
            'route_name' => 'work_order.index',
        ]);

        // Building - WIP - Work Request
        $createWr = Menu::where('route_name', 'work_request.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWr,
            'route_name' => 'work_request.create',
        ]);

        $indexApproveWR = Menu::where('route_name', 'work_request.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWR,
            'route_name' => 'work_request.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWR,
            'route_name' => 'work_request.showApprove',
        ]);

        $viewWr = Menu::where('route_name', 'work_request.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWr,
            'route_name' => 'work_request.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewWr,
            'route_name' => 'work_request.edit',
        ]);

        /**
         * ========================================================================
         * =                                REPAIRING STAGE
         * ========================================================================
         */

        // Repairing - WIP - Work Order
        $createWORepair = Menu::where('route_name', 'work_order_repair.selectWR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWORepair,
            'route_name' => 'work_order_repair.selectWR',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWORepair,
            'route_name' => 'work_order_repair.selectWRD',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $createWORepair,
            'route_name' => 'work_order_repair.create',
        ]);

        $approveWORepair = Menu::where('route_name', 'work_order_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $approveWORepair,
            'route_name' => 'work_order_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $approveWORepair,
            'route_name' => 'work_order_repair.showApprove',
        ]);

        $viewWORepair = Menu::where('route_name', 'work_order_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWORepair,
            'route_name' => 'work_order_repair.index',
        ]);

        // Repairing - WIP - Work Request
        $createWrRepair = Menu::where('route_name', 'work_request_repair.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createWrRepair,
            'route_name' => 'work_request_repair.create',
        ]);

        $indexApproveWRRepair = Menu::where('route_name', 'work_request_repair.indexApprove')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWRRepair,
            'route_name' => 'work_request_repair.indexApprove',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $indexApproveWRRepair,
            'route_name' => 'work_request_repair.showApprove',
        ]);

        $viewWrRepair = Menu::where('route_name', 'work_request_repair.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewWrRepair,
            'route_name' => 'work_request_repair.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewWrRepair,
            'route_name' => 'work_request_repair.edit',
        ]);
    }
}
