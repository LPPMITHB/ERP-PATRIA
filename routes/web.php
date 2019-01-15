<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@index')->name('index')->middleware('can:show-dashboard');
Auth::routes();

// Configuration Routes
Route::name('appearance.')->prefix('appearance')->group(function() {
    Route::get('/', 'ConfigurationController@appearanceIndex')->name('index');

    Route::post('/', 'ConfigurationController@appearanceSave')->name('save');
});

// Currencies Routes
Route::name('currencies.')->prefix('currencies')->group(function() {
    Route::get('/', 'ConfigurationController@currenciesIndex')->name('index');

    Route::put('/add', 'ConfigurationController@currenciesAdd')->name('add');
});

// Menu Routes
Route::name('menus.')->prefix('menus')->group(function() {
    Route::get('/create', 'MenuController@create')->name('create')->middleware('can:create-menu');

    Route::get('/', 'MenuController@index')->name('index')->middleware('can:list-menu');

    Route::get('/{id}', 'MenuController@show')->name('show')->middleware('can:show-menu');

    Route::get('/{id}/edit', 'MenuController@edit')->name('edit')->middleware('can:edit-menu');

    Route::patch('/{id}', 'MenuController@update')->name('update')->middleware('can:edit-menu');

    Route::post('/', 'MenuController@store')->name('store')->middleware('can:create-menu');

    Route::delete('/{id}', 'MenuController@destroy')->name('destroy')->middleware('can:destroy-menu');
});

// User Management Routes
Route::name('user.')->prefix('user')->group(function() {
    //Change Default Password
    Route::get('/changeDefaultPassword', 'UserController@changeDefaultPassword')->name('changeDefaultPassword')->middleware('can:edit-default-password');   
    
    Route::patch('/updateDefaultPassword', 'UserController@updateDefaultPassword')->name('updateDefaultPassword')->middleware('can:edit-default-password');

    //User
    Route::get('/create', 'UserController@create')->name('create')->middleware('can:create-user');

    Route::get('/', 'UserController@index')->name('index')->middleware('can:list-user');

    Route::get('/{id}', 'UserController@show')->name('show')->middleware('can:show-user');

    Route::get('/{id}/edit', 'UserController@edit')->name('edit')->middleware('can:edit-user');
    
    Route::patch('/{id}', 'UserController@update')->name('update')->middleware('can:edit-user');

    Route::post('/', 'UserController@store')->name('store')->middleware('can:create-user');

    Route::get('/{id}/change', 'UserController@editPassword')->name('change_password')->middleware('can:edit-password');

    Route::patch('/{id}/update', 'UserController@updatePassword')->name('update_password')->middleware('can:edit-password');
});

// Role Management Routes
Route::name('role.')->prefix('role')->group(function() {
    Route::get('/create', 'RoleController@create')->name('create')->middleware('can:create-role');

    Route::get('/', 'RoleController@index')->name('index')->middleware('can:list-role');

    Route::get('/{id}', 'RoleController@show')->name('show')->middleware('can:show-role');

    Route::get('/{id}/edit', 'RoleController@edit')->name('edit')->middleware('can:edit-role');

    Route::patch('/{id}', 'RoleController@update')->name('update')->middleware('can:edit-role');

    Route::post('/', 'RoleController@store')->name('store')->middleware('can:create-role');
});

// Permission Management Routes
Route::name('permission.')->prefix('permission')->group(function() {
    Route::get('/create', 'PermissionController@create')->name('create')->middleware('can:create-permission');

    Route::get('/', 'PermissionController@index')->name('index')->middleware('can:list-permission');

    Route::get('/{id}', 'PermissionController@show')->name('show')->middleware('can:show-permission');

    Route::get('/{id}/edit', 'PermissionController@edit')->name('edit')->middleware('can:edit-permission');

    Route::patch('/{id}', 'PermissionController@update')->name('update')->middleware('can:edit-permission');

    Route::post('/', 'PermissionController@store')->name('store')->middleware('can:create-permission');
});

//Ship Routes
Route::name('ship.')->prefix('ship')->group(function() {
    Route::get('/create', 'ShipController@create')->name('create')->middleware('can:create-ship');

    Route::get('/', 'ShipController@index')->name('index')->middleware('can:list-ship');

    Route::get('/{id}', 'ShipController@show')->name('show')->middleware('can:show-ship');

    Route::get('/{id}/edit', 'ShipController@edit')->name('edit')->middleware('can:edit-ship');

    Route::patch('/{id}', 'ShipController@update')->name('update')->middleware('can:edit-ship');

    Route::post('/', 'ShipController@store')->name('store')->middleware('can:create-ship');
});

//Customer Routes
Route::name('customer.')->prefix('customer')->group(function() {
    Route::get('/create', 'CustomerController@create')->name('create')->middleware('can:create-customer');

    Route::get('/', 'CustomerController@index')->name('index')->middleware('can:list-customer');

    Route::get('/{id}', 'CustomerController@show')->name('show')->middleware('can:show-customer');

    Route::get('/{id}/edit', 'CustomerController@edit')->name('edit')->middleware('can:edit-customer');

    Route::patch('/{id}', 'CustomerController@update')->name('update')->middleware('can:edit-customer');

    Route::post('/', 'CustomerController@store')->name('store')->middleware('can:create-customer');
});

//Branch Routes
Route::name('branch.')->prefix('branch')->group(function() {
    Route::get('/create', 'BranchController@create')->name('create')->middleware('can:create-branch');

    Route::get('/', 'BranchController@index')->name('index')->middleware('can:list-branch');

    Route::get('/{id}', 'BranchController@show')->name('show')->middleware('can:show-branch');

    Route::get('/{id}/edit', 'BranchController@edit')->name('edit')->middleware('can:edit-branch');

    Route::patch('/{id}', 'BranchController@update')->name('update')->middleware('can:edit-branch');

    Route::post('/', 'BranchController@store')->name('store')->middleware('can:create-branch');
});

//Business Unit Routes
Route::name('business_unit.')->prefix('business_unit')->group(function() {
    Route::get('/create', 'BusinessUnitController@create')->name('create')->middleware('can:create-business-unit');

    Route::get('/', 'BusinessUnitController@index')->name('index')->middleware('can:list-business-unit');

    Route::get('/{id}', 'BusinessUnitController@show')->name('show')->middleware('can:show-business-unit');

    Route::get('/{id}/edit', 'BusinessUnitController@edit')->name('edit')->middleware('can:edit-business-unit');

    Route::patch('/{id}', 'BusinessUnitController@update')->name('update')->middleware('can:edit-business-unit');

    Route::post('/', 'BusinessUnitController@store')->name('store')->middleware('can:create-business-unit');
});

//Material Routes
Route::name('material.')->prefix('material')->group(function() {
    Route::get('/create', 'MaterialController@create')->name('create')->middleware('can:create-material');

    Route::get('/', 'MaterialController@index')->name('index')->middleware('can:list-material');

    Route::get('/{id}', 'MaterialController@show')->name('show')->middleware('can:show-material');

    Route::get('/{id}/edit', 'MaterialController@edit')->name('edit')->middleware('can:edit-material');

    Route::patch('/{id}', 'MaterialController@update')->name('update')->middleware('can:edit-material');

    Route::post('/', 'MaterialController@store')->name('store')->middleware('can:create-material');
});

//Resource Management Routes
Route::name('resource.')->prefix('resource')->group(function() {
    Route::get('/assignResource', 'ResourceController@assignResource')->name('assignResource')->middleware('can:list-resource');

    Route::get('/create', 'ResourceController@create')->name('create')->middleware('can:create-resource');

    Route::get('/', 'ResourceController@index')->name('index')->middleware('can:list-resource');

    Route::get('/{id}', 'ResourceController@show')->name('show')->middleware('can:show-resource');

    Route::get('/{id}/edit', 'ResourceController@edit')->name('edit')->middleware('can:edit-resource');

    Route::patch('/{id}', 'ResourceController@update')->name('update')->middleware('can:edit-resource');

    Route::post('/', 'ResourceController@store')->name('store')->middleware('can:create-resource');

    Route::post('/storeAssignResource', 'ResourceController@storeAssignResource')->name('storeAssignResource')->middleware('can:create-resource');

    Route::patch('updateAssignResource/{id}', 'ResourceController@updateAssignResource')->name('updateAssignResource')->middleware('can:edit-resource');

    Route::patch('/storeResourceDetail/{wbs_id}', 'ResourceController@storeResourceDetail')->name('storeResourceDetail')->middleware('can:create-resource');
    
    Route::patch('/storeResourceCategory/{wbs_id}', 'ResourceController@storeResourceCategory')->name('storeResourceCategory')->middleware('can:create-resource');
});

//Unit Of Measurement Routes
Route::name('unit_of_measurement.')->prefix('unit_of_measurement')->group(function() {
    Route::get('/create', 'UnitOfMeasurementController@create')->name('create')->middleware('can:create-unit-of-measurement');

    Route::get('/', 'UnitOfMeasurementController@index')->name('index')->middleware('can:list-unit-of-measurement');

    Route::get('/{id}', 'UnitOfMeasurementController@show')->name('show')->middleware('can:show-unit-of-measurement');

    Route::get('/{id}/edit', 'UnitOfMeasurementController@edit')->name('edit')->middleware('can:edit-unit-of-measurement');

    Route::patch('/{id}', 'UnitOfMeasurementController@update')->name('update')->middleware('can:edit-unit-of-measurement');

    Route::post('/', 'UnitOfMeasurementController@store')->name('store')->middleware('can:create-unit-of-measurement');
});

//Vendor Routes
Route::name('vendor.')->prefix('vendor')->group(function() {
    Route::get('/create', 'VendorController@create')->name('create')->middleware('can:create-vendor');

    Route::get('/', 'VendorController@index')->name('index')->middleware('can:list-vendor');

    Route::get('/{id}', 'VendorController@show')->name('show')->middleware('can:show-vendor');

    Route::get('/{id}/edit', 'VendorController@edit')->name('edit')->middleware('can:edit-vendor');

    Route::patch('/{id}', 'VendorController@update')->name('update')->middleware('can:edit-vendor');

    Route::post('/', 'VendorController@store')->name('store')->middleware('can:create-vendor');
});

//Company Routes
Route::name('company.')->prefix('company')->group(function() {
    Route::get('/create', 'CompanyController@create')->name('create')->middleware('can:create-company');

    Route::get('/', 'CompanyController@index')->name('index')->middleware('can:list-company');

    Route::get('/{id}', 'CompanyController@show')->name('show')->middleware('can:show-company');

    Route::get('/{id}/edit', 'CompanyController@edit')->name('edit')->middleware('can:edit-company');

    Route::patch('/{id}', 'CompanyController@update')->name('update')->middleware('can:edit-company');

    Route::post('/', 'CompanyController@store')->name('store')->middleware('can:create-company');
});

//Service Routes
Route::name('service.')->prefix('service')->group(function() {
    Route::get('/create', 'ServiceController@create')->name('create')->middleware('can:create-service');

    Route::get('/', 'ServiceController@index')->name('index')->middleware('can:list-service');

    Route::get('/{id}', 'ServiceController@show')->name('show')->middleware('can:show-service');

    Route::get('/{id}/edit', 'ServiceController@edit')->name('edit')->middleware('can:edit-service');

    Route::patch('/{id}', 'ServiceController@update')->name('update')->middleware('can:edit-service');

    Route::post('/', 'ServiceController@store')->name('store')->middleware('can:create-service');
});

//StorageLocation Routes
Route::name('storage_location.')->prefix('storage_location')->group(function() {
    Route::get('/create', 'StorageLocationController@create')->name('create')->middleware('can:create-storage-location');

    Route::get('/', 'StorageLocationController@index')->name('index')->middleware('can:list-storage-location');

    Route::get('/{id}', 'StorageLocationController@show')->name('show')->middleware('can:show-storage-location');

    Route::get('/{id}/edit', 'StorageLocationController@edit')->name('edit')->middleware('can:edit-storage-location');

    Route::patch('/{id}', 'StorageLocationController@update')->name('update')->middleware('can:edit-storage-location');

    Route::post('/', 'StorageLocationController@store')->name('store')->middleware('can:create-storage-location');
});

//Warehouse Routes
Route::name('warehouse.')->prefix('warehouse')->group(function() {
    Route::get('/create', 'WarehouseController@create')->name('create')->middleware('can:create-warehouse');

    Route::get('/', 'WarehouseController@index')->name('index')->middleware('can:list-warehouse');

    Route::get('/{id}', 'WarehouseController@show')->name('show')->middleware('can:show-warehouse');

    Route::get('/{id}/edit', 'WarehouseController@edit')->name('edit')->middleware('can:edit-warehouse');

    Route::patch('/{id}', 'WarehouseController@update')->name('update')->middleware('can:edit-warehouse');

    Route::post('/', 'WarehouseController@store')->name('store')->middleware('can:create-warehouse');
});

//Yard Routes
Route::name('yard.')->prefix('yard')->group(function() {
    Route::get('/create', 'YardController@create')->name('create')->middleware('can:create-yard');

    Route::get('/', 'YardController@index')->name('index')->middleware('can:list-yard');

    Route::get('/{id}', 'YardController@show')->name('show')->middleware('can:show-yard');

    Route::get('/{id}/edit', 'YardController@edit')->name('edit')->middleware('can:edit-yard');

    Route::patch('/{id}', 'YardController@update')->name('update')->middleware('can:edit-yard');

    Route::post('/', 'YardController@store')->name('store')->middleware('can:create-yard');
});

//BOM Routes
Route::name('bom.')->prefix('bom')->group(function() {
    Route::post('/storeBom', 'BOMController@storeBom')->name('storeBom')->middleware('can:create-bom');

    Route::put('/', 'BOMController@update')->name('update')->middleware('can:edit-bom');

    Route::get('/create/{id}', 'BOMController@create')->name('create')->middleware('can:create-bom');

    Route::get('/indexProject', 'BOMController@indexProject')->name('indexProject')->middleware('can:create-bom');

    Route::get('/selectProject', 'BOMController@selectProject')->name('selectProject')->middleware('can:list-bom');
    
    Route::get('/selectWBS/{id}', 'BOMController@selectWBS')->name('selectWBS')->middleware('can:list-bom');

    Route::get('/indexBom/{id}', 'BOMController@indexBom')->name('indexBom')->middleware('can:edit-bom');

    Route::get('/{id}', 'BOMController@show')->name('show')->middleware('can:show-bom');

    Route::get('/{id}/edit', 'BOMController@edit')->name('edit')->middleware('can:edit-bom');

    Route::put('/updateDesc', 'BOMController@updateDesc')->name('updateDesc')->middleware('can:edit-bom');

    Route::post('/', 'BOMController@store')->name('store')->middleware('can:create-bom');
});

//BOM Repair Routes
Route::name('bom_repair.')->prefix('bom_repair')->group(function() {
    Route::post('/storeBom', 'BOMController@storeBom')->name('storeBom')->middleware('can:create-bom-repair');

    Route::put('/', 'BOMController@update')->name('update')->middleware('can:edit-bom-repair');

    Route::get('/create/{id}', 'BOMController@create')->name('create')->middleware('can:create-bom-repair');

    Route::get('/indexProject', 'BOMController@indexProject')->name('indexProject')->middleware('can:create-bom-repair');

    Route::get('/selectProject', 'BOMController@selectProject')->name('selectProject')->middleware('can:create-bom-repair');
    
    Route::get('/selectWBS/{id}', 'BOMController@selectWBS')->name('selectWBS')->middleware('can:list-bom-repair');

    Route::get('/indexBom/{id}', 'BOMController@indexBom')->name('indexBom')->middleware('can:list-bom-repair');

    Route::get('/{id}', 'BOMController@show')->name('show')->middleware('can:show-bom-repair');

    Route::get('/{id}/edit', 'BOMController@edit')->name('edit')->middleware('can:edit-bom-repair');

    Route::put('/updateDesc', 'BOMController@updateDesc')->name('updateDesc')->middleware('can:edit-bom-repair');

    Route::post('/', 'BOMController@store')->name('store')->middleware('can:create-bom-repair');

    Route::patch('/destroy', 'BOMController@destroy')->name('destroy')->middleware('can:destroy-bom-repair');
});

//Project Routes
Route::name('project.')->prefix('project')->group(function() {
    // Project Cost Evaluation
    Route::get('/projectCE/{id}', 'ProjectController@projectCE')->name('projectCE')->middleware('can:show-project');
    
    //GanttChart
    Route::get('/ganttChart/{id}', 'ProjectController@showGanttChart')->name('showGanttChart')->middleware('can:show-project');

    //Project
    Route::get('/create', 'ProjectController@create')->name('create')->middleware('can:create-project');

    Route::get('/', 'ProjectController@index')->name('index')->middleware('can:list-project');

    Route::get('/{id}', 'ProjectController@show')->name('show')->middleware('can:show-project');

    Route::get('/{id}/edit', 'ProjectController@edit')->name('edit')->middleware('can:edit-project');

    Route::patch('/{id}', 'ProjectController@update')->name('update')->middleware('can:edit-project');
    
    Route::post('/', 'ProjectController@store')->name('store')->middleware('can:create-project');

    Route::delete('/{id}', 'ProjectController@destroy')->name('destroy')->middleware('can:destroy-project');
    
    Route::get('/listWBS/{id}/{menu}', 'ProjectController@listWBS')->name('listWBS')->middleware('can:show-project');
});

//Project Routes
Route::name('project_repair.')->prefix('project_repair')->group(function() {
    // Project Cost Evaluation
    Route::get('/projectCE/{id}', 'ProjectController@projectCE')->name('projectCE')->middleware('can:show-project-repair');
    
    //GanttChart
    Route::get('/ganttChart/{id}', 'ProjectController@showGanttChart')->name('showGanttChart')->middleware('can:show-project-repair');

    //Project
    Route::get('/create', 'ProjectController@create')->name('create')->middleware('can:create-project-repair');

    Route::get('/', 'ProjectController@index')->name('index')->middleware('can:list-project-repair');

    Route::get('/{id}', 'ProjectController@show')->name('show')->middleware('can:show-project-repair');

    Route::get('/{id}/edit', 'ProjectController@edit')->name('edit')->middleware('can:edit-project-repair');

    Route::patch('/{id}', 'ProjectController@update')->name('update')->middleware('can:edit-project-repair');
    
    Route::post('/', 'ProjectController@store')->name('store')->middleware('can:create-project-repair');

    Route::delete('/{id}', 'ProjectController@destroy')->name('destroy')->middleware('can:destroy-project-repair');   
    
    Route::get('/listWBS/{id}/{menu}', 'ProjectController@listWBS')->name('listWBS')->middleware('can:show-project-repair');

});

// WBS Routes
Route::name('wbs.')->prefix('wbs')->group(function() {
    // WBS & Estimator Configuration
    Route::get('/selectProjectConfig', 'WBSController@selectProjectConfig')->name('selectProjectConfig')->middleware('can:create-project');

    Route::get('/configWbsEstimator/{id}', 'WBSController@configWbsEstimator')->name('configWbsEstimator')->middleware('can:create-project');
    
    //WBS
    Route::get('/listWBS/{id}/{menu}', 'WBSController@listWBS')->name('listWBS')->middleware('can:show-project');

    Route::get('/createWBS/{id}', 'WBSController@createWBS')->name('createWBS')->middleware('can:create-project');

    Route::post('/store', 'WBSController@store')->name('store')->middleware('can:create-project');
    
    Route::put('update/{id}', 'WBSController@update')->name('update')->middleware('can:edit-project');  
      
    Route::patch('updateWithForm/{id}', 'WBSController@updateWithForm')->name('updateWithForm')->middleware('can:edit-project');    
    
    Route::get('/createSubWBS/{project_id}/{wbs_id}', 'WBSController@createSubWBS')->name('createSubWBS')->middleware('can:create-project');
        
    Route::get('/show/{id}', 'WBSController@show')->name('show')->middleware('can:show-project');    
});

// WBS Repair Routes
Route::name('wbs_repair.')->prefix('wbs_repair')->group(function() {
    // WBS & Estimator Configuration
    Route::get('/selectProjectConfig', 'WBSController@selectProjectConfig')->name('selectProjectConfig')->middleware('can:create-project-repair');

    Route::get('/configWbsEstimator/{id}', 'WBSController@configWbsEstimator')->name('configWbsEstimator')->middleware('can:create-project-repair');
    
    //WBS
    Route::get('/listWBS/{id}/{menu}', 'WBSController@listWBS')->name('listWBS')->middleware('can:show-project-repair');

    Route::get('/createWBS/{id}', 'WBSController@createWBS')->name('createWBS')->middleware('can:create-project-repair');

    Route::post('/store', 'WBSController@store')->name('store')->middleware('can:create-project-repair');
    
    Route::put('update/{id}', 'WBSController@update')->name('update')->middleware('can:edit-project-repair');  
      
    Route::patch('updateWithForm/{id}', 'WBSController@updateWithForm')->name('updateWithForm')->middleware('can:edit-project-repair');    
    
    Route::get('/createSubWBS/{project_id}/{wbs_id}', 'WBSController@createSubWBS')->name('createSubWBS')->middleware('can:create-project-repair');
        
    Route::get('/show/{id}', 'WBSController@show')->name('show')->middleware('can:show-project-repair');    
});

// Activity Routes
Route::name('activity.')->prefix('activity')->group(function() {
    //Confirm Activity
    Route::get('/selectWbs/{id}/{menu}', 'ProjectController@listWBS')->name('selectWbs')->middleware('can:show-project');

    Route::get('/indexConfirm', 'ActivityController@indexConfirm')->name('indexConfirm')->middleware('can:show-project');

    Route::get('/confirmActivity/{id}', 'ActivityController@confirmActivity')->name('confirmActivity')->middleware('can:show-project');

    Route::put('updateActualActivity/{id}', 'ActivityController@updateActualActivity')->name('updateActualActivity')->middleware('can:edit-project');    

    //Activity 
    Route::get('/create/{id}', 'ActivityController@create')->name('create')->middleware('can:create-project');

    Route::put('update/{id}', 'ActivityController@update')->name('update')->middleware('can:edit-project');    

    Route::post('/store', 'ActivityController@store')->name('store')->middleware('can:create-project');
    
    Route::get('/index/{id}', 'ActivityController@index')->name('index')->middleware('can:show-project');

    Route::get('/show/{id}', 'ActivityController@show')->name('show')->middleware('can:show-project');
    
    //Network
    Route::put('updatePredecessor/{id}', 'ActivityController@updatePredecessor')->name('updatePredecessor')->middleware('can:edit-project');
    
    Route::get('/manageNetwork/{id}', 'ActivityController@manageNetwork')->name('manageNetwork')->middleware('can:show-project');
});

// Activity Repair Routes
Route::name('activity_repair.')->prefix('activity_repair')->group(function() {
    //Confirm Activity
    Route::get('/selectWbs/{id}/{menu}', 'ProjectController@listWBS')->name('selectWbs')->middleware('can:show-project-repair');

    Route::get('/indexConfirm', 'ActivityController@indexConfirm')->name('indexConfirm')->middleware('can:show-project-repair');

    Route::get('/confirmActivity/{id}', 'ActivityController@confirmActivity')->name('confirmActivity')->middleware('can:show-project-repair');

    Route::put('updateActualActivity/{id}', 'ActivityController@updateActualActivity')->name('updateActualActivity')->middleware('can:edit-project-repair');    

    //Activity 
    Route::get('/create/{id}', 'ActivityController@create')->name('create')->middleware('can:create-project-repair');

    Route::put('update/{id}', 'ActivityController@update')->name('update')->middleware('can:edit-project-repair');    

    Route::post('/store', 'ActivityController@store')->name('store')->middleware('can:create-project-repair');
    
    Route::get('/index/{id}', 'ActivityController@index')->name('index')->middleware('can:show-project-repair');

    Route::get('/show/{id}', 'ActivityController@show')->name('show')->middleware('can:show-project-repair');
    
    //Network
    Route::put('updatePredecessor/{id}', 'ActivityController@updatePredecessor')->name('updatePredecessor')->middleware('can:edit-project-repair');
    
    Route::get('/manageNetwork/{id}', 'ActivityController@manageNetwork')->name('manageNetwork')->middleware('can:show-project-repair');
   
});

//rap Routes
Route::name('rap.')->prefix('rap')->group(function() {
    Route::get('/selectProject', 'RAPController@selectProject')->name('selectProject')->middleware('can:list-rap');

    Route::get('/indexSelectProject', 'RAPController@indexSelectProject')->name('indexSelectProject')->middleware('can:list-rap');

    Route::get('/index/{id}', 'RAPController@index')->name('index')->middleware('can:list-rap');
    
    Route::get('/selectProjectCost', 'RAPController@selectProjectCost')->name('selectProjectCost')->middleware('can:create-other-cost');

    Route::get('/selectProjectActualOtherCost', 'RAPController@selectProjectActualOtherCost')->name('selectProjectActualOtherCost')->middleware('can:create-actual-other-cost');
    
    Route::get('/selectProjectViewCost', 'RAPController@selectProjectViewCost')->name('selectProjectViewCost')->middleware('can:view-planned-cost');

    Route::get('/selectProjectViewRM', 'RAPController@selectProjectViewRM')->name('selectProjectViewRM')->middleware('can:view-remaining-material');
    
    Route::get('/selectWBS/{id}', 'RAPController@selectWBS')->name('selectWBS')->middleware('can:view-remaining-material');

    Route::get('/showMaterialEvaluation/{id}', 'RAPController@showMaterialEvaluation')->name('showMaterialEvaluation')->middleware('can:view-remaining-material');

    Route::get('/createCost/{id}', 'RAPController@createCost')->name('createCost')->middleware('can:create-other-cost');

    Route::get('/viewPlannedCost/{id}', 'RAPController@viewPlannedCost')->name('viewPlannedCost')->middleware('can:view-planned-cost');
    
    Route::get('/inputActualOtherCost/{id}', 'RAPController@inputActualOtherCost')->name('inputActualOtherCost');

    Route::get('/assignCost/{id}', 'RAPController@assignCost')->name('assignCost');

    Route::post('/storeCost', 'RAPController@storeCost')->name('storeCost');

    Route::put('updateCost/{id}', 'RAPController@updateCost')->name('updateCost');  
     
    Route::put('/storeActualCost', 'RAPController@storeActualCost')->name('storeActualCost');

    Route::get('/getCosts/{id}', 'RAPController@getCosts')->name('getCosts');

    Route::get('/{id}', 'RAPController@show')->name('show')->middleware('can:show-rap');
    
    Route::get('/{id}/edit', 'RAPController@edit')->name('edit')->middleware('can:edit-rap');
    
    Route::patch('/{id}', 'RAPController@update')->name('update')->middleware('can:edit-rap');
});

//rap Routes
Route::name('rap_repair.')->prefix('rap_repair')->group(function() {
    Route::get('/selectProject', 'RAPController@selectProject')->name('selectProject')->middleware('can:list-rap');

    Route::get('/indexSelectProject', 'RAPController@indexSelectProject')->name('indexSelectProject')->middleware('can:list-rap-repair');

    Route::get('/index/{id}', 'RAPController@index')->name('index')->middleware('can:list-rap-repair');
    
    Route::get('/selectProjectCost', 'RAPController@selectProjectCost')->name('selectProjectCost')->middleware('can:create-other-cost-repair');

    Route::get('/selectProjectActualOtherCost', 'RAPController@selectProjectActualOtherCost')->name('selectProjectActualOtherCost')->middleware('can:create-actual-other-cost-repair');
    
    Route::get('/selectProjectViewCost', 'RAPController@selectProjectViewCost')->name('selectProjectViewCost')->middleware('can:view-planned-cost-repair');

    Route::get('/selectProjectViewRM', 'RAPController@selectProjectViewRM')->name('selectProjectViewRM')->middleware('can:view-remaining-material-repair');
    
    Route::get('/selectWBS/{id}', 'RAPController@selectWBS')->name('selectWBS')->middleware('can:view-remaining-material-repair');

    Route::get('/showMaterialEvaluation/{id}', 'RAPController@showMaterialEvaluation')->name('showMaterialEvaluation')->middleware('can:view-remaining-material-repair');

    Route::get('/createCost/{id}', 'RAPController@createCost')->name('createCost')->middleware('can:create-other-cost-repair');

    Route::get('/viewPlannedCost/{id}', 'RAPController@viewPlannedCost')->name('viewPlannedCost')->middleware('can:view-planned-cost-repair');
    
    Route::get('/inputActualOtherCost/{id}', 'RAPController@inputActualOtherCost')->name('inputActualOtherCost')->middleware('can:create-actual-other-cost-repair');

    Route::patch('updateCost/{id}', 'RAPController@updateCost')->name('updateCost');  
     
    Route::patch('/storeActualCost', 'RAPController@storeActualCost')->name('storeActualCost');

    Route::get('/{id}', 'RAPController@show')->name('show')->middleware('can:show-rap-repair');
    
    Route::get('/{id}/edit', 'RAPController@edit')->name('edit')->middleware('can:edit-rap-repair');
    
    Route::patch('/{id}', 'RAPController@update')->name('update')->middleware('can:edit-rap-repair');
});

//Work Request Routes
Route::name('work_request.')->prefix('work_request')->group(function() {
    Route::patch('/{id}', 'WorkRequestController@update')->name('update')->middleware('can:edit-work-request');

    Route::get('/indexApprove', 'WorkRequestController@indexApprove')->name('indexApprove')->middleware('can:approve-work-request');

    Route::get('/approval/{id}/{status}', 'WorkRequestController@approval')->name('approval')->middleware('can:approve-work-request');

    Route::delete('/{id}', 'WorkRequestController@destroy')->name('destroy')->middleware('can:edit-work-request');

    Route::delete('/', 'WorkRequestController@destroyWRD')->name('destroyWRD')->middleware('can:destroy-work-request');

    Route::patch('/updateWRD', 'WorkRequestController@updateWRD')->name('updateWRD')->middleware('can:edit-work-request');

    Route::get('/', 'WorkRequestController@index')->name('index')->middleware('can:list-work-request');

    Route::get('/create', 'WorkRequestController@create')->name('create')->middleware('can:create-work-request');

    Route::get('/{id}', 'WorkRequestController@show')->name('show')->middleware('can:show-work-request');

    Route::get('/showApprove/{id}', 'WorkRequestController@showApprove')->name('showApprove')->middleware('can:approve-work-request');

    Route::get('/edit/{id}', 'WorkRequestController@edit')->name('edit')->middleware('can:edit-work-request');

    Route::post('/', 'WorkRequestController@store')->name('store')->middleware('can:create-work-request');

    Route::post('/storeWRD', 'WorkRequestController@storeWRD')->name('storeWRD')->middleware('can:edit-work-request');

});

//Work Request Routes
Route::name('work_request_repair.')->prefix('work_request_repair')->group(function() {
    Route::patch('/{id}', 'WorkRequestController@update')->name('update')->middleware('can:edit-work-request-repair');

    Route::get('/indexApprove', 'WorkRequestController@indexApprove')->name('indexApprove')->middleware('can:approve-work-request-repair');

    Route::get('/approval/{id}/{status}', 'WorkRequestController@approval')->name('approval')->middleware('can:approve-work-request-repair');

    Route::delete('/{id}', 'WorkRequestController@destroy')->name('destroy')->middleware('can:edit-work-request-repair');

    Route::delete('/', 'WorkRequestController@destroyWRD')->name('destroyWRD')->middleware('can:destroy-work-request-repair');

    Route::patch('/updateWRD', 'WorkRequestController@updateWRD')->name('updateWRD')->middleware('can:edit-work-request-repair');

    Route::get('/', 'WorkRequestController@index')->name('index')->middleware('can:list-work-request-repair');

    Route::get('/create', 'WorkRequestController@create')->name('create')->middleware('can:create-work-request-repair');

    Route::get('/{id}', 'WorkRequestController@show')->name('show')->middleware('can:show-work-request-repair');

    Route::get('/showApprove/{id}', 'WorkRequestController@showApprove')->name('showApprove')->middleware('can:approve-work-request-repair');

    Route::get('/edit/{id}', 'WorkRequestController@edit')->name('edit')->middleware('can:edit-work-request-repair');

    Route::post('/', 'WorkRequestController@store')->name('store')->middleware('can:create-work-request-repair');

    Route::post('/storeWRD', 'WorkRequestController@storeWRD')->name('storeWRD')->middleware('can:edit-work-request-repair');

});

//Purchase Requisition Routes
Route::name('purchase_requisition.')->prefix('purchase_requisition')->group(function() {
    Route::post('/storeConsolidation', 'PurchaseRequisitionController@storeConsolidation')->name('storeConsolidation')->middleware('can:consolidation-purchase-requisition');

    Route::patch('/{id}', 'PurchaseRequisitionController@update')->name('update')->middleware('can:edit-purchase-requisition');

    Route::get('/indexApprove', 'PurchaseRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-requisition');

    Route::get('/indexConsolidation', 'PurchaseRequisitionController@indexConsolidation')->name('indexConsolidation')->middleware('can:consolidation-purchase-requisition');

    Route::get('/approval/{id}/{status}', 'PurchaseRequisitionController@approval')->name('approval')->middleware('can:approve-purchase-requisition');

    Route::delete('/{id}', 'PurchaseRequisitionController@destroy')->name('destroy')->middleware('can:edit-purchase-requisition');

    Route::delete('/', 'PurchaseRequisitionController@destroyPRD')->name('destroyPRD')->middleware('can:consolidation-purchase-requisition');

    Route::get('/', 'PurchaseRequisitionController@index')->name('index')->middleware('can:list-purchase-requisition');

    Route::get('/create', 'PurchaseRequisitionController@create')->name('create')->middleware('can:create-purchase-requisition');

    Route::get('/{id}', 'PurchaseRequisitionController@show')->name('show')->middleware('can:show-purchase-requisition');

    Route::get('/showApprove/{id}', 'PurchaseRequisitionController@showApprove')->name('showApprove')->middleware('can:approve-purchase-requisition');

    Route::get('/edit/{id}', 'PurchaseRequisitionController@edit')->name('edit')->middleware('can:edit-purchase-requisition');

    Route::post('/', 'PurchaseRequisitionController@store')->name('store')->middleware('can:create-purchase-requisition');
});

//Purchase Requisition Repair Routes
Route::name('purchase_requisition_repair.')->prefix('purchase_requisition_repair')->group(function() {
    Route::post('/storeConsolidation', 'PurchaseRequisitionController@storeConsolidation')->name('storeConsolidation')->middleware('can:consolidation-purchase-requisition-repair');

    Route::patch('/{id}', 'PurchaseRequisitionController@update')->name('update')->middleware('can:edit-purchase-requisition-repair');

    Route::get('/indexApprove', 'PurchaseRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-requisition-repair');

    Route::get('/indexConsolidation', 'PurchaseRequisitionController@indexConsolidation')->name('indexConsolidation')->middleware('can:consolidation-purchase-requisition-repair');

    Route::get('/approval/{id}/{status}', 'PurchaseRequisitionController@approval')->name('approval')->middleware('can:approve-purchase-requisition-repair');

    Route::delete('/{id}', 'PurchaseRequisitionController@destroy')->name('destroy')->middleware('can:edit-purchase-requisition-repair');

    Route::delete('/', 'PurchaseRequisitionController@destroyPRD')->name('destroyPRD')->middleware('can:consolidation-purchase-requisition-repair');

    Route::get('/', 'PurchaseRequisitionController@index')->name('index')->middleware('can:list-purchase-requisition-repair');

    Route::get('/create', 'PurchaseRequisitionController@create')->name('create')->middleware('can:create-purchase-requisition-repair');

    Route::get('/{id}', 'PurchaseRequisitionController@show')->name('show')->middleware('can:show-purchase-requisition-repair');

    Route::get('/showApprove/{id}', 'PurchaseRequisitionController@showApprove')->name('showApprove')->middleware('can:approve-purchase-requisition-repair');

    Route::get('/edit/{id}', 'PurchaseRequisitionController@edit')->name('edit')->middleware('can:edit-purchase-requisition-repair');

    Route::post('/', 'PurchaseRequisitionController@store')->name('store')->middleware('can:create-purchase-requisition-repair');
});

//Purchase Order Routes
Route::name('purchase_order.')->prefix('purchase_order')->group(function() {
    Route::get('/indexApprove', 'PurchaseOrderController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-order');

    Route::get('/approval/{id}/{status}', 'PurchaseOrderController@approval')->name('approval')->middleware('can:approve-purchase-order');
    
    Route::get('/selectPR', 'PurchaseOrderController@selectPR')->name('selectPR')->middleware('can:create-purchase-order');
    
    Route::get('/', 'PurchaseOrderController@index')->name('index')->middleware('can:list-purchase-order');

    Route::get('/create', 'PurchaseOrderController@create')->name('create')->middleware('can:create-purchase-order');

    Route::get('/selectPRD/{id}', 'PurchaseOrderController@selectPRD')->name('selectPRD')->middleware('can:create-purchase-order');

    Route::get('/{id}', 'PurchaseOrderController@show')->name('show')->middleware('can:show-purchase-order');

    Route::get('/showApprove/{id}', 'PurchaseOrderController@showApprove')->name('showApprove')->middleware('can:approve-purchase-order');

    Route::get('/{id}/edit', 'PurchaseOrderController@edit')->name('edit')->middleware('can:edit-purchase-order');

    Route::patch('/', 'PurchaseOrderController@update')->name('update')->middleware('can:edit-purchase-order');

    Route::post('/', 'PurchaseOrderController@store')->name('store')->middleware('can:create-purchase-order');
});

//Purchase Order Repair Routes
Route::name('purchase_order_repair.')->prefix('purchase_order_repair')->group(function() {
    Route::get('/indexApprove', 'PurchaseOrderController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-order-repair');

    Route::get('/approval/{id}/{status}', 'PurchaseOrderController@approval')->name('approval')->middleware('can:approve-purchase-order-repair');
    
    Route::get('/selectPR', 'PurchaseOrderController@selectPR')->name('selectPR')->middleware('can:create-purchase-order-repair');
    
    Route::get('/', 'PurchaseOrderController@index')->name('index')->middleware('can:list-purchase-order-repair');

    Route::get('/create', 'PurchaseOrderController@create')->name('create')->middleware('can:create-purchase-order-repair');

    Route::get('/selectPRD/{id}', 'PurchaseOrderController@selectPRD')->name('selectPRD')->middleware('can:create-purchase-order-repair');

    Route::get('/{id}', 'PurchaseOrderController@show')->name('show')->middleware('can:show-purchase-order-repair');

    Route::get('/showApprove/{id}', 'PurchaseOrderController@showApprove')->name('showApprove')->middleware('can:approve-purchase-order-repair');

    Route::get('/{id}/edit', 'PurchaseOrderController@edit')->name('edit')->middleware('can:edit-purchase-order-repair');

    Route::patch('/', 'PurchaseOrderController@update')->name('update')->middleware('can:edit-purchase-order-repair');

    Route::post('/', 'PurchaseOrderController@store')->name('store')->middleware('can:create-purchase-order-repair');
});

//Work Order Routes
Route::name('work_order.')->prefix('work_order')->group(function() {
    Route::get('/indexApprove', 'WorkOrderController@indexApprove')->name('indexApprove')->middleware('can:approve-work-order');

    Route::get('/approval/{id}/{status}', 'WorkOrderController@approval')->name('approval')->middleware('can:approve-work-order');
    
    Route::get('/selectWR', 'WorkOrderController@selectWR')->name('selectWR')->middleware('can:create-work-order');
    
    Route::get('/', 'WorkOrderController@index')->name('index')->middleware('can:list-work-order');

    Route::get('/create', 'WorkOrderController@create')->name('create')->middleware('can:create-work-order');

    Route::get('/selectWRD/{id}', 'WorkOrderController@selectWRD')->name('selectWRD')->middleware('can:create-work-order');

    Route::get('/{id}', 'WorkOrderController@show')->name('show')->middleware('can:show-work-order');

    Route::get('/showApprove/{id}', 'WorkOrderController@showApprove')->name('showApprove')->middleware('can:approve-work-order');

    Route::get('/{id}/edit', 'WorkOrderController@edit')->name('edit')->middleware('can:edit-work-order');

    Route::patch('/', 'WorkOrderController@update')->name('update')->middleware('can:edit-work-order');

    Route::post('/', 'WorkOrderController@store')->name('store')->middleware('can:create-work-order');

    Route::delete('/{id}', 'WorkOrderController@destroy')->name('destroy')->middleware('can:destroy-work-order');
});

//Work Order Routes
Route::name('work_order_repair.')->prefix('work_order_repair')->group(function() {
    Route::get('/indexApprove', 'WorkOrderController@indexApprove')->name('indexApprove')->middleware('can:approve-work-order-repair');

    Route::get('/approval/{id}/{status}', 'WorkOrderController@approval')->name('approval')->middleware('can:approve-work-order-repair');
    
    Route::get('/selectWR', 'WorkOrderController@selectWR')->name('selectWR')->middleware('can:create-work-order-repair');
    
    Route::get('/', 'WorkOrderController@index')->name('index')->middleware('can:list-work-order-repair');

    Route::get('/create', 'WorkOrderController@create')->name('create')->middleware('can:create-work-order-repair');

    Route::get('/selectWRD/{id}', 'WorkOrderController@selectWRD')->name('selectWRD')->middleware('can:create-work-order-repair');

    Route::get('/{id}', 'WorkOrderController@show')->name('show')->middleware('can:show-work-order-repair');

    Route::get('/showApprove/{id}', 'WorkOrderController@showApprove')->name('showApprove')->middleware('can:show-work-order-repair');

    Route::get('/{id}/edit', 'WorkOrderController@edit')->name('edit')->middleware('can:edit-work-order-repair');

    Route::patch('/', 'WorkOrderController@update')->name('update')->middleware('can:edit-work-order-repair');

    Route::post('/', 'WorkOrderController@store')->name('store')->middleware('can:create-work-order-repair');

    Route::delete('/{id}', 'WorkOrderController@destroy')->name('destroy')->middleware('can:destroy-work-order-repair');
});

//Physical Inventory Routes
Route::name('physical_inventory.')->prefix('physical_inventory')->group(function() {
    Route::get('/indexSnapshot', 'PhysicalInventoryController@indexSnapshot')->name('indexSnapshot')->middleware('can:create-snapshot');

    Route::post('/displaySnapshot', 'PhysicalInventoryController@displaySnapshot')->name('displaySnapshot')->middleware('can:create-snapshot');
    
    Route::post('/storeSnapshot', 'PhysicalInventoryController@storeSnapshot')->name('storeSnapshot')->middleware('can:create-snapshot');

    Route::get('/showSnapshot/{id}', 'PhysicalInventoryController@showSnapshot')->name('showSnapshot')->middleware('can:show-snapshot');

    Route::get('/indexCountStock', 'PhysicalInventoryController@indexCountStock')->name('indexCountStock')->middleware('can:count-stock');

    Route::get('/countStock/{id}', 'PhysicalInventoryController@countStock')->name('countStock')->middleware('can:count-stock');

    Route::patch('/storeCountStock/{id}', 'PhysicalInventoryController@storeCountStock')->name('storeCountStock')->middleware('can:count-stock');

    Route::get('/showCountStock/{id}', 'PhysicalInventoryController@showCountStock')->name('showCountStock')->middleware('can:count-stock');

    Route::get('/showPI/{id}', 'PhysicalInventoryController@showPI')->name('showPI')->middleware('can:show-adjustment-history');

    Route::get('/showConfirmCountStock/{id}', 'PhysicalInventoryController@showConfirmCountStock')->name('showConfirmCountStock')->middleware('can:adjust-stock');

    Route::get('/indexAdjustStock', 'PhysicalInventoryController@indexAdjustStock')->name('indexAdjustStock')->middleware('can:adjust-stock');

    Route::patch('/storeAdjustStock/{id}', 'PhysicalInventoryController@storeAdjustStock')->name('storeAdjustStock')->middleware('can:adjust-stock');

    Route::get('/viewAdjustmentHistory', 'PhysicalInventoryController@viewAdjustmentHistory')->name('viewAdjustmentHistory')->middleware('can:list-adjustment-history');

});

//Physical Inventory Routes
Route::name('physical_inventory_repair.')->prefix('physical_inventory_repair')->group(function() {
    Route::get('/indexSnapshot', 'PhysicalInventoryController@indexSnapshot')->name('indexSnapshot')->middleware('can:create-snapshot-repair');

    Route::post('/displaySnapshot', 'PhysicalInventoryController@displaySnapshot')->name('displaySnapshot')->middleware('can:create-snapshot-repair');
    
    Route::post('/storeSnapshot', 'PhysicalInventoryController@storeSnapshot')->name('storeSnapshot')->middleware('can:create-snapshot-repair');

    Route::get('/showSnapshot/{id}', 'PhysicalInventoryController@showSnapshot')->name('showSnapshot')->middleware('can:show-snapshot-repair');

    Route::get('/indexCountStock', 'PhysicalInventoryController@indexCountStock')->name('indexCountStock')->middleware('can:count-stock-repair');

    Route::get('/countStock/{id}', 'PhysicalInventoryController@countStock')->name('countStock')->middleware('can:count-stock-repair');

    Route::patch('/storeCountStock/{id}', 'PhysicalInventoryController@storeCountStock')->name('storeCountStock')->middleware('can:count-stock-repair');

    Route::get('/showCountStock/{id}', 'PhysicalInventoryController@showCountStock')->name('showCountStock')->middleware('can:count-stock-repair');

    Route::get('/showPI/{id}', 'PhysicalInventoryController@showPI')->name('showPI')->middleware('can:show-adjustment-history-repair');

    Route::get('/showConfirmCountStock/{id}', 'PhysicalInventoryController@showConfirmCountStock')->name('showConfirmCountStock')->middleware('can:adjust-stock-repair');

    Route::get('/indexAdjustStock', 'PhysicalInventoryController@indexAdjustStock')->name('indexAdjustStock')->middleware('can:adjust-stock-repair');

    Route::patch('/storeAdjustStock/{id}', 'PhysicalInventoryController@storeAdjustStock')->name('storeAdjustStock')->middleware('can:adjust-stock-repair');

    Route::get('/viewAdjustmentHistory', 'PhysicalInventoryController@viewAdjustmentHistory')->name('viewAdjustmentHistory')->middleware('can:list-adjustment-history-repair');

});

// Good Receipt Routes
Route::name('goods_receipt.')->prefix('goods_receipt')->group(function() {    
    Route::get('/selectPO', 'GoodsReceiptController@selectPO')->name('selectPO')->middleware('can:create-goods-receipt');

    Route::get('/createGrWithRef/{id}', 'GoodsReceiptController@createGrWithRef')->name('createGrWithRef')->middleware('can:create-goods-receipt');

    Route::post('/', 'GoodsReceiptController@store')->name('store')->middleware('can:create-goods-receipt');

    Route::get('/createGrFromWo/{id}', 'GoodsReceiptController@createGrFromWo')->name('createGrFromWo')->middleware('can:create-goods-receipt');

    Route::post('/storeWo', 'GoodsReceiptController@storeWo')->name('storeWo')->middleware('can:create-goods-receipt');

    Route::get('/createGrWithoutRef', 'GoodsReceiptController@createGrWithoutRef')->name('createGrWithoutRef')->middleware('can:create-goods-receipt-without-ref');

    Route::post('/storeWOR', 'GoodsReceiptController@storeWOR')->name('storeWOR')->middleware('can:create-goods-receipt-without-ref');

    Route::get('/', 'GoodsReceiptController@index')->name('index')->middleware('can:list-goods-receipt');

    Route::get('/{id}', 'GoodsReceiptController@show')->name('show')->middleware('can:show-goods-receipt');
});

// Good Receipt Repair Routes
Route::name('goods_receipt_repair.')->prefix('goods_receipt_repair')->group(function() {    
    Route::get('/selectPO', 'GoodsReceiptController@selectPO')->name('selectPO')->middleware('can:create-goods-receipt-repair');

    Route::get('/createGrWithRef/{id}', 'GoodsReceiptController@createGrWithRef')->name('createGrWithRef')->middleware('can:create-goods-receipt-repair');

    Route::post('/', 'GoodsReceiptController@store')->name('store')->middleware('can:create-goods-receipt-repair');

    Route::get('/createGrFromWo/{id}', 'GoodsReceiptController@createGrFromWo')->name('createGrFromWo')->middleware('can:create-goods-receipt-repair');

    Route::post('/storeWo', 'GoodsReceiptController@storeWo')->name('storeWo')->middleware('can:create-goods-receipt-repair');

    Route::get('/createGrWithoutRef', 'GoodsReceiptController@createGrWithoutRef')->name('createGrWithoutRef')->middleware('can:create-goods-receipt-without-ref-repair');

    Route::post('/storeWOR', 'GoodsReceiptController@storeWOR')->name('storeWOR')->middleware('can:create-goods-receipt-without-ref-repair');

    Route::get('/', 'GoodsReceiptController@index')->name('index')->middleware('can:list-goods-receipt-repair');

    Route::get('/{id}', 'GoodsReceiptController@show')->name('show')->middleware('can:show-goods-receipt-repair');
});

//Stock Management Routes
Route::name('stock_management.')->prefix('stock_management')->group(function() {
    Route::get('/', 'StockManagementController@index')->name('index');
});

//Stock Management Routes
Route::name('stock_management_repair.')->prefix('stock_management_repair')->group(function() {
    Route::get('/', 'StockManagementController@index')->name('index');
});

//Material Requisition Routes
Route::name('material_requisition.')->prefix('material_requisition')->group(function() {
    Route::get('/indexApprove', 'MaterialRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-material-requisition');

    Route::get('/approval/{id}/{status}', 'MaterialRequisitionController@approval')->name('approval')->middleware('can:approve-material-requisition');

    Route::get('/', 'MaterialRequisitionController@index')->name('index')->middleware('can:list-material-requisition');

    Route::get('/create', 'MaterialRequisitionController@create')->name('create')->middleware('can:create-material-requisition');

    Route::get('/{id}', 'MaterialRequisitionController@show')->name('show')->middleware('can:show-material-requisition');

    Route::get('/showApprove/{id}', 'MaterialRequisitionController@showApprove')->name('showApprove')->middleware('can:show-material-requisition');

    Route::get('/{id}/edit', 'MaterialRequisitionController@edit')->name('edit')->middleware('can:edit-material-requisition');

    Route::patch('/{id}', 'MaterialRequisitionController@update')->name('update')->middleware('can:edit-material-requisition');

    Route::post('/', 'MaterialRequisitionController@store')->name('store')->middleware('can:create-material-requisition');

    Route::delete('/{id}', 'MaterialRequisitionController@destroy')->name('destroy')->middleware('can:destroy-material-requisition');
});

//Material Requisition Repair Routes
Route::name('material_requisition_repair.')->prefix('material_requisition_repair')->group(function() {
    Route::get('/indexApprove', 'MaterialRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-material-requisition-repair');

    Route::get('/approval/{id}/{status}', 'MaterialRequisitionController@approval')->name('approval')->middleware('can:approve-material-requisition-repair');

    Route::get('/', 'MaterialRequisitionController@index')->name('index')->middleware('can:list-material-requisition-repair');

    Route::get('/create', 'MaterialRequisitionController@create')->name('create')->middleware('can:create-material-requisition-repair');

    Route::get('/{id}', 'MaterialRequisitionController@show')->name('show')->middleware('can:show-material-requisition-repair');

    Route::get('/showApprove/{id}', 'MaterialRequisitionController@showApprove')->name('showApprove')->middleware('can:show-material-requisition-repair');

    Route::get('/{id}/edit', 'MaterialRequisitionController@edit')->name('edit')->middleware('can:edit-material-requisition-repair');

    Route::patch('/{id}', 'MaterialRequisitionController@update')->name('update')->middleware('can:edit-material-requisition-repair');

    Route::post('/', 'MaterialRequisitionController@store')->name('store')->middleware('can:create-material-requisition-repair');

    Route::delete('/{id}', 'MaterialRequisitionController@destroy')->name('destroy')->middleware('can:destroy-material-requisition-repair');
});

// Goods Issue Routes
Route::name('goods_issue.')->prefix('goods_issue')->group(function() {    
    Route::get('/', 'GoodsIssueController@index')->name('index')->middleware('can:list-goods-issue');

    Route::get('/selectMR', 'GoodsIssueController@selectMR')->name('selectMR')->middleware('can:create-goods-issue');
   
    Route::get('/approval/{id}/{status}', 'GoodsIssueController@approval')->name('approval');

    Route::get('/createGiWithRef', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue');

    Route::get('/createGiWithRef/{id}', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue');

    Route::get('/{id}', 'GoodsIssueController@show')->name('show')->middleware('can:show-goods-issue');

    Route::get('/showApproval/{id}', 'GoodsIssueController@showApprove')->name('showApprove')->middleware('can:show-goods-issue');
    
    Route::get('/{id}/edit', 'GoodsIssueController@edit')->name('edit')->middleware('can:edit-goods-issue');

    Route::patch('/{id}', 'GoodsIssueController@update')->name('update')->middleware('can:edit-goods-issue');

    Route::post('/', 'GoodsIssueController@store')->name('store')->middleware('can:create-goods-issue');

    Route::delete('/{id}', 'GoodsIssueController@destroy')->name('destroy')->middleware('can:destroy-goods-issue');
});

// Goods Issue Repair Routes
Route::name('goods_issue_repair.')->prefix('goods_issue_repair')->group(function() {    
    Route::get('/', 'GoodsIssueController@index')->name('index')->middleware('can:list-goods-issue-repair');

    Route::get('/selectMR', 'GoodsIssueController@selectMR')->name('selectMR')->middleware('can:create-goods-issue-repair');
   
    Route::get('/approval/{id}/{status}', 'GoodsIssueController@approval')->name('approval');

    Route::get('/createGiWithRef', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue-repair');

    Route::get('/createGiWithRef/{id}', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue-repair');

    Route::get('/{id}', 'GoodsIssueController@show')->name('show')->middleware('can:show-goods-issue-repair');

    Route::get('/showApproval/{id}', 'GoodsIssueController@showApprove')->name('showApprove')->middleware('can:show-goods-issue-repair');
    
    Route::get('/{id}/edit', 'GoodsIssueController@edit')->name('edit')->middleware('can:edit-goods-issue-repair');

    Route::patch('/{id}', 'GoodsIssueController@update')->name('update')->middleware('can:edit-goods-issue-repair');

    Route::post('/', 'GoodsIssueController@store')->name('store')->middleware('can:create-goods-issue-repair');

    Route::delete('/{id}', 'GoodsIssueController@destroy')->name('destroy')->middleware('can:destroy-goods-issue-repair');
});


//Material Write Off Routes
Route::name('material_write_off.')->prefix('material_write_off')->group(function() {

    Route::get('/create', 'MaterialWriteOffController@create')->name('create')->middleware('can:create-material-write-off');

    Route::post('/', 'MaterialWriteOffController@store')->name('store')->middleware('can:create-material-write-off');
});

//Material Write Off Routes
Route::name('material_write_off_repair.')->prefix('material_write_off_repair')->group(function() {

    Route::get('/create', 'MaterialWriteOffController@create')->name('create')->middleware('can:create-material-write-off-repair');

    Route::post('/', 'MaterialWriteOffController@store')->name('store')->middleware('can:create-material-write-off-repair');
});

//Goods Movement Routes
Route::name('goods_movement.')->prefix('goods_movement')->group(function() {
    Route::get('/', 'GoodsMovementController@index')->name('index')->middleware('can:list-goods-movement');

    Route::get('/create', 'GoodsMovementController@create')->name('create')->middleware('can:create-goods-movement');

    Route::get('/{id}', 'GoodsMovementController@show')->name('show')->middleware('can:view-goods-movement');

    Route::post('/', 'GoodsMovementController@store')->name('store')->middleware('can:create-goods-movement');
});

//Goods Movement Repair Routes
Route::name('goods_movement_repair.')->prefix('goods_movement_repair')->group(function() {
    Route::get('/', 'GoodsMovementController@index')->name('index')->middleware('can:list-goods-movement-repair');

    Route::get('/create', 'GoodsMovementController@create')->name('create')->middleware('can:create-goods-movement-repair');

    Route::get('/{id}', 'GoodsMovementController@show')->name('show')->middleware('can:view-goods-movement-repair');

    Route::post('/', 'GoodsMovementController@store')->name('store')->middleware('can:create-goods-movement-repair');
});

//Production Order Routes
Route::name('production_order.')->prefix('production_order')->group(function() {
    Route::get('/selectProject', 'ProductionOrderController@selectProject')->name('selectProject')->middleware('can:create-production-order');

    Route::get('/selectWBS/{id}', 'ProductionOrderController@selectWBS')->name('selectWBS')->middleware('can:create-production-order');

    Route::get('/create/{id}', 'ProductionOrderController@create')->name('create')->middleware('can:create-production-order');

    Route::post('/', 'ProductionOrderController@store')->name('store')->middleware('can:create-production-order');

    Route::get('/selectProjectRelease', 'ProductionOrderController@selectProjectRelease')->name('selectProjectRelease')->middleware('can:release-production-order');

    Route::get('/selectPrO/{id}', 'ProductionOrderController@selectPrO')->name('selectPrO')->middleware('can:release-production-order');

    Route::get('/release/{id}', 'ProductionOrderController@release')->name('release')->middleware('can:release-production-order');

    Route::patch('/storeRelease', 'ProductionOrderController@storeRelease')->name('storeRelease')->middleware('can:release-production-order');

    Route::get('/selectProjectConfirm', 'ProductionOrderController@selectProjectConfirm')->name('selectProjectConfirm')->middleware('can:confirm-production-order');
    
    Route::get('/confirmPrO/{id}', 'ProductionOrderController@confirmPrO')->name('confirmPrO')->middleware('can:confirm-production-order');

    Route::get('/confirm/{id}', 'ProductionOrderController@confirm')->name('confirm')->middleware('can:confirm-production-order');

    Route::patch('/storeConfirm', 'ProductionOrderController@storeConfirm')->name('storeConfirm')->middleware('can:confirm-production-order');

    Route::get('/', 'ProductionOrderController@index')->name('index')->middleware('can:list-production-order');

    Route::get('/selectProjectReport', 'ProductionOrderController@selectProjectReport')->name('selectProjectReport')->middleware('can:list-production-order');

    Route::get('/showRelease/{id}', 'ProductionOrderController@show')->name('showRelease')->middleware('can:show-production-order');

    Route::get('/report/{id}', 'ProductionOrderController@report')->name('report')->middleware('can:list-production-order');

    Route::get('/selectPrOReport/{id}', 'ProductionOrderController@selectPrOReport')->name('selectPrOReport')->middleware('can:show-production-order');

    Route::get('/{id}', 'ProductionOrderController@show')->name('show')->middleware('can:show-production-order');

    Route::get('/showConfirm/{id}', 'ProductionOrderController@show')->name('showConfirm')->middleware('can:show-production-order');
});

//Production Order Repair Routes
Route::name('production_order_repair.')->prefix('production_order_repair')->group(function() {
    Route::get('/selectProject', 'ProductionOrderController@selectProject')->name('selectProject')->middleware('can:create-production-order-repair');

    Route::get('/selectWBS/{id}', 'ProductionOrderController@selectWBS')->name('selectWBS')->middleware('can:create-production-order-repair');

    Route::get('/create/{id}', 'ProductionOrderController@create')->name('create')->middleware('can:create-production-order-repair');

    Route::post('/', 'ProductionOrderController@store')->name('store')->middleware('can:create-production-order-repair');

    Route::get('/selectProjectRelease', 'ProductionOrderController@selectProjectRelease')->name('selectProjectRelease')->middleware('can:release-production-order-repair');

    Route::get('/selectPrO/{id}', 'ProductionOrderController@selectPrO')->name('selectPrO')->middleware('can:release-production-order-repair');

    Route::get('/release/{id}', 'ProductionOrderController@release')->name('release')->middleware('can:release-production-order-repair');

    Route::patch('/storeRelease', 'ProductionOrderController@storeRelease')->name('storeRelease')->middleware('can:release-production-order-repair');

    Route::get('/selectProjectConfirm', 'ProductionOrderController@selectProjectConfirm')->name('selectProjectConfirm')->middleware('can:confirm-production-order-repair');
    
    Route::get('/confirmPrO/{id}', 'ProductionOrderController@confirmPrO')->name('confirmPrO')->middleware('can:confirm-production-order-repair');

    Route::get('/confirm/{id}', 'ProductionOrderController@confirm')->name('confirm')->middleware('can:confirm-production-order-repair');

    Route::patch('/storeConfirm', 'ProductionOrderController@storeConfirm')->name('storeConfirm')->middleware('can:confirm-production-order-repair');

    Route::get('/', 'ProductionOrderController@index')->name('index')->middleware('can:list-production-order-repair');

    Route::get('/selectProjectReport', 'ProductionOrderController@selectProjectReport')->name('selectProjectReport')->middleware('can:list-production-order-repair');

    Route::get('/showRelease/{id}', 'ProductionOrderController@show')->name('showRelease')->middleware('can:show-production-order-repair');

    Route::get('/report/{id}', 'ProductionOrderController@report')->name('report')->middleware('can:list-production-order-repair');

    Route::get('/selectPrOReport/{id}', 'ProductionOrderController@selectPrOReport')->name('selectPrOReport')->middleware('can:show-production-order-repair');

    Route::get('/{id}', 'ProductionOrderController@show')->name('show')->middleware('can:show-production-order-repair');

    Route::get('/showConfirm/{id}', 'ProductionOrderController@show')->name('showConfirm')->middleware('can:show-production-order-repair');
});

//Yard Plan Routes
Route::name('yard_plan.')->prefix('yard_plan')->group(function() {
    Route::get('/create', 'YardPlanController@create')->name('create');

    Route::get('/', 'YardPlanController@index')->name('index');

    Route::get('/{id}', 'YardPlanController@show')->name('show');

    Route::get('/{id}/edit', 'YardPlanController@edit')->name('edit');

    Route::patch('/{id}', 'YardPlanController@update')->name('update');

    Route::patch('/confirmActual/{id}', 'YardPlanController@confirmActual')->name('confirmActual');

    Route::post('/', 'YardPlanController@store')->name('store');

    Route::delete('/{id}', 'YardPlanController@destroy')->name('destroy');
});