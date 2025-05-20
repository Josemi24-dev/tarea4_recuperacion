<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

class AuthController
{
    public function loginForm(): void
    {
        require_once __DIR__ . '/../../resources/views/login.php';
    }

    public function login(): void
    {
        session_start();
        $db = Database::connect();

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = (int) $usuario['id'];
            header("Location: /usuario/{$usuario['id']}");
            exit;
        } else {
            $_SESSION['error'] = "Credenciales incorrectas.";
            header("Location: /login");
            exit;
        }
    }

    public function registerForm(): void
    {
        require_once __DIR__ . '/../../resources/views/register.php';
    }

    public function register(): void
    {
        session_start();
        $db = Database::connect();

        $nombre = $_POST['nombre'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $nick = $_POST['nick'] ?? '';
        $email = $_POST['email'] ?? '';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        $password = $_POST['password'] ?? '';
        $saldo = $_POST['saldo'] ?? 0;

        if (!$nombre || !$email || !$password) {
            $_SESSION['error'] = "Campos obligatorios vacíos.";
            header("Location: /registro");
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("
            INSERT INTO usuarios (nombre, apellidos, nick, email, fecha_nacimiento, password, saldo)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        try {
            $stmt->execute([$nombre, $apellidos, $nick, $email, $fecha_nacimiento, $hash, $saldo]);

            $id = $db->lastInsertId();
            $_SESSION['usuario_id'] = $id;
            header("Location: /usuario/$id");
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error al registrar usuario: " . $e->getMessage();
            header("Location: /registro");
            exit;
        }
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        header("Location: /");
        exit;
    }
}
