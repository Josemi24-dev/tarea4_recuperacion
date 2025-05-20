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

}


