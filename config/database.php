<!-- Archivo encargado de crear una instancia PDO (PHP Data Objects) 
que se usará para todas las operaciones con la base de datos.-->
<?php
declare(strict_types=1);

class Database {
    private static ?PDO $connection = null; // atributo estático tipo PDO

    // Función estática que devuelve una conexión configurada y lista para usar
    public static function connect(): PDO {
        if (self::$connection === null) {
            // Se define el DSN
            $dsn = 'mysql:host=localhost;dbname=tarea4recuperacion2;charset=utf8mb4';

            try {
                // Crea una nueva conexión con usuario 'root' y contraseña vacía
                self::$connection = new PDO($dsn, 'root', '');  
                // Se configura que cualquier error PDO lanzará excepciones
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) { // falla la conexión
                // Se termina el script con un mensaje de error
                die('Error de conexión: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
