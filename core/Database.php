<?php 
use Core\Env;

class Database
{
    public static function connect()
    {
        try {
            return new PDO(
                'mysql:host=' . Env::get('DB_HOST') . ';dbname=' . Env::get('DB_NAME') . ';charset=utf8mb4',
                Env::get('DB_USER'),
                Env::get('DB_PASS'),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("DB Error: " . $e->getMessage());
        }
    }
}