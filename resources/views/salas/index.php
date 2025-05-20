<h2>Listado de Salas</h2>
<ul>
    <?php foreach ($salas as $sala): ?>
        <li>
            <?= htmlspecialchars($sala['nombre']) ?>
            <a href="/sala/<?= $sala['id'] ?>">Ver Asientos</a>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Paginación -->
<nav>
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="/salas?p=<?= $i ?>" <?= $i === $pagina ? 'style="font-weight:bold;"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>
</nav>