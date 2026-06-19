<?php
require_once 'header.php';
require_once 'config/db.php';
$busqueda = trim($_GET['buscar'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$por_pagina = 4;
$offset = ($pagina - 1) * $por_pagina;
$where = 'WHERE 1=1';
$params = [];
$types = '';
if ($busqueda !== '') { $where .= ' AND nombre LIKE ?'; $params[] = "%$busqueda%"; $types .= 's'; }
if ($categoria !== '') { $where .= ' AND categoria = ?'; $params[] = $categoria; $types .= 's'; }

$sqlCount = "SELECT COUNT(*) total FROM productos $where";
$stmtCount = mysqli_prepare($conexion, $sqlCount);
if ($params) mysqli_stmt_bind_param($stmtCount, $types, ...$params);
mysqli_stmt_execute($stmtCount);
$total = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCount))['total'];
$total_paginas = max(1, ceil($total / $por_pagina));

$sql = "SELECT * FROM productos $where ORDER BY fecha_creacion DESC LIMIT ? OFFSET ?";
$stmt = mysqli_prepare($conexion, $sql);
$params2 = $params; $params2[] = $por_pagina; $params2[] = $offset;
$types2 = $types . 'ii';
mysqli_stmt_bind_param($stmt, $types2, ...$params2);
mysqli_stmt_execute($stmt);
$productos = mysqli_stmt_get_result($stmt);
$cats = mysqli_query($conexion, 'SELECT DISTINCT categoria FROM productos ORDER BY categoria');
?>
<main class="contenedor">
    <h1>Tienda de Bots</h1>
    <section class="panel">
        <form method="GET" class="filtros">
            <input type="text" name="buscar" placeholder="Buscar bot..." value="<?= limpiar($busqueda) ?>">
            <select name="categoria">
                <option value="">Todas las categorías</option>
                <?php while($cat = mysqli_fetch_assoc($cats)): ?>
                    <option value="<?= limpiar($cat['categoria']) ?>" <?= $categoria === $cat['categoria'] ? 'selected' : '' ?>><?= limpiar($cat['categoria']) ?></option>
                <?php endwhile; ?>
            </select>
            <button class="btn" type="submit">Filtrar</button>
            <a class="btn btn-secundario" href="exportar_pdf.php?buscar=<?= urlencode($busqueda) ?>&categoria=<?= urlencode($categoria) ?>">Exportar PDF</a>
        </form>
    </section>
    <section class="bot-grid">
        <?php while($p = mysqli_fetch_assoc($productos)): ?>
            <article class="bot-card">
                <?php if ($p['imagen']): ?><img class="producto-img" src="uploads/<?= limpiar($p['imagen']) ?>" alt="<?= limpiar($p['nombre']) ?>"><?php endif; ?>
                <h3><?= limpiar($p['nombre']) ?></h3>
                <p><?= limpiar($p['descripcion']) ?></p>
                <p><strong><?= limpiar($p['categoria']) ?></strong></p>
                <p class="precio"><?= number_format($p['precio'], 2) ?> €</p>
                <form action="agregar_carrito.php" method="POST">
                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                    <button class="btn btnComprar" type="submit" data-nombre="<?= limpiar($p['nombre']) ?>">Añadir al carrito</button>
                </form>
            </article>
        <?php endwhile; ?>
    </section>
    <div class="paginacion">
        <?php for($i=1; $i <= $total_paginas; $i++): ?>
            <a class="<?= $i === $pagina ? 'activa' : '' ?>" href="?buscar=<?= urlencode($busqueda) ?>&categoria=<?= urlencode($categoria) ?>&pagina=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <section class="panel"><h2>Datos cargados con AJAX</h2><button id="cargarAjax" class="btn">Cargar ofertas</button><div id="resultadoAjax"></div></section>
</main>
<?php require_once 'footer.php'; ?>
