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
        $this->call(UsersTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SidenavsTableSeeder::class);
        $this->call(MaterialsTableSeeder::class);
        $this->call(ShipsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(WarehousesTableSeeder::class);
        $this->call(StorageLocationsTableSeeder::class);
        $this->call(StorageLocationDetailsTableSeeder::class);
        $this->call(VendorsTableSeeder::class);
        $this->call(BusinessUnitsTableSeeder::class);    
        $this->call(ProjectsTableSeeder::class);
        $this->call(StructuresTableSeeder::class);
        $this->call(StocksTableSeeder::class);
        $this->call(ProjectWbsTableSeeder::class);
        $this->call(ProjectActivityTableSeeder::class);
        $this->call(BOMsTableSeeder::class);
        $this->call(BOMDetailsTableSeeder::class);
        $this->call(RAPTableSeeder::class);        
        $this->call(RAPDetailsTableSeeder::class);
        $this->call(PRTableSeeder::class);
        $this->call(PRDetailsTableSeeder::class);
        $this->call(POTableSeeder::class);
        $this->call(PODetailsTableSeeder::class);
        $this->call(YardsTableSeeder::class);
        $this->call(UOMTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ResourcesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ProductionOrderTableSeeder::class);
        $this->call(ProductionOrderDetailsTableSeeder::class);    
    }
}
