<?php
include_once __DIR__.'/database.php';
header('Content-Type: application/json');

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT nombre FROM productos WHERE nombre LIKE ? AND eliminado = 0";
$stmt = $conexion->prepare($query);
$searchParam = "%" . $search . "%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();

$productos = array();
while ($row = $result->fetch_assoc()) {
    
    $productos[] = $row;
}

$stmt->close();
$conexion->close();

echo json_encode($productos);
?>