<?php
/**
 * ==========================================================
 * MRM Inventory Management System (MRM-IT-New)
 * Helper Functions
 * Part 1 - Core Helpers
 * ==========================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Redirect Helper
|--------------------------------------------------------------------------
*/

if (!function_exists('redirect')) {

    function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Redirect Back
|--------------------------------------------------------------------------
*/

if (!function_exists('back')) {

    function back(): void
    {
        $url = $_SERVER['HTTP_REFERER'] ?? APP_URL;
        redirect($url);
    }
}

/*
|--------------------------------------------------------------------------
| HTML Escape
|--------------------------------------------------------------------------
*/

if (!function_exists('e')) {

    function e(?string $value): string
    {
        return htmlspecialchars(
            $value ?? '',
            ENT_QUOTES,
            'UTF-8'
        );
    }
}

/*
|--------------------------------------------------------------------------
| Sanitize Input
|--------------------------------------------------------------------------
*/

if (!function_exists('sanitize')) {

    function sanitize(?string $value): string
    {
        return trim(strip_tags($value ?? ''));
    }
}

/*
|--------------------------------------------------------------------------
| POST Request?
|--------------------------------------------------------------------------
*/

if (!function_exists('isPost')) {

    function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}

/*
|--------------------------------------------------------------------------
| GET Request?
|--------------------------------------------------------------------------
*/

if (!function_exists('isGet')) {

    function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
}

/*
|--------------------------------------------------------------------------
| Is AJAX?
|--------------------------------------------------------------------------
*/

if (!function_exists('isAjax')) {

    function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']);
    }
}

/*
|--------------------------------------------------------------------------
| Current URL
|--------------------------------------------------------------------------
*/

if (!function_exists('currentUrl')) {

    function currentUrl(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }
}

/*
|--------------------------------------------------------------------------
| Currency Formatter
|--------------------------------------------------------------------------
*/

if (!function_exists('currency')) {

    function currency(float $amount): string
    {
        return DEFAULT_CURRENCY . ' ' .
            number_format($amount, 2);
    }
}

/*
|--------------------------------------------------------------------------
| Number Formatter
|--------------------------------------------------------------------------
*/

if (!function_exists('number')) {

    function number(float $number): string
    {
        return number_format($number, 2);
    }
}

/*
|--------------------------------------------------------------------------
| Date Formatter
|--------------------------------------------------------------------------
*/

if (!function_exists('formatDate')) {

    function formatDate(?string $date): string
    {
        if (!$date) {
            return '-';
        }

        return date(
            DATE_FORMAT,
            strtotime($date)
        );
    }
}

/*
|--------------------------------------------------------------------------
| DateTime Formatter
|--------------------------------------------------------------------------
*/

if (!function_exists('formatDateTime')) {

    function formatDateTime(?string $date): string
    {
        if (!$date) {
            return '-';
        }

        return date(
            DATETIME_FORMAT,
            strtotime($date)
        );
    }
}

/*
|--------------------------------------------------------------------------
| Time Ago
|--------------------------------------------------------------------------
*/

if (!function_exists('timeAgo')) {

    function timeAgo(string $datetime): string
    {
        $time = strtotime($datetime);

        $difference = time() - $time;

        if ($difference < 60)
            return "Just now";

        if ($difference < 3600)
            return floor($difference / 60) . " mins ago";

        if ($difference < 86400)
            return floor($difference / 3600) . " hrs ago";

        if ($difference < 604800)
            return floor($difference / 86400) . " days ago";

        return formatDate($datetime);
    }
}

/*
|--------------------------------------------------------------------------
| Flash Message
|--------------------------------------------------------------------------
*/

if (!function_exists('setFlash')) {

    function setFlash(
        string $type,
        string $message
    ): void {

        $_SESSION['flash'] = [

            'type' => $type,

            'message' => $message

        ];
    }
}

/*
|--------------------------------------------------------------------------
| Get Flash Message
|--------------------------------------------------------------------------
*/

if (!function_exists('getFlash')) {

    function getFlash(): ?array
    {
        if (!isset($_SESSION['flash'])) {

            return null;
        }

        $flash = $_SESSION['flash'];

        unset($_SESSION['flash']);

        return $flash;
    }
}

/*
|--------------------------------------------------------------------------
| Has Flash?
|--------------------------------------------------------------------------
*/

if (!function_exists('hasFlash')) {

    function hasFlash(): bool
    {
        return isset($_SESSION['flash']);
    }
}

/*
|--------------------------------------------------------------------------
| Old Form Input
|--------------------------------------------------------------------------
*/

if (!function_exists('old')) {

    function old(
        string $key,
        string $default = ''
    ): string {

        return $_POST[$key] ?? $default;
    }
}

/*
|--------------------------------------------------------------------------
| Debug Helper
|--------------------------------------------------------------------------
*/

if (!function_exists('dd')) {

    function dd($data): void
    {
        echo "<pre>";

        print_r($data);

        echo "</pre>";

        die();
    }
}

/*
|--------------------------------------------------------------------------
| Dump Helper
|--------------------------------------------------------------------------
*/

if (!function_exists('dump')) {

    function dump($data): void
    {
        echo "<pre>";

        print_r($data);

        echo "</pre>";
    }
}
/*
|--------------------------------------------------------------------------
| Generate Random Token
|--------------------------------------------------------------------------
*/

if (!function_exists('generateToken')) {

    function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
}

/*
|--------------------------------------------------------------------------
| Generate Product Code
|--------------------------------------------------------------------------
*/

if (!function_exists('generateProductCode')) {

    function generateProductCode(PDO $db): string
    {
        $stmt = $db->query("
            SELECT product_code
            FROM products
            ORDER BY product_id DESC
            LIMIT 1
        ");

        $last = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$last) {
            return 'PRD000001';
        }

        $number = (int) substr($last['product_code'], 3);

        return 'PRD' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
    }
}

/*
|--------------------------------------------------------------------------
| Generate Customer Code
|--------------------------------------------------------------------------
*/

if (!function_exists('generateCustomerCode')) {

    function generateCustomerCode(PDO $db): string
    {
        $stmt = $db->query("
            SELECT customer_code
            FROM customers
            ORDER BY customer_id DESC
            LIMIT 1
        ");

        $last = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$last) {
            return 'CUS000001';
        }

        $number = (int) substr($last['customer_code'], 3);

        return 'CUS' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
    }
}

/*
|--------------------------------------------------------------------------
| Generate Supplier Code
|--------------------------------------------------------------------------
*/

if (!function_exists('generateSupplierCode')) {

    function generateSupplierCode(PDO $db): string
    {
        $stmt = $db->query("
            SELECT supplier_code
            FROM suppliers
            ORDER BY supplier_id DESC
            LIMIT 1
        ");

        $last = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$last) {
            return 'SUP000001';
        }

        $number = (int) substr($last['supplier_code'], 3);

        return 'SUP' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
    }
}

/*
|--------------------------------------------------------------------------
| Generate Order Number
|--------------------------------------------------------------------------
*/

if (!function_exists('generateOrderNumber')) {

    function generateOrderNumber(PDO $db): string
    {
        $year = date('Y');

        $stmt = $db->prepare("
            SELECT COUNT(*) AS total
            FROM orders
            WHERE YEAR(order_date)=?
        ");

        $stmt->execute([$year]);

        $count = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

        $count++;

        return 'ORD' . $year . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
}

/*
|--------------------------------------------------------------------------
| Generate Username
|--------------------------------------------------------------------------
*/

if (!function_exists('generateUsername')) {

    function generateUsername(string $name): string
    {
        $username = strtolower(trim($name));

        $username = preg_replace('/[^a-z0-9]+/', '.', $username);

        return trim($username, '.');
    }
}

/*
|--------------------------------------------------------------------------
| Password Strength
|--------------------------------------------------------------------------
*/

if (!function_exists('passwordStrong')) {

    function passwordStrong(string $password): bool
    {
        return preg_match(
            '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/',
            $password
        ) === 1;
    }
}

/*
|--------------------------------------------------------------------------
| CSRF Token
|--------------------------------------------------------------------------
*/

if (!function_exists('csrfToken')) {

    function csrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}

/*
|--------------------------------------------------------------------------
| CSRF Input Field
|--------------------------------------------------------------------------
*/

if (!function_exists('csrfField')) {

    function csrfField(): string
    {
        return '<input type="hidden" name="_token" value="' .
            csrfToken() .
            '">';
    }
}

/*
|--------------------------------------------------------------------------
| Verify CSRF
|--------------------------------------------------------------------------
*/

if (!function_exists('verifyCsrf')) {

    function verifyCsrf(): bool
    {
        return isset($_POST['_token'])
            && isset($_SESSION['csrf_token'])
            && hash_equals(
                $_SESSION['csrf_token'],
                $_POST['_token']
            );
    }
}

/*
|--------------------------------------------------------------------------
| Role Checker
|--------------------------------------------------------------------------
*/

if (!function_exists('hasRole')) {

    function hasRole(string $role): bool
    {
        return isset($_SESSION['role_name'])
            && $_SESSION['role_name'] === $role;
    }
}

/*
|--------------------------------------------------------------------------
| Permission Checker
|--------------------------------------------------------------------------
*/

if (!function_exists('can')) {

    function can(string $permission): bool
    {
        if (!isset($_SESSION['permissions'])) {
            return false;
        }

        return in_array(
            $permission,
            $_SESSION['permissions']
        );
    }
}

/*
|--------------------------------------------------------------------------
| Approval Level Checker
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
| Super Admin?
|--------------------------------------------------------------------------
*/

if (!function_exists('isSuperAdmin')) {

    function isSuperAdmin(): bool
    {
        return hasRole('Super Admin');
    }
}

/*
|--------------------------------------------------------------------------
| Finance Admin?
|--------------------------------------------------------------------------
*/

if (!function_exists('isFinanceAdmin')) {

    function isFinanceAdmin(): bool
    {
        return hasRole('Finance Admin');
    }
}

/*
|--------------------------------------------------------------------------
| Inventory Admin?
|--------------------------------------------------------------------------
*/

if (!function_exists('isInventoryAdmin')) {

    function isInventoryAdmin(): bool
    {
        return hasRole('Inventory Admin');
    }
}

/*
|--------------------------------------------------------------------------
| Sales Admin?
|--------------------------------------------------------------------------
*/

if (!function_exists('isSalesAdmin')) {

    function isSalesAdmin(): bool
    {
        return hasRole('Sales Admin');
    }
}

/*
|--------------------------------------------------------------------------
| Logistics Admin?
|--------------------------------------------------------------------------
*/

if (!function_exists('isLogisticsAdmin')) {

    function isLogisticsAdmin(): bool
    {
        return hasRole('Logistics Admin');
    }
}
/*
|--------------------------------------------------------------------------
| Upload Image
|--------------------------------------------------------------------------
*/

if (!function_exists('uploadImage')) {

    function uploadImage(array $file, string $destination): ?string
    {
        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] > MAX_IMAGE_SIZE) {
            return null;
        }

        if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
            return null;
        }

        if (!is_dir($destination)) {
            mkdir($destination, 0775, true);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $filename = uniqid('IMG_', true) . '.' . $extension;

        $target = rtrim($destination, '/') . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return $filename;
        }

        return null;
    }
}

/*
|--------------------------------------------------------------------------
| Delete File
|--------------------------------------------------------------------------
*/

if (!function_exists('deleteFile')) {

    function deleteFile(string $filepath): bool
    {
        return file_exists($filepath) ? unlink($filepath) : false;
    }
}

/*
|--------------------------------------------------------------------------
| Image URL
|--------------------------------------------------------------------------
*/

if (!function_exists('imageUrl')) {

    function imageUrl(?string $filename, string $folder = 'products'): string
    {
        if (empty($filename)) {
            return APP_URL . '/assets/images/no-image.png';
        }

        return APP_URL . '/../assets/uploads/' . $folder . '/' . $filename;
    }
}

/*
|--------------------------------------------------------------------------
| Human File Size
|--------------------------------------------------------------------------
*/

if (!function_exists('fileSizeHuman')) {

    function fileSizeHuman(int $bytes): string
    {
        if ($bytes >= 1073741824)
            return number_format($bytes / 1073741824, 2) . ' GB';

        if ($bytes >= 1048576)
            return number_format($bytes / 1048576, 2) . ' MB';

        if ($bytes >= 1024)
            return number_format($bytes / 1024, 2) . ' KB';

        return $bytes . ' Bytes';
    }
}

/*
|--------------------------------------------------------------------------
| Audit Log
|--------------------------------------------------------------------------
*/

if (!function_exists('auditLog')) {

    function auditLog(
        PDO $db,
        int $userId,
        string $module,
        string $action,
        string $description
    ): void {

        $stmt = $db->prepare("
            INSERT INTO audit_logs
            (
                user_id,
                module,
                action,
                description,
                ip_address
            )
            VALUES
            (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $userId,
            $module,
            $action,
            $description,
            $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);
    }
}

/*
|--------------------------------------------------------------------------
| Notification
|--------------------------------------------------------------------------
*/

if (!function_exists('createNotification')) {

    function createNotification(
        PDO $db,
        int $userId,
        string $title,
        string $message
    ): void {

        $stmt = $db->prepare("
            INSERT INTO notifications
            (
                user_id,
                title,
                message
            )
            VALUES
            (?, ?, ?)
        ");

        $stmt->execute([
            $userId,
            $title,
            $message
        ]);
    }
}

/*
|--------------------------------------------------------------------------
| Get System Setting
|--------------------------------------------------------------------------
*/

if (!function_exists('setting')) {

    function setting(PDO $db, string $key, string $default = ''): string
    {
        $stmt = $db->prepare("
            SELECT setting_value
            FROM system_settings
            WHERE setting_key = ?
            LIMIT 1
        ");

        $stmt->execute([$key]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['setting_value'] ?? $default;
    }
}

/*
|--------------------------------------------------------------------------
| JSON Response
|--------------------------------------------------------------------------
*/

if (!function_exists('jsonResponse')) {

    function jsonResponse(array $data, int $status = 200): never
    {
        http_response_code($status);

        header('Content-Type: application/json');

        echo json_encode($data);

        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Pagination Offset
|--------------------------------------------------------------------------
*/

if (!function_exists('paginationOffset')) {

    function paginationOffset(int $page, int $perPage = DEFAULT_PAGINATION): int
    {
        return max(0, ($page - 1) * $perPage);
    }
}

/*
|--------------------------------------------------------------------------
| Is Active Menu
|--------------------------------------------------------------------------
*/

if (!function_exists('activeMenu')) {

    function activeMenu(string $page): string
    {
        return str_contains($_SERVER['REQUEST_URI'], $page)
            ? 'active'
            : '';
    }
}

/*
|--------------------------------------------------------------------------
| Generate UUID v4
|--------------------------------------------------------------------------
*/

if (!function_exists('uuid')) {

    function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);

        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf(
            '%s%s-%s-%s-%s-%s%s%s',
            str_split(bin2hex($data), 4)
        );
    }
}

/*
|--------------------------------------------------------------------------
| Application Logger
|--------------------------------------------------------------------------
*/

if (!function_exists('systemLog')) {

    function systemLog(string $message): void
    {
        $line = '[' .
            date('Y-m-d H:i:s') .
            '] ' .
            $message .
            PHP_EOL;

        file_put_contents(
            SYSTEM_LOG_FILE,
            $line,
            FILE_APPEND
        );
    }
}

/*
|--------------------------------------------------------------------------
| Error Logger
|--------------------------------------------------------------------------
*/

if (!function_exists('errorLogFile')) {

    function errorLogFile(string $message): void
    {
        $line = '[' .
            date('Y-m-d H:i:s') .
            '] ERROR: ' .
            $message .
            PHP_EOL;

        file_put_contents(
            ERROR_LOG_FILE,
            $line,
            FILE_APPEND
        );
    }
}

/*
|--------------------------------------------------------------------------
| Application Version
|--------------------------------------------------------------------------
*/

if (!function_exists('appVersion')) {

    function appVersion(): string
    {
        return PROJECT_VERSION;
    }
}

/*
|--------------------------------------------------------------------------
| Company Name
|--------------------------------------------------------------------------
*/

if (!function_exists('companyName')) {

    function companyName(): string
    {
        return COMPANY_NAME;
    }
}

/*
|--------------------------------------------------------------------------
| Current Year
|--------------------------------------------------------------------------
*/

if (!function_exists('currentYear')) {

    function currentYear(): string
    {
        return date('Y');
    }
}