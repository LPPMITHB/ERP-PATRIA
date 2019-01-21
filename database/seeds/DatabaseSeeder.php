<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompaniesTableSeeder::class);
        $this->call(BranchesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(MstCustomerTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SidenavsTableSeeder::class);
        $this->call(MstMaterialTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ShipsTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(StorageLocationsTableSeeder::class);
        $this->call(StorageLocationDetailsTableSeeder::class);
        $this->call(MstVendorTableSeeder::class);
        $this->call(BusinessUnitsTableSeeder::class);
        $this->call(StocksTableSeeder::class);
        $this->call(ResourcesTableSeeder::class);
        $this->call(YardsTableSeeder::class);
        $this->call(UOMTableSeeder::class);
        $this->call(ProProjectTableSeeder::class);
        $this->call(ProWbsTableSeeder::class);
        $this->call(ProActivityTableSeeder::class);
        $this->call(MstBomTableSeeder::class);
        $this->call(MstBomDetailTableSeeder::class);
        $this->call(TrxRapTableSeeder::class);
        $this->call(TrxRapDetailTableSeeder::class);
        $this->call(TrxPurchaseRequisitionTableSeeder::class);
        $this->call(TrxPurchaseRequisitionDetailTableSeeder::class);
        $this->call(TrxPurchaseOrderTableSeeder::class);
        $this->call(TrxPurchaseOrderDetailTableSeeder::class);
        $this->call(TrxProductionOrderTableSeeder::class);
        $this->call(TrxProductionOrderDetailTableSeeder::class);
        $this->call(WorkRequestTableSeeder::class); 
        $this->call(WorkRequestDetailTableSeeder::class); 
    }
}
