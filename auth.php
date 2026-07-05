<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Authentication Core
 * File: app/core/auth.php
 * ==========================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Check Login Status
|--------------------------------------------------------------------------
*/

if (!function_exists('isLoggedIn')) {

    function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id'])
            && !empty($_SESSION['user_id']);
    }

}

/*
|--------------------------------------------------------------------------
| Get Current User ID
|--------------------------------------------------------------------------
*/

if (!function_exists('userId')) {

    function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

}

/*
|--------------------------------------------------------------------------
| Get Username
|--------------------------------------------------------------------------
*/

if (!function_exists('username')) {

    function username(): string
    {
        return $_SESSION['username'] ?? '';
    }

}

/*
|--------------------------------------------------------------------------
| Get Full Name
|--------------------------------------------------------------------------
*/

if (!function_exists('fullName')) {

    function fullName(): string
    {
        return $_SESSION['full_name'] ?? '';
    }

}

/*
|--------------------------------------------------------------------------
| Get Email
|--------------------------------------------------------------------------
*/

if (!function_exists('userEmail')) {

    function userEmail(): string
    {
        return $_SESSION['email'] ?? '';
    }

}

/*
|--------------------------------------------------------------------------
| Get Role
|--------------------------------------------------------------------------
*/

if (!function_exists('userRole')) {

    function userRole(): string
    {
        return $_SESSION['role_name'] ?? '';
    }

}

/*
|--------------------------------------------------------------------------
| Get Approval Level
|--------------------------------------------------------------------------
*/

if (!function_exists('approvalLevel')) {

    function approvalLevel(): int
    {
        return (int) ($_SESSION['approval_level'] ?? 0);
    }

}
/*
|--------------------------------------------------------------------------
| Login User
|--------------------------------------------------------------------------
|
| Stores authenticated user information in the session.
|
*/

if (!function_exists('loginUser')) {

    function loginUser(array $user): void
    {
        // Prevent Session Fixation
        session_regenerate_id(true);

        $_SESSION['user_id']          = (int) $user['user_id'];
        $_SESSION['username']         = $user['username'];
        $_SESSION['email']            = $user['email'];

        $_SESSION['first_name']       = $user['first_name'];
        $_SESSION['last_name']        = $user['last_name'];
        $_SESSION['full_name']        = trim(
            $user['first_name'] . ' ' . $user['last_name']
        );

        $_SESSION['role_id']          = $user['role_id'];
        $_SESSION['role_name']        = $user['role_name'];

        $_SESSION['approval_level']   = (int) $user['approval_level'];

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $_SESSION['permissions'] = $user['permissions'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Session Security
        |--------------------------------------------------------------------------
        */

        $_SESSION['logged_in'] = true;

        $_SESSION['login_time'] = time();

        $_SESSION['last_activity'] = time();

        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? '';

        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
    }

}

/*
|--------------------------------------------------------------------------
| Logout User
|--------------------------------------------------------------------------
*/

if (!function_exists('logoutUser')) {

    function logoutUser(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(

                session_name(),

                '',

                time() - 3600,

                $params['path'],

                $params['domain'],

                $params['secure'],

                $params['httponly']

            );

        }

        session_destroy();
    }

}

/*
|--------------------------------------------------------------------------
| Update Last Activity
|--------------------------------------------------------------------------
*/

if (!function_exists('updateLastActivity')) {

    function updateLastActivity(): void
    {
        $_SESSION['last_activity'] = time();
    }

}

/*
|--------------------------------------------------------------------------
| Check Session Timeout
|--------------------------------------------------------------------------
*/

if (!function_exists('sessionExpired')) {

    function sessionExpired(): bool
    {
        if (!isset($_SESSION['last_activity'])) {

            return false;

        }

        return (time() - $_SESSION['last_activity'])
            > SESSION_TIMEOUT;
    }

}

/*
|--------------------------------------------------------------------------
| Validate Session
|--------------------------------------------------------------------------
|
| Checks:
| - Login
| - Timeout
| - IP Address
| - Browser
|
*/

if (!function_exists('validateSession')) {

    function validateSession(): bool
    {
        if (!isLoggedIn()) {

            return false;

        }

        if (sessionExpired()) {

            logoutUser();

            return false;

        }

        if (
            ($_SESSION['ip_address'] ?? '') !==
            ($_SERVER['REMOTE_ADDR'] ?? '')
        ) {

            logoutUser();

            return false;

        }

        if (
            ($_SESSION['user_agent'] ?? '') !==
            ($_SERVER['HTTP_USER_AGENT'] ?? '')
        ) {

            logoutUser();

            return false;

        }

        updateLastActivity();

        return true;
    }

}
/*
|--------------------------------------------------------------------------
| Require Login
|--------------------------------------------------------------------------
|
| Redirect guests to the login page.
|
*/

if (!function_exists('requireLogin')) {

    function requireLogin(): void
    {
        if (!validateSession()) {

            $_SESSION['flash'] = [

                'type'    => 'warning',

                'message' => 'Please log in to continue.'

            ];

            redirect(APP_URL . '/public/login.php');

            exit;

        }
    }

}

/*
|--------------------------------------------------------------------------
| Require Guest
|--------------------------------------------------------------------------
|
| Redirect authenticated users away from login/register pages.
|
*/

if (!function_exists('requireGuest')) {

    function requireGuest(): void
    {
        if (isLoggedIn()) {

            redirect(APP_URL . '/dashboard/dashboard.php');

            exit;

        }
    }

}

/*
|--------------------------------------------------------------------------
| Get Current User
|--------------------------------------------------------------------------
*/

if (!function_exists('currentUser')) {

    function currentUser(): array
    {
        if (!isLoggedIn()) {

            return [];

        }

        return [

            'user_id' => $_SESSION['user_id'] ?? null,

            'username' => $_SESSION['username'] ?? '',

            'email' => $_SESSION['email'] ?? '',

            'first_name' => $_SESSION['first_name'] ?? '',

            'last_name' => $_SESSION['last_name'] ?? '',

            'full_name' => $_SESSION['full_name'] ?? '',

            'role_id' => $_SESSION['role_id'] ?? null,

            'role_name' => $_SESSION['role_name'] ?? '',

            'approval_level' => $_SESSION['approval_level'] ?? 0,

            'permissions' => $_SESSION['permissions'] ?? []

        ];

    }

}

/*
|--------------------------------------------------------------------------
| User Initials
|--------------------------------------------------------------------------
*/

if (!function_exists('userInitials')) {

    function userInitials(): string
    {
        $first = $_SESSION['first_name'] ?? '';

        $last = $_SESSION['last_name'] ?? '';

        $initials = '';

        if ($first !== '') {

            $initials .= strtoupper(substr($first, 0, 1));

        }

        if ($last !== '') {

            $initials .= strtoupper(substr($last, 0, 1));

        }

        return $initials ?: 'U';
    }

}

/*
|--------------------------------------------------------------------------
| Account Status
|--------------------------------------------------------------------------
|
| Future-proof helper. Can later check:
| - Active
| - Suspended
| - Locked
| - Disabled
|
*/

if (!function_exists('isAccountActive')) {

    function isAccountActive(): bool
    {
        return ($_SESSION['account_status'] ?? 'Active') === 'Active';
    }

}

/*
|--------------------------------------------------------------------------
| Flash Authentication Messages
|--------------------------------------------------------------------------
*/

if (!function_exists('authMessage')) {

    function authMessage(string $type, string $message): void
    {
        $_SESSION['flash'] = [

            'type' => $type,

            'message' => $message

        ];
    }

}

/*
|--------------------------------------------------------------------------
| Remember Me (Foundation)
|--------------------------------------------------------------------------
|
| Placeholder for future implementation.
|
*/

if (!function_exists('rememberUser')) {

    function rememberUser(int $userId): void
    {
        // Future implementation:
        // Generate secure token
        // Save hashed token in database
        // Store cookie in browser
    }

}

/*
|--------------------------------------------------------------------------
| Authentication Middleware
|--------------------------------------------------------------------------
*/

if (!function_exists('auth')) {

    function auth(): void
    {
        requireLogin();
    }

}

/*
|--------------------------------------------------------------------------
| Guest Middleware
|--------------------------------------------------------------------------
*/

if (!function_exists('guest')) {

    function guest(): void
    {
        requireGuest();
    }

}

/*
|--------------------------------------------------------------------------
| Authentication Bootstrap
|--------------------------------------------------------------------------
|
| Automatically validate authenticated sessions.
|
*/

if (isLoggedIn()) {

    validateSession();

}