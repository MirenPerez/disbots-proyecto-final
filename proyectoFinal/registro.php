<?php
require_once 'header.php';
require_once 'config/db.php';
$mensaje = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($nombre && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 4) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $rol = 'normal';
        $stmt = mysqli_prepare($conexion, 'INSERT INTO usuarios(nombre, email, password, rol) VALUES (?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'ssss', $nombre, $email, $hash, $rol);
        if (mysqli_stmt_execute($stmt)) {
            $mensaje = 'Usuario registrado correctamente. Ya puedes iniciar sesión.';
        } else {
            $error = 'No se ha podido registrar. Puede que el email ya exista.';
        }
    } else {
        $error = 'Revisa los datos introducidos.';
    }
}
?>
<main class="contenedor form-page">
    <h1>Registro</h1>
    <?php if ($mensaje): ?><p class="ok"><?= limpiar($mensaje) ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?= limpiar($error) ?></p><?php endif; ?>
    <form method="POST" id="formRegistro" class="formulario">
        <label>Nombre</label><input type="text" name="nombre" id="nombre" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{2,100}">
        <label>Email</label><input type="email" name="email" id="emailRegistro" required>
        <label>Contraseña</label><input type="password" name="password" id="passwordRegistro" required minlength="4">
        <button type="submit" class="btn">Crear cuenta</button>
    </form>
</main>
<?php require_once 'footer.php'; ?>
