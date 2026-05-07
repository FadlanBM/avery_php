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
$router->get('/menu', [\App\Controllers\MenuController::class, 'index']);
$router->get('/scan-qr', [\App\Controllers\ScanqrController::class, 'index']);
$router->get('/cart', [\App\Controllers\CartController::class, 'index']);
$router->get('/order-tracking', [\App\Controllers\OrderController::class, 'index']);

// Dashboard protected with AuthMiddleware
$router->get('/dashboard', [\App\Controllers\DashboardController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/menu-management', [\App\Controllers\MenumanagementController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/menu-management/add', [\App\Controllers\MenumanagementController::class, 'addMenu'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/table-management', [\App\Controllers\TablemanagementController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/table-management/add', [\App\Controllers\TablemanagementController::class, 'addTable'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->get('/dashboard/settings', [\App\Controllers\SettingController::class, 'index'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/create-payment-method', [\App\Controllers\SettingController::class, 'createPaymentMethod'], [\App\Middleware\SuperAdminMiddleware::class]);
$router->post('/dashboard/settings/delete-payment-method', [\App\Controllers\SettingController::class, 'deletePayment'], [\App\Middleware\SuperAdminMiddleware::class]);

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
