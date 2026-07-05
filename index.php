<?php

/**
 * ==========================================================
 * MRM Inventory Management System
 * Front Controller
 * File: public/index.php
 * ==========================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Load Application
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../app/config/bootstrap.php';

/*
|--------------------------------------------------------------------------
| Redirect User
|--------------------------------------------------------------------------
*/

if (isLoggedIn()) {

    $role = $_SESSION['role_name'] ?? '';

    switch ($role) {

        case ROLE_SUPER_ADMIN:
            redirect(APP_URL . '/dashboard/super_admin.php');
            break;

        case ROLE_FINANCE_ADMIN:
            redirect(APP_URL . '/dashboard/finance.php');
            break;

        case ROLE_INVENTORY_ADMIN:
            redirect(APP_URL . '/dashboard/inventory.php');
            break;

        case ROLE_SALES_ADMIN:
            redirect(APP_URL . '/dashboard/sales.php');
            break;

        case ROLE_LOGISTICS_ADMIN:
            redirect(APP_URL . '/dashboard/logistics.php');
            break;

        default:
            redirect(APP_URL . '/dashboard/customer.php');
            break;
    }
}

/*
|--------------------------------------------------------------------------
| Guest User
|--------------------------------------------------------------------------
*/

redirect(APP_URL . '/login.php');