<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// role
Route::get('/getPermission/{id}', 'RoleController@getPermissionAPI')->name('api.role.getPermissionAPI');
Route::get('/getSubMenu/{id}', 'RoleController@getSubMenuAPI')->name('api.role.getSubMenuAPI');

// bom
Route::get('/getMaterialBOM/{id}', 'BOMController@getMaterialAPI')->name('api.bom.getMaterialAPI');
Route::get('/getServiceBOM/{id}', 'BOMController@getServiceAPI')->name('api.bom.getServiceAPI');
Route::get('/getBom/{id}', 'BOMController@getBomAPI')->name('api.bom.getBomAPI');
Route::get('/getNewBom/{id}', 'BOMController@getNewBomAPI')->name('api.bom.getNewBomAPI');
Route::get('/getBomDetail/{id}', 'BOMController@getBomDetailAPI')->name('api.bom.getBomDetailAPI');
Route::get('/getMaterialsBOM/{id}', 'BOMController@getMaterialsAPI')->name('api.bom.getMaterialsAPI');

// bos
Route::get('/getServiceBOS/{id}', 'BOSController@getServiceAPI')->name('api.bos.getServiceAPI');
Route::get('/getBos/{id}', 'BOSController@getBosAPI')->name('api.bos.getBosAPI');
Route::get('/getNewBos/{id}', 'BOSController@getNewBosAPI')->name('api.bos.getNewBosAPI');
Route::get('/getBosDetail/{id}', 'BOSController@getBosDetailAPI')->name('api.bos.getBosDetailAPI');
Route::get('/getServicesBOS/{id}', 'BOSController@getServicesAPI')->name('api.bos.getServicesAPI');

// rap
Route::get('/getNewCost/{id}', 'RAPController@getNewCostAPI')->name('api.bom.getNewCostAPI');
Route::get('/getAllWorks/{id}', 'RAPController@getAllWorksCostAPI')->name('api.bom.getAllWorksCostAPI');

// purchase_requisition
Route::get('/getProject/{id}', 'PurchaseRequisitionController@getProjectApi')->name('api.purchase_requisition.getProjectApi');
Route::get('/getMaterialPR/{id}', 'PurchaseRequisitionController@getMaterialAPI')->name('api.purchase_requisition.getMaterialAPI');
Route::get('/getMaterials/{id}', 'PurchaseRequisitionController@getMaterialsAPI')->name('api.purchase_requisition.getMaterialsAPI');
Route::get('/getWork/{id}', 'PurchaseRequisitionController@getWorkAPI')->name('api.purchase_requisition.getWorkAPI');
Route::get('/getPRD/{id}', 'PurchaseRequisitionController@getPRDAPI')->name('api.purchase_requisition.getPRDAPI');

// material_requisition
Route::get('/getWbsMR/{id}', 'MaterialRequisitionController@getWbsAPI')->name('api.purchase_requisition.getWbsAPI');


// goods_receipt
Route::get('/getSlocGR/{id}', 'GoodsReceiptController@getSlocApi')->name('api.goods_receipt.getSlocApi');
Route::get('/getMaterialGR/{id}', 'GoodsReceiptController@getMaterialAPI')->name('api.goods_receipt.getMaterialAPI');
Route::get('/getMaterials/{id}', 'GoodsReceiptController@getMaterialsAPI')->name('api.goods_receipt.getMaterialsAPI');
Route::get('/getPRD/{id}', 'GoodsReceiptController@getGRDAPI')->name('api.goods_receipt.getPRDAPI');

// purchase order
Route::get('/getVendor', 'PurchaseOrderController@getVendorAPI')->name('api.purchase_order.getVendorAPI');
Route::get('/getResourcePO/{id}', 'PurchaseOrderController@getResourceAPI')->name('api.purchase_order.getResourceAPI');

// stock management
Route::get('/getSlocSM/{id}', 'StockManagementController@getSlocApi')->name('api.stock_management.getSlocApi');
Route::get('/getWarehouseInfoSM/{id}', 'StockManagementController@getWarehouseInfoSM')->name('api.stock_management.getWarehouseInfoSM');

// material write off
Route::get('/getMaterial/{id}', 'MaterialWriteOffController@getMaterialApi')->name('api.material_write_off.getMaterialApi');
Route::get('/getMaterials/{id}', 'MaterialWriteOffController@getMaterialsApi')->name('api.material_write_off.getMaterialsApi');
Route::get('/getSloc/{id}', 'MaterialWriteOffController@getSlocApi')->name('api.material_write_off.getSlocApi');

// goods movement
Route::get('/getSlocGM/{id}', 'GoodsMovementController@getSlocAPI')->name('api.goods_movement.getSlocAPI');
Route::get('/getSlocToGM/{id}', 'GoodsMovementController@getSlocToAPI')->name('api.goods_movement.getSlocToAPI');
Route::get('/getSlocDetailGM/{id}', 'GoodsMovementController@getSlocDetailAPI')->name('api.goods_movement.getSlocDetailAPI');

// goods issue
Route::get('/getSlocDetail/{id}', 'GoodsIssueController@getSlocDetailAPI')->name('api.goods_issue.getSlocDetailAPI');

// production order
Route::get('/getMaterialWO/{id}', 'ProductionOrderController@getMaterialAPI')->name('api.production_order.getMaterialAPI');
Route::get('/getResourceWO/{id}', 'ProductionOrderController@getResourceAPI')->name('api.production_order.getResourceAPI');
Route::get('/getStockWO/{id}', 'ProductionOrderController@getStockAPI')->name('api.production_order.getStockAPI');

// assign Resource
Route::get('/getResourceAssign/{id}', 'ResourceController@getResourceAssignApi')->name('api.resource.getResourceAssignApi');
Route::get('/getWorkAssignResource/{id}', 'ResourceController@getWorkAssignResourceApi')->name('api.resource.getWorkAssignResourceApi');
Route::get('/getWorkNameAssignResource/{id}', 'ResourceController@getWorkNameAssignResourceApi')->name('api.resource.getWorkNameAssignResourceApi');
Route::get('/getProjectNameAssignResource/{id}', 'ResourceController@getProjectNameAssignResourceApi')->name('api.resource.getProjectNameAssignResourceApi');
Route::get('/getResourceNameAssignResource/{id}', 'ResourceController@getResourceNameAssignResourceApi')->name('api.resource.getResourceNameAssignResourceApi');
Route::get('/getResourceDetail', 'ResourceController@getResourceDetailApi')->name('api.resource.getResourceDetailApi');
Route::get('/getCategoryAR/{id}', 'ResourceController@getCategoryARApi')->name('api.resource.getCategoryARApi');


// yard plan
Route::get('/getWork/{id}', 'YardPlanController@getWorkAPI')->name('api.yard_plan.getWorkAPI');

// project
Route::get('/getCustomerPM/{id}', 'ProjectController@getCustomerPM')->name('api.yard_plan.getCustomerPM');
Route::get('/getResourceByCategoryPM/{id}', 'ProjectController@getResourceByCategoryAPI')->name('api.yard_plan.getResourceByCategoryAPI');
Route::get('/getResourcePM/{id}', 'ProjectController@getResourceAPI')->name('api.yard_plan.getResourceAPI');
Route::get('/getAllResourcePM/{id}', 'ProjectController@getAllResourceAPI')->name('api.yard_plan.getAllResourceAPI');
Route::get('/getActivity/{id}', 'ProjectController@getActivityAPI')->name('api.project.getActivityAPI');
Route::get('/getDataGantt/{id}', 'ProjectController@getDataGanttAPI')->name('api.project.getDataGanttAPI');
Route::get('/getDataChart/{id}', 'ProjectController@getDataChartAPI')->name('api.project.getDataChartAPI');
Route::get('/getDataJstree/{id}', 'ProjectController@getDataJstreeAPI')->name('api.project.getDataJstreeAPI');


// wbs
Route::get('/getWbs/{id}', 'WBSController@getWbsAPI')->name('api.wbs.getWbsAPI');
Route::get('/getAllWbs/{id}', 'WBSController@getAllWbsAPI')->name('api.wbs.getAllWbsAPI');
Route::get('/getSubWbs/{id}', 'WBSController@getSubWbsAPI')->name('api.wbs.getSubWbsAPI');
Route::get('/getWeightWbs/{id}', 'WBSController@getWeightWbsAPI')->name('api.wbs.getWeightWbsAPI');
Route::get('/getWeightProject/{id}', 'WBSController@getWeightProjectAPI')->name('api.wbs.getWeightProjectAPI');

// activity
Route::get('/getActivities/{id}', 'ActivityController@getActivitiesAPI')->name('api.activity.getActivitiesAPI');
Route::get('/getActivitiesNetwork/{id}', 'ActivityController@getActivitiesNetworkAPI')->name('api.activity.getActivitiesNetworkAPI');
Route::get('/getAllActivities/{id}', 'ActivityController@getAllActivitiesAPI')->name('api.activity.getAllActivitiesAPI');
Route::get('/getAllActivitiesEdit/{project_id}/{activity_id}', 'ActivityController@getAllActivitiesEditAPI')->name('api.activity.getAllActivitiesEditAPI');
Route::get('/getPredecessor/{id}', 'ActivityController@getPredecessorAPI')->name('api.activity.getPredecessorAPI');
Route::get('/getProjectActivity/{id}', 'ActivityController@getProjectAPI')->name('api.activity.getProjectAPI');
Route::get('/getLatestPredecessor/{id}', 'ActivityController@getLatestPredecessorAPI')->name('api.activity.getLatestPredecessorAPI');


