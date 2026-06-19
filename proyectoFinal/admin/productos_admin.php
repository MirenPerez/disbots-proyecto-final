<?php
require_once '../header.php';
require_once '../config/db.php';
proteger_admin();
$resultado = mysqli_query($conexion, 'SELECT * FROM productos ORDER BY fecha_creacion DESC');
?>
<main class="contenedor">
    <h1>Panel de administración</h1>
    <a class="btn" href="producto_form.php">Añadir producto</a>
    <table class="tabla">
        <thead><tr><th>Imagen</th><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php while($p = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php if($p['imagen']): ?><img class="miniatura" src="../uploads/<?= limpiar($p['imagen']) ?>" alt=""><?php endif; ?></td>
                <td><?= limpiar($p['nombre']) ?></td>
                <td><?= limpiar($p['categoria']) ?></td>
                <td><?= number_format($p['precio'], 2) ?> €</td>
                <td>
                    <a href="producto_form.php?id=<?= $p['id'] ?>">Editar</a> |
                    <a href="producto_borrar.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro que quieres borrar este producto?')">Borrar</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php require_once '../footer.php'; ?>
