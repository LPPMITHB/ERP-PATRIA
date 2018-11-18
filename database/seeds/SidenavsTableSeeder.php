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
        $dashboard = Menu::where('route_name','index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $dashboard,
            'route_name' => '.index',
        ]);

        $manageProject = Menu::where('route_name','project.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.showGanttChart',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.createWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.createSubWBS',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.indexWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.listWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.createActivities',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.indexActivities',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageProject,
            'route_name' => 'project.manageNetwork',
        ]);

        $confirmActivity = Menu::where('route_name','project.indexConfirm')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivity,
            'route_name' => 'project.indexConfirm',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivity,
            'route_name' => 'project.selectWBS',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $confirmActivity,
            'route_name' => 'project.confirmActivity',
        ]);

        $manageBom = Menu::where('route_name','bom.indexProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.indexProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.indexBom',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageBom,
            'route_name' => 'bom.edit',
        ]);

        $assignBom = Menu::where('route_name','bom.selectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignBom,
            'route_name' => 'bom.selectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $assignBom,
            'route_name' => 'bom.assignBom',
        ]);

        // $createRab = Menu::where('route_name','rab.selectProject')->select('id')->first()->id;
        // DB::table('sidenav')->insert([
        //     'menu_id' => $createRab,
        //     'route_name' => 'rab.selectProject',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $createRab,
        //     'route_name' => 'rab.create',
        // ]);

        // DB::table('sidenav')->insert([
        //     'menu_id' => $createRab,
        //     'route_name' => 'rab.show',
        // ]);

        $viewRab = Menu::where('route_name','rab.indexSelectProject')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewRab,
            'route_name' => 'rab.indexSelectProject',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRab,
            'route_name' => 'rab.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewRab,
            'route_name' => 'rab.show',
        ]);

        $createCost = Menu::where('route_name','rab.selectProjectCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rab.selectProjectCost',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $createCost,
            'route_name' => 'rab.createCost',
        ]);

        $assignCost = Menu::where('route_name','rab.selectProjectCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignCost,
            'route_name' => 'rab.selectProjectAssignCost',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $assignCost,
            'route_name' => 'rab.assignCost',
        ]);

        $viewPlannedCost = Menu::where('route_name','rab.selectProjectViewCost')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rab.selectProjectViewCost',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPlannedCost,
            'route_name' => 'rab.viewPlannedCost',
        ]);

        $createPr = Menu::where('route_name','purchase_requisition.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPr,
            'route_name' => 'purchase_requisition.create',
        ]);

        $viewPr = Menu::where('route_name','purchase_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPr,
            'route_name' => 'purchase_requisition.show',
        ]);

        $createPo = Menu::where('route_name','purchase_order.selectPR')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createPo,
            'route_name' => 'purchase_order.selectPR',
        ]);

        $viewPo = Menu::where('route_name','purchase_order.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewPo,
            'route_name' => 'purchase_order.show',
        ]);

        $createGiWithRef = Menu::where('route_name','goods_issue.createGiWithRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGiWithRef,
            'route_name' => 'goods_issue.createGiWithRef',
        ]);

        $createGiWithoutRef = Menu::where('route_name','goods_issue.createGiWithoutRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGiWithoutRef,
            'route_name' => 'goods_issue.createGiWithoutRef',
        ]);

        $viewGi = Menu::where('route_name','goods_issue.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGi,
            'route_name' => 'goods_issue.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewGi,
            'route_name' => 'goods_issue.show',
        ]);

        $viewGr = Menu::where('route_name','goods_receipt.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewGr,
            'route_name' => 'goods_receipt.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewGr,
            'route_name' => 'goods_receipt.show',
        ]);

        $createMrManually = Menu::where('route_name','material_requisition.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createMrManually,
            'route_name' => 'material_requisition.create',
        ]);

        $viewMr = Menu::where('route_name','material_requisition.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $viewMr,
            'route_name' => 'material_requisition.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $viewMr,
            'route_name' => 'material_requisition.show',
        ]);

        $createGrWithRef = Menu::where('route_name','goods_receipt.createGrWithRef')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $createGrWithRef,
            'route_name' => 'goods_receipt.createGrWithRef',
        ]);

        // $createGrWithoutRef = Menu::where('route_name','goods_receipt.createGrWithoutRef')->select('id')->first()->id;
        // DB::table('sidenav')->insert([
        //     'menu_id' => $createGrWithoutRef,
        //     'route_name' => 'goods_receipt.createGrWithoutRef',
        // ]);
        
        $snapshot = Menu::where('route_name','physical_inventory.indexSnapshot')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $snapshot,
            'route_name' => 'physical_inventory.indexSnapshot',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $snapshot,
            'route_name' => 'physical_inventory.displaySnapshot',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $snapshot,
            'route_name' => 'physical_inventory.showSnapshot',
        ]);

        $countStock = Menu::where('route_name','physical_inventory.indexCountStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $countStock,
            'route_name' => 'physical_inventory.indexCountStock',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $countStock,
            'route_name' => 'physical_inventory.countStock',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $countStock,
            'route_name' => 'physical_inventory.showCountStock',
        ]);

        $adjustStock = Menu::where('route_name','physical_inventory.indexAdjustStock')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStock,
            'route_name' => 'physical_inventory.indexAdjustStock',
        ]);
        
        DB::table('sidenav')->insert([
            'menu_id' => $adjustStock,
            'route_name' => 'physical_inventory.showConfirmCountStock',
        ]);

        $materialWriteOff = Menu::where('route_name','material_write_off.create')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $materialWriteOff,
            'route_name' => 'material_write_off.create',
        ]);

        $ship = Menu::where('route_name','ship.index')->select('id')->first()->id;
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
            'route_name' => 'ship.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $ship,
            'route_name' => 'ship.edit',
        ]);

        $branch = Menu::where('route_name','branch.index')->select('id')->first()->id;
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
            'route_name' => 'branch.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $branch,
            'route_name' => 'branch.edit',
        ]);
        
        $company = Menu::where('route_name','company.index')->select('id')->first()->id;
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
            'route_name' => 'company.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $company,
            'route_name' => 'company.edit',
        ]);

        $storageLocation = Menu::where('route_name','storage_location.index')->select('id')->first()->id;
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
            'route_name' => 'storage_location.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $storageLocation,
            'route_name' => 'storage_location.edit',
        ]);

        $customer = Menu::where('route_name','customer.index')->select('id')->first()->id;
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
            'route_name' => 'customer.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $customer,
            'route_name' => 'customer.edit',
        ]);

        $material = Menu::where('route_name','material.index')->select('id')->first()->id;
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
            'route_name' => 'material.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $material,
            'route_name' => 'material.edit',
        ]);

        $vendor = Menu::where('route_name','vendor.index')->select('id')->first()->id;
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
            'route_name' => 'vendor.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $vendor,
            'route_name' => 'vendor.edit',
        ]);

        $menus = Menu::where('route_name','menus.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $menus,
            'route_name' => 'menus.edit',
        ]);

        $appearance = Menu::where('route_name','appearance.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $appearance,
            'route_name' => 'appearance.index',
        ]);

        $user = Menu::where('route_name','user.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.edit',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $user,
            'route_name' => 'user.change_password',
        ]);

        $role = Menu::where('route_name','role.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $role,
            'route_name' => 'role.edit',
        ]);

        $permission = Menu::where('route_name','permission.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $permission,
            'route_name' => 'permission.edit',
        ]);

        $stockManagement = Menu::where('route_name','stock_management.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $stockManagement,
            'route_name' => 'stock_management.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => '16',
            'route_name' => 'purchase_requisition.create',
        ]);

        $manageResource = Menu::where('route_name','resource.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.show',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $manageResource,
            'route_name' => 'resource.edit',
        ]);

        $assignResource = Menu::where('route_name','resource.assignResource')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $assignResource,
            'route_name' => 'resource.assignResource',
        ]); 
         
        $yardPlan = Menu::where('route_name','yard_plan.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $yardPlan,
            'route_name' => 'yard_plan.index',
        ]);

        $currencies = Menu::where('route_name','currencies.index')->select('id')->first()->id;
        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.index',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.create',
        ]);

        DB::table('sidenav')->insert([
            'menu_id' => $currencies,
            'route_name' => 'currencies.edit',
        ]);
    }
}
