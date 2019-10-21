<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class SidenavsV2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Sidenav/BillOfMaterialMenuSeeder::class);
        $this->call(Sidenav/ConfigurationMenuSeeder::class);
        $this->call(Sidenav/CostPlanMenuSeeder::class);
        $this->call(Sidenav/ProjectDeliveryMenuSeeder::class);
        $this->call(Sidenav/ProjectManagementMenuSeeder::class);
        $this->call(Sidenav/CustomerPortalMenuSeeder::class);
        $this->call(Sidenav/ImputDailyInformationMenuSeeder::class);
        $this->call(Sidenav/MarketingSalesMenuSeeder::class);
        $this->call(Sidenav/MasterDataMenuSeeder::class);
        $this->call(Sidenav/MaterialManagementMenuSeeder::class);
        $this->call(Sidenav/PermissionManagementMenuSeeder::class);
        $this->call(Sidenav/PicaMenuSeeder::class);
        $this->call(Sidenav/ProductionPlanningMenuSeeder::class);
        $this->call(Sidenav/QualityControlMenuSeeder::class);
        $this->call(Sidenav/ResourceManagementMenuSeeder::class);
        $this->call(Sidenav/RoleManagementMenuSeeder::class);
        $this->call(Sidenav/UserManagementMenuSeeder::class);
        $this->call(Sidenav/WipMenuSeeder::class);
    }
}
