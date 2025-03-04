<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = array();

// SE VERIFICA HABER RECIBIDO EL ID O EL TÉRMINO DE BÚSQUEDA
if (isset($_POST['searchID'])) {
    $id = $_POST['searchID'];
    // SE REALIZA LA QUERY DE BÚSQUEDA POR ID
    if ($result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'")) {
        // SE OBTIENEN LOS RESULTADOS
        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row; // utf8_encode($value);
        }
            $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
} elseif (isset($_POST['search'])) {
    $search = $_POST['search'];
    // SE REALIZA LA QUERY DE BÚSQUEDA UTILIZANDO LIKE
    $query = "SELECT * FROM productos WHERE nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%'";
    if ($result = $conexion->query($query)) {
        // SE OBTIENEN LOS RESULTADOS
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $data[] = $row; // utf8_encode($value);
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
}

$conexion->close();

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>