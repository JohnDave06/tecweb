<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST['nombre'];
    $marca    = $_POST['marca'];
    $modelo   = $_POST['modelo'];
    $precio   = $_POST['precio'];
    $detalles = $_POST['detalles'];
    $unidades = $_POST['unidades'];
    $imagen   = $_POST['imagen'];

    /** SE CREA EL OBJETO DE CONEXIÓN */
    $link = new mysqli('localhost', 'root', 'contraseña_6', 'marketzone');

    /** Comprobar la conexión */
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error);
    }

    /** Validar si el producto ya existe */
    $sql_check = "SELECT COUNT(*) AS total FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?";
    $stmt = $link->prepare($sql_check);
    $stmt->bind_param("sss", $nombre, $marca, $modelo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        echo '<p style="color:red;">El producto ya existe en la base de datos.</p>';
    } else {
        /** Query de inserción SIN column names */
        /** $sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)"; */
        
        // **Nueva consulta usando nombres de columnas**
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        
        if ($link->query($sql_insert)) {
            echo '<p style="color:green;">Producto insertado con éxito. ID: ' . $link->insert_id . '</p>';
        } else {
            echo '<p style="color:red;">Error al insertar producto: ' . $link->error . '</p>';
        }
    }

    $stmt->close();
    $link->close();
}
?>
