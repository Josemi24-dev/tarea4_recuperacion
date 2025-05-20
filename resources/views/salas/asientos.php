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
