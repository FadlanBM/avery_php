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

// Initialize Router
$router = new \App\Core\Router();

// Define Routes
$router->get('/', [\App\Controllers\HomeController::class, 'index']);

// Dashboard protected with AuthMiddleware
$router->get('/dashboard', [\App\Controllers\HomeController::class, 'index'], [\App\Middleware\AuthMiddleware::class]);

// Auth Routes
$router->get('/login', [\App\Controllers\AuthController::class, 'login']);
$router->post('/login', [\App\Controllers\AuthController::class, 'processLogin']);
$router->get('/register', [\App\Controllers\AuthController::class, 'register']);
$router->post('/register', [\App\Controllers\AuthController::class, 'processRegister']);
$router->get('/logout', [\App\Controllers\AuthController::class, 'logout']);

// Dispatch
$router->dispatch();
