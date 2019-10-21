<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MasterDataMenuSeeder extends Seeder
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
            'name' => 'Trading',
            'icon' => 'fa-archive',
            'is_active' => true,
            'roles' => 'ADMIN',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 1,
            'name' => 'Master Data',
            'icon' => 'fa-database',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);


        $masterData =  Menu::where('name', 'Master Data')->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Branch',
            'icon' => 'fa-wrench',
            'route_name' => 'branch.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Business Unit',
            'icon' => 'fa-wrench',
            'route_name' => 'business_unit.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Company',
            'icon' => 'fa-wrench',
            'route_name' => 'company.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Customer',
            'icon' => 'fa-wrench',
            'route_name' => 'customer.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Material',
            'icon' => 'fa-wrench',
            'route_name' => 'material.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Service',
            'icon' => 'fa-wrench',
            'route_name' => 'service.index',
            'is_active' => true,
            'roles' => 'ADMIN,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Ship',
            'icon' => 'fa-wrench',
            'route_name' => 'ship.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Storage Location',
            'icon' => 'fa-wrench',
            'route_name' => 'storage_location.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Unit Of Measurement',
            'icon' => 'fa-wrench',
            'route_name' => 'unit_of_measurement.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Vendor',
            'icon' => 'fa-wrench',
            'route_name' => 'vendor.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);


        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Warehouse',
            'icon' => 'fa-wrench',
            'route_name' => 'warehouse.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 2,
            'name' => 'Yard',
            'icon' => 'fa-wrench',
            'route_name' => 'yard.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'QC Type',
            'icon' => 'fa-wrench',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $masterData,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        $qcType =  Menu::where('name', 'QC Type')->where('menu_id', $masterData)->select('id')->first()->id;
        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'Create QC Type',
            'icon' => 'fa-wrench',
            'route_name' => 'qc_type.create',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $qcType,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);

        DB::table('menus')->insert([
            'level' => 3,
            'name' => 'View & Edit QC Type',
            'icon' => 'fa-wrench',
            'route_name' => 'qc_type.index',
            'is_active' => true,
            'roles' => 'ADMIN,PMP,PAMI',
            'menu_id' => $qcType,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d')
        ]);
    }
}
