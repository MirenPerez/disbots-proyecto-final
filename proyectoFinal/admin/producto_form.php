<?php
require_once '../header.php';
require_once '../config/db.php';
proteger_admin();
$id = (int)($_GET['id'] ?? 0);
$producto = ['nombre'=>'','descripcion'=>'','categoria'=>'','precio'=>'','imagen'=>''];
if ($id) {
    $stmt = mysqli_prepare($conexion, 'SELECT * FROM productos WHERE id=?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $producto = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $categoria = trim($_POST['categoria']);
    $precio = (float)$_POST['precio'];
    $imagen = $producto['imagen'] ?? null;
    if (!empty($_FILES['imagen']['name'])) {
        $permitidos = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        $tipo = mime_content_type($_FILES['imagen']['tmp_name']);
        if (isset($permitidos[$tipo])) {
            $imagen = uniqid('bot_') . '.' . $permitidos[$tipo];
            move_uploaded_file($_FILES['imagen']['tmp_name'], '../uploads/' . $imagen);
        }
    }
    if ($id) {
        $stmt = mysqli_prepare($conexion, 'UPDATE productos SET nombre=?, descripcion=?, categoria=?, precio=?, imagen=? WHERE id=?');
        mysqli_stmt_bind_param($stmt, 'sssdsi', $nombre, $descripcion, $categoria, $precio, $imagen, $id);
    } else {
        $stmt = mysqli_prepare($conexion, 'INSERT INTO productos(nombre, descripcion, categoria, precio, imagen) VALUES (?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sssds', $nombre, $descripcion, $categoria, $precio, $imagen);
    }
    mysqli_stmt_execute($stmt);
    header('Location: productos_admin.php');
    exit;
}
?>
<main class="contenedor form-page">
    <h1><?= $id ? 'Editar' : 'Añadir' ?> producto</h1>
    <form method="POST" enctype="multipart/form-data" id="formProducto" class="formulario">
        <label>Nombre</label><input type="text" name="nombre" id="nombreProducto" value="<?= limpiar($producto['nombre']) ?>" required>
        <label>Descripción</label><textarea name="descripcion" id="descripcion" required><?= limpiar($producto['descripcion']) ?></textarea>
        <label>Categoría</label><input type="text" name="categoria" id="categoria" value="<?= limpiar($producto['categoria']) ?>" required>
        <label>Precio</label><input type="number" step="0.01" min="0" name="precio" id="precio" value="<?= limpiar($producto['precio']) ?>" required>
        <label>Imagen</label><input type="file" name="imagen" accept="image/png,image/jpeg,image/webp">
        <button type="submit" class="btn">Guardar</button>
    </form>
</main>
<?php require_once '../footer.php'; ?>
