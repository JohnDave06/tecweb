<?php
    namespace tecweb\myapi;

    require_once __DIR__ . '/myapi/Products.php';
    
    use tecweb\myapi\Products;
    
    // Obtener datos desde la solicitud
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? null;
    
    if ($id) {
        // Crear una instancia de la clase Products
        $products = new Products();
    
        // Llamar al método delete() para eliminar el producto
        $result = $products->delete($id);
    
        // Devolver la respuesta en formato JSON
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'ID del producto requerido']);
    }
?>