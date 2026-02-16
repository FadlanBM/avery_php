<?php

// Database Configuration
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_DATABASE') ?: 'my_project');
define('DB_USER', getenv('DB_USERNAME') ?: 'root');
define('DB_PASS', getenv('DB_PASSWORD') ?: '');

// App Configuration
define('BASE_URL', getenv('APP_URL') ?: 'http://localhost/my-project');
define('APP_NAME', 'My PHP App');

// Directory Paths
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}
if (!defined('PUBLIC_ROOT')) {
    define('PUBLIC_ROOT', dirname(APP_ROOT));
}
if (!defined('SRC_ROOT')) {
    define('SRC_ROOT', APP_ROOT . '/src');
}
if (!defined('TEMPLATE_ROOT')) {
    define('TEMPLATE_ROOT', APP_ROOT . '/templates');
}
