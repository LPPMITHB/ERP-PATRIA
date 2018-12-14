<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Dashboard
        $dashboard = Menu::where('name','Dashboard')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Show Dashboard',
            'menu_id' => $dashboard,
            'middleware' => 'show-dashboard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        //Project
        $manageProject = Menu::where('name','Manage Projects')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Project',
            'menu_id' => $manageProject,
            'middleware' => 'index-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Project',
            'menu_id' => $manageProject,
            'middleware' => 'create-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Project',
            'menu_id' => $manageProject,
            'middleware' => 'show-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Project',
            'menu_id' => $manageProject,
            'middleware' => 'edit-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Project',
            'menu_id' => $manageProject,
            'middleware' => 'destroy-project',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Project Repair
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $projectManagementRepair =  Menu::where('name','Project Management')->where('menu_id',$repair)->select('id')->first()->id;
        $manageProjectRepair = Menu::where('name','Manage Projects')->where('menu_id',$projectManagementRepair)->select('id')->first()->id;
        
        DB::table('permissions')->insert([
            'name' => 'Index Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'index-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'create-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'show-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'edit-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Project',
            'menu_id' => $manageProjectRepair,
            'middleware' => 'destroy-project-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //BOM
        $manageBOM = Menu::where('name','Manage BOM')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'index-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Manage Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'create-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'show-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'edit-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Bom',
            'menu_id' => $manageBOM,
            'middleware' => 'destroy-bom',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //BOM Repair
        $repair =  Menu::where('name','Ship Repair')->select('id')->first()->id;
        $bomRepair =  Menu::where('name','Bill Of Material')->where('menu_id',$repair)->select('id')->first()->id;
        $manageBOMRepair = Menu::where('name','Manage BOM')->where('menu_id',$bomRepair)->select('id')->first()->id;
        
        DB::table('permissions')->insert([
            'name' => 'Index Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'index-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Manage Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'create-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'show-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'edit-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Bom Repair',
            'menu_id' => $manageBOMRepair,
            'middleware' => 'destroy-bom-repair',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //BOS
        $manageBOS = Menu::where('name','Manage BOS')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Bos',
            'menu_id' => $manageBOS,
            'middleware' => 'index-bos',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Manage Bos',
            'menu_id' => $manageBOS,
            'middleware' => 'create-bos',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Bos',
            'menu_id' => $manageBOS,
            'middleware' => 'show-bos',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Bos',
            'menu_id' => $manageBOS,
            'middleware' => 'edit-bos',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Bos',
            'menu_id' => $manageBOS,
            'middleware' => 'destroy-bos',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        //RAP
        // $createRAP = Menu::where('name','Create RAP')->select('id')->first()->id;
        // DB::table('permissions')->insert([
        //     'name' => 'Create Rap',
        //     'menu_id' => $createRAP,
        //     'middleware' => 'create-rap',
        //     'created_at' => date('Y-m-d'),
        //     'updated_at' => date('Y-m-d'),
        // ]);

        $viewRAP = Menu::where('name','Manage RAP')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'index-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'show-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'edit-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Rap',
            'menu_id' => $viewRAP,
            'middleware' => 'destroy-rap',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Purchase Requisition
        $createPR = Menu::where('name','Create PR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Purchase Requisition',
            'menu_id' => $createPR,
            'middleware' => 'create-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPR = Menu::where('name','View PR')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'index-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'show-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'edit-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Purchase Requisition',
            'menu_id' => $viewPR,
            'middleware' => 'destroy-purchase-requisition',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Purchase Order
        $createPO = Menu::where('name','Create PO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Purchase Order',
            'menu_id' => $createPO,
            'middleware' => 'create-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        $viewPO = Menu::where('name','View PO')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'index-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'show-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'edit-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Purchase Order',
            'menu_id' => $viewPO,
            'middleware' => 'destroy-purchase-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Ship
        $ship = Menu::where('name','Ship')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Ship',
            'menu_id' => $ship,
            'middleware' => 'index-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Ship',
            'menu_id' => $ship,
            'middleware' => 'create-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Ship',
            'menu_id' => $ship,
            'middleware' => 'show-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Ship',
            'menu_id' => $ship,
            'middleware' => 'edit-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Ship',
            'menu_id' => $ship,
            'middleware' => 'destroy-ship',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
        
        //Master Data Branch
        $branch = Menu::where('name','Branch')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Branch',
            'menu_id' => $branch,
            'middleware' => 'index-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Branch',
            'menu_id' => $branch,
            'middleware' => 'create-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Branch',
            'menu_id' => $branch,
            'middleware' => 'show-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Branch',
            'menu_id' => $branch,
            'middleware' => 'edit-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Branch',
            'menu_id' => $branch,
            'middleware' => 'destroy-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Business Unit
        $businessUnit = Menu::where('name','Business Unit')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'index-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'create-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'show-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'edit-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Business Unit',
            'menu_id' => $businessUnit,
            'middleware' => 'destroy-business-unit',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        // Master Data Company
        $company = Menu::where('name','Company')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Company',
            'menu_id' => $company,
            'middleware' => 'index-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Company',
            'menu_id' => $company,
            'middleware' => 'create-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Company',
            'menu_id' => $company,
            'middleware' => 'show-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Company',
            'menu_id' => $company,
            'middleware' => 'edit-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Company',
            'menu_id' => $company,
            'middleware' => 'destroy-company',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Storage Location
        $storageLocation = Menu::where('name','Storage Location')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'index-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'create-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'show-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'edit-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Storage Location',
            'menu_id' => $storageLocation,
            'middleware' => 'destroy-storage-location',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Customer
        $customer = Menu::where('name','Customer')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Customer',
            'menu_id' => $customer,
            'middleware' => 'index-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Customer',
            'menu_id' => $customer,
            'middleware' => 'create-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Customer',
            'menu_id' => $customer,
            'middleware' => 'show-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Customer',
            'menu_id' => $customer,
            'middleware' => 'edit-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Customer',
            'menu_id' => $customer,
            'middleware' => 'destroy-customer',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Material
        $material = Menu::where('name','Material')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Material',
            'menu_id' => $material,
            'middleware' => 'index-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Material',
            'menu_id' => $material,
            'middleware' => 'create-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Material',
            'menu_id' => $material,
            'middleware' => 'show-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Material',
            'menu_id' => $material,
            'middleware' => 'edit-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Material',
            'menu_id' => $material,
            'middleware' => 'destroy-material',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Resource Management
        $resource = Menu::where('name','Manage Resource')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Resource',
            'menu_id' => $resource,
            'middleware' => 'index-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Resource',
            'menu_id' => $resource,
            'middleware' => 'create-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Resource',
            'menu_id' => $resource,
            'middleware' => 'show-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Resource',
            'menu_id' => $resource,
            'middleware' => 'edit-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Resource',
            'menu_id' => $resource,
            'middleware' => 'destroy-resource',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Service
        $service = Menu::where('name','Service')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Service',
            'menu_id' => $service,
            'middleware' => 'index-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Service',
            'menu_id' => $service,
            'middleware' => 'create-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Service',
            'menu_id' => $service,
            'middleware' => 'show-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Service',
            'menu_id' => $service,
            'middleware' => 'edit-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Service',
            'menu_id' => $service,
            'middleware' => 'destroy-service',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Unit Of Measurement
        $uom = Menu::where('name','Unit Of Measurement')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'index-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'create-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'show-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'edit-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Unit Of Measurement',
            'menu_id' => $uom,
            'middleware' => 'destroy-unit-of-measurement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Vendor
        $vendor = Menu::where('name','Vendor')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Vendor',
            'menu_id' => $vendor,
            'middleware' => 'index-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Vendor',
            'menu_id' => $vendor,
            'middleware' => 'create-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Vendor',
            'menu_id' => $vendor,
            'middleware' => 'show-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Vendor',
            'menu_id' => $vendor,
            'middleware' => 'edit-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Vendor',
            'menu_id' => $vendor,
            'middleware' => 'destroy-vendor',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Warehouse
        $warehouse = Menu::where('name','Warehouse')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'index-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'create-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'show-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'edit-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Warehouse',
            'menu_id' => $warehouse,
            'middleware' => 'destroy-warehouse',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Yard
        $yard = Menu::where('name','Yard')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index yard',
            'menu_id' => $yard,
            'middleware' => 'index-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Yard',
            'menu_id' => $yard,
            'middleware' => 'create-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Yard',
            'menu_id' => $yard,
            'middleware' => 'show-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Yard',
            'menu_id' => $yard,
            'middleware' => 'edit-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy yard',
            'menu_id' => $yard,
            'middleware' => 'destroy-yard',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Menu
        $menu = Menu::where('name','Menus')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Menu',
            'menu_id' => $menu,
            'middleware' => 'index-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Menu',
            'menu_id' => $menu,
            'middleware' => 'create-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Menu',
            'menu_id' => $menu,
            'middleware' => 'show-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Menu',
            'menu_id' => $menu,
            'middleware' => 'edit-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Menu',
            'menu_id' => $menu,
            'middleware' => 'destroy-menu',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Appearence
        $appearance = Menu::where('name','Appearance')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Appearence',
            'menu_id' => $appearance,
            'middleware' => 'index-appearence',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Appearence',
            'menu_id' => $appearance,
            'middleware' => 'edit-appearence',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Currencies
        $currencies = Menu::where('name','Currencies')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Currencies',
            'menu_id' => $currencies,
            'middleware' => 'index-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Currencies',
            'menu_id' => $currencies,
            'middleware' => 'create-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Currencies',
            'menu_id' => $currencies,
            'middleware' => 'edit-currencies',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data User
        $userManagement = Menu::where('name','User Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index User',
            'menu_id' => $userManagement,
            'middleware' => 'index-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create User',
            'menu_id' => $userManagement,
            'middleware' => 'create-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show User',
            'menu_id' => $userManagement,
            'middleware' => 'show-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit User',
            'menu_id' => $userManagement,
            'middleware' => 'edit-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Password',
            'menu_id' => $userManagement,
            'middleware' => 'edit-password',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Change Branch',
            'menu_id' => $userManagement,
            'middleware' => 'change-branch',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Change Role',
            'menu_id' => $userManagement,
            'middleware' => 'change-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Change Status',
            'menu_id' => $userManagement,
            'middleware' => 'change-status',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy User',
            'menu_id' => $userManagement,
            'middleware' => 'destroy-user',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Role
        $roleManagement = Menu::where('name','Role Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Role',
            'menu_id' => $roleManagement,
            'middleware' => 'index-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Role',
            'menu_id' => $roleManagement,
            'middleware' => 'create-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Role',
            'menu_id' => $roleManagement,
            'middleware' => 'show-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Role',
            'menu_id' => $roleManagement,
            'middleware' => 'edit-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Role',
            'menu_id' => $roleManagement,
            'middleware' => 'destroy-role',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Master Data Permission
        $permissionManagement = Menu::where('name','Permission Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'index-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'create-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'show-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'edit-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Permission',
            'menu_id' => $permissionManagement,
            'middleware' => 'destroy-permission',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Stock Management
        $stockManagement = Menu::where('name','Stock Management')->select('id')->first()->id;
        DB::table('permissions')->insert([
        'name' => 'Index Stock Management',
        'menu_id' => $stockManagement,
        'middleware' => 'index-stock-management',
        'created_at' => date('Y-m-d'),
        'updated_at' => date('Y-m-d'),
        ]);

        //Material Write Off
        $materialWriteOff = Menu::where('name','Material Write Off')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Create Material Write Off',
            'menu_id' => $materialWriteOff,
            'middleware' => 'create-material-write-off',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
            ]);

        //Master Data Permission
        $goodsMovement = Menu::where('name','Goods Movement')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Goods Movement',
            'menu_id' => $goodsMovement,
            'middleware' => 'index-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Goods Movement',
            'menu_id' => $goodsMovement,
            'middleware' => 'create-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Goods Movement',
            'menu_id' => $goodsMovement,
            'middleware' => 'show-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Goods Movement',
            'menu_id' => $goodsMovement,
            'middleware' => 'edit-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Goods Movement',
            'menu_id' => $goodsMovement,
            'middleware' => 'destroy-goods-movement',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        //Production Order
        $createProductionOrder = Menu::where('name','Create Production Order')->select('id')->first()->id;
        DB::table('permissions')->insert([
            'name' => 'Index Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'index-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Create Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'create-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Show Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'show-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Edit Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'edit-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('permissions')->insert([
            'name' => 'Destroy Production Order',
            'menu_id' => $createProductionOrder,
            'middleware' => 'destroy-production-order',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    }
}

