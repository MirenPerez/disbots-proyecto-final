<?php
require_once '../header.php';
require_once '../config/db.php';
proteger_admin();
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conexion, 'DELETE FROM productos WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
header('Location: productos_admin.php');
exit;
?>
