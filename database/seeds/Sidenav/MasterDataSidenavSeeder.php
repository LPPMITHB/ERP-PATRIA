<?php


use Illuminate\Database\Seeder;
use App\Models\Menu; 

class MasterDataSidenavSeeder extends Seeder
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

        // Master Data - Branch
        $branch = Menu::where('route_name', 'branch.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.index',
        ]);
        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.edit',
        ]);
        // Master Data - Business Unit
        $business_unit = Menu::where('route_name', 'business_unit.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $business_unit,
            'route_name' => 'business_unit.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $business_unit,
            'route_name' => 'business_unit.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $business_unit,
            'route_name' => 'business_unit.edit',
        ]);
        // Master Data - Company
        $company = Menu::where('route_name', 'company.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.edit',
        ]);

        // Master Data - Storage Location
        $storageLocation = Menu::where('route_name', 'storage_location.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.edit',
        ]);

        // Master Data - Customer
        $customer = Menu::where('route_name', 'customer.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.edit',
        ]);

        // Master Data - Material
        $material = Menu::where('route_name', 'material.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.edit',
        ]);

        // Master Data - Vendor
        $vendor = Menu::where('route_name', 'vendor.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.edit',
        ]);

        // Master Data - Warehouse
        $warehouse = Menu::where('route_name', 'warehouse.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $warehouse,
            'route_name' => 'warehouse.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $warehouse,
            'route_name' => 'warehouse.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $warehouse,
            'route_name' => 'warehouse.edit',
        ]);

        // Master Data - Shipyard
        $yard = Menu::where('route_name', 'yard.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yard,
            'route_name' => 'yard.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $yard,
            'route_name' => 'yard.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $yard,
            'route_name' => 'yard.edit',
        ]);

        // Master Data - Ship
        $ship = Menu::where('route_name', 'ship.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.edit',
        ]);

        // Master Data - Qc Type
        $menu_create_qc_type = Menu::where('route_name', 'qc_type.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $menu_create_qc_type,
            'route_name' => 'qc_type.create',
        ]);

        $qcType = Menu::where('route_name', 'qc_type.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $qcType,
            'route_name' => 'qc_type.index',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $qcType,
            'route_name' => 'qc_type.edit',
        ]);
        
        // Master Data - Manage Service
        $manageService = Menu::where('route_name', 'service.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageService,
            'route_name' => 'service.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageService,
            'route_name' => 'service.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageService,
            'route_name' => 'service.edit',
        ]);
    }
}
