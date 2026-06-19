<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/includes/funciones.php';
$base = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '';
$carrito_count = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $carrito_count += $item['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base ?>estilos/estilo.css?v=3">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>DisBots</title>
</head>
<body>
<header>
    <a href="<?= $base ?>index.php"><img src="<?= $base ?>assets/img/logo-letras.png" alt="Logo de DisBots" class="logo-header"></a>
    <button id="menuMovil" class="menu-movil">☰</button>
    <nav id="menuPrincipal">
        <ul>
            <li><a href="<?= $base ?>index.php">Inicio</a></li>
            <li><a href="<?= $base ?>productos.php">Bots</a></li>
            <li><a href="<?= $base ?>contacto.php">Contacto</a></li>
            <li><a href="<?= $base ?>carrito.php">Carrito (<?= $carrito_count ?>)</a></li>
            <?php if (esta_logueado()): ?>
                <?php if (es_admin()): ?><li><a href="<?= $base ?>admin/productos_admin.php">Admin</a></li><?php endif; ?>
                <li><a href="<?= $base ?>logout.php">Salir</a></li>
            <?php else: ?>
                <li><a href="<?= $base ?>login.php">Login</a></li>
                <li><a href="<?= $base ?>registro.php">Registro</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
