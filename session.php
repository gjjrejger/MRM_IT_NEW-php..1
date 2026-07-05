<?php
/**
 * ==========================================================
 * MRM Inventory Management System
 * Session Management
 * ==========================================================
 */

if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => false,      // Change to true when using HTTPS
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

/**
 * Regenerate session ID periodically
 */
if (!isset($_SESSION['created'])) {

    $_SESSION['created'] = time();

} elseif (time() - $_SESSION['created'] > 1800) {

    session_regenerate_id(true);

    $_SESSION['created'] = time();
}

/**
 * Check whether a user is logged in
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Require login
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {

        $_SESSION['error'] = "Please log in first.";

        header("Location: /MRM-IT-New/public/login.php");

        exit;
    }
}

/**
 * Destroy session
 */
function logout(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"] ?? '',
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    header("Location: /MRM-IT-New/public/login.php");

    exit;
}

/**
 * Logged in user
 */
function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

/**
 * Current user ID
 */
function currentUserId(): ?int
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Current role
 */
function currentRole(): ?string
{
    return $_SESSION['role_name'] ?? null;
}

/**
 * Department
 */
function currentDepartment(): ?string
{
    return $_SESSION['department_name'] ?? null;
}

/**
 * Approval level
 */
function currentApprovalLevel(): ?int
{
    return $_SESSION['approval_level'] ?? null;
}