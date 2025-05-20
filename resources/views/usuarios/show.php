<h2>Panel de Usuario</h2>

<p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
<p><strong>Apellidos:</strong> <?= htmlspecialchars($usuario['apellidos']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
<p><strong>Nick:</strong> <?= htmlspecialchars($usuario['nick']) ?></p>
<p><strong>Fecha de nacimiento:</strong> <?= $usuario['fecha_nacimiento'] ?></p>
<p><strong>Saldo:</strong> €<?= $usuario['saldo'] ?></p>

<a href="/salas">🎟️ Comprar entradas</a><br>
<a href="/logout">🔓 Cerrar sesión</a>

<hr>
<h3>🎟️ Entradas compradas</h3>

<?php if (empty($entradas)): ?>
    <p>No has comprado ninguna entrada todavía.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Fecha</th>
            <th>Sala</th>
            <th>Asiento</th>
            <th>Precio</th>
        </tr>
        <?php foreach ($entradas as $e): ?>
            <tr>
                <td><?= $e['fecha_compra'] ?></td>
                <td><?= $e['sala'] ?></td>
                <td><?= $e['fila'] ?><?= $e['numero'] ?></td>
                <td>€<?= $e['precio'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<a href="/usuario/<?= $usuario['id'] ?>/editar">✏️ Editar perfil</a>
