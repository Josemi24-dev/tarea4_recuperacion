<?php session_start(); ?>
<h2>Registro</h2>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>
<form action="/registro" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="text" name="apellidos" placeholder="Apellidos"><br>
    <input type="text" name="nick" placeholder="Nick"><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="date" name="fecha_nacimiento"><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <input type="number" name="saldo" placeholder="Saldo inicial" step="0.01"><br>
    <button type="submit">Registrar</button>
</form>
