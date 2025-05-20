<h2>Panel de Usuario</h2>
<p>Nombre: <?= htmlspecialchars($usuario['nombre']) ?></p>
<p>Apellidos: <?= htmlspecialchars($usuario['apellidos']) ?></p>
<p>Email: <?= htmlspecialchars($usuario['email']) ?></p>
<p>Nick: <?= htmlspecialchars($usuario['nick']) ?></p>
<p>Fecha de nacimiento: <?= $usuario['fecha_nacimiento'] ?></p>
<p>Saldo: <?= $usuario['saldo'] ?> €</p>
<a href="/logout">Cerrar sesión</a>
