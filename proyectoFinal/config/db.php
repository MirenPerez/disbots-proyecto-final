<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'disbots_tienda';
$port = 3306; // Cambia a 3306 si tu MySQL usa el puerto normal

$conexion = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

mysqli_set_charset($conexion, 'utf8mb4');
?>
