<h2>Filtrar asientos</h2>
<form method="GET">
    Mín precio: <input type="number" name="min" value="<?= $_GET['min'] ?? '' ?>" step="0.01"><br>
    Máx precio: <input type="number" name="max" value="<?= $_GET['max'] ?? '' ?>" step="0.01"><br>
    Posición (ej: A1, B): <input type="text" name="pos" value="<?= $_GET['pos'] ?? '' ?>"><br>
    <button type="submit">Filtrar</button>
</form>
<hr>

<h2>Asientos disponibles</h2>

<form method="POST" action="/resumen-compra">
    <?php foreach ($asientos as $a): ?>
        <?php if (!$a['ocupado']): ?>
            <label>
                <input type="checkbox" name="asientos[]" value="<?= $a['id'] ?>">
                <?= $a['fila'] ?><?= $a['numero'] ?> (€<?= $a['precio'] ?>)
            </label><br>
        <?php else: ?>
            <span style="color:gray;"><?= $a['fila'] ?><?= $a['numero'] ?> (ocupado)</span><br>
        <?php endif; ?>
    <?php endforeach; ?>

    <input type="hidden" name="sala_id" value="<?= $sala_id ?>">
    <button type="submit">Continuar compra</button>
</form>
