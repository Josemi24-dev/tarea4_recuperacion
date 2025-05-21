<!-- Fichero que crea e introduce desde cero en la base de datos tarea4recuperacion2:
-Usuarios (100)
-Salas (3)
-Asientos (por sala)
-Entradas (estructura)
-Cuenta del cine
-->

<?php
declare(strict_types=1);

// Nos conectamos al servidor mysql a nivel root (sin especificar base de datos)
$db = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Crear base de datos si no existe
$db->exec("CREATE DATABASE IF NOT EXISTS tarea4recuperacion2 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
// Seleccionamos la base de datos creada
$db->exec("USE tarea4recuperacion2");

// Eliminamos las posibles tablas 
$db->exec("DROP TABLE IF EXISTS entradas, asientos, salas, cuenta_cine, usuarios");

// Tabla usuarios
$db->exec("
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

// Tabla salas
$db->exec("
    CREATE TABLE salas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50)
    );
");

// Tabla asientos
$db->exec("
    CREATE TABLE asientos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        sala_id INT,
        fila CHAR(1),
        numero INT,
        precio DECIMAL(10,2),
        ocupado BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (sala_id) REFERENCES salas(id) ON DELETE CASCADE
    );
");

// Tabla entradas
$db->exec("
    CREATE TABLE entradas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT,
        asiento_id INT,
        fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
        FOREIGN KEY (asiento_id) REFERENCES asientos(id)
    );
");

// Tabla cuenta del cine
$db->exec("
    CREATE TABLE cuenta_cine (
        id INT PRIMARY KEY,
        saldo_total DECIMAL(10,2)
    );
");

// Inicializamos la tabla cuenta_cine
$db->exec("INSERT INTO cuenta_cine (id, saldo_total) VALUES (1, 0.00)");

// Preparamos la sentencia de inserción de usuarios
$stmt = $db->prepare("
    INSERT INTO usuarios (nombre, apellidos, nick, email, fecha_nacimiento, password, saldo)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

// Insertamos 100 usuarios de prueba
for ($i = 1; $i <= 100; $i++) {
    $nombre = "Usuario$i";
    $apellidos = "Apellido$i";
    $nick = "user$i";
    $email = "user$i@example.com";
    $fecha = date('Y-m-d', rand(strtotime('1980-01-01'), strtotime('2005-12-31')));
    $pass = password_hash("clave$i", PASSWORD_DEFAULT);
    $saldo = rand(20, 100);

    $stmt->execute([$nombre, $apellidos, $nick, $email, $fecha, $pass, $saldo]);
}

// Insertar salas
$db->exec("INSERT INTO salas (nombre) VALUES ('Sala A'), ('Sala B'), ('Sala C')");

// Insertar asientos para cada sala (ej: 5 filas, 10 asientos por fila)
$salas = $db->query("SELECT id FROM salas")->fetchAll(PDO::FETCH_ASSOC);

foreach ($salas as $sala) {
    // Consultamos los ids de cada sala para insertar sus respectivos asientos
    $sala_id = $sala['id'];
    foreach (range('A', 'E') as $fila) {    // Creamos 5 filas, de la A a la E
        for ($n = 1; $n <= 10; $n++) {   // 10 columnas por fila
            $precio = rand(5, 10);  
            $db->prepare("INSERT INTO asientos (sala_id, fila, numero, precio) VALUES (?, ?, ?, ?)")
                ->execute([$sala_id, $fila, $n, $precio]);
        }
    }
}

echo "✅ Base de datos completa: usuarios, salas, asientos, entradas y cuenta del cine creados.";
