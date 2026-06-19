<?php
require_once 'header.php';
require_once 'config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = mysqli_prepare($conexion, 'SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);
    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        setcookie('ultimo_usuario', $usuario['email'], time() + 3600 * 24 * 30, '/');
        header('Location: productos.php');
        exit;
    } else {
        $error = 'Email o contraseña incorrectos';
    }
}
?>
<main class="contenedor form-page">
    <h1>Iniciar sesión</h1>
    
    <?php if ($error): ?><p class="error"><?= limpiar($error) ?></p><?php endif; ?>
    <form method="POST" id="formLogin" class="formulario">
        <label>Email</label>
        <input type="email" name="email" id="email" value="<?= limpiar($_COOKIE['ultimo_usuario'] ?? '') ?>" required>
        <label>Contraseña</label>
        <input type="password" name="password" id="password" required minlength="4">
        <button type="submit" class="btn">Entrar</button>
    </form>
</main>
<?php require_once 'footer.php'; ?>
