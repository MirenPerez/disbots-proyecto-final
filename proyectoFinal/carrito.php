<?php
require_once 'header.php';
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>
<main class="contenedor">
    <h1>Carrito de la compra</h1>

    <?php if (empty($carrito)): ?>
        <section class="panel">
            <p>Tu carrito está vacío.</p>
            <a class="btn" href="productos.php">Ver productos</a>
        </section>
    <?php else: ?>
        <section class="panel carrito-panel">
            <?php foreach ($carrito as $item): ?>
                <?php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; ?>
                <article class="item-carrito">
                    <?php if (!empty($item['imagen'])): ?>
                        <img src="uploads/<?= limpiar($item['imagen']) ?>" alt="<?= limpiar($item['nombre']) ?>">
                    <?php endif; ?>
                    <div>
                        <h3><?= limpiar($item['nombre']) ?></h3>
                        <p>Cantidad: <?= (int)$item['cantidad'] ?></p>
                        <p>Precio: <?= number_format($item['precio'], 2) ?> €</p>
                        <p><strong>Subtotal: <?= number_format($subtotal, 2) ?> €</strong></p>
                    </div>
                    <a class="btn btn-secundario" href="eliminar_carrito.php?id=<?= (int)$item['id'] ?>">Eliminar</a>
                </article>
            <?php endforeach; ?>

            <div class="total-carrito">
                <h2>Total: <?= number_format($total, 2) ?> €</h2>
                <a class="btn btn-secundario" href="productos.php">Seguir comprando</a>
                <a class="btn" href="finalizar_compra.php">Realizar pago</a>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php require_once 'footer.php'; ?>
