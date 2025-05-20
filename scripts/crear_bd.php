<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

$db = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Crear base de datos si no existe
$db->exec("CREATE DATABASE IF NOT EXISTS tarea4recuperacion2 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
$db->exec("USE tarea4recuperacion2");

$db = Database::connect();

try {
    // Crear tabla usuarios
    $db->exec("
        DROP TABLE IF EXISTS usuarios;
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(50),
            apellidos VARCHAR(50),
            nick VARCHAR(30) UNIQUE,
            email VARCHAR(100) UNIQUE,
            fecha_nacimiento DATE,
            password VARCHAR(255),
            saldo DECIMAL(10,2)
        );
    ");

    // Insertar 100 usuarios aleatorios
    $stmt = $db->prepare("
        INSERT INTO usuarios (nombre, apellidos, nick, email, fecha_nacimiento, password, saldo)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    for ($i = 1; $i <= 100; $i++) {
        $nombre = "Usuario$i";
        $apellidos = "Apellidos$i";
        $nick = "user$i";
        $email = "user$i@example.com";
        $fecha = date('Y-m-d', rand(strtotime('1980-01-01'), strtotime('2005-12-31')));
        $pass = password_hash("clave$i", PASSWORD_DEFAULT);
        $saldo = rand(10, 200);

        $stmt->execute([$nombre, $apellidos, $nick, $email, $fecha, $pass, $saldo]);
    }

    echo "✅ Base de datos y 100 usuarios creados correctamente.";
} catch (PDOException $e) {
    echo "❌ Error creando base de datos: " . $e->getMessage();
}
