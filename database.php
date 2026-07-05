<?php
/**
 * ===========================================================
 * MRM Inventory & Order Management System (MRM-IT-New)
 * -----------------------------------------------------------
 * File: database.php
 * Purpose: Database Connection using PDO
 * Version: 2.0.0
 * ===========================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/constants.php';

class Database
{
    /**
     * Database Credentials
     */
    private const HOST = 'localhost';
    private const DBNAME = 'mrm_inventory';
    private const USERNAME = 'root';
    private const PASSWORD = '';

    /**
     * PDO Instance
     */
    private ?PDO $connection = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Create Database Connection
     */
    private function connect(): void
    {
        try {

            $dsn = "mysql:host=" . self::HOST .
                   ";dbname=" . self::DBNAME .
                   ";charset=utf8mb4";

            $this->connection = new PDO(
                $dsn,
                self::USERNAME,
                self::PASSWORD,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_PERSISTENT         => false
                ]
            );

        } catch (PDOException $e) {

            $this->databaseError($e);

        }
    }

    /**
     * Return PDO Connection
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Test Database Connection
     */
    public function isConnected(): bool
    {
        return $this->connection instanceof PDO;
    }

    /**
     * Database Error Handler
     */
    private function databaseError(PDOException $e): void
    {
        if (APP_ENV === 'development') {

            die("
                <h2>Database Connection Failed</h2>
                <strong>Error:</strong> {$e->getMessage()}
            ");

        }

        die("A database connection error occurred.");
    }
}

/**
 * ===========================================================
 * Create Global Database Object
 * ===========================================================
 */

try {

    $database = new Database();

    $pdo = $database->getConnection();

} catch (Exception $e) {

    die($e->getMessage());

}
