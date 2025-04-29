<?php 
namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {} // Prevent instantiation
    private function __clone() {}     // Prevent cloning
    private function __wakeup() {}    // Prevent unserialization

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . Env::get('DB_HOST') . ';dbname=' . Env::get('DB_NAME') . ';charset=utf8mb4',
                    Env::get('DB_USER'),
                    Env::get('DB_PASS'),
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("DB Error: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
