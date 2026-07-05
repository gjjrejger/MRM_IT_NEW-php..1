<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Application Bootstrap
 * File: app/config/bootstrap.php
 * ==========================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Error Reporting
|--------------------------------------------------------------------------
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Africa/Nairobi');

/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {

    session_start();

}

/*
|--------------------------------------------------------------------------
| Base Paths
|--------------------------------------------------------------------------
*/

define('ROOT_PATH', dirname(__DIR__, 2));

define('APP_PATH', ROOT_PATH . '/app');

define('CONFIG_PATH', APP_PATH . '/config');

define('HELPER_PATH', APP_PATH . '/helpers');

define('MODEL_PATH', APP_PATH . '/models');

define('CONTROLLER_PATH', APP_PATH . '/controllers');

define('VIEW_PATH', ROOT_PATH . '/views');

/*
|--------------------------------------------------------------------------
| Load Core Configuration
|--------------------------------------------------------------------------
*/

require_once CONFIG_PATH . '/constants.php';

require_once CONFIG_PATH . '/config.php';

require_once CONFIG_PATH . '/database.php';

/*
|--------------------------------------------------------------------------
| Load Helpers
|--------------------------------------------------------------------------
*/

require_once HELPER_PATH . '/functions.php';

require_once HELPER_PATH . '/permission_helper.php';

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require_once APP_PATH . '/core/auth.php';

/*
|--------------------------------------------------------------------------
| Configuration Arrays
|--------------------------------------------------------------------------
*/

$menu = require CONFIG_PATH . '/menu.php';

/*
|--------------------------------------------------------------------------
| Optional Configuration Files
|--------------------------------------------------------------------------
|
| These are loaded only if they exist so the application
| remains functional while the project is still being built.
|
*/

$permissions = [];

if (file_exists(CONFIG_PATH . '/permissions.php')) {

    $permissions = require CONFIG_PATH . '/permissions.php';

}

$routes = [];

if (file_exists(CONFIG_PATH . '/routes.php')) {

    $routes = require CONFIG_PATH . '/routes.php';

}

$dashboard = [];

if (file_exists(CONFIG_PATH . '/dashboard.php')) {

    $dashboard = require CONFIG_PATH . '/dashboard.php';

}

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

try {

    $database = new Database();

    $db = $database->connect();

} catch (Throwable $e) {

    exit(
        '<h2>Database Connection Failed</h2>
        <p>' . htmlspecialchars($e->getMessage()) . '</p>'
    );

}

/*
|--------------------------------------------------------------------------
| Global Application Variables
|--------------------------------------------------------------------------
*/

$GLOBALS['db'] = $db;

$GLOBALS['menu'] = $menu;

$GLOBALS['permissions'] = $permissions;

$GLOBALS['routes'] = $routes;

$GLOBALS['dashboard'] = $dashboard;

/*
|--------------------------------------------------------------------------
| Application Version
|--------------------------------------------------------------------------
*/

define('APP_VERSION', '1.0.0');

/*
|--------------------------------------------------------------------------
| Security Headers
|--------------------------------------------------------------------------
*/

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');

/*
|--------------------------------------------------------------------------
| CSRF Token
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

}