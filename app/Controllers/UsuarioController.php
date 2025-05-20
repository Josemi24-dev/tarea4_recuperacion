<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

class UsuarioController
{
    public function mostrar(int $id): void
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

        if (!$usuario) {
            http_response_code(404);
            echo "Usuario no encontrado.";
            exit;
        }

        require __DIR__ . '/../../resources/views/usuarios/show.php';
    }
}
