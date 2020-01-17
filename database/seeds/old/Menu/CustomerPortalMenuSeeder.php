<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class CustomerPortalMenuSeeder extends Seeder
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
            'name' => 'Customer Portal',
            'icon' => 'fa-file-text-o',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI,CUSTOMER',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $customer_portal =  Menu::where('name', 'Customer Portal')->select('id')->first()->id;
        
        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'View Project Progress',
            'icon' => 'fa-file-text-o',
            'route_name' => 'customer_portal.selectProject',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI,CUSTOMER',
            'menu_id' => $customer_portal,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Post Complaints',
            'icon' => 'fa-file-text-o',
            'route_name' => 'customer_portal.selectProjectPost',
            'is_active' => true,
            'roles' => 'CUSTOMER',
            'menu_id' => $customer_portal,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 4,
            'name' => 'Reply Complaints',
            'icon' => 'fa-file-text-o',
            'route_name' => 'customer_portal.selectProjectReply',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $customer_portal,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
