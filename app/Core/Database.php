<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{

    private function __construct() {}
    private function __clone() {}

    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/database.php';

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$instance = new PDO($dsn, $config['user'], $config['password'], $options);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                die("Došlo je do greške pri povezivanju sa bazom podataka. Pokušajte kasnije.");
            }
        }

        return self::$instance;
    }
}
