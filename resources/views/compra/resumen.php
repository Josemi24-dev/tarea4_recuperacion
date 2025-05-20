<h2>Resumen de compra</h2>

<ul>
    <?php foreach ($asientos as $a): ?>
        <li><?= $a['fila'] ?><?= $a['numero'] ?> (€<?= $a['precio'] ?>)</li>
    <?php endforeach; ?>
</ul>

<p><strong>Total:</strong> €<?= $total ?></p>

<form action="/confirmar-compra" method="POST">
    <?php foreach ($asientos as $a): ?>
        <input type="hidden" name="asientos[]" value="<?= $a['id'] ?>">
    <?php endforeach; ?>
    <button type="submit">Confirmar compra</button>
</form>
