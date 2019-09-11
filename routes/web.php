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

// Approval Routes
Route::name('approval.')->prefix('approval')->group(function() {
    Route::get('/', 'ConfigurationController@approvalIndex')->name('index');

    Route::put('/', 'ConfigurationController@approvalSave')->name('save');
});

// Cost Type Routes
Route::name('cost_type.')->prefix('cost_type')->group(function() {
    Route::get('/', 'ConfigurationController@costTypeIndex')->name('index');

    Route::post('/', 'ConfigurationController@acostTypeSave')->name('save');
});

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

// Material Family Routes
Route::name('material_family.')->prefix('material_family')->group(function() {
    Route::get('/', 'ConfigurationController@materialFamilyIndex')->name('index');

    Route::put('/add', 'ConfigurationController@materialFamilyAdd')->name('add');
});

// Density Routes
Route::name('density.')->prefix('density')->group(function() {
    Route::get('/', 'ConfigurationController@densityIndex')->name('index');

    Route::put('/add', 'ConfigurationController@densityAdd')->name('add');
});

// Payment Terms Routes
Route::name('payment_terms.')->prefix('payment_terms')->group(function() {
    Route::get('/', 'ConfigurationController@paymentTermsIndex')->name('index');

    Route::put('/add', 'ConfigurationController@paymentTermsAdd')->name('add');
});

// Delivery Terms Routes
Route::name('delivery_terms.')->prefix('delivery_terms')->group(function() {
    Route::get('/', 'ConfigurationController@deliveryTermsIndex')->name('index');

    Route::put('/add', 'ConfigurationController@deliveryTermsAdd')->name('add');
});

// Weather Routes
Route::name('weather.')->prefix('weather')->group(function() {
    Route::get('/', 'ConfigurationController@weatherIndex')->name('index');

    Route::put('/add', 'ConfigurationController@weatherAdd')->name('add');
});

// Tidal Routes
Route::name('tidal.')->prefix('tidal')->group(function() {
    Route::get('/', 'ConfigurationController@tidalIndex')->name('index');

    Route::put('/add', 'ConfigurationController@tidalAdd')->name('add');
});

// Dimension Type Routes
Route::name('dimension_type.')->prefix('dimension_type')->group(function() {
    Route::get('/', 'ConfigurationController@dimensionTypeIndex')->name('index');

    Route::put('/add', 'ConfigurationController@dimensionTypeAdd')->name('add');
});

// Daily Weather Routes
Route::name('daily_weather.')->prefix('daily_weather')->group(function() {
    Route::get('/', 'WeatherController@index')->name('index');

    Route::put('/store', 'WeatherController@store')->name('store');

    Route::put('/update', 'WeatherController@update')->name('update');

    Route::delete('/delete/{id}', 'WeatherController@destroy')->name('delete');
});

// Tidal Routes
Route::name('daily_tidal.')->prefix('daily_tidal')->group(function() {
    Route::get('/', 'TidalController@index')->name('index');

    Route::put('/store', 'TidalController@store')->name('store');

    Route::put('/update', 'TidalController@update')->name('update');

    Route::delete('/delete/{id}', 'TidalController@destroy')->name('delete');
});

// General PICA Routes
Route::name('pica.')->prefix('pica')->group(function() {
    Route::get('/create', 'PicaController@create')->name('create')->middleware('can:create-pica');

    Route::get('/', 'PicaController@index')->name('index')->middleware('can:list-pica');

    Route::get('/{id}', 'PicaController@show')->name('show')->middleware('can:show-pica');

    Route::get('/selectDocument/{type}', 'PicaController@selectDocument')->name('selectDocument')->middleware('can:create-pica');

    Route::get('/{id}/edit', 'PicaController@edit')->name('edit')->middleware('can:edit-pica');

    Route::put('/store', 'PicaController@store')->name('store')->middleware('can:create-pica');

    Route::put('/update', 'PicaController@update')->name('update')->middleware('can:edit-pica');

    Route::delete('/delete/{id}', 'PicaController@destroy')->name('delete')->middleware('can:delete-pica');
});

// Daily Man Hour Routes
Route::name('daily_man_hour.')->prefix('daily_man_hour')->group(function() {
    Route::get('/selectProject', 'DailyManHourController@selectProject')->name('selectProject');

    Route::get('/create/{id}', 'DailyManHourController@create')->name('create');

    Route::put('/store', 'DailyManHourController@store')->name('store');

    Route::put('/update', 'DailyManHourController@update')->name('update');

    Route::delete('/delete/{id}', 'DailyManHourController@destroy')->name('delete');
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

    Route::patch('/updateCreditLimit/{id}', 'CustomerController@updateCreditLimit')->name('updateCreditLimit')->middleware('can:edit-customer');

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
    Route::get('/resourceSchedule', 'ResourceController@resourceSchedule')->name('resourceSchedule')->middleware('can:resource-schedule');

    Route::put('/updateDetail', 'ResourceController@updateDetail')->name('updateDetail')->middleware('can:show-resource');

    Route::get('/assignResource', 'ResourceController@assignResource')->name('assignResource')->middleware('can:list-resource');

    Route::get('/selectPO', 'ResourceController@selectPO')->name('selectPO')->middleware('can:create-receive-resource');

    Route::get('/createGR/{id}', 'ResourceController@createGR')->name('createGR')->middleware('can:create-receive-resource');

    Route::get('/createInternal/{id}', 'ResourceController@createInternal')->name('createInternal')->middleware('can:create-resource');

    Route::post('/storeGR', 'ResourceController@storeGR')->name('storeGR')->middleware('can:create-receive-resource');

    Route::get('/showGR/{id}', 'ResourceController@showGR')->name('showGR')->middleware('can:show-receive-resource');

    Route::get('/showGI/{id}', 'ResourceController@showGI')->name('showGI')->middleware('can:show-issue-resource');

    Route::get('/indexReceived', 'ResourceController@indexReceived')->name('indexReceived')->middleware('can:list-receive-resource');

    Route::get('/indexIssued', 'ResourceController@indexIssued')->name('indexIssued')->middleware('can:list-issue-resource');

    Route::get('/issueResource', 'ResourceController@issueResource')->name('issueResource')->middleware('can:create-issue-resource');

    Route::get('/create', 'ResourceController@create')->name('create')->middleware('can:create-resource');

    Route::get('/', 'ResourceController@index')->name('index')->middleware('can:list-resource');

    Route::get('/{id}', 'ResourceController@show')->name('show')->middleware('can:show-resource');

    Route::get('/{id}/edit', 'ResourceController@edit')->name('edit')->middleware('can:edit-resource');

    Route::patch('/{id}', 'ResourceController@update')->name('update')->middleware('can:edit-resource');

    Route::post('/', 'ResourceController@store')->name('store')->middleware('can:create-resource');

    Route::post('/storeIssue', 'ResourceController@storeIssue')->name('storeIssue')->middleware('can:create-issue-resource');

    Route::post('/storeInternal', 'ResourceController@storeInternal')->name('storeInternal')->middleware('can:create-resource');

    Route::post('/storeAssignResource', 'ResourceController@storeAssignResource')->name('storeAssignResource')->middleware('can:create-resource');

    Route::put('updateAssignResource/{id}', 'ResourceController@updateAssignResource')->name('updateAssignResource')->middleware('can:edit-resource');

    Route::delete('/deleteAssignedResource/{id}', 'ResourceController@destroyAssignedResource')->name('deleteAssignedResource')->middleware('can:edit-resource');
});

//Resource Management Routes
Route::name('resource_repair.')->prefix('resource_repair')->group(function() {
    Route::get('/resourceSchedule', 'ResourceController@resourceSchedule')->name('resourceSchedule')->middleware('can:resource-schedule-repair');

    Route::put('/updateDetail', 'ResourceController@updateDetail')->name('updateDetail')->middleware('can:show-resource');

    Route::get('/assignResource', 'ResourceController@assignResource')->name('assignResource')->middleware('can:list-resource-repair');

    Route::get('/selectPO', 'ResourceController@selectPO')->name('selectPO')->middleware('can:create-receive-resource-repair');

    Route::get('/createGR/{id}', 'ResourceController@createGR')->name('createGR')->middleware('can:create-receive-resource-repair');

    Route::get('/createInternal/{id}', 'ResourceController@createInternal')->name('createInternal')->middleware('can:create-resource-repair');

    Route::post('/storeGR', 'ResourceController@storeGR')->name('storeGR')->middleware('can:create-receive-resource-repair');

    Route::get('/showGR/{id}', 'ResourceController@showGR')->name('showGR')->middleware('can:show-receive-resource-repair');

    Route::get('/showGI/{id}', 'ResourceController@showGI')->name('showGI')->middleware('can:show-issue-resource-repair');

    Route::get('/indexReceived', 'ResourceController@indexReceived')->name('indexReceived')->middleware('can:list-receive-resource-repair');

    Route::get('/indexIssued', 'ResourceController@indexIssued')->name('indexIssued')->middleware('can:list-issue-resource-repair');

    Route::get('/issueResource', 'ResourceController@issueResource')->name('issueResource')->middleware('can:create-issue-resource-repair');

    Route::get('/create', 'ResourceController@create')->name('create')->middleware('can:create-resource-repair');

    Route::get('/', 'ResourceController@index')->name('index')->middleware('can:list-resource-repair');

    Route::get('/{id}', 'ResourceController@show')->name('show')->middleware('can:show-resource-repair');

    Route::get('/{id}/edit', 'ResourceController@edit')->name('edit')->middleware('can:edit-resource-repair');

    Route::patch('/{id}', 'ResourceController@update')->name('update')->middleware('can:edit-resource-repair');

    Route::post('/', 'ResourceController@store')->name('store')->middleware('can:create-resource-repair');

    Route::post('/storeIssue', 'ResourceController@storeIssue')->name('storeIssue')->middleware('can:create-resource-repair');

    Route::post('/storeInternal', 'ResourceController@storeInternal')->name('storeInternal')->middleware('can:create-resource-repair');

    Route::post('/storeAssignResource', 'ResourceController@storeAssignResource')->name('storeAssignResource')->middleware('can:create-resource-repair');

    Route::put('updateAssignResource/{id}', 'ResourceController@updateAssignResource')->name('updateAssignResource')->middleware('can:edit-resource-repair');

    Route::delete('/deleteAssignedResource/{id}', 'ResourceController@destroyAssignedResource')->name('deleteAssignedResource')->middleware('can:edit-resource');
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

    Route::patch('/{id}', 'ServiceController@update')->name('update')->middleware('can:edit-service');

    Route::get('/{id}/edit', 'ServiceController@edit')->name('edit')->middleware('can:edit-service');

    Route::get('/createServiceDetail/{id}', 'ServiceController@createServiceDetail')->name('createServiceDetail')->middleware('can:create-service');

    Route::post('/storeServiceDetail', 'ServiceController@storeServiceDetail')->name('storeServiceDetail')->middleware('can:create-service');

    Route::put('/updateDetail', 'ServiceController@updateDetail')->name('updateDetail')->middleware('can:show-service');

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
    Route::put('/confirmBom', 'BOMController@confirm')->name('confirmBom')->middleware('can:confirm-bom');

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

    Route::delete('/deleteMaterial/{id}', 'BOMController@deleteMaterial')->name('deleteMaterial')->middleware('can:edit-bom');
});

//BOM Repair Routes
Route::name('bom_repair.')->prefix('bom_repair')->group(function() {

    Route::get('/selectProjectSum', 'BOMController@selectProjectSum')->name('selectProjectSum')->middleware('can:create-bom-repair');

    Route::get('/materialSummary/{id}', 'BOMController@materialSummary')->name('materialSummary')->middleware('can:create-bom-repair');

    Route::post('/storeBom', 'BOMController@storeBomRepair')->name('storeBomRepair')->middleware('can:create-bom-repair');

    Route::put('/confirmBom', 'BOMController@confirm')->name('confirmBom')->middleware('can:confirm-bom-repair');

    Route::put('/', 'BOMController@update')->name('update')->middleware('can:edit-bom-repair');

    Route::get('/create/{id}', 'BOMController@create')->name('create')->middleware('can:create-bom-repair');

    Route::get('/indexProject', 'BOMController@indexProject')->name('indexProject')->middleware('can:create-bom-repair');

    Route::get('/selectProject', 'BOMController@selectProject')->name('selectProject')->middleware('can:create-bom-repair');

    Route::get('/selectWBS/{id}', 'BOMController@selectWBS')->name('selectWBS')->middleware('can:list-bom-repair');

    Route::get('/indexBom/{id}', 'BOMController@indexBom')->name('indexBom')->middleware('can:list-bom-repair');

    Route::get('/{id}', 'BOMController@showRepair')->name('show')->middleware('can:show-bom-repair');

    Route::get('/{id}/edit', 'BOMController@edit')->name('edit')->middleware('can:edit-bom-repair');

    Route::put('/updateDesc', 'BOMController@updateDesc')->name('updateDesc')->middleware('can:edit-bom-repair');

    Route::post('/', 'BOMController@store')->name('store')->middleware('can:create-bom-repair');

    Route::delete('/deleteMaterial/{id}', 'BOMController@deleteMaterial')->name('deleteMaterial')->middleware('can:edit-bom-repair');
});

//Project Routes
Route::name('project.')->prefix('project')->group(function() {
    // Project Cost Evaluation
    Route::get('/projectCE/{id}', 'ProjectController@projectCE')->name('projectCE')->middleware('can:show-project');

    //GanttChart
    Route::get('/ganttChart/{id}', 'ProjectController@showGanttChart')->name('showGanttChart')->middleware('can:show-project');

    //Project
    Route::get('/create', 'ProjectController@create')->name('create')->middleware('can:create-project');

    Route::get('/indexCopyProject', 'ProjectController@indexCopyProject')->name('indexCopyProject')->middleware('can:create-project');

    Route::get('/copyProject/{id}', 'ProjectController@copyProject')->name('copyProject')->middleware('can:create-project');

    Route::post('/storeCopyProject', 'ProjectController@storeCopyProject')->name('storeCopyProject')->middleware('can:create-project');

    Route::get('/copyProjectStructure/{old_id}/{new_id}', 'ProjectController@copyProjectStructure')->name('copyProjectStructure')->middleware('can:create-project');

    Route::post('/storeCopyProjectStructure', 'ProjectController@storeCopyProjectStructure')->name('storeCopyProjectStructure')->middleware('can:create-project');

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

    Route::get('/indexCopyProject', 'ProjectController@indexCopyProject')->name('indexCopyProject')->middleware('can:create-project-repair');

    Route::get('/copyProject/{id}', 'ProjectController@copyProject')->name('copyProject')->middleware('can:create-project-repair');

    Route::post('/storeCopyProject', 'ProjectController@storeCopyProject')->name('storeCopyProject')->middleware('can:create-project-repair');

    Route::get('/copyProjectStructure/{old_id}/{new_id}', 'ProjectController@copyProjectStructure')->name('copyProjectStructure')->middleware('can:create-project-repair');

    Route::get('/selectStructure/{project_standard_id}/{project_id}', 'ProjectController@selectStructure')->name('selectStructure')->middleware('can:create-project-repair');

    Route::post('/storeCopyProjectStructure', 'ProjectController@storeCopyProjectStructure')->name('storeCopyProjectStructure')->middleware('can:create-project-repair');

    Route::post('/storeSelectedStructure', 'ProjectController@storeSelectedStructure')->name('storeSelectedStructure')->middleware('can:create-project-repair');

    Route::get('/', 'ProjectController@index')->name('index')->middleware('can:list-project-repair');

    Route::get('/{id}', 'ProjectController@show')->name('show')->middleware('can:show-project-repair');

    Route::get('/{id}/edit', 'ProjectController@edit')->name('edit')->middleware('can:edit-project-repair');

    Route::patch('/{id}', 'ProjectController@update')->name('update')->middleware('can:edit-project-repair');

    Route::post('/', 'ProjectController@storeGeneralInfo')->name('storeGeneralInfo')->middleware('can:create-project-repair');

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

    Route::post('/adoptWbs', 'WBSController@adoptWbs')->name('adoptWbs')->middleware('can:create-project');

    Route::put('update/{id}', 'WBSController@update')->name('update')->middleware('can:edit-project');

    Route::patch('updateWithForm/{id}', 'WBSController@updateWithForm')->name('updateWithForm')->middleware('can:edit-project');

    Route::get('/createSubWBS/{project_id}/{wbs_id}', 'WBSController@createSubWBS')->name('createSubWBS')->middleware('can:create-project');

    Route::get('/show/{id}', 'WBSController@show')->name('show')->middleware('can:show-project');

    Route::delete('/deleteWbs/{id}', 'WBSController@destroyWbs')->name('destroyWbs');

    Route::delete('/deleteWbsImage/{id}','WBSController@destroyWbsImage')->name('destroyWbsImage');

    // WBS Profile
    Route::get('/createWbsProfile', 'WBSController@createWbsProfile')->name('createWbsProfile')->middleware('can:manage-wbs-profile');

    Route::get('/createSubWbsProfile/{id}', 'WBSController@createSubWbsProfile')->name('createSubWbsProfile')->middleware('can:manage-wbs-profile');

    Route::get('/manageWbsImages', 'WBSController@manageWbsImages')->name('manageWbsImages');

    Route::post('/storeWbsProfile', 'WBSController@storeWbsProfile')->name('storeWbsProfile')->middleware('can:manage-wbs-profile');

    Route::put('updateWbsProfile/{id}', 'WBSController@updateWbsProfile')->name('updateWbsProfile')->middleware('can:manage-wbs-profile');

    Route::delete('/{id}', 'WBSController@destroyWbsProfile')->name('destroyWbsProfile')->middleware('can:manage-wbs-profile');

    // BOM Profile
    Route::get('/createBomProfile/{id}', 'WBSController@createBomProfile')->name('createBomProfile')->middleware('can:manage-bom-profile');

    Route::post('/storeBomProfile', 'WBSController@storeBomProfile')->name('storeBomProfile')->middleware('can:manage-bom-profile');

    Route::put('/updateBomProfile', 'WBSController@updateBomProfile')->name('updateBomProfile')->middleware('can:manage-bom-profile');

    Route::delete('/deleteBomProfile/{id}', 'WBSController@destroyBomProfile')->name('destroyBomProfile')->middleware('can:manage-bom-profile');

    // Resource Profile
    Route::get('/createResourceProfile/{id}', 'WBSController@createResourceProfile')->name('createResourceProfile')->middleware('can:manage-resource-profile');

    Route::post('/storeResourceProfile', 'WBSController@storeResourceProfile')->name('storeResourceProfile')->middleware('can:manage-resource-profile');

    Route::put('/updateResourceProfile', 'WBSController@updateResourceProfile')->name('updateResourceProfile')->middleware('can:manage-resource-profile');

    Route::delete('/deleteResourceProfile/{id}', 'WBSController@destroyResourceProfile')->name('destroyResourceProfile')->middleware('can:manage-resource-profile');
});

// WBS Repair Routes
Route::name('wbs_repair.')->prefix('wbs_repair')->group(function() {
    // WBS & Estimator Configuration
    Route::get('/selectProjectConfig', 'WBSController@selectProjectConfig')->name('selectProjectConfig')->middleware('can:create-project-repair');

    Route::get('/configWbsEstimator/{id}', 'WBSController@configWbsEstimator')->name('configWbsEstimator')->middleware('can:create-project-repair');

    //WBS
    Route::get('/listWBS/{id}/{menu}', 'WBSController@listWBS')->name('listWBS')->middleware('can:show-project-repair');

    Route::get('/createWBS/{id}', 'WBSController@createWbsRepair')->name('createWBS')->middleware('can:create-project-repair');

    Route::post('/store', 'WBSController@storeWbsRepair')->name('store')->middleware('can:create-project-repair');

    Route::post('/adoptWbs', 'WBSController@adoptWbs')->name('adoptWbs')->middleware('can:create-project-repair');

    Route::put('update/{id}', 'WBSController@updateWbsRepair')->name('update')->middleware('can:edit-project-repair');

    Route::patch('updateWithForm/{id}', 'WBSController@updateWithForm')->name('updateWithForm')->middleware('can:edit-project-repair');

    Route::get('/createSubWBS/{project_id}/{wbs_id}', 'WBSController@createSubWbsRepair')->name('createSubWBS')->middleware('can:create-project-repair');

    Route::get('/show/{id}', 'WBSController@show')->name('show')->middleware('can:show-project-repair');

    Route::delete('/deleteWbs/{id}', 'WBSController@destroyWbs')->name('destroyWbs');

    Route::delete('/deleteWbsImage/{id}','WBSController@destroyWbsImage')->name('destroyWbsImage');

    // WBS Profile
    Route::get('/createWbsProfile', 'WBSController@createWbsProfile')->name('createWbsProfile')->middleware('can:manage-wbs-profile-repair');

    Route::get('/createSubWbsProfile/{id}', 'WBSController@createSubWbsProfile')->name('createSubWbsProfile')->middleware('can:manage-wbs-profile-repair');

    Route::post('/storeWbsProfile', 'WBSController@storeWbsProfile')->name('storeWbsProfile')->middleware('can:manage-wbs-profile-repair');

    Route::put('updateWbsProfile/{id}', 'WBSController@updateWbsProfile')->name('updateWbsProfile')->middleware('can:manage-wbs-profile-repair');

    Route::delete('/{id}', 'WBSController@destroyWbsProfile')->name('destroyWbsProfile')->middleware('can:manage-wbs-profile-repair');

    // BOM Profile
    Route::get('/createBomProfile/{id}', 'WBSController@createBomProfile')->name('createBomProfile')->middleware('can:manage-bom-profile-repair');

    Route::post('/storeBomProfile', 'WBSController@storeBomProfile')->name('storeBomProfile')->middleware('can:manage-bom-profile-repair');

    Route::put('/updateBomProfile', 'WBSController@updateBomProfile')->name('updateBomProfile')->middleware('can:manage-bom-profile-repair');

    Route::delete('/deleteBomProfile/{id}', 'WBSController@destroyBomProfile')->name('destroyBomProfile')->middleware('can:manage-bom-profile-repair');

    // Resource Profile
    Route::get('/createResourceProfile/{id}', 'WBSController@createResourceProfile')->name('createResourceProfile')->middleware('can:manage-resource-profile-repair');

    Route::post('/storeResourceProfile', 'WBSController@storeResourceProfile')->name('storeResourceProfile')->middleware('can:manage-resource-profile-repair');

    Route::put('/updateResourceProfile', 'WBSController@updateResourceProfile')->name('updateResourceProfile')->middleware('can:manage-resource-profile-repair');

    Route::delete('/deleteResourceProfile/{id}', 'WBSController@destroyResourceProfile')->name('destroyResourceProfile')->middleware('can:manage-resource-profile-repair');
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

    Route::get('/createActivityProfile/{id}', 'ActivityController@createActivityProfile')->name('createActivityProfile')->middleware('can:create-project');

    Route::put('update/{id}', 'ActivityController@update')->name('update')->middleware('can:edit-project');

    Route::post('/store', 'ActivityController@store')->name('store')->middleware('can:create-project');

    Route::post('/storeActivityProfile', 'ActivityController@storeActivityProfile')->name('storeActivityProfile')->middleware('can:create-project');

    Route::put('updateActivityProfile/{id}', 'ActivityController@updateActivityProfile')->name('updateActivityProfile')->middleware('can:edit-project');

    Route::get('/index/{id}', 'ActivityController@index')->name('index')->middleware('can:show-project');

    Route::get('/show/{id}', 'ActivityController@show')->name('show')->middleware('can:show-project');

    Route::delete('/{id}', 'ActivityController@destroyActivityProfile')->name('destroyActivityProfile');

    Route::delete('/deleteActivity/{id}', 'ActivityController@destroyActivity')->name('destroyActivity');

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

    Route::delete('/deleteActivity/{id}', 'ActivityController@destroyActivity')->name('destroyActivity');

    //Activity Profile
    Route::get('/createActivityProfile/{id}', 'ActivityController@createActivityProfile')->name('createActivityProfile')->middleware('can:create-project-repair');

    Route::post('/storeActivityProfile', 'ActivityController@storeActivityProfile')->name('storeActivityProfile')->middleware('can:create-project-repair');

    Route::put('updateActivityProfile/{id}', 'ActivityController@updateActivityProfile')->name('updateActivityProfile')->middleware('can:edit-project-repair');

    Route::delete('/{id}', 'ActivityController@destroyActivityProfile')->name('destroyActivityProfile');

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

    //===============start approval project plan cost
    Route::get('/selectProjectPlanOtherCost', 'RAPController@selectProjectPlanOtherCost')->name('selectProjectPlanOtherCost')->middleware('can:create-actual-other-cost');

    Route::get('/inputApprovalProjectPlanOtherCost/{id}', 'RAPController@inputApprovalProjectPlanOtherCost')->name('inputApprovalProjectPlanOtherCost');

    Route::put('/updateApprovalProjectPlanOtherCost', 'RAPController@updateApprovalProjectPlanOtherCost')->name('updateApprovalProjectPlanOtherCost');

    Route::get('/getCostsPlanned/{id}', 'RAPController@getCostsPlanned')->name('getCostsPlanned');

    Route::get('/getCostsApproved/{id}', 'RAPController@getCostsApproved')->name('getCostsApproved');
    // /rap/getCostsPlanned/
    //===============end approval project plan cost

    Route::post('/storeCost', 'RAPController@storeCost')->name('storeCost');

    Route::put('updateCost/{id}', 'RAPController@updateCost')->name('updateCost');

    Route::put('/storeActualCost', 'RAPController@storeActualCost')->name('storeActualCost');

    Route::get('/getCosts/{id}', 'RAPController@getCosts')->name('getCosts');

    Route::get('/{id}', 'RAPController@show')->name('show')->middleware('can:show-rap');

    Route::get('/{id}/edit', 'RAPController@edit')->name('edit')->middleware('can:edit-rap');

    Route::patch('/{id}', 'RAPController@update')->name('update')->middleware('can:edit-rap');

    Route::delete('/deleteOtherCost/{id}','RAPController@deleteOtherCost')->name('deleteOtherCost')->middleware('can:edit-rap');
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

    Route::get('/showMaterialEvaluation/{id}', 'RAPController@showMaterialEvaluationRepair')->name('showMaterialEvaluation')->middleware('can:view-remaining-material-repair');

    Route::get('/createCost/{id}', 'RAPController@createCost')->name('createCost')->middleware('can:create-other-cost-repair');

    Route::get('/viewPlannedCost/{id}', 'RAPController@viewPlannedCostRepair')->name('viewPlannedCost')->middleware('can:view-planned-cost-repair');

    Route::get('/inputActualOtherCost/{id}', 'RAPController@inputActualOtherCost')->name('inputActualOtherCost')->middleware('can:create-actual-other-cost-repair');

    Route::patch('updateCost/{id}', 'RAPController@updateCost')->name('updateCost');

    Route::patch('/storeActualCost', 'RAPController@storeActualCost')->name('storeActualCost');

    Route::get('/{id}', 'RAPController@show')->name('show')->middleware('can:show-rap-repair');

    Route::get('/{id}/edit', 'RAPController@edit')->name('edit')->middleware('can:edit-rap-repair');

    Route::patch('/{id}', 'RAPController@update')->name('update')->middleware('can:edit-rap-repair');

    Route::delete('/deleteOtherCost/{id}','RAPController@deleteOtherCost')->name('deleteOtherCost')->middleware('can:edit-rap-repair');
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

    Route::get('/print/{id}', 'WorkRequestController@printPdf')->name('print')->middleware('can:show-work-request');
});

//Work Request Repair Routes
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

    Route::get('/print/{id}', 'WorkRequestController@printPdf')->name('print')->middleware('can:show-work-request-repair');
});

//Purchase Requisition Routes
Route::name('purchase_requisition.')->prefix('purchase_requisition')->group(function() {
    Route::get('/cancel/{id}', 'PurchaseRequisitionController@cancel')->name('cancel')->middleware('can:cancel-purchase-requisition');

    Route::get('/cancelApproval/{id}', 'PurchaseRequisitionController@cancelApproval')->name('cancelApproval')->middleware('can:cancel-approval-purchase-requisition');

    Route::post('/storeConsolidation', 'PurchaseRequisitionController@storeConsolidation')->name('storeConsolidation')->middleware('can:consolidation-purchase-requisition');

    Route::patch('/{id}', 'PurchaseRequisitionController@update')->name('update')->middleware('can:edit-purchase-requisition');

    Route::get('/indexApprove', 'PurchaseRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-requisition');

    Route::get('/indexConsolidation', 'PurchaseRequisitionController@indexConsolidation')->name('indexConsolidation')->middleware('can:consolidation-purchase-requisition');

    Route::get('/approval', 'PurchaseRequisitionController@approval')->name('approval')->middleware('can:approve-purchase-requisition');

    Route::delete('/{id}', 'PurchaseRequisitionController@destroy')->name('destroy')->middleware('can:edit-purchase-requisition');

    Route::delete('/', 'PurchaseRequisitionController@destroyPRD')->name('destroyPRD')->middleware('can:consolidation-purchase-requisition');

    Route::get('/', 'PurchaseRequisitionController@index')->name('index')->middleware('can:list-purchase-requisition');

    Route::get('/create', 'PurchaseRequisitionController@create')->name('create')->middleware('can:create-purchase-requisition');

    Route::get('/{id}', 'PurchaseRequisitionController@show')->name('show')->middleware('can:show-purchase-requisition');

    Route::get('showViaNotification/{id}', 'PurchaseRequisitionController@showViaNotification')->name('showViaNotification')->middleware('can:show-purchase-requisition');

    Route::get('/showApprove/{id}', 'PurchaseRequisitionController@showApprove')->name('showApprove')->middleware('can:approve-purchase-requisition');

    Route::get('/edit/{id}', 'PurchaseRequisitionController@edit')->name('edit')->middleware('can:edit-purchase-requisition');

    Route::post('/', 'PurchaseRequisitionController@store')->name('store')->middleware('can:create-purchase-requisition');

    Route::get('/print/{id}', 'PurchaseRequisitionController@printPdf')->name('print')->middleware('can:show-purchase-requisition');
});

//Purchase Requisition Repair Routes
Route::name('purchase_requisition_repair.')->prefix('purchase_requisition_repair')->group(function() {
    Route::get('/cancel/{id}', 'PurchaseRequisitionController@cancel')->name('cancel')->middleware('can:cancel-purchase-requisition-repair');

    Route::get('/cancelApproval/{id}', 'PurchaseRequisitionController@cancelApproval')->name('cancelApproval')->middleware('can:cancel-approval-purchase-requisition-repair');

    Route::post('/storeConsolidation', 'PurchaseRequisitionController@storeConsolidation')->name('storeConsolidation')->middleware('can:consolidation-purchase-requisition-repair');

    Route::patch('/{id}', 'PurchaseRequisitionController@update')->name('update')->middleware('can:edit-purchase-requisition-repair');

    Route::get('/indexApprove', 'PurchaseRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-requisition-repair');

    Route::get('/indexConsolidation', 'PurchaseRequisitionController@indexConsolidation')->name('indexConsolidation')->middleware('can:consolidation-purchase-requisition-repair');

    Route::get('/approval', 'PurchaseRequisitionController@approval')->name('approval')->middleware('can:approve-purchase-requisition-repair');

    Route::delete('/{id}', 'PurchaseRequisitionController@destroy')->name('destroy')->middleware('can:edit-purchase-requisition-repair');

    Route::delete('/', 'PurchaseRequisitionController@destroyPRD')->name('destroyPRD')->middleware('can:consolidation-purchase-requisition-repair');

    Route::get('/', 'PurchaseRequisitionController@index')->name('index')->middleware('can:list-purchase-requisition-repair');

    Route::get('/create', 'PurchaseRequisitionController@create')->name('create')->middleware('can:create-purchase-requisition-repair');

    Route::get('/{id}', 'PurchaseRequisitionController@show')->name('show')->middleware('can:show-purchase-requisition-repair');

    Route::get('showViaNotification/{id}', 'PurchaseRequisitionController@showViaNotification')->name('showViaNotification')->middleware('can:show-purchase-requisition');

    Route::get('/showApprove/{id}', 'PurchaseRequisitionController@showApprove')->name('showApprove')->middleware('can:approve-purchase-requisition-repair');

    Route::get('/edit/{id}', 'PurchaseRequisitionController@edit')->name('edit')->middleware('can:edit-purchase-requisition-repair');

    Route::post('/', 'PurchaseRequisitionController@store')->name('store')->middleware('can:create-purchase-requisition-repair');

    Route::get('/print/{id}', 'PurchaseRequisitionController@printPdf')->name('print')->middleware('can:show-purchase-requisition-repair');
});

//Purchase Order Routes
Route::name('purchase_order.')->prefix('purchase_order')->group(function() {
    Route::get('/cancel/{id}', 'PurchaseOrderController@cancel')->name('cancel')->middleware('can:cancel-purchase-order');

    Route::get('/cancelApproval/{id}', 'PurchaseOrderController@cancelApproval')->name('cancelApproval')->middleware('can:cancel-approval-purchase-order');

    Route::get('/indexApprove', 'PurchaseOrderController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-order');

    Route::get('/approval', 'PurchaseOrderController@approval')->name('approval')->middleware('can:approve-purchase-order');

    Route::get('/selectPR', 'PurchaseOrderController@selectPR')->name('selectPR')->middleware('can:create-purchase-order');

    Route::get('/', 'PurchaseOrderController@index')->name('index')->middleware('can:list-purchase-order');

    Route::get('/create', 'PurchaseOrderController@create')->name('create')->middleware('can:create-purchase-order');

    Route::get('/selectPRD/{id}', 'PurchaseOrderController@selectPRD')->name('selectPRD')->middleware('can:create-purchase-order');

    Route::get('/{id}', 'PurchaseOrderController@show')->name('show')->middleware('can:show-purchase-order');

    Route::get('/showApprove/{id}', 'PurchaseOrderController@showApprove')->name('showApprove')->middleware('can:approve-purchase-order');

    Route::get('/{id}/edit', 'PurchaseOrderController@edit')->name('edit')->middleware('can:edit-purchase-order');

    Route::patch('/', 'PurchaseOrderController@update')->name('update')->middleware('can:edit-purchase-order');

    Route::post('/', 'PurchaseOrderController@store')->name('store')->middleware('can:create-purchase-order');

    Route::get('/print/{id}', 'PurchaseOrderController@printPdf')->name('print')->middleware('can:show-purchase-order');
});

//Purchase Order Repair Routes
Route::name('purchase_order_repair.')->prefix('purchase_order_repair')->group(function() {
    Route::get('/cancel/{id}', 'PurchaseOrderController@cancel')->name('cancel')->middleware('can:cancel-purchase-order-repair');

    Route::get('/cancelApproval/{id}', 'PurchaseOrderController@cancelApproval')->name('cancelApproval')->middleware('can:cancel-approval-purchase-order-repair');

    Route::get('/indexApprove', 'PurchaseOrderController@indexApprove')->name('indexApprove')->middleware('can:approve-purchase-order-repair');

    Route::get('/approval', 'PurchaseOrderController@approval')->name('approval')->middleware('can:approve-purchase-order-repair');

    Route::get('/selectPR', 'PurchaseOrderController@selectPR')->name('selectPR')->middleware('can:create-purchase-order-repair');

    Route::get('/', 'PurchaseOrderController@index')->name('index')->middleware('can:list-purchase-order-repair');

    Route::get('/create', 'PurchaseOrderController@create')->name('create')->middleware('can:create-purchase-order-repair');

    Route::get('/selectPRD/{id}', 'PurchaseOrderController@selectPRD')->name('selectPRD')->middleware('can:create-purchase-order-repair');

    Route::get('/{id}', 'PurchaseOrderController@show')->name('show')->middleware('can:show-purchase-order-repair');

    Route::get('/showApprove/{id}', 'PurchaseOrderController@showApprove')->name('showApprove')->middleware('can:approve-purchase-order-repair');

    Route::get('/{id}/edit', 'PurchaseOrderController@edit')->name('edit')->middleware('can:edit-purchase-order-repair');

    Route::patch('/', 'PurchaseOrderController@update')->name('update')->middleware('can:edit-purchase-order-repair');

    Route::post('/', 'PurchaseOrderController@store')->name('store')->middleware('can:create-purchase-order-repair');

    Route::get('/print/{id}', 'PurchaseOrderController@printPdf')->name('print')->middleware('can:show-purchase-order-repair');

    Route::get('/printJobOrder/{id}', 'PurchaseOrderController@printPdfJobOrder')->name('printJobOrder')->middleware('can:show-purchase-order-repair');
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

    Route::get('/print/{id}', 'WorkOrderController@printPdf')->name('print')->middleware('can:show-work-order');

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

    Route::get('/print/{id}', 'WorkOrderController@printPdf')->name('print')->middleware('can:show-work-order-repair');
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

    Route::get('/print/{id}', 'PhysicalInventoryController@printPdf')->name('print')->middleware('can:show-snapshot');

    Route::get('/exportToExcel/{id}', 'PhysicalInventoryController@exportToExcel')->name('exportToExcel')->middleware('can:show-snapshot');

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

    Route::get('/print/{id}', 'PhysicalInventoryController@printPdf')->name('print')->middleware('can:show-snapshot-repair');

    Route::get('/exportToExcel/{id}', 'PhysicalInventoryController@exportToExcel')->name('exportToExcel')->middleware('can:show-snapshot-repair');

});

// Goods Receipt Routes
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

    Route::get('/print/{id}', 'GoodsReceiptController@printPdf')->name('print')->middleware('can:show-goods-receipt');

});

// Goods Receipt Repair Routes
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

    Route::get('/print/{id}', 'GoodsReceiptController@printPdf')->name('print')->middleware('can:show-goods-receipt-repair');

});

//Goods Return Building
Route::name('goods_return.')->prefix('goods_return')->group(function() {
    Route::get('/indexApprove', 'GoodsReturnController@indexApprove')->name('indexApprove')->middleware('can:approve-goods-return');

    Route::patch('/{id}', 'GoodsReturnController@update')->name('update')->middleware('can:edit-goods-return');

    Route::get('/showApprove/{id}', 'GoodsReturnController@showApprove')->name('showApprove')->middleware('can:show-goods-return');

    Route::get('/approval', 'GoodsReturnController@approval')->name('approval')->middleware('can:approve-goods-return');

    Route::get('/approvalGI', 'GoodsReturnController@approvalGI')->name('approvalGI')->middleware('can:approve-goods-return');

    Route::get('/selectGR', 'GoodsReturnController@selectGR')->name('selectGR')->middleware('can:create-goods-return');

    Route::get('/selectPO', 'GoodsReturnController@selectPO')->name('selectPO')->middleware('can:create-goods-return');

    Route::get('/selectGI', 'GoodsReturnController@selectGI')->name('selectGI')->middleware('can:create-goods-return');

    Route::post('/GR', 'GoodsReturnController@storeGoodsReturnGR')->name('storeGR')->middleware('can:create-goods-return');

    Route::post('/PO', 'GoodsReturnController@storeGoodsReturnPO')->name('storePO')->middleware('can:create-goods-return');

    Route::post('/GI', 'GoodsReturnController@storeGoodsReturnGI')->name('storeGI')->middleware('can:create-goods-return');

    Route::get('/createGoodsReturnGR/{id}', 'GoodsReturnController@createGoodsReturnGR')->name('createGoodsReturnGR')->middleware('can:create-goods-return');

    Route::get('/createGoodsReturnPO/{id}', 'GoodsReturnController@createGoodsReturnPO')->name('createGoodsReturnPO')->middleware('can:create-goods-return');

    Route::get('/createGoodsReturnGI/{id}', 'GoodsReturnController@createGoodsReturnGI')->name('createGoodsReturnGI')->middleware('can:create-goods-return');

    Route::get('/', 'GoodsReturnController@indexGoodsReturn')->name('index')->middleware('can:list-goods-return');

    Route::get('/edit/{id}', 'GoodsReturnController@edit')->name('edit')->middleware('can:edit-goods-return');

    Route::get('/{id}', 'GoodsReturnController@show')->name('show')->middleware('can:show-goods-return');

    Route::get('/print/{id}', 'GoodsReturnController@printPdf')->name('print')->middleware('can:show-goods-return');

});

//Goods Return Repair
Route::name('goods_return_repair.')->prefix('goods_return_repair')->group(function() {
    Route::get('/indexApprove', 'GoodsReturnController@indexApprove')->name('indexApprove')->middleware('can:approve-goods-return-repair');

    Route::patch('/{id}', 'GoodsReturnController@update')->name('update')->middleware('can:edit-goods-return-repair');

    Route::get('/showApprove/{id}', 'GoodsReturnController@showApprove')->name('showApprove')->middleware('can:show-goods-return-repair');

    Route::get('/approval', 'GoodsReturnController@approval')->name('approval')->middleware('can:approve-goods-return-repair');

    Route::get('/approvalGI', 'GoodsReturnController@approvalGI')->name('approvalGI')->middleware('can:approve-goods-return-repair');

    Route::get('/selectGR', 'GoodsReturnController@selectGR')->name('selectGR')->middleware('can:create-goods-return-repair');

    Route::get('/selectPO', 'GoodsReturnController@selectPO')->name('selectPO')->middleware('can:create-goods-return-repair');

    Route::get('/selectGI', 'GoodsReturnController@selectGI')->name('selectGI')->middleware('can:create-goods-return-repair');

    Route::post('/GR', 'GoodsReturnController@storeGoodsReturnGR')->name('storeGR')->middleware('can:create-goods-return-repair');

    Route::post('/PO', 'GoodsReturnController@storeGoodsReturnPO')->name('storePO')->middleware('can:create-goods-return-repair');

    Route::post('/GI', 'GoodsReturnController@storeGoodsReturnGI')->name('storeGI')->middleware('can:create-goods-return-repair');

    Route::get('/createGoodsReturnGR/{id}', 'GoodsReturnController@createGoodsReturnGR')->name('createGoodsReturnGR')->middleware('can:create-goods-return-repair');

    Route::get('/createGoodsReturnPO/{id}', 'GoodsReturnController@createGoodsReturnPO')->name('createGoodsReturnPO')->middleware('can:create-goods-return-repair');

    Route::get('/createGoodsReturnGI/{id}', 'GoodsReturnController@createGoodsReturnGI')->name('createGoodsReturnGI')->middleware('can:create-goods-return-repair');

    Route::get('/', 'GoodsReturnController@indexGoodsReturn')->name('index')->middleware('can:list-goods-return-repair');

    Route::get('/edit/{id}', 'GoodsReturnController@edit')->name('edit')->middleware('can:edit-goods-return-repair');

    Route::get('/{id}', 'GoodsReturnController@show')->name('show')->middleware('can:show-goods-return-repair');

    Route::get('/print/{id}', 'GoodsReturnController@printPdf')->name('print')->middleware('can:show-goods-return-repair');
});

//Reverse Transaction Routes
Route::name('reverse_transaction.')->prefix('reverse_transaction')->group(function() {
    Route::get('/indexApprove', 'ReverseTransactionController@indexApprove')->name('indexApprove')->middleware('can:approve-reverse-transaction');

    Route::get('/approval', 'ReverseTransactionController@approval')->name('approval')->middleware('can:approve-material-requisition');

    Route::get('/create/{documentType}/{id}', 'ReverseTransactionController@create')->name('create')->middleware('can:create-reverse-transaction');

    Route::get('/selectDocument', 'ReverseTransactionController@selectDocument')->name('selectDocument')->middleware('can:create-reverse-transaction');

    Route::get('/', 'ReverseTransactionController@index')->name('index')->middleware('can:list-reverse-transaction');

    Route::get('/{id}', 'ReverseTransactionController@show')->name('show')->middleware('can:show-reverse-transaction');

    Route::get('/showApprove/{id}', 'ReverseTransactionController@showApprove')->name('showApprove')->middleware('can:approve-reverse-transaction');

    Route::get('/{id}/edit', 'ReverseTransactionController@edit')->name('edit')->middleware('can:edit-reverse-transaction');

    Route::patch('/{id}', 'ReverseTransactionController@update')->name('update')->middleware('can:edit-reverse-transaction');

    Route::post('/', 'ReverseTransactionController@store')->name('store')->middleware('can:create-reverse-transaction');

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

    Route::get('/approval', 'MaterialRequisitionController@approval')->name('approval')->middleware('can:approve-material-requisition');

    Route::get('/', 'MaterialRequisitionController@index')->name('index')->middleware('can:list-material-requisition');

    Route::get('/create', 'MaterialRequisitionController@create')->name('create')->middleware('can:create-material-requisition');

    Route::get('/{id}', 'MaterialRequisitionController@show')->name('show')->middleware('can:show-material-requisition');

    Route::get('/showApprove/{id}', 'MaterialRequisitionController@showApprove')->name('showApprove')->middleware('can:show-material-requisition');

    Route::get('/{id}/edit', 'MaterialRequisitionController@edit')->name('edit')->middleware('can:edit-material-requisition');

    Route::patch('/{id}', 'MaterialRequisitionController@update')->name('update')->middleware('can:edit-material-requisition');

    Route::post('/', 'MaterialRequisitionController@store')->name('store')->middleware('can:create-material-requisition');

    Route::delete('/{id}', 'MaterialRequisitionController@destroy')->name('destroy')->middleware('can:destroy-material-requisition');

    Route::get('/print/{id}', 'MaterialRequisitionController@printPdf')->name('print')->middleware('can:show-material-requisition');

});

//Material Requisition Repair Routes
Route::name('material_requisition_repair.')->prefix('material_requisition_repair')->group(function() {
    Route::get('/indexApprove', 'MaterialRequisitionController@indexApprove')->name('indexApprove')->middleware('can:approve-material-requisition-repair');

    Route::get('/approval', 'MaterialRequisitionController@approval')->name('approval')->middleware('can:approve-material-requisition-repair');

    Route::get('/', 'MaterialRequisitionController@index')->name('index')->middleware('can:list-material-requisition-repair');

    Route::get('/create', 'MaterialRequisitionController@createRepair')->name('create')->middleware('can:create-material-requisition-repair');

    Route::get('/{id}', 'MaterialRequisitionController@show')->name('show')->middleware('can:show-material-requisition-repair');

    Route::get('/showApprove/{id}', 'MaterialRequisitionController@showApprove')->name('showApprove')->middleware('can:show-material-requisition-repair');

    Route::get('/{id}/edit', 'MaterialRequisitionController@editRepair')->name('edit')->middleware('can:edit-material-requisition-repair');

    Route::patch('/{id}', 'MaterialRequisitionController@update')->name('update')->middleware('can:edit-material-requisition-repair');

    Route::post('/', 'MaterialRequisitionController@store')->name('store')->middleware('can:create-material-requisition-repair');

    Route::delete('/{id}', 'MaterialRequisitionController@destroy')->name('destroy')->middleware('can:destroy-material-requisition-repair');

    Route::get('/print/{id}', 'MaterialRequisitionController@printPdf')->name('print')->middleware('can:show-material-requisition-repair');

});

// Goods Issue Routes
Route::name('goods_issue.')->prefix('goods_issue')->group(function() {
    Route::get('/', 'GoodsIssueController@index')->name('index')->middleware('can:list-goods-issue');

    Route::get('/selectMR', 'GoodsIssueController@selectMR')->name('selectMR')->middleware('can:create-goods-issue');

    Route::get('/approval/{id}/{status}', 'GoodsIssueController@approval')->name('approval');

    Route::get('/createGiWithRef', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue');

    Route::get('/createGiWithRef/{id}', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue');

    Route::get('/{id}', 'GoodsIssueController@show')->name('show')->middleware('can:show-goods-issue');

    Route::get('/{id}/edit', 'GoodsIssueController@edit')->name('edit')->middleware('can:edit-goods-issue');

    Route::patch('/{id}', 'GoodsIssueController@update')->name('update')->middleware('can:edit-goods-issue');

    Route::post('/', 'GoodsIssueController@store')->name('store')->middleware('can:create-goods-issue');

    Route::delete('/{id}', 'GoodsIssueController@destroy')->name('destroy')->middleware('can:destroy-goods-issue');

    Route::get('/print/{id}', 'GoodsIssueController@printPdf')->name('print')->middleware('can:show-goods-issue');
});

// Goods Issue Repair Routes
Route::name('goods_issue_repair.')->prefix('goods_issue_repair')->group(function() {
    Route::get('/', 'GoodsIssueController@index')->name('index')->middleware('can:list-goods-issue-repair');

    Route::get('/selectMR', 'GoodsIssueController@selectMR')->name('selectMR')->middleware('can:create-goods-issue-repair');

    Route::get('/approval/{id}/{status}', 'GoodsIssueController@approval')->name('approval');

    Route::get('/createGiWithRef', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue-repair');

    Route::get('/createGiWithRef/{id}', 'GoodsIssueController@createGiWithRef')->name('createGiWithRef')->middleware('can:create-goods-issue-repair');

    Route::get('/{id}', 'GoodsIssueController@show')->name('show')->middleware('can:show-goods-issue-repair');

    Route::get('/{id}/edit', 'GoodsIssueController@edit')->name('edit')->middleware('can:edit-goods-issue-repair');

    Route::patch('/{id}', 'GoodsIssueController@update')->name('update')->middleware('can:edit-goods-issue-repair');

    Route::post('/', 'GoodsIssueController@store')->name('store')->middleware('can:create-goods-issue-repair');

    Route::delete('/{id}', 'GoodsIssueController@destroy')->name('destroy')->middleware('can:destroy-goods-issue-repair');

    Route::get('/print/{id}', 'GoodsIssueController@printPdf')->name('print')->middleware('can:show-goods-issue-repair');
});


//Material Write Off Routes
Route::name('material_write_off.')->prefix('material_write_off')->group(function() {
    Route::get('/indexApprove', 'MaterialWriteOffController@indexApprove')->name('indexApprove')->middleware('can:approve-material-write-off');

    Route::get('/showApprove/{id}', 'MaterialWriteOffController@showApprove')->name('showApprove')->middleware('can:approve-material-write-off');

    Route::get('/approval', 'MaterialWriteOffController@approval')->name('approval');

    Route::get('/create', 'MaterialWriteOffController@create')->name('create')->middleware('can:create-material-write-off');

    Route::get('/', 'MaterialWriteOffController@index')->name('index')->middleware('can:list-material-write-off');

    Route::get('/{id}', 'MaterialWriteOffController@show')->name('show')->middleware('can:show-material-write-off');

    Route::get('/{id}/edit', 'MaterialWriteOffController@edit')->name('edit')->middleware('can:edit-material-write-off');

    Route::patch('/{id}', 'MaterialWriteOffController@update')->name('update')->middleware('can:edit-material-write-off');

    Route::post('/', 'MaterialWriteOffController@store')->name('store')->middleware('can:create-material-write-off');


});

//Material Write Off Repair Routes
Route::name('material_write_off_repair.')->prefix('material_write_off_repair')->group(function() {
    Route::get('/indexApprove', 'MaterialWriteOffController@indexApprove')->name('indexApprove')->middleware('can:approve-material-write-off');

    Route::get('/showApprove/{id}', 'MaterialWriteOffController@showApprove')->name('showApprove')->middleware('can:approve-material-write-off');

    Route::get('/approval', 'MaterialWriteOffController@approval')->name('approval');

    Route::get('/create', 'MaterialWriteOffController@create')->name('create')->middleware('can:create-material-write-off-repair');

    Route::get('/', 'MaterialWriteOffController@index')->name('index')->middleware('can:list-material-write-off-repair');

    Route::get('/{id}', 'MaterialWriteOffController@show')->name('show')->middleware('can:show-material-write-off-repair');

    Route::get('/{id}/edit', 'MaterialWriteOffController@edit')->name('edit')->middleware('can:edit-material-write-off-repair');

    Route::patch('/{id}', 'MaterialWriteOffController@update')->name('update')->middleware('can:edit-material-write-off-repair');

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
    Route::delete('/deleteImage/{id}', 'ProductionOrderController@deleteImage')->name('deleteImage')->middleware('can:confirm-production-order');

    Route::patch('/checkProdOrder/{wbs_id}', 'ProductionOrderController@checkProdOrder')->name('checkProdOrder')->middleware('can:create-production-order');

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

    Route::post('/upload', 'ProductionOrderController@upload')->name('upload')->middleware('can:confirm-production-order');

    Route::get('/selectProjectIndex', 'ProductionOrderController@selectProjectIndex')->name('selectProjectIndex')->middleware('can:list-production-order');

    Route::get('/indexPrO/{id}', 'ProductionOrderController@indexPrO')->name('indexPrO')->middleware('can:list-production-order');

    Route::get('/editPrO/{id}', 'ProductionOrderController@editPrO')->name('editPrO')->middleware('can:edit-production-order');

    Route::patch('/updatePrO/{id}', 'ProductionOrderController@updatePrO')->name('updatePrO')->middleware('can:edit-production-order');

    Route::get('/selectProjectReport', 'ProductionOrderController@selectProjectReport')->name('selectProjectReport')->middleware('can:list-production-order');

    Route::get('/showRelease/{id}', 'ProductionOrderController@show')->name('showRelease')->middleware('can:show-production-order');

    Route::get('/report/{id}', 'ProductionOrderController@report')->name('report')->middleware('can:list-production-order');

    Route::get('/selectPrOReport/{id}', 'ProductionOrderController@selectPrOReport')->name('selectPrOReport')->middleware('can:show-production-order');

    Route::get('/{id}', 'ProductionOrderController@show')->name('show')->middleware('can:show-production-order');

    Route::get('/showConfirm/{id}', 'ProductionOrderController@show')->name('showConfirm')->middleware('can:show-production-order');
});

//Production Order Repair Routes
Route::name('production_order_repair.')->prefix('production_order_repair')->group(function() {
    Route::delete('/deleteImage/{id}', 'ProductionOrderController@deleteImage')->name('deleteImage')->middleware('can:confirm-production-order-repair');

    Route::patch('/checkProdOrder/{wbs_id}', 'ProductionOrderController@checkProdOrder')->name('checkProdOrder')->middleware('can:create-production-order-repair');

    Route::get('/selectProject', 'ProductionOrderController@selectProject')->name('selectProject')->middleware('can:create-production-order-repair');

    Route::get('/selectWBS/{id}', 'ProductionOrderController@selectWBS')->name('selectWBS')->middleware('can:create-production-order-repair');

    Route::get('/create/{id}', 'ProductionOrderController@createRepair')->name('create')->middleware('can:create-production-order-repair');

    Route::post('/', 'ProductionOrderController@store')->name('store')->middleware('can:create-production-order-repair');

    Route::get('/selectProjectRelease', 'ProductionOrderController@selectProjectRelease')->name('selectProjectRelease')->middleware('can:release-production-order-repair');

    Route::get('/selectPrO/{id}', 'ProductionOrderController@selectPrO')->name('selectPrO')->middleware('can:release-production-order-repair');

    Route::get('/release/{id}', 'ProductionOrderController@releaseRepair')->name('release')->middleware('can:release-production-order-repair');

    Route::patch('/storeRelease', 'ProductionOrderController@storeReleaseRepair')->name('storeRelease')->middleware('can:release-production-order-repair');

    Route::get('/selectProjectConfirm', 'ProductionOrderController@selectProjectConfirm')->name('selectProjectConfirm')->middleware('can:confirm-production-order-repair');

    Route::get('/confirmPrO/{id}', 'ProductionOrderController@confirmPrO')->name('confirmPrO')->middleware('can:confirm-production-order-repair');

    Route::get('/confirm/{id}', 'ProductionOrderController@confirmRepair')->name('confirm')->middleware('can:confirm-production-order-repair');

    Route::patch('/storeConfirm', 'ProductionOrderController@storeConfirmRepair')->name('storeConfirm')->middleware('can:confirm-production-order-repair');

    Route::get('/selectProjectIndex', 'ProductionOrderController@selectProjectIndex')->name('selectProjectIndex')->middleware('can:list-production-order-repair');

    Route::get('/indexPrO/{id}', 'ProductionOrderController@indexPrO')->name('indexPrO')->middleware('can:list-production-order-repair');

    Route::get('/editPrO/{id}', 'ProductionOrderController@editPrO')->name('editPrO')->middleware('can:edit-production-order-repair');

    Route::patch('/updatePrO/{id}', 'ProductionOrderController@updatePrO')->name('updatePrO')->middleware('can:edit-production-order-repair');

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

    Route::put('confirmYardPlan/{id}', 'YardPlanController@confirmYardPlan')->name('confirmYardPlan');

    Route::patch('/confirmActual/{id}', 'YardPlanController@confirmActual')->name('confirmActual');

    Route::post('/', 'YardPlanController@store')->name('store');

    Route::delete('/{id}', 'YardPlanController@destroy')->name('destroy');
});

//Project Standard
Route::name('project_standard.')->prefix('project_standard')->group(function() {
    //Project Standard
    Route::get('/createProjectStandard', 'ProjectStandardController@createProjectStandard')->name('createProjectStandard')->middleware('can:manage-project-standard');

    Route::post('/storeProjectStandard', 'ProjectStandardController@storeProjectStandard')->name('storeProjectStandard')->middleware('can:manage-project-standard');

    Route::put('updateProjectStandard/{id}', 'ProjectStandardController@updateProjectStandard')->name('updateProjectStandard')->middleware('can:manage-project-standard');

    Route::delete('/deleteProjectStandard/{id}', 'ProjectStandardController@destroyProjectStandard')->name('destroyProjectStandard')->middleware('can:manage-project-standard');

    // WBS Standard
    Route::get('/createWbsStandard/{id}', 'ProjectStandardController@createWbsStandard')->name('createWbsStandard')->middleware('can:manage-project-standard');

    Route::get('/createSubWbsStandard/{wbs_id}', 'ProjectStandardController@createSubWbsStandard')->name('createSubWbsStandard')->middleware('can:manage-project-standard');

    Route::get('/selectProject', 'ProjectStandardController@selectProject')->name('selectProject')->middleware('can:list-bom');

    Route::get('/selectWBS/{id}', 'ProjectStandardController@selectWBS')->name('selectWBS')->middleware('can:manage-project-standard');

    Route::get('/manageMaterial/{wbs_id}', 'ProjectStandardController@manageMaterial')->name('manageMaterial')->middleware('can:manage-project-standard');

    Route::get('/showMaterialStandard/{wbs_id}', 'ProjectStandardController@showMaterialStandard')->name('showMaterialStandard')->middleware('can:manage-project-standard');

    Route::post('/storeMaterialStandard', 'ProjectStandardController@storeMaterialStandard')->name('storeMaterialStandard')->middleware('can:manage-project-standard');

    Route::post('/storeWbsStandard', 'ProjectStandardController@storeWbsStandard')->name('storeWbsStandard')->middleware('can:manage-project-standard');

    Route::patch('/updateMaterialStandard', 'ProjectStandardController@updateMaterialStandard')->name('updateMaterialStandard')->middleware('can:manage-project-standard');

    Route::put('/updateWbsStandard/{id}', 'ProjectStandardController@updateWbsStandard')->name('updateWbsStandard')->middleware('can:manage-project-standard');

    Route::delete('/deleteWbsStandard/{id}', 'ProjectStandardController@destroyWbsStandard')->name('destroyWbsStandard')->middleware('can:manage-project-standard');

    //Activity Standard
    Route::get('/createActivityStandard/{id}', 'ProjectStandardController@createActivityStandard')->name('createActivityStandard')->middleware('can:manage-project-standard');

    Route::post('/storeActivityStandard', 'ProjectStandardController@storeActivityStandard')->name('storeActivityStandard')->middleware('can:manage-project-standard');

    Route::put('/updateActivityStandard/{id}', 'ProjectStandardController@updateActivityStandard')->name('updateActivityStandard')->middleware('can:manage-project-standard');

    Route::delete('/deleteActivityStandard/{id}', 'ProjectStandardController@destroyActivityStandard')->name('destroyActivityStandard')->middleware('can:manage-project-standard');
});

// Estimator Routes
Route::name('estimator.')->prefix('estimator')->group(function() {
    Route::get('/indexEstimatorWbs', 'EstimatorController@indexEstimatorWbs')->name('indexEstimatorWbs');

    Route::get('/indexEstimatorCostStandard', 'EstimatorController@indexEstimatorCostStandard')->name('indexEstimatorCostStandard');

    Route::get('/indexEstimatorProfile', 'EstimatorController@indexEstimatorProfile')->name('indexEstimatorProfile');

    Route::get('/createWbs', 'EstimatorController@createWbs')->name('createWbs');

    Route::get('/createCostStandard', 'EstimatorController@createCostStandard')->name('createCostStandard');

    Route::get('/createProfile', 'EstimatorController@createProfile')->name('createProfile');

    Route::post('/storeWbs', 'EstimatorController@storeWbs')->name('storeWbs');

    Route::post('/storeCostStandard', 'EstimatorController@storeCostStandard')->name('storeCostStandard');

    Route::post('/storeProfile', 'EstimatorController@storeProfile')->name('storeProfile');

    Route::get('/editWbs/{id}', 'EstimatorController@editWbs')->name('editWbs');

    Route::get('/editCostStandard/{id}', 'EstimatorController@editCostStandard')->name('editCostStandard');

    Route::get('/editProfile/{id}', 'EstimatorController@editProfile')->name('editProfile');

    // Route::get('/showWbs/{id}', 'EstimatorController@showWbs')->name('showWbs');

    Route::get('/showCostStandard/{id}', 'EstimatorController@showCostStandard')->name('showCostStandard');

    Route::get('/showProfile/{id}', 'EstimatorController@showProfile')->name('showProfile');

    Route::patch('/updateWbs/{id}', 'EstimatorController@updateWbs')->name('updateWbs');

    Route::patch('/updateCostStandard/{id}', 'EstimatorController@updateCostStandard')->name('updateCostStandard');

    Route::patch('/updateProfile/{id}', 'EstimatorController@updateProfile')->name('updateProfile');

    Route::get('/deleteWbs/{id}', 'EstimatorController@deleteWbs')->name('deleteWbs');

    Route::get('/deleteCostStandard/{id}', 'EstimatorController@deleteCostStandard')->name('deleteCostStandard');

    Route::get('/deleteProfile/{id}', 'EstimatorController@deleteProfile')->name('deleteProfile');
});

//Estimator Repair
Route::name('estimator_repair.')->prefix('estimator_repair')->group(function() {
    Route::get('/indexEstimatorWbs', 'EstimatorController@indexEstimatorWbs')->name('indexEstimatorWbs');

    Route::get('/indexEstimatorCostStandard', 'EstimatorController@indexEstimatorCostStandard')->name('indexEstimatorCostStandard');

    Route::get('/indexEstimatorProfile', 'EstimatorController@indexEstimatorProfile')->name('indexEstimatorProfile');

    Route::get('/createWbs', 'EstimatorController@createWbs')->name('createWbs');

    Route::get('/createCostStandard', 'EstimatorController@createCostStandard')->name('createCostStandard');

    Route::get('/createProfile', 'EstimatorController@createProfile')->name('createProfile');

    Route::post('/storeWbs', 'EstimatorController@storeWbs')->name('storeWbs');

    Route::post('/storeCostStandard', 'EstimatorController@storeCostStandard')->name('storeCostStandard');

    Route::post('/storeProfile', 'EstimatorController@storeProfile')->name('storeProfile');

    Route::get('/editWbs/{id}', 'EstimatorController@editWbs')->name('editWbs');

    Route::get('/editCostStandard/{id}', 'EstimatorController@editCostStandard')->name('editCostStandard');

    Route::get('/editProfile/{id}', 'EstimatorController@editProfile')->name('editProfile');

    // Route::get('/showWbs/{id}', 'EstimatorController@showWbs')->name('showWbs');

    Route::get('/showCostStandard/{id}', 'EstimatorController@showCostStandard')->name('showCostStandard');

    Route::get('/showProfile/{id}', 'EstimatorController@showProfile')->name('showProfile');

    Route::patch('/updateWbs/{id}', 'EstimatorController@updateWbs')->name('updateWbs');

    Route::patch('/updateCostStandard/{id}', 'EstimatorController@updateCostStandard')->name('updateCostStandard');

    Route::patch('/updateProfile/{id}', 'EstimatorController@updateProfile')->name('updateProfile');

    Route::get('/deleteWbs/{id}', 'EstimatorController@deleteWbs')->name('deleteWbs');

    Route::get('/deleteCostStandard/{id}', 'EstimatorController@deleteCostStandard')->name('deleteCostStandard');

    Route::get('/deleteProfile/{id}', 'EstimatorController@deleteProfile')->name('deleteProfile');
});

// Quotation Routes
Route::name('quotation.')->prefix('quotation')->group(function() {
    Route::get('/create', 'QuotationController@create')->name('create');

    Route::get('/', 'QuotationController@index')->name('index');

    Route::get('/{id}', 'QuotationController@show')->name('show');

    Route::get('/{id}/edit', 'QuotationController@edit')->name('edit');

    Route::patch('/{id}', 'QuotationController@update')->name('update');

    Route::post('/', 'QuotationController@store')->name('store');
});

// Quotation Repair Routes
Route::name('quotation_repair.')->prefix('quotation_repair')->group(function() {
    Route::get('/create', 'QuotationController@create')->name('create');

    Route::get('/', 'QuotationController@index')->name('index');

    Route::get('/{id}', 'QuotationController@show')->name('show');

    Route::get('/{id}/edit', 'QuotationController@edit')->name('edit');

    Route::patch('/{id}', 'QuotationController@update')->name('update');

    Route::post('/', 'QuotationController@store')->name('store');
});

// Sales Order Routes
Route::name('sales_order.')->prefix('sales_order')->group(function() {
    Route::get('/selectQT', 'SalesOrderController@selectQT')->name('selectQT');

    Route::get('/create/{id}', 'SalesOrderController@create')->name('create');

    Route::get('/', 'SalesOrderController@index')->name('index');

    Route::get('/{id}', 'SalesOrderController@show')->name('show');

    Route::get('/{id}/edit', 'SalesOrderController@edit')->name('edit');

    Route::patch('/{id}', 'SalesOrderController@update')->name('update');

    Route::post('/', 'SalesOrderController@store')->name('store');
});

// Sales Order Repair Routes
Route::name('sales_order_repair.')->prefix('sales_order_repair')->group(function() {
    Route::get('/selectQT', 'SalesOrderController@selectQT')->name('selectQT');

    Route::get('/create/{id}', 'SalesOrderController@create')->name('create');

    Route::get('/', 'SalesOrderController@index')->name('index');

    Route::get('/{id}', 'SalesOrderController@show')->name('show');

    Route::get('/{id}/edit', 'SalesOrderController@edit')->name('edit');

    Route::patch('/{id}', 'SalesOrderController@update')->name('update');

    Route::post('/', 'SalesOrderController@store')->name('store');
});

// Invoice Routes
Route::name('invoice.')->prefix('invoice')->group(function() {
    Route::get('/selectProject', 'InvoiceController@selectProject')->name('selectProject');

    Route::get('/create/{id}', 'InvoiceController@create')->name('create');

    Route::get('/', 'InvoiceController@index')->name('index');

    Route::get('/{id}', 'InvoiceController@show')->name('show');

    Route::get('/{id}/edit', 'InvoiceController@edit')->name('edit');

    Route::patch('/{id}', 'InvoiceController@update')->name('update');

    Route::post('/', 'InvoiceController@store')->name('store');
});

// Invoice Repair Routes
Route::name('invoice_repair.')->prefix('invoice_repair')->group(function() {
    Route::get('/selectProject', 'InvoiceController@selectProject')->name('selectProject');

    Route::get('/create/{id}', 'InvoiceController@create')->name('create');

    Route::get('/', 'InvoiceController@index')->name('index');

    Route::get('/{id}', 'InvoiceController@show')->name('show');

    Route::get('/{id}/edit', 'InvoiceController@edit')->name('edit');

    Route::patch('/{id}', 'InvoiceController@update')->name('update');

    Route::post('/', 'InvoiceController@store')->name('store');
});

// Payment Routes
Route::name('payment.')->prefix('payment')->group(function() {
    Route::get('/selectInvoice', 'PaymentController@selectInvoice')->name('selectInvoice');

    Route::get('/selectInvoiceView', 'PaymentController@selectInvoiceView')->name('selectInvoiceView');

    Route::get('/create/{id}', 'PaymentController@create')->name('create');

    Route::get('/manage/{id}/{menu}', 'PaymentController@manage')->name('manage');

    Route::get('/', 'PaymentController@index')->name('index');

    Route::get('/{id}', 'PaymentController@show')->name('show');

    Route::get('/{id}/edit', 'PaymentController@edit')->name('edit');

    Route::patch('/{id}', 'PaymentController@update')->name('update');

    Route::post('/', 'PaymentController@store')->name('store');
});

// Payment Repair Routes
Route::name('payment_repair.')->prefix('payment_repair')->group(function() {
    Route::get('/selectInvoice', 'PaymentController@selectInvoice')->name('selectInvoice');

    Route::get('/selectInvoiceView', 'PaymentController@selectInvoiceView')->name('selectInvoiceView');

    Route::get('/create/{id}', 'PaymentController@create')->name('create');

    Route::get('/manage/{id}', 'PaymentController@manage')->name('manage');

    Route::get('/', 'PaymentController@index')->name('index');

    Route::get('/{id}', 'PaymentController@show')->name('show');

    Route::get('/{id}/edit', 'PaymentController@edit')->name('edit');

    Route::patch('/{id}', 'PaymentController@update')->name('update');

    Route::post('/', 'PaymentController@store')->name('store');
});

//  QC Type Routes
Route::name('qc_type.')->prefix('qc_type')->group(function() {

    Route::get('/', 'QualityControlTypeController@index')->name('index');

    Route::get('/create', 'QualityControlTypeController@create')->name('create');

    Route::get('/{id}', 'QualityControlTypeController@show')->name('show');

    Route::get('/{id}/edit', 'QualityControlTypeController@edit')->name('edit');

    Route::patch('/update', 'QualityControlTypeController@update')->name('update');

    Route::put('/updatemaster', 'QualityControlTypeController@updateMaster')->name('updatemaster');

    Route::put('/updatedetail', 'QualityControlTypeController@updateDetail')->name('updatedetail');

    Route::delete('/deletedetail/{id}', 'QualityControlTypeController@deleteDetail')->name('deletedetail');

    Route::post('/', 'QualityControlTypeController@store')->name('store');

    Route::delete('/{id}', 'QualityControlTypeController@destroy')->name('destroy');

});

//  QC Task Routes
Route::name('qc_task.')->prefix('qc_task')->group(function() {

    Route::get('/', 'QualityControlTaskController@index')->name('index')->middleware('can:list-qc-task');

    Route::get('/selectProject', 'QualityControlTaskController@selectProject')->name('selectProject');

    Route::get('/selectProjectConfirm', 'QualityControlTaskController@selectProjectConfirm')->name('selectProjectConfirm');

    Route::get('/selectProjectSummary', 'QualityControlTaskController@selectProjectSummary')->name('selectProjectSummary');

    Route::get('/selectWBS/{id}', 'QualityControlTaskController@selectWBS')->name('selectWBS')->middleware('can:list-bom');

    Route::get('/create/{id}', 'QualityControlTaskController@create')->name('create')->middleware('can:create-qc-task');;

    Route::get('/{id}', 'QualityControlTaskController@show')->name('show')->middleware('can:show-qc-task');

    Route::get('/{id}/edit', 'QualityControlTaskController@edit')->name('edit')->middleware('can:edit-qc-task');

    Route::patch('/', 'QualityControlTaskController@update')->name('update')->middleware('can:edit-qc-task');

    Route::post('/', 'QualityControlTaskController@store')->name('store')->middleware('can:create-qc-task');

    Route::delete('/{id}', 'QualityControlTaskController@destroy')->name('destroy')->middleware('can:destroy-qc-task');

});

// Sales Plan Routes
Route::name('sales_plan.')->prefix('sales_plan')->group(function() {
    Route::get('/create/{id}', 'SalesPlanController@create')->name('create');

    Route::get('/', 'SalesPlanController@index')->name('index');

    Route::get('/{id}', 'SalesPlanController@show')->name('show');

    Route::get('/{id}/edit', 'SalesPlanController@edit')->name('edit');

    Route::patch('/{id}', 'SalesPlanController@update')->name('update');

    Route::post('/', 'SalesPlanController@store')->name('store');

});

// Sales Plan Repair Routes
Route::name('sales_plan_repair.')->prefix('sales_plan_repair')->group(function() {
    Route::get('/create/{id}', 'SalesPlanController@create')->name('create');

    Route::get('/', 'SalesPlanController@index')->name('index');

    Route::get('/{id}', 'SalesPlanController@show')->name('show');

    Route::get('/{id}/edit', 'SalesPlanController@edit')->name('edit');

    Route::patch('/{id}', 'SalesPlanController@update')->name('update');

    Route::post('/', 'SalesPlanController@store')->name('store');
});

// Customer Visit Routes
Route::name('customer_visit.')->prefix('customer_visit')->group(function() {
    Route::get('/', 'CustomerVisitController@index')->name('index');

    Route::patch('/{id}', 'CustomerVisitController@update')->name('update');

    Route::post('/', 'CustomerVisitController@store')->name('store');

    Route::delete('/{id}', 'CustomerVisitController@destroy')->name('destroy');
});

// Customer Visit Repair Routes
Route::name('customer_visit_repair.')->prefix('customer_visit_repair')->group(function() {
    Route::get('/', 'CustomerVisitController@index')->name('index');

    Route::patch('/{id}', 'CustomerVisitController@update')->name('update');

    Route::post('/', 'CustomerVisitController@store')->name('store');

    Route::delete('/{id}', 'CustomerVisitController@destroy')->name('destroy');
});

// Delivery Document Routes
Route::name('delivery_document.')->prefix('delivery_document')->group(function() {
    Route::get('/selectProject', 'DeliveryDocumentController@selectProject')->name('selectProject');

    Route::get('/selectProjectIndex', 'DeliveryDocumentController@selectProjectIndex')->name('selectProjectIndex');

    Route::get('/manage/{id}', 'DeliveryDocumentController@manage')->name('manage');

    Route::get('/{id}', 'DeliveryDocumentController@show')->name('show');

    Route::get('/{id}/edit', 'DeliveryDocumentController@edit')->name('edit');

    Route::post('/{id}', 'DeliveryDocumentController@update')->name('update');

    Route::post('/', 'DeliveryDocumentController@store')->name('store');

    Route::delete('/{id}', 'DeliveryDocumentController@destroy')->name('destroy');
});

// Project Close Routes
Route::name('close_project.')->prefix('close_project')->group(function() {
    Route::get('/selectProject', 'CloseProjectController@selectProject')->name('selectProject');

    Route::get('/', 'CloseProjectController@index')->name('index');

    Route::get('/{id}', 'CloseProjectController@show')->name('show');

    Route::patch('/{id}', 'CloseProjectController@close')->name('close');

    Route::delete('/{id}', 'CloseProjectController@destroy')->name('destroy');
});

// Customer Portal Routes
Route::name('customer_portal.')->prefix('customer_portal')->group(function() {
    Route::get('/selectProject', 'CustomerPortalController@selectProject')->name('selectProject');

    Route::get('/selectProjectPost', 'CustomerPortalController@selectProjectPost')->name('selectProjectPost');

    Route::get('/selectProjectReply', 'CustomerPortalController@selectProjectReply')->name('selectProjectReply');

    Route::get('/', 'CustomerPortalController@index')->name('index');

    Route::get('/{id}', 'CustomerPortalController@show')->name('show');

    Route::get('/showProject/{id}', 'CustomerPortalController@showProject')->name('showProject');

    Route::get('/showPost/{id}', 'CustomerPortalController@showPost')->name('showPost');

    Route::get('/createPost/{id}', 'CustomerPortalController@createPost')->name('createPost');

    Route::get('/selectPost/{id}', 'CustomerPortalController@selectPost')->name('selectPost');

    Route::post('/storePost', 'CustomerPortalController@storePost')->name('storePost');

    Route::post('/storeComment', 'CustomerPortalController@storeComment')->name('storeComment');

    Route::patch('/{id}', 'CustomerPortalController@close')->name('close');

    Route::delete('/{id}', 'CustomerPortalController@destroy')->name('destroy');
});
