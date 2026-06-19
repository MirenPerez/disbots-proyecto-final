<?php
session_start();
require_once 'config/db.php';

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: productos.php');
    exit;
}

$stmt = mysqli_prepare($conexion, 'SELECT id, nombre, precio, imagen FROM productos WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$producto = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$producto) {
    header('Location: productos.php');
    exit;
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad']++;
} else {
    $_SESSION['carrito'][$id] = [
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'imagen' => $producto['imagen'],
        'cantidad' => 1
    ];
}

header('Location: carrito.php');
exit;
