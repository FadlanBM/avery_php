<?php

/**
 * Front Controller
 */

// Start Session
session_start();

// Define critical paths first
define('APP_ROOT', __DIR__ . '/app');
define('SRC_ROOT', APP_ROOT . '/src');

// Load Autoloader
require_once SRC_ROOT . '/Core/Autoloader.php';

// Register Autoloader
\App\Core\Autoloader::register();

// Load Helpers
require_once SRC_ROOT . '/Helpers/functions.php';

// Load Environment Variables (.env)
\App\Core\Env::load(__DIR__ . '/.env');

// Load Configuration (After Env)
require_once APP_ROOT . '/config/config.php';

// Remember Me Auto-Login
(new \App\Middleware\RememberMeMiddleware())->handle();

// Initialize Router
$router = new \App\Core\Router();

// Define Routes
$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/scan-qr', [\App\Controllers\ScanqrController::class, 'index']);
$router->post('/scan-qr', [\App\Controllers\ScanqrController::class, 'inputManualCode']);
$router->get('/menu/logout', [\App\Controllers\ScanqrController::class, 'logoutTable']);
$router->get('/menu', [\App\Controllers\MenuController::class, 'index'], [\App\Middleware\TableAccessMiddleware::class]);
// Cart Routes
$router->get('/cart', [\App\Controllers\CartController::class, 'index']);
$router->post('/cart/add', [\App\Controllers\CartController::class, 'addItem']);
$router->post('/cart/update', [\App\Controllers\CartController::class, 'updateItem']);
$router->post('/cart/remove', [\App\Controllers\CartController::class, 'removeItem']);
$router->get('/cart/api', [\App\Controllers\CartController::class, 'getCartApi']);

// Like Routes
$router->post('/like/toggle', [\App\Controllers\MenuLikeController::class, 'toggle']);
$router->get('/order-tracking', [\App\Controllers\OrderController::class, 'index']);

// Dashboard protected with AuthMiddleware
$router->get('/dashboard', [\App\Controllers\DashboardController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/menu-management', [\App\Controllers\MenumanagementController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/menu-management/add', [\App\Controllers\MenumanagementController::class, 'addMenu'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/menu-management/add', [\App\Controllers\MenumanagementController::class, 'post'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/menu-management/edit', [\App\Controllers\MenumanagementController::class, 'editMenu'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/menu-management/edit', [\App\Controllers\MenumanagementController::class, 'updateMenu'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/menu-management/delete', [\App\Controllers\MenumanagementController::class, 'deleteMenu'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/menu-management/delete-asset', [\App\Controllers\MenumanagementController::class, 'deleteMenuAsset'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/table-management', [\App\Controllers\TablemanagementController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/table-management/create-area', [\App\Controllers\TablemanagementController::class, 'createArea'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/table-management/update-area', [\App\Controllers\TablemanagementController::class, 'updateArea'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/table-management/get-area', [\App\Controllers\TablemanagementController::class, 'getAreaById'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/table-management/delete-area', [\App\Controllers\TablemanagementController::class, 'deleteArea'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/table-management/create-table', [\App\Controllers\TablemanagementController::class, 'createTable'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/table-management/get-tables', [\App\Controllers\TablemanagementController::class, 'getTablesByArea'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/table-management/delete-table', [\App\Controllers\TablemanagementController::class, 'deleteTable'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/table-management/export-qr', [\App\Controllers\TablemanagementController::class, 'exportQr'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/settings', [\App\Controllers\SettingController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/create-payment-method', [\App\Controllers\SettingController::class, 'createPayment'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/delete-payment-method', [\App\Controllers\SettingController::class, 'deletePayment'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/create-category-menu', [\App\Controllers\SettingController::class, 'createCategory'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/delete-category-menu', [\App\Controllers\SettingController::class, 'deleteCategory'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/settings/get-category', [\App\Controllers\SettingController::class, 'getCategoryById'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/update-category-menu', [\App\Controllers\SettingController::class, 'updateCategory'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/create-employee', [\App\Controllers\SettingController::class, 'createEmployee'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/settings/get-employee', [\App\Controllers\SettingController::class, 'getEmployeeById'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/update-employee', [\App\Controllers\SettingController::class, 'updateEmployee'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/delete-employee', [\App\Controllers\SettingController::class, 'deleteEmployee'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/update-profile', [\App\Controllers\SettingController::class, 'updateProfile'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/update-open-setting', [\App\Controllers\SettingController::class, 'updateOpenSetting'], [\App\Middleware\SuperAdminMiddleware::class]);
// Employee Dashboard Routes
$router->get('/employee-dashboard/scan-qr', [\App\Controllers\EmployeeDashboardController::class, 'scanQr']);
$router->get('/employee-dashboard/pembayaran-tunai', [\App\Controllers\EmployeeDashboardController::class, 'pembayaranTunai']);

// Handover Dashboard Routes
$router->get('/handover-dashboard/order-handover', [\App\Controllers\HandoverDashboardController::class, 'orderHandover']);
$router->get('/handover-dashboard/qr-massal', [\App\Controllers\HandoverDashboardController::class, 'qrMassal']);

// Kitchen Dashboard Routes
$router->get('/kitchen-dashboard', [\App\Controllers\KitchenDashboardController::class, 'index']);

// Auth Routes
$router->get('/login', [\App\Controllers\AuthController::class, 'login']);
$router->post('/login', [\App\Controllers\AuthController::class, 'processLogin']);
$router->get('/logout', [\App\Controllers\AuthController::class, 'logout']);

// Dispatch
$router->dispatch();
