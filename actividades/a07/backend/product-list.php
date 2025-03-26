<?php
    namespace tecweb\myapi;

    require_once __DIR__ . '/myapi/Products.php';
    
    use tecweb\myapi\Products;
    
    // Crear una instancia de la clase Products
    $products = new Products();
    
    // Llamar al método list() para obtener todos los productos
    $productList = $products->list();
    
    // Devolver la respuesta en formato JSON
    echo json_encode($productList);
?>