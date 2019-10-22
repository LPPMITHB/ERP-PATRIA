<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class ConfigurationMenuSeeder extends Seeder
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
            'name' => 'Configuration',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $configuration =  Menu::where('name', 'Configuration')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Menus',
            'icon' => 'fa-wrench',
            'route_name' => 'menus.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Appearance',
            'icon' => 'fa-wrench',
            'route_name' => 'appearance.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Currencies',
            'icon' => 'fa-wrench',
            'route_name' => 'currencies.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Change Default Password',
            'icon' => 'fa-wrench',
            'route_name' => 'user.changeDefaultPassword',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Density',
            'icon' => 'fa-wrench',
            'route_name' => 'density.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material Family',
            'icon' => 'fa-wrench',
            'route_name' => 'material_family.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Cost Type',
            'icon' => 'fa-wrench',
            'route_name' => 'cost_type.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Payment Terms',
            'icon' => 'fa-wrench',
            'route_name' => 'payment_terms.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Delivery Terms',
            'icon' => 'fa-wrench',
            'route_name' => 'delivery_terms.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Weather Configuration',
            'icon' => 'fa-wrench',
            'route_name' => 'weather.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Tidal Configuration',
            'icon' => 'fa-wrench',
            'route_name' => 'tidal.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Dimension Type Configuration',
            'icon' => 'fa-wrench',
            'route_name' => 'dimension_type.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Approval Configuration',
            'icon' => 'fa-wrench',
            'route_name' => 'approval.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $configuration,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
