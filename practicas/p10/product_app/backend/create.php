<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
if (!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto, true);

    // VALIDAR SI EL PRODUCTO YA EXISTE
    $nombre = $jsonOBJ['nombre'];
    $marca = $jsonOBJ['marca'];
    $modelo = $jsonOBJ['modelo'];
    $precio = $jsonOBJ['precio'];
    $detalles = $jsonOBJ['detalles'];
    $unidades = $jsonOBJ['unidades'];
    $imagen = $jsonOBJ['imagen'];

    $sql_check = "SELECT COUNT(*) AS total FROM productos WHERE (nombre = ? AND marca = ? AND eliminado = 0) OR (marca = ? AND modelo = ? AND eliminado = 0)";
    $stmt = $conexion->prepare($sql_check);
    $stmt->bind_param("ssss", $nombre, $marca, $marca, $modelo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        echo 'El producto ya existe en la base de datos.';
    } else {
        // INSERTA EL NUEVO PRODUCTO
        $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
        
        if ($stmt_insert->execute()) {
            echo 'Producto insertado con éxito. ID: ' . $conexion->insert_id;
        } else {
            echo 'Error al insertar producto: ' . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
    $stmt->close();
} else {
    echo "Datos incompletos.";
}

$conexion->close();
?>