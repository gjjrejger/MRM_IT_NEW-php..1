<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Application Configuration
 * File: app/config/config.php
 * ==========================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Application Information
|--------------------------------------------------------------------------
*/

define('APP_NAME', 'Mabati Rolling Mills Inventory Management System');

define('APP_SHORT_NAME', 'MRM-IT');

define('APP_VERSION', '1.0.0');

define('APP_ENV', 'development'); // development | production

/*
|--------------------------------------------------------------------------
| Base URL
|--------------------------------------------------------------------------
|
| Change this when deploying.
|
*/

define('APP_URL', 'http://localhost/MRM-IT-New');

/*
|--------------------------------------------------------------------------
| Company Information
|--------------------------------------------------------------------------
*/

define('COMPANY_NAME', 'Mabati Rolling Mills Limited');

define('COMPANY_EMAIL', 'info@mrm.co.ke');

define('COMPANY_PHONE', '+254700000000');

define('COMPANY_COUNTRY', 'Kenya');

/*
|--------------------------------------------------------------------------
| Default Timezone
|--------------------------------------------------------------------------
*/

define('APP_TIMEZONE', 'Africa/Nairobi');

/*
|--------------------------------------------------------------------------
| Session Configuration
|--------------------------------------------------------------------------
*/

define('SESSION_NAME', 'MRM_SESSION');

define('SESSION_TIMEOUT', 1800); // 30 minutes

define('REMEMBER_ME_DAYS', 30);

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

define('PASSWORD_ALGO', PASSWORD_DEFAULT);

define('PASSWORD_COST', 12);

define('CSRF_TOKEN_NAME', '_token');

define('LOGIN_MAX_ATTEMPTS', 5);

define('LOGIN_LOCKOUT_MINUTES', 15);

/*
|--------------------------------------------------------------------------
| Upload Configuration
|--------------------------------------------------------------------------
*/

define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');

define('PROFILE_UPLOAD_PATH', UPLOAD_PATH . '/profiles');

define('PRODUCT_UPLOAD_PATH', UPLOAD_PATH . '/products');

define('REPORT_UPLOAD_PATH', UPLOAD_PATH . '/reports');

define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

define('DEFAULT_PAGE_SIZE', 20);

define('MAX_PAGE_SIZE', 100);

/*
|--------------------------------------------------------------------------
| Currency
|--------------------------------------------------------------------------
*/

define('DEFAULT_CURRENCY', 'KES');

define('CURRENCY_SYMBOL', 'KSh');

/*
|--------------------------------------------------------------------------
| Date Formats
|--------------------------------------------------------------------------
*/

define('DATE_FORMAT', 'd/m/Y');

define('DATETIME_FORMAT', 'd/m/Y H:i:s');

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/

define('DEFAULT_REORDER_LEVEL', 10);

define('LOW_STOCK_ALERT', true);

/*
|--------------------------------------------------------------------------
| Approval Workflow
|--------------------------------------------------------------------------
*/

define('APPROVAL_ENABLED', true);

define('MAX_APPROVAL_LEVEL', 5);

/*
|--------------------------------------------------------------------------
| Audit Logs
|--------------------------------------------------------------------------
*/

define('AUDIT_LOG_ENABLED', true);

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

define('DASHBOARD_REFRESH_SECONDS', 60);

/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/

define('ENABLE_PDF_EXPORT', true);

define('ENABLE_EXCEL_EXPORT', true);

define('ENABLE_CSV_EXPORT', true);

/*
|--------------------------------------------------------------------------
| Email
|--------------------------------------------------------------------------
|
| Configure these later when SMTP is implemented.
|
*/

define('MAIL_HOST', '');

define('MAIL_PORT', 587);

define('MAIL_USERNAME', '');

define('MAIL_PASSWORD', '');

define('MAIL_ENCRYPTION', 'tls');

define('MAIL_FROM_NAME', APP_NAME);

define('MAIL_FROM_EMAIL', '');

/*
|--------------------------------------------------------------------------
| Logging
|--------------------------------------------------------------------------
*/

define('LOG_PATH', ROOT_PATH . '/storage/logs');

define('ERROR_LOG_FILE', LOG_PATH . '/application.log');

/*
|--------------------------------------------------------------------------
| Development Mode
|--------------------------------------------------------------------------
*/

if (APP_ENV === 'development') {

    ini_set('display_errors', '1');

    ini_set('display_startup_errors', '1');

    error_reporting(E_ALL);

} else {

    ini_set('display_errors', '0');

    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

}

/*
|--------------------------------------------------------------------------
| Create Required Directories
|--------------------------------------------------------------------------
*/

$directories = [

    UPLOAD_PATH,
    PROFILE_UPLOAD_PATH,
    PRODUCT_UPLOAD_PATH,
    REPORT_UPLOAD_PATH,
    LOG_PATH

];

foreach ($directories as $directory) {

    if (!is_dir($directory)) {

        @mkdir($directory, 0755, true);

    }

}