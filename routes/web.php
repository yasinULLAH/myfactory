<?php
use App\Core\Router;

Router::get('/', 'AuthController@showLogin');
Router::get('/login', 'AuthController@showLogin');
Router::post('/login', 'AuthController@processLogin');
Router::get('/logout', 'AuthController@logout');
Router::get('/captcha', 'CaptchaController@show');
Router::get('/dashboard', 'DashboardController@index');

// Master Data
Router::get('/master/factories', 'MasterDataController@factories');
Router::get('/master/factories/get', 'MasterDataController@getFactory');
Router::post('/master/factories/save', 'MasterDataController@saveFactory');
Router::post('/master/factories/delete', 'MasterDataController@deleteFactory');

Router::get('/master/products', 'MasterDataController@products');
Router::get('/master/products/get', 'MasterDataController@getProduct');
Router::post('/master/products/save', 'MasterDataController@saveProduct');
Router::post('/master/products/delete', 'MasterDataController@deleteProduct');

Router::get('/master/suppliers', 'MasterDataController@suppliers');
Router::get('/master/suppliers/get', 'MasterDataController@getSupplier');
Router::post('/master/suppliers/save', 'MasterDataController@saveSupplier');
Router::post('/master/suppliers/delete', 'MasterDataController@deleteSupplier');

// Inventory
Router::get('/inventory/warehouses', 'InventoryController@warehouses');
Router::get('/inventory/warehouses/get', 'InventoryController@getWarehouse');
Router::post('/inventory/warehouses/save', 'InventoryController@saveWarehouse');
Router::post('/inventory/warehouses/delete', 'InventoryController@deleteWarehouse');

Router::get('/inventory/stock', 'InventoryController@stock');
Router::get('/inventory/stock/get', 'InventoryController@getStock');
Router::post('/inventory/stock/save', 'InventoryController@saveStock');
Router::post('/inventory/stock/delete', 'InventoryController@deleteStock');

// Settings
Router::get('/settings', 'SettingsController@index');
Router::post('/settings/save', 'SettingsController@save');
Router::get('/settings/backups', 'BackupController@index');
Router::post('/settings/backups/create', 'BackupController@create');
Router::get('/settings/backups/download', 'BackupController@download');

// Procurement
Router::get('/procurement', 'ProcurementController@index');
Router::get('/procurement/create', 'ProcurementController@create');
Router::post('/procurement/store', 'ProcurementController@store');
Router::get('/procurement/view', 'ProcurementController@viewOrder');

// Production
Router::get('/production/bom', 'ProductionController@bom');
Router::post('/production/bom/save', 'ProductionController@saveBOM');

// Quality Control
Router::get('/qc', 'QCController@index');

// Maintenance
Router::get('/maintenance', 'MaintenanceController@index');

// Sales & Dispatch
Router::get('/sales', 'SalesController@index');

// HR / Attendance
Router::get('/hr', 'HRController@index');

// User Management
Router::get('/users', 'UserController@index');
Router::get('/users/get', 'UserController@getUser');
Router::post('/users/save', 'UserController@saveUser');
Router::post('/users/delete', 'UserController@deleteUser');

Router::get('/roles/get', 'UserController@getRole');
Router::post('/roles/save', 'UserController@saveRole');
Router::post('/roles/delete', 'UserController@deleteRole');

// Reports
Router::get('/reports', 'ReportController@index');