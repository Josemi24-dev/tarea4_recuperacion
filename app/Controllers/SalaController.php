<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

class SalaController
{
    public function listar(): void
    {
        $db = Database::connect();

        // Paginación
        $porPagina = 2;
        $pagina = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($pagina - 1) * $porPagina;

        $stmt = $db->prepare("SELECT * FROM salas LIMIT :lim OFFSET :off");
        $stmt->bindValue(':lim', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $salas = $stmt->fetchAll();

        // Total para paginación
        $total = $db->query("SELECT COUNT(*) FROM salas")->fetchColumn();
        $totalPaginas = ceil($total / $porPagina);

        require __DIR__ . '/../../resources/views/salas/index.php';
    }

    public function verAsientos(int $sala_id): void
    {
        session_start();
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM asientos WHERE sala_id = ? ORDER BY fila, numero");
        $stmt->execute([$sala_id]);
        $asientos = $stmt->fetchAll();

        require __DIR__ . '/../../resources/views/salas/asientos.php';
    }

    public function resumenCompra(): void
    {
        session_start();
        $db = Database::connect();

        $ids = $_POST['asientos'] ?? [];

        if (empty($ids)) {
            echo "No seleccionaste asientos.";
            exit;
        }

        // Evitar inyecciones
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $stmt = $db->prepare("SELECT * FROM asientos WHERE id IN ($in)");
        $stmt->execute($ids);
        $asientos = $stmt->fetchAll();

        $total = array_sum(array_column($asientos, 'precio'));

        require __DIR__ . '/../../resources/views/compra/resumen.php';
    }

    public function confirmarCompra(): void
    {
        session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /login");
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $asiento_ids = $_POST['asientos'] ?? [];

        if (empty($asiento_ids)) {
            echo "Error: no se enviaron asientos.";
            exit;
        }

        $db = Database::connect();

        try {
            $db->beginTransaction();

            // Obtener datos de usuario
            $stmt = $db->prepare("SELECT saldo FROM usuarios WHERE id = ?");
            $stmt->execute([$usuario_id]);
            $usuario = $stmt->fetch();

            // Obtener asientos y calcular total
            $in = str_repeat('?,', count($asiento_ids) - 1) . '?';
            $stmt = $db->prepare("SELECT * FROM asientos WHERE id IN ($in) FOR UPDATE");
            $stmt->execute($asiento_ids);
            $asientos = $stmt->fetchAll();

            $total = array_sum(array_column($asientos, 'precio'));

            if ($usuario['saldo'] < $total) {
                $db->rollBack();
                echo "Saldo insuficiente.";
                exit;
            }

            // Restar saldo al usuario
            $stmt = $db->prepare("UPDATE usuarios SET saldo = saldo - ? WHERE id = ?");
            $stmt->execute([$total, $usuario_id]);

            // Marcar asientos como ocupados
            $stmt = $db->prepare("UPDATE asientos SET ocupado = 1 WHERE id = ?");
            foreach ($asiento_ids as $id) {
                $stmt->execute([$id]);
            }

            // Insertar entradas
            $stmt = $db->prepare("INSERT INTO entradas (usuario_id, asiento_id) VALUES (?, ?)");
            foreach ($asiento_ids as $id) {
                $stmt->execute([$usuario_id, $id]);
            }

            // Sumar al saldo del cine
            $stmt = $db->prepare("UPDATE cuenta_cine SET saldo_total = saldo_total + ? WHERE id = 1");
            $stmt->execute([$total]);

            $db->commit();

            echo "✅ Compra realizada con éxito. <a href='/usuario/$usuario_id'>Ir al panel</a>";
        } catch (PDOException $e) {
            $db->rollBack();
            echo "❌ Error en la compra: " . $e->getMessage();
        }
    }


}


