<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class DailyInformationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Input Daily Information',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $daily_info =  Menu::where('name', 'Input Daily Information')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Daily Man Hour',
            'icon' => 'fa-calendar',
            'route_name' => 'daily_man_hour.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $daily_info,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Weather',
            'icon' => 'fa-calendar',
            'route_name' => 'daily_weather.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $daily_info,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Tidal',
            'icon' => 'fa-calendar',
            'route_name' => 'daily_tidal.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $daily_info,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'PICA',
            'icon' => 'fa-calendar',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $pica =  Menu::where('name', 'PICA')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Create PICA',
            'icon' => 'fa-file-text-o',
            'route_name' => 'pica.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $pica,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View & Edit PICA',
            'icon' => 'fa-file-text-o',
            'route_name' => 'pica.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $pica,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
