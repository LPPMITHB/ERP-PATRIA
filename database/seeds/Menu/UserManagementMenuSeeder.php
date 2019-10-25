<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class UserManagementMenuSeeder extends Seeder
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
            'name' => 'User Management',
            'icon' => 'fa-users',
            'route_name' => 'user.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Role Management',
            'icon' => 'fa-user-secret',
            'route_name' => 'role.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Permission Management',
            'icon' => 'fa-ban',
            'route_name' => 'permission.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}
