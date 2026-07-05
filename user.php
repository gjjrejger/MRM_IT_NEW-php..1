<?php

/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * User Model
 * ----------------------------------------------------------
 * Handles all user-related database operations.
 * ==========================================================
 */

declare(strict_types=1);

class User
{
    /**
     * Database connection
     *
     * @var PDO
     */
    private PDO $db;

    /**
     * Constructor
     *
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /*
    |--------------------------------------------------------------------------
    | Find User by ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id): ?array
    {
        $sql = "
            SELECT
                u.*,
                r.role_name,
                r.approval_level
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.role_id
            WHERE u.user_id = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | Find User by Username
    |--------------------------------------------------------------------------
    */

    public function findByUsername(string $username): ?array
    {
        $sql = "
            SELECT
                u.*,
                r.role_name,
                r.approval_level
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.role_id
            WHERE u.username = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | Find User by Email
    |--------------------------------------------------------------------------
    */

    public function findByEmail(string $email): ?array
    {
        $sql = "
            SELECT
                u.*,
                r.role_name,
                r.approval_level
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.role_id
            WHERE u.email = ?
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | Username Exists?
    |--------------------------------------------------------------------------
    */

    public function usernameExists(string $username): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM users
            WHERE username = ?
        ");

        $stmt->execute([$username]);

        return (bool)$stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | Email Exists?
    |--------------------------------------------------------------------------
    */

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM users
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        return (bool)$stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | Get User by Employee Number
    |--------------------------------------------------------------------------
    */

    public function findByEmployeeNumber(string $employeeNo): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                u.*,
                r.role_name,
                r.approval_level
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.role_id
            WHERE u.employee_number = ?
            LIMIT 1
        ");

        $stmt->execute([$employeeNo]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | Get All Users
    |--------------------------------------------------------------------------
    */

    public function getAllUsers(): array
    {
        $sql = "
            SELECT
                u.user_id,
                u.first_name,
                u.last_name,
                u.username,
                u.email,
                u.phone,
                u.status,
                u.last_login,
                r.role_name
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.role_id
            ORDER BY u.first_name ASC
        ";

        return $this->db
            ->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | Count Users
    |--------------------------------------------------------------------------
    */

    public function countUsers(): int
    {
        return (int)$this->db
            ->query("SELECT COUNT(*) FROM users")
            ->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | Count Active Users
    |--------------------------------------------------------------------------
    */

    public function countActiveUsers(): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM users
            WHERE status='Active'
        ");

        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | Count Inactive Users
    |--------------------------------------------------------------------------
    */

    public function countInactiveUsers(): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*)
            FROM users
            WHERE status='Inactive'
        ");

        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    /*
    |--------------------------------------------------------------------------
    | Search Users
    |--------------------------------------------------------------------------
    */

    public function search(string $keyword): array
    {
        $keyword = "%{$keyword}%";

        $sql = "
            SELECT
                u.*,
                r.role_name
            FROM users u
            LEFT JOIN roles r
                ON u.role_id = r.role_id
            WHERE
                u.first_name LIKE ?
                OR u.last_name LIKE ?
                OR u.username LIKE ?
                OR u.email LIKE ?
            ORDER BY u.first_name
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $keyword,
            $keyword,
            $keyword,
            $keyword
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Users by Role
    |--------------------------------------------------------------------------
    */

    public function getUsersByRole(int $roleId): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE role_id = ?
            ORDER BY first_name
        ");

        $stmt->execute([$roleId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Recently Logged-in Users
    |--------------------------------------------------------------------------
    */

    public function recentUsers(int $limit = 10): array
    {
        $stmt = $this->db->prepare("
            SELECT
                first_name,
                last_name,
                username,
                last_login
            FROM users
            ORDER BY last_login DESC
            LIMIT ?
        ");

        $stmt->bindValue(1, $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
/*
|--------------------------------------------------------------------------
| Authenticate User
|--------------------------------------------------------------------------
| Verifies username/email and password.
| Returns user data on success or null on failure.
|--------------------------------------------------------------------------
*/

public function authenticate(string $login, string $password): ?array
{
    $sql = "
        SELECT
            u.*,
            r.role_name,
            r.approval_level
        FROM users u
        INNER JOIN roles r
            ON u.role_id = r.role_id
        WHERE
            u.username = :login
            OR u.email = :login
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);

    $stmt->execute([
        ':login' => $login
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return null;
    }

    if (!password_verify($password, $user['password'])) {
        return null;
    }

    return $user;
}

/*
|--------------------------------------------------------------------------
| Is User Active?
|--------------------------------------------------------------------------
*/

public function isActive(array $user): bool
{
    return ($user['status'] ?? '') === USER_ACTIVE;
}

/*
|--------------------------------------------------------------------------
| Is User Locked?
|--------------------------------------------------------------------------
*/

public function isLocked(array $user): bool
{
    return ($user['status'] ?? '') === USER_LOCKED;
}

/*
|--------------------------------------------------------------------------
| Update Last Login
|--------------------------------------------------------------------------
*/

public function updateLastLogin(int $userId): bool
{
    $stmt = $this->db->prepare("
        UPDATE users
        SET
            last_login = NOW()
        WHERE user_id = ?
    ");

    return $stmt->execute([$userId]);
}

/*
|--------------------------------------------------------------------------
| Increment Failed Login Attempts
|--------------------------------------------------------------------------
*/

public function incrementFailedAttempts(int $userId): bool
{
    $stmt = $this->db->prepare("
        UPDATE users
        SET failed_attempts = failed_attempts + 1
        WHERE user_id = ?
    ");

    return $stmt->execute([$userId]);
}

/*
|--------------------------------------------------------------------------
| Reset Failed Login Attempts
|--------------------------------------------------------------------------
*/

public function resetFailedAttempts(int $userId): bool
{
    $stmt = $this->db->prepare("
        UPDATE users
        SET failed_attempts = 0
        WHERE user_id = ?
    ");

    return $stmt->execute([$userId]);
}

/*
|--------------------------------------------------------------------------
| Lock User Account
|--------------------------------------------------------------------------
*/

public function lockAccount(int $userId): bool
{
    $stmt = $this->db->prepare("
        UPDATE users
        SET status = ?
        WHERE user_id = ?
    ");

    return $stmt->execute([
        USER_LOCKED,
        $userId
    ]);
}

/*
|--------------------------------------------------------------------------
| Unlock User Account
|--------------------------------------------------------------------------
*/

public function unlockAccount(int $userId): bool
{
    $stmt = $this->db->prepare("
        UPDATE users
        SET
            status = ?,
            failed_attempts = 0
        WHERE user_id = ?
    ");

    return $stmt->execute([
        USER_ACTIVE,
        $userId
    ]);
}

/*
|--------------------------------------------------------------------------
| Get User Permissions
|--------------------------------------------------------------------------
*/

public function getPermissions(int $roleId): array
{
    $stmt = $this->db->prepare("
        SELECT permission_name
        FROM permissions
        WHERE role_id = ?
        ORDER BY permission_name
    ");

    $stmt->execute([$roleId]);

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/*
|--------------------------------------------------------------------------
| Get Approval Level
|--------------------------------------------------------------------------
*/

public function getApprovalLevel(int $roleId): int
{
    $stmt = $this->db->prepare("
        SELECT approval_level
        FROM roles
        WHERE role_id = ?
        LIMIT 1
    ");

    $stmt->execute([$roleId]);

    return (int) $stmt->fetchColumn();
}

/*
|--------------------------------------------------------------------------
| Change Password
|--------------------------------------------------------------------------
*/

public function changePassword(
    int $userId,
    string $newPassword
): bool {

    $hash = password_hash(
        $newPassword,
        PASSWORD_HASH_ALGO,
        [
            'cost' => PASSWORD_COST
        ]
    );

    $stmt = $this->db->prepare("
        UPDATE users
        SET password = ?
        WHERE user_id = ?
    ");

    return $stmt->execute([
        $hash,
        $userId
    ]);
}

/*
|--------------------------------------------------------------------------
| Update Profile
|--------------------------------------------------------------------------
*/

public function updateProfile(
    int $userId,
    array $data
): bool {

    $stmt = $this->db->prepare("
        UPDATE users
        SET
            first_name = ?,
            last_name = ?,
            email = ?,
            phone = ?
        WHERE user_id = ?
    ");

    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $data['phone'],
        $userId
    ]);
}

/*
|--------------------------------------------------------------------------
| Get Dashboard User Information
|--------------------------------------------------------------------------
*/

public function getDashboardUser(int $userId): ?array
{
    $stmt = $this->db->prepare("
        SELECT
            u.user_id,
            u.first_name,
            u.last_name,
            u.username,
            u.email,
            u.phone,
            u.profile_image,
            u.last_login,
            r.role_name
        FROM users u
        INNER JOIN roles r
            ON u.role_id = r.role_id
        WHERE u.user_id = ?
        LIMIT 1
    ");

    $stmt->execute([$userId]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: null;
}