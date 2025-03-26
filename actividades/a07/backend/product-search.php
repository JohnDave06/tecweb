<?php
    namespace tecweb\myapi;

    require_once __DIR__ . '/myapi/Products.php';
    
    use tecweb\myapi\Products;
    
    // Obtener el término de búsqueda desde la solicitud
    $search = $_GET['search'] ?? '';
    
    if ($search) {
        // Crear una instancia de la clase Products
        $products = new Products();
    
        // Llamar al método search() para buscar productos
        $products->search($search);
    
        // Devolver la respuesta en formato JSON
        echo $products->getData();
    } else {
        echo json_encode(['error' => 'El término de búsqueda es requerido']);
    }
?>