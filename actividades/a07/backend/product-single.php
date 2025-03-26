<?php
    namespace tecweb\myapi;

    require_once __DIR__ . '/myapi/Products.php';
    
    use tecweb\myapi\Products;
    
    // Obtener el ID del producto desde la solicitud
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        // Crear una instancia de la clase Products
        $products = new Products('root', 'contraseña_6', 'marketzone');
    
        // Llamar al método single() para obtener los datos del producto
        $result = $products->single($id);
    
        // Devolver la respuesta en formato JSON
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'ID del producto requerido']);
    }
?>