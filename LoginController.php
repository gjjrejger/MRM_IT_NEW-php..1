<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Login Controller
 * ==========================================================
 */

declare(strict_types=1);

require_once APP_PATH . '/models/User.php';

class LoginController
{
    private PDO $db;
    private User $userModel;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    /**
     * Display Login Page
     */
    public function index(): void
    {
        if (isLoggedIn()) {
            $this->redirectDashboard();
        }

        require ROOT_PATH . '/views/auth/login.view.php';
    }

    /**
     * Process Login
     */
    public function login(): void
    {
        if (!isPost()) {
            redirect(APP_URL . '/login.php');
        }

        // CSRF Protection
        if (!verifyCsrf()) {

            setFlash(MSG_ERROR, 'Invalid security token.');

            redirect(APP_URL . '/login.php');
        }

        $login = sanitize($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($login === '' || $password === '') {

            setFlash(MSG_ERROR, 'Username/email and password are required.');

            redirect(APP_URL . '/login.php');
        }

        // Authenticate User
        $user = $this->userModel->authenticate($login, $password);

        if (!$user) {

            setFlash(MSG_ERROR, 'Invalid username or password.');

            redirect(APP_URL . '/login.php');
        }

        // Account Status Checks
        if ($this->userModel->isLocked($user)) {

            setFlash(MSG_ERROR,
                'Your account has been locked. Please contact the System Administrator.'
            );

            redirect(APP_URL . '/login.php');
        }

        if (!$this->userModel->isActive($user)) {

            setFlash(MSG_ERROR,
                'Your account is inactive.'
            );

            redirect(APP_URL . '/login.php');
        }

        // Reset failed attempts
        $this->userModel->resetFailedAttempts($user['user_id']);

        // Update last login
        $this->userModel->updateLastLogin($user['user_id']);

        // Load Permissions
        $permissions = $this->userModel->getPermissions($user['role_id']);

        // Session
        session_regenerate_id(true);

        $_SESSION['logged_in'] = true;

        $_SESSION['user_id'] = $user['user_id'];

        $_SESSION['employee_number'] = $user['employee_number'];

        $_SESSION['username'] = $user['username'];

        $_SESSION['first_name'] = $user['first_name'];

        $_SESSION['last_name'] = $user['last_name'];

        $_SESSION['full_name'] =
            $user['first_name'] . ' ' . $user['last_name'];

        $_SESSION['email'] = $user['email'];

        $_SESSION['role_id'] = $user['role_id'];

        $_SESSION['role_name'] = $user['role_name'];

        $_SESSION['approval_level'] = $user['approval_level'];

        $_SESSION['permissions'] = $permissions;

        $_SESSION['last_activity'] = time();

        // Audit Log (optional)
        if (function_exists('auditLog')) {

            auditLog(
                $this->db,
                $user['user_id'],
                'Authentication',
                'Login',
                'User logged into the system'
            );
        }

        setFlash(
            MSG_SUCCESS,
            'Welcome back, ' . $user['first_name'] . '!'
        );

        $this->redirectDashboard();
    }

    /**
     * Redirect User Based On Role
     */
    private function redirectDashboard(): void
    {
        switch ($_SESSION['role_name']) {

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
}