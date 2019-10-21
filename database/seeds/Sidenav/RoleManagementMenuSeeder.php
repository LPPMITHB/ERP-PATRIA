<?php

use Illuminate\Database\Seeder\Sidenav;
use Illuminate\Database\Seeder;
use App\Models\Menu; 

class RoleManagementMenuSeeder extends Seeder
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
        $role = Menu::where('route_name', 'role.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.edit',
        ]);
    }
}
