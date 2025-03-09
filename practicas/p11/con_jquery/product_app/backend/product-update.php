<?php
include_once __DIR__.'/database.php';

// Recibir el JSON enviado desde el frontend
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'] ?? null;
$nombre = $data['nombre'] ?? null;
$precio = $data['precio'] ?? null;
$unidades = $data['unidades'] ?? null;
$modelo = $data['modelo'] ?? null;
$marca = $data['marca'] ?? null;
$detalles = $data['detalles'] ?? null;
$descripcion = $data['descripcion'] ?? '';

// Validar que se haya enviado un ID válido
if (!$id || !is_numeric($id)) {
    die(json_encode(['error' => 'ID no válido']));
}

// Prepara la consulta para actualizar los datos
$query = "UPDATE productos SET nombre=?, precio=?, unidades=?, modelo=?, marca=?, detalles=?, eliminado = 0 WHERE id=?";

$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sdisssi", $nombre, $precio, $unidades, $modelo, $marca, $detalles, $id);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $data['status'] = "success";
        $data['message'] = "Producto actualizado correctamente";
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No se pudo actualizar el producto']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'Error en la consulta']);
}

mysqli_close($conexion);
?>