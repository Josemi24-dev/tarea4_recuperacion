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
}
