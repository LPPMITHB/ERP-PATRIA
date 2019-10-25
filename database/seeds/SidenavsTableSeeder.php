<?php

use Illuminate\Database\Seeder;
use App\Models\Menu; 

class SidenavsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BillOfMaterialSidenavSeeder::class);
        $this->call(ConfigurationSidenavSeeder::class);
        $this->call(CostPlanSidenavSeeder::class);
        $this->call(ProjectDeliverySidenavSeeder::class);
        $this->call(ProjectManagementSidenavSeeder::class);
        $this->call(CustomerPortalSidenavSeeder::class);
        $this->call(DailyInformationSidenavSeeder::class);
        $this->call(MarketingSalesSidenavSeeder::class);
        $this->call(MasterDataSidenavSeeder::class);
        $this->call(MaterialManagementSidenavSeeder::class);
        $this->call(PermissionManagementSidenavSeeder::class);
        $this->call(PicaSidenavSeeder::class);
        $this->call(ProductionPlanningSidenavSeeder::class);
        $this->call(QualityControlSidenavSeeder::class);
        $this->call(ResourceManagementSidenavSeeder::class);
        $this->call(RoleManagementSidenavSeeder::class);
        $this->call(UserManagementSidenavSeeder::class);
        $this->call(WipSidenavSeeder::class);
    }
}
