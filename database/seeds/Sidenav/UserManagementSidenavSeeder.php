<?php

use Illuminate\Database\Seeder\Sidenav\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class UserManagementSidenavSeeder extends Seeder
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
        $user = Menu::where('route_name', 'user.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.change_password',
        ]);
    }
}
