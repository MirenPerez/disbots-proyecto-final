<?php
require_once 'header.php';
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
?>
<main class="contenedor">
    <h1>Finalizar compra</h1>

    <?php if (empty($carrito)): ?>
        <section class="panel">
            <p>No hay productos en el carrito.</p>
            <a class="btn" href="productos.php">Volver a la tienda</a>
        </section>
    <?php else: ?>
        <section class="panel pago-falso">
            <h2>Resumen del pedido</h2>
            <p>Total a pagar: <strong><?= number_format($total, 2) ?> €</strong></p>
            <p>Esta es una pasarela de pago simulada para el proyecto.</p>

            <form action="pago_realizado.php" method="POST">
                <label>Nombre del cliente</label>
                <input type="text" name="nombre" required placeholder="Tu nombre">

                <label>Número de tarjeta de prueba</label>
                <input type="text" name="tarjeta" required pattern="[0-9]{16}" maxlength="16" placeholder="1234567812345678">

                <button class="btn" type="submit">Pagar ahora</button>
            </form>
        </section>
    <?php endif; ?>
</main>
<?php require_once 'footer.php'; ?>
