<?php
declare(strict_types=1);

class UsuarioController
{
    public function mostrar(int $id): void
    {
        session_start();

        if (!isset($_SESSION['usuario_id']) || (int)$_SESSION['usuario_id'] !== $id) {
            http_response_code(403);
            echo "Acceso no autorizado.";
            exit;
        }

        $db = Database::connect();

        // Usuario
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();

        // Entradas compradas
        $stmt = $db->prepare("
            SELECT entradas.fecha_compra, salas.nombre AS sala, asientos.fila, asientos.numero, asientos.precio
            FROM entradas
            JOIN asientos ON entradas.asiento_id = asientos.id
            JOIN salas ON asientos.sala_id = salas.id
            WHERE entradas.usuario_id = ?
            ORDER BY entradas.fecha_compra DESC
        ");
        $stmt->execute([$id]);
        $entradas = $stmt->fetchAll();

        require __DIR__ . '/../../resources/views/usuarios/show.php';
    }

    public function editar(int $id): void
    {
        session_start();

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] !== $id) {
            http_response_code(403);
            echo "Acceso no autorizado.";
            exit;
        }

        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();

        require __DIR__ . '/../../resources/views/usuarios/editar.php';
    }

    public function actualizar(int $id): void
    {
        session_start();

        if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] !== $id) {
            http_response_code(403);
            echo "Acceso no autorizado.";
            exit;
        }

        $db = Database::connect();

        $nombre = $_POST['nombre'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $nick = $_POST['nick'] ?? '';
        $email = $_POST['email'] ?? '';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';

        $stmt = $db->prepare("
            UPDATE usuarios
            SET nombre = ?, apellidos = ?, nick = ?, email = ?, fecha_nacimiento = ?
            WHERE id = ?
        ");
        $stmt->execute([$nombre, $apellidos, $nick, $email, $fecha_nacimiento, $id]);

        header("Location: /usuario/$id");
        exit;
    }

}
