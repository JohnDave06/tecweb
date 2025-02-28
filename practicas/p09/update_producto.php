<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
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
    $stmt->bind_param("sssdsisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>
                alert('Producto actualizado con éxito.');
                    window.location.href = 'get_productos_vigentes_v2.php';
            </script>";
    } else {
        echo "<script>
                alert('Error al actualizar el producto: " . $stmt->error . "');
                    window.history.back();
            </script>";
    }

    $stmt->close();
    $link->close();
}
?>