<h2>Panel de Usuario</h2>

<p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
<p><strong>Apellidos:</strong> <?= htmlspecialchars($usuario['apellidos']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
<p><strong>Nick:</strong> <?= htmlspecialchars($usuario['nick']) ?></p>
<p><strong>Fecha de nacimiento:</strong> <?= $usuario['fecha_nacimiento'] ?></p>
<p><strong>Saldo:</strong> €<?= $usuario['saldo'] ?></p>

<a href="/salas">🎟️ Comprar entradas</a><br>
<a href="/logout">🔓 Cerrar sesión</a>
