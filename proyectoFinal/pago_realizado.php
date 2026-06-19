<?php
session_start();
unset($_SESSION['carrito']);
require_once 'header.php';
?>
<main class="contenedor">
    <section class="panel pago-realizado">
        <h1>Pago realizado</h1>
        <p>Gracias por tu compra. Tu pedido se ha procesado correctamente.</p>
        <a class="btn" href="index.php">Volver al inicio</a>
    </section>
</main>
<?php require_once 'footer.php'; ?>
