<?php
include_once __DIR__.'/database.php';

$id = $_POST['id'];
$query = "SELECT id, nombre, precio, unidades, modelo, marca, detalles, imagen FROM productos WHERE id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$json = array();
if ($row = mysqli_fetch_assoc($result)) {
    $json = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'precio' => $row['precio'],
        'unidades' => $row['unidades'],
        'modelo' => $row['modelo'],
        'marca' => $row['marca'],
        'detalles' => $row['detalles'],
        'imagen' => $row['imagen']
    );
}

echo json_encode($json);
?>
