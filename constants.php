<?php
/**
 * ==========================================================
 * MRM Inventory Management System
 * Global Constants
 * File: app/config/constants.php
 * ==========================================================
 */

if (!defined('APP_NAME')) {
    define('APP_NAME', 'MRM Inventory Management System');
}

if (!defined('APP_VERSION')) {
    define('APP_VERSION', '1.0.0');
}

if (!defined('COMPANY_NAME')) {
    define('COMPANY_NAME', 'Mabati Rolling Mills Limited');
}

if (!defined('COMPANY_SHORT_NAME')) {
    define('COMPANY_SHORT_NAME', 'MRM');
}

if (!defined('COMPANY_EMAIL')) {
    define('COMPANY_EMAIL', 'info@mrm.co.ke');
}

if (!defined('COMPANY_PHONE')) {
    define('COMPANY_PHONE', '+254 700 000 000');
}

if (!defined('TIMEZONE')) {
    define('TIMEZONE', 'Africa/Nairobi');
}

date_default_timezone_set(TIMEZONE);

/*
|--------------------------------------------------------------------------
| Currency
|--------------------------------------------------------------------------
*/

define('DEFAULT_CURRENCY', 'KES');

/*
|--------------------------------------------------------------------------
| URLs
|--------------------------------------------------------------------------
*/

define('BASE_URL', 'http://localhost/MRM-IT-New/public');

define('APP_PATH', dirname(__DIR__));

define('PUBLIC_PATH', dirname(__DIR__, 2) . '/public');

define('ROOT_PATH', dirname(__DIR__, 2));

/*
|--------------------------------------------------------------------------
| Upload Directories
|--------------------------------------------------------------------------
*/

define('UPLOADS_PATH', ROOT_PATH . '/assets/uploads/');

define('PRODUCT_IMAGE_PATH', UPLOADS_PATH . 'products/');

define('USER_IMAGE_PATH', UPLOADS_PATH . 'users/');

define('REPORT_PATH', UPLOADS_PATH . 'reports/');

/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/

define('SESSION_TIMEOUT', 1800); // 30 minutes

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

define('DEFAULT_PAGE_SIZE', 10);

/*
|--------------------------------------------------------------------------
| Stock
|--------------------------------------------------------------------------
*/

define('LOW_STOCK_WARNING', 10);

/*
|--------------------------------------------------------------------------
| Password Policy
|--------------------------------------------------------------------------
*/

define('MIN_PASSWORD_LENGTH', 8);

/*
|--------------------------------------------------------------------------
| User Roles
|--------------------------------------------------------------------------
*/

const ROLE_SUPER_ADMIN = 'Super Admin';

const ROLE_FINANCE_ADMIN = 'Finance Admin';

const ROLE_INVENTORY_ADMIN = 'Inventory Admin';

const ROLE_SALES_ADMIN = 'Sales Admin';

const ROLE_LOGISTICS_ADMIN = 'Logistics Admin';

const ROLE_CUSTOMER = 'Customer';

/*
|--------------------------------------------------------------------------
| Order Status
|--------------------------------------------------------------------------
*/

const ORDER_PENDING = 'Pending';

const ORDER_APPROVED = 'Approved';

const ORDER_PROCESSING = 'Processing';

const ORDER_READY = 'Ready';

const ORDER_DISPATCHED = 'Dispatched';

const ORDER_DELIVERED = 'Delivered';

const ORDER_CANCELLED = 'Cancelled';

/*
|--------------------------------------------------------------------------
| Payment Status
|--------------------------------------------------------------------------
*/

const PAYMENT_PENDING = 'Pending';

const PAYMENT_PARTIAL = 'Partially Paid';

const PAYMENT_PAID = 'Paid';

/*
|--------------------------------------------------------------------------
| Approval Status
|--------------------------------------------------------------------------
*/

const APPROVAL_PENDING = 'Pending';

const APPROVAL_APPROVED = 'Approved';

const APPROVAL_REJECTED = 'Rejected';

const APPROVAL_CANCELLED = 'Cancelled';

/*
|--------------------------------------------------------------------------
| Product Status
|--------------------------------------------------------------------------
*/

const PRODUCT_ACTIVE = 'Active';

const PRODUCT_INACTIVE = 'Inactive';

/*
|--------------------------------------------------------------------------
| User Status
|--------------------------------------------------------------------------
*/

const USER_ACTIVE = 'Active';

const USER_INACTIVE = 'Inactive';

const USER_LOCKED = 'Locked';

/*
|--------------------------------------------------------------------------
| Report Types
|--------------------------------------------------------------------------
*/

const REPORT_DAILY = 'Daily';

const REPORT_WEEKLY = 'Weekly';

const REPORT_MONTHLY = 'Monthly';

const REPORT_YEARLY = 'Yearly';

/*
|--------------------------------------------------------------------------
| Flash Messages
|--------------------------------------------------------------------------
*/

const MSG_SUCCESS = 'success';

const MSG_ERROR = 'error';

const MSG_WARNING = 'warning';

const MSG_INFO = 'info';

/*
|--------------------------------------------------------------------------
| System Information
|--------------------------------------------------------------------------
*/

define('DEVELOPER_NAME', 'MRM Inventory Project');

define('COPYRIGHT', '© ' . date('Y') . ' Mabati Rolling Mills Limited. All Rights Reserved.');