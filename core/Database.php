<?php
/**
 * Database Singleton - PDO Connection
 * Kết nối database dùng PDO Singleton / PDOシングルトン接続
 */

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        try {
            // Support both SQLite and MySQL based on config
            if (defined('DB_TYPE') && DB_TYPE === 'mysql') {
                // MySQL connection
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=%s',
                    DB_HOST,
                    DB_NAME,
                    defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4'
                );
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            } else {
                // SQLite connection (default)
                $dbPath = defined('DB_PATH') ? DB_PATH : __DIR__ . '/../database/app.db';
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ];
                $this->pdo = new PDO('sqlite:' . $dbPath, null, null, $options);
            }
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // Prevent cloning
    private function __clone() {}
}
