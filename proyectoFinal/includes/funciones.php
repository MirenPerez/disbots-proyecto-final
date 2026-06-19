<?php
function esta_logueado() {
    return isset($_SESSION['usuario']);
}

function es_admin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

function proteger_login() {
    if (!esta_logueado()) {
        header('Location: login.php');
        exit;
    }
}

function proteger_admin() {
    proteger_login();
    if (!es_admin()) {
        header('Location: productos.php');
        exit;
    }
}

function limpiar($dato) {
    return htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8');
}
?>
