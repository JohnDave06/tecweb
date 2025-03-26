<?php
    namespace tecweb\myapi;

    require_once __DIR__ . '/myapi/Products.php';
    
    use tecweb\myapi\Products;
    
    // Obtener los datos del producto desde la solicitud
    $data = json_decode(file_get_contents("php://input"), true); // Decodificar el JSON recibido
    
    if (!empty($data['nombre']) && !empty($data['marca']) && !empty($data['modelo']) && 
        isset($data['precio']) && isset($data['unidades']) && !empty($data['detalles']) && 
        !empty($data['imagen'])) {
        // Crear una instancia de la clase Products
        $products = new Products('root', 'contraseña_6', 'marketzone');
    
        // Llamar al método add() para agregar el producto
        $result = $products->add($data);
    
        // Devolver la respuesta en formato JSON
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    }
?>