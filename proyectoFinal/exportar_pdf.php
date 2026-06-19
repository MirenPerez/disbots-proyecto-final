<?php
require_once 'config/db.php';
require_once 'lib/SimplePDF.php';
$busqueda = trim($_GET['buscar'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');
$where = 'WHERE 1=1';
$params = [];
$types = '';
if ($busqueda !== '') { $where .= ' AND nombre LIKE ?'; $params[] = "%$busqueda%"; $types .= 's'; }
if ($categoria !== '') { $where .= ' AND categoria = ?'; $params[] = $categoria; $types .= 's'; }
$stmt = mysqli_prepare($conexion, "SELECT nombre, categoria, precio FROM productos $where ORDER BY nombre");
if ($params) mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$pdf = new SimplePDF();
$pdf->addTitle('Listado de productos - DisBots');
$pdf->addLine('Generado: ' . date('d/m/Y H:i'));
$pdf->addLine('----------------------------------------------');
while($p = mysqli_fetch_assoc($res)) {
    $pdf->addLine($p['nombre'] . ' | ' . $p['categoria'] . ' | ' . number_format($p['precio'], 2) . ' EUR');
}
$pdf->output('productos_disbots.pdf');
?>
