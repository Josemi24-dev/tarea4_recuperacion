<?php
declare(strict_types=1);

class Database {
    private static ?PDO $connection = null;

    public static function connect(): PDO {
        if (self::$connection === null) {
            $dsn = 'mysql:host=localhost;dbname=tarea4recuperacion2;charset=utf8mb4';

            try {
                self::$connection = new PDO($dsn, 'root', '');
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Error de conexión: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
