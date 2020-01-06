<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class PermissionManagementSidenavSeeder extends Seeder
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
        $permission = Menu::where('route_name', 'permission.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.edit',
        ]);
    }
}
