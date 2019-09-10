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

// currencies
Route::get('/getCurrenciesConfig', 'ConfigurationController@getCurrenciesAPI')->name('api.configuration.getCurrenciesAPI');

// approval configuration
Route::get('/getApprovalConfig/{type}', 'ConfigurationController@getApprovalAPI')->name('api.configuration.getApprovalAPI');

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
Route::get('/getServicesBOM/{id}', 'BOMController@getServicesAPI')->name('api.bom.getServicesAPI');
Route::get('/getPRBom/{id}', 'BOMController@getPRAPI')->name('api.bom.getPRAPI');
Route::get('/getBomHeader/{id}', 'BOMController@getBomHeaderAPI')->name('api.bom.getBomHeaderAPI');

// bos
Route::get('/getServiceBOS/{id}', 'BOSController@getServiceAPI')->name('api.bos.getServiceAPI');
Route::get('/getBos/{id}', 'BOSController@getBosAPI')->name('api.bos.getBosAPI');
Route::get('/getNewBos/{id}', 'BOSController@getNewBosAPI')->name('api.bos.getNewBosAPI');
Route::get('/getBosDetail/{id}', 'BOSController@getBosDetailAPI')->name('api.bos.getBosDetailAPI');
Route::get('/getServicesBOS/{id}', 'BOSController@getServicesAPI')->name('api.bos.getServicesAPI');

// rap
Route::get('/getNewCost/{id}', 'RAPController@getNewCostAPI')->name('api.bom.getNewCostAPI');
Route::get('/getAllWbss/{id}', 'RAPController@getAllWbssCostAPI')->name('api.bom.getAllWbssCostAPI');

// purchase_requisition
Route::get('/getProjectPR/{id}', 'PurchaseRequisitionController@getProjectApi')->name('api.purchase_requisition.getProjectApi');
Route::get('/getMaterialPR/{id}', 'PurchaseRequisitionController@getMaterialAPI')->name('api.purchase_requisition.getMaterialAPI');
Route::get('/getResourcePR/{id}', 'PurchaseRequisitionController@getResourceAPI')->name('api.purchase_requisition.getResourceAPI');
// Route::get('/getMaterials/{id}', 'PurchaseRequisitionController@getMaterialsAPI')->name('api.purchase_requisition.getMaterialsAPI');
Route::get('/getWbsPR/{id}', 'PurchaseRequisitionController@getWbsAPI')->name('api.purchase_requisition.getWbsAPI');
Route::get('/getModelWbsPR/{id}', 'PurchaseRequisitionController@getModelWbsAPI')->name('api.purchase_requisition.getModelWbsAPI');
Route::get('/getModelActivityPR/{id}/{ids}', 'PurchaseRequisitionController@getModelActivityAPI')->name('api.purchase_requisition.getModelActivityAPI');
Route::get('/getPRD/{id}', 'PurchaseRequisitionController@getPRDAPI')->name('api.purchase_requisition.getPRDAPI');
Route::get('/getActivityId', 'PurchaseRequisitionController@getActivityIdAPI')->name('api.purchase_requisition.getActivityIdAPI');

// material_requisition
Route::get('/getWbsMR/{id}', 'MaterialRequisitionController@getWbsAPI')->name('api.material_requisition.getWbsAPI');
Route::get('/getWbsMREdit/{id}/{mr_id}', 'MaterialRequisitionController@getWbsEditAPI')->name('api.material_requisition.getWbsEditAPI');
Route::get('/getProjectMR/{id}', 'MaterialRequisitionController@getProjectApi')->name('api.material_requisition.getProjectApi');
Route::get('/getMaterialMR/{id}', 'MaterialRequisitionController@getMaterialAPI')->name('api.material_requisition.getMaterialAPI');
Route::get('/getStockMR/{id}', 'MaterialRequisitionController@getStockAPI')->name('api.material_requisition.getStockAPI');
Route::get('/getMaterialInfoAPI/{id}/{wbs_id}', 'MaterialRequisitionController@getMaterialInfoAPI')->name('api.material_requisition.getMaterialInfoAPI');
Route::get('/getMaterialInfoWithoutProjectAPI/{id}', 'MaterialRequisitionController@getMaterialInfoWithoutProjectAPI')->name('api.material_requisition.getMaterialInfoWithoutProjectAPI');
Route::get('/getMaterialInfoRepairAPI/{id}/{wbs_id}', 'MaterialRequisitionController@getMaterialInfoRepairAPI')->name('api.material_requisition.getMaterialInfoRepairAPI');


// goods_receipt
Route::get('/getSlocGR/{id}', 'GoodsReceiptController@getSlocApi')->name('api.goods_receipt.getSlocApi');
Route::get('/getMaterialGR/{id}', 'GoodsReceiptController@getMaterialAPI')->name('api.goods_receipt.getMaterialAPI');
Route::get('/getMaterials/{id}', 'GoodsReceiptController@getMaterialsAPI')->name('api.goods_receipt.getMaterialsAPI');
Route::get('/getPRD/{id}', 'GoodsReceiptController@getGRDAPI')->name('api.goods_receipt.getPRDAPI');

// purchase order
Route::get('/getVendor', 'PurchaseOrderController@getVendorAPI')->name('api.purchase_order.getVendorAPI');
Route::get('/getResourcePO/{id}', 'PurchaseOrderController@getResourceAPI')->name('api.purchase_order.getResourceAPI');
Route::get('/getVendorList/{id}', 'PurchaseOrderController@getVendorListAPI')->name('api.purchase_order.getVendorListAPI');

// stock management
Route::get('/getSlocSM/{id}', 'StockManagementController@getSlocApi')->name('api.stock_management.getSlocApi');
Route::get('/getWarehouseInfoSM/{id}', 'StockManagementController@getWarehouseInfoSM')->name('api.stock_management.getWarehouseInfoSM');
Route::get('/getWarehouseStockSM/{id}', 'StockManagementController@getWarehouseStockSM')->name('api.stock_management.getWarehouseStockSM');
Route::get('/getStockInfoSM', 'StockManagementController@getStockInfoSM')->name('api.stock_management.getStockInfoSM');

// work request
Route::get('/getQuantityReserved/{id}', 'WorkRequestController@getQuantityReservedApi')->name('api.work_request.getQuantityReservedApi');
Route::get('/getMaterialWr/{id}', 'WorkRequestController@getMaterialWrAPI')->name('api.work_request.getMaterialWrAPI');
Route::get('/getWbsWr/{id}', 'WorkRequestController@getWbsWrAPI')->name('api.work_request.getWbsWrAPI');
Route::get('/getBomWr/{id}', 'WorkRequestController@getBomWrAPI')->name('api.work_request.getBomWrAPI');
Route::get('/getBomDetailWr/{id}', 'WorkRequestController@getBomDetailWrAPI')->name('api.work_request.getBomDetailWrAPI');
Route::get('/getProjectWR/{id}', 'WorkRequestController@getProjectApi')->name('api.work_request.getProjectApi');
Route::get('/getMaterialWIP/{id}', 'WorkRequestController@getMaterialWIPApi')->name('api.work_request.getMaterialWIPApi');
Route::get('/getWbsWREdit/{id}/{wr_id}', 'WorkRequestController@getWbsEditAPI')->name('api.work_request.getWbsEditAPI');
Route::get('/getMaterialWIPEdit/{id}/{wr_id}', 'WorkRequestController@getMaterialWIPEditAPI')->name('api.work_request.getMaterialWIPEditAPI');
Route::get('/getActivityWR/{id}', 'WorkRequestController@getActivityWRAPI')->name('api.work_request.getActivityWRAPI');
Route::get('/getMaterialActivityWIP/{id}', 'WorkRequestController@getMaterialActivityWIPAPI')->name('api.work_request.getMaterialActivityWIPAPI');
Route::get('/getBomPrepWR/{id}', 'WorkRequestController@getBomPrepWRAPI')->name('api.work_request.getBomPrepWRAPI');
Route::get('/getDataActivityWR/{id}', 'WorkRequestController@getDataActivityWRAPI')->name('api.work_request.getDataActivityWRAPI');

// material write off
Route::get('/getMaterialMWO/{id}', 'MaterialWriteOffController@getMaterialApi')->name('api.material_write_off.getMaterialApi');
Route::get('/getMaterialsMWO/{id}', 'MaterialWriteOffController@getMaterialsMWOApi')->name('api.material_write_off.getMaterialsMWOApi');
Route::get('/getSloc/{id}', 'MaterialWriteOffController@getSlocApi')->name('api.material_write_off.getSlocApi');
Route::get('/getWloc/{id}', 'MaterialWriteOffController@getWlocApi')->name('api.material_write_off.getWlocApi');
Route::get('/getStorloc/{id}', 'MaterialWriteOffController@getStorlocApi')->name('api.material_write_off.getStorlocApi');

// goods movement
Route::get('/getSlocGM/{id}', 'GoodsMovementController@getSlocAPI')->name('api.goods_movement.getSlocAPI');
Route::get('/getSlocToGM/{id}', 'GoodsMovementController@getSlocToAPI')->name('api.goods_movement.getSlocToAPI');
Route::get('/getSlocDetailGM/{id}', 'GoodsMovementController@getSlocDetailAPI')->name('api.goods_movement.getSlocDetailAPI');

// goods issue
Route::get('/getSlocDetail/{id}', 'GoodsIssueController@getSlocDetailAPI')->name('api.goods_issue.getSlocDetailAPI');

// production order
Route::get('/getMaterialPrO/{id}', 'ProductionOrderController@getMaterialAPI')->name('api.production_order.getMaterialAPI');
Route::get('/getResourcePrO/{id}', 'ProductionOrderController@getResourceAPI')->name('api.production_order.getResourceAPI');
Route::get('/getServicePrO/{id}', 'ProductionOrderController@getServiceAPI')->name('api.production_order.getServiceAPI');
Route::get('/getStockPrO/{id}', 'ProductionOrderController@getStockAPI')->name('api.production_order.getStockAPI');
Route::get('/getProjectInvPrO/{id}', 'ProductionOrderController@getProjectInvAPI')->name('api.production_order.getProjectInvAPI');
Route::get('/getTrxResourcePro/{id}/{jsonResource}/{category_id}', 'ProductionOrderController@getTrxResourceAPI')->name('api.production_order.getTrxResourceAPI');
Route::get('/getProjectPO/{id}', 'ProductionOrderController@getProjectPOApi')->name('api.production_order.getProjectPOApi');
Route::get('/getPO/{id}', 'ProductionOrderController@getPOApi')->name('api.production_order.getPOApi');
Route::get('/getPou/{id}', 'ProductionOrderController@getPouAPI')->name('api.production_order.getPouAPI');

// Resource
Route::get('/getResourceAssign/{id}', 'ResourceController@getResourceAssignApi')->name('api.resource.getResourceAssignApi');
Route::get('/getWbsAssignResource/{id}', 'ResourceController@getWbsAssignResourceApi')->name('api.resource.getWbsAssignResourceApi');
Route::get('/getWbsNameAssignResource/{id}', 'ResourceController@getWbsNameAssignResourceApi')->name('api.resource.getWbsNameAssignResourceApi');
Route::get('/getProjectNameAssignResource/{id}', 'ResourceController@getProjectNameAssignResourceApi')->name('api.resource.getProjectNameAssignResourceApi');
Route::get('/getResourceNameAssignResource/{id}', 'ResourceController@getResourceNameAssignResourceApi')->name('api.resource.getResourceNameAssignResourceApi');
Route::get('/getResourceTrx/{id}', 'ResourceController@getResourceTrxApi')->name('api.resource.getResourceTrxApi');
Route::get('/getAllResourceTrx', 'ResourceController@getAllResourceTrxApi')->name('api.resource.getAllResourceTrxApi');
Route::get('/getResourceDetail/{data}', 'ResourceController@getResourceDetailApi')->name('api.resource.getResourceDetailApi');
Route::get('/getCategoryAR/{id}', 'ResourceController@getCategoryARApi')->name('api.resource.getCategoryARApi');
Route::get('/generateCodeGrResource/{data}', 'ResourceController@generateCodeAPI')->name('api.resource.generateCodeAPI');
Route::get('/getNewResourceDetail/{id}', 'ResourceController@getNewResourceDetailAPI')->name('api.resource.getNewResourceDetailAPI');
Route::get('/getSchedule/{id}', 'ResourceController@getScheduleAPI')->name('api.resource.getScheduleAPI');
Route::get('/getCodeRSCD', 'ResourceController@getCodeRSCDAPI')->name('api.resource.getCodeRSCDAPI');

// yard plan
Route::get('/getWbs/{id}', 'YardPlanController@getWbsAPI')->name('api.yard_plan.getWbsAPI');

// project
Route::get('/getCustomerPM/{id}', 'ProjectController@getCustomerPM')->name('api.yard_plan.getCustomerPM');
Route::get('/getResourceByCategoryPM/{id}', 'ProjectController@getResourceByCategoryAPI')->name('api.yard_plan.getResourceByCategoryAPI');
Route::get('/getResourcePM/{id}', 'ProjectController@getResourceAPI')->name('api.yard_plan.getResourceAPI');
Route::get('/getAllResourcePM/{id}', 'ProjectController@getAllResourceAPI')->name('api.yard_plan.getAllResourceAPI');
Route::get('/getActivity/{id}', 'ProjectController@getActivityAPI')->name('api.project.getActivityAPI');
Route::get('/getDataGantt/{id}', 'ProjectController@getDataGanttAPI')->name('api.project.getDataGanttAPI');
Route::get('/getDataChart/{id}', 'ProjectController@getDataChartAPI')->name('api.project.getDataChartAPI');
Route::get('/getDataJstree/{id}', 'ProjectController@getDataJstreeAPI')->name('api.project.getDataJstreeAPI');
Route::get('/getActualStartDate/{id}', 'ProjectController@getActualStartDateAPI')->name('api.project.getActualStartDateAPI');
Route::get('/getProjectStandard/{id}', 'ProjectController@getProjectStandardAPI')->name('api.project.getProjectStandardAPI');

// wbs
Route::get('/getWbs/{id}', 'WBSController@getWbsAPI')->name('api.wbs.getWbsAPI');
Route::get('/getWbsProfile/{menu}/{project_type}', 'WBSController@getWbsProfileAPI')->name('api.wbs.getWbsProfileAPI');
Route::get('/getAllWbs/{id}', 'WBSController@getAllWbsAPI')->name('api.wbs.getAllWbsAPI');
Route::get('/getSubWbs/{id}', 'WBSController@getSubWbsAPI')->name('api.wbs.getSubWbsAPI');
Route::get('/getSubWbsProfile/{id}', 'WBSController@getSubWbsProfileAPI')->name('api.wbs.getSubWbsProfileAPI');
Route::get('/getWeightWbs/{id}', 'WBSController@getWeightWbsAPI')->name('api.wbs.getWeightWbsAPI');
Route::get('/getWeightProject/{id}', 'WBSController@getWeightProjectAPI')->name('api.wbs.getWeightProjectAPI');
Route::get('/getDataProfileJstree/{id}', 'WBSController@getDataProfileJstreeAPI')->name('api.project.getDataProfileJstreeAPI');

// activity
Route::get('/getActivities/{id}', 'ActivityController@getActivitiesAPI')->name('api.activity.getActivitiesAPI');
Route::get('/getActivitiesProfile/{id}', 'ActivityController@getActivitiesProfileAPI')->name('api.activity.getActivitiesProfileAPI');
Route::get('/getActivitiesNetwork/{id}', 'ActivityController@getActivitiesNetworkAPI')->name('api.activity.getActivitiesNetworkAPI');
Route::get('/getAllActivities/{id}', 'ActivityController@getAllActivitiesAPI')->name('api.activity.getAllActivitiesAPI');
Route::get('/getAllActivitiesEdit/{project_id}/{activity_id}', 'ActivityController@getAllActivitiesEditAPI')->name('api.activity.getAllActivitiesEditAPI');
Route::get('/getPredecessor/{id}', 'ActivityController@getPredecessorAPI')->name('api.activity.getPredecessorAPI');
Route::get('/getProjectActivity/{id}', 'ActivityController@getProjectAPI')->name('api.activity.getProjectAPI');
Route::get('/getLatestPredecessor/{id}', 'ActivityController@getLatestPredecessorAPI')->name('api.activity.getLatestPredecessorAPI');

// bom profile
Route::get('/getBomProfile/{id}', 'WBSController@getBomProfileAPI')->name('api.wbs.getBomProfileAPI');
Route::get('/getResourceProfile/{id}', 'WBSController@getResourceProfileAPI')->name('api.wbs.getResourceProfileAPI');
Route::get('/getRdProfiles/{id}', 'WBSController@getRdProfilesAPI')->name('api.wbs.getRdProfilesAPI');

// service
Route::get('/getNewServiceDetail/{id}', 'ServiceController@getNewServiceDetailAPI')->name('api.service.getNewServiceDetailAPI');

// Daily Man Hour
Route::get('/getDailyManHour/{id}', 'DailyManHourController@getDailyManHourAPI')->name('api.dmh.getDailyManHourAPI');

// Weather Report
Route::get('/getDailyWeather', 'WeatherController@getWeatherAPI')->name('api.dmh.getWeatherAPI');

// Tidal Report
Route::get('/getDailyTidal', 'TidalController@getTidalAPI')->name('api.dmh.getTidalAPI');

// Reverse Transaction
Route::get('/getDocuments/{id}/{menu}', 'ReverseTransactionController@getDocuments')->name('api.rt.getDocuments');

// Vendor
Route::get('/getMaterialVendor/{id}', 'VendorController@getMaterialAPI')->name('api.vendor.getMaterialAPI');

//Project Standard
Route::get('/getProjectStandard', 'ProjectStandardController@getProjectStandardAPI')->name('api.wbs.getProjectStandardAPI');
Route::get('/getWbsStandard/{id}', 'ProjectStandardController@getWbsStandardAPI')->name('api.wbs.getWbsStandardAPI');
Route::get('/getSubWbsStandard/{id}', 'ProjectStandardController@getSubWbsStandardAPI')->name('api.wbs.getSubWbsStandardAPI');
Route::get('/getActivityStandard/{id}', 'ProjectStandardController@getActivityStandardAPI')->name('api.activity.getActivityStandardAPI');

// Payment Receipt
Route::get('/getInvoicesPReceipt/{id}', 'PaymentController@getInvoiceAPI')->name('api.payment.getInvoiceAPI');
Route::get('/getPaymentsPReceipt/{id}', 'PaymentController@getPaymentAPI')->name('api.payment.getPaymentAPI');

// Yard Plan
Route::get('/getDataYardPlan', 'YardPlanController@getDataYardPlanAPI')->name('api.project.getDataYardPlanAPI');

// Sales Plan
Route::get('/getSalesPlan/{year}', 'SalesPlanController@getSalesPlanAPI')->name('api.project.getSalesPlanAPI');

// QC Task
Route::get('/getQcType/{id}', 'QualityControlTaskController@getQcTypeApi')->name('api.qc_task.getQcTypeApi');

// Delivery Document
Route::get('/getDeliveryDocuments/{project_id}', 'DeliveryDocumentController@getDeliveryDocumentsAPI')->name('api.project.getDeliveryDocumentsAPI');

// Post
Route::get('/getPosts/{project_id}', 'CustomerPortalController@getPostsAPI')->name('api.project.getPostsAPI');
Route::get('/getComments/{project_id}', 'CustomerPortalController@getCommentsAPI')->name('api.project.getCommentsAPI');
