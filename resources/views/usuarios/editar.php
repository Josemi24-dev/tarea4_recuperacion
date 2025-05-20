<h2>Editar perfil</h2>

<form method="POST" action="/usuario/<?= $usuario['id'] ?>/editar">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>"><br><br>

    <label>Apellidos:</label><br>
    <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>"><br><br>

    <label>Nick:</label><br>
    <input type="text" name="nick" value="<?= htmlspecialchars($usuario['nick']) ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>"><br><br>

    <label>Fecha de nacimiento:</label><br>
    <input type="date" name="fecha_nacimiento" value="<?= $usuario['fecha_nacimiento'] ?>"><br><br>

    <button type="submit">Guardar cambios</button>
</form>

<a href="/usuario/<?= $usuario['id'] ?>">← Volver al panel</a>
