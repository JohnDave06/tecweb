<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $detalles = $_POST['detalles'];
    $unidades = $_POST['unidades'];
    $imagen = $_POST['imagen'];

    // Conectar a la base de datos
    $link = new mysqli('localhost', 'root', 'contraseña_6', 'marketzone');

    // Comprobar la conexión
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    // Preparar la consulta de actualización
    $sql = "UPDATE productos SET nombre=?, marca=?, modelo=?, precio=?, detalles=?, unidades=?, imagen=? WHERE id=?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("sssdsisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $_POST['id']);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Producto actualizado con éxito.";
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
        echo "<button onclick='window.history.back()'>Regresar</button>";
    }

    // Cerrar la conexión
    $stmt->close();
    $link->close();
}
?>