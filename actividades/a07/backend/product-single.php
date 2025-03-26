<?php
    // include_once __DIR__.'/database.php';

    // // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    // $data = array();

    // if( isset($_POST['id']) ) {
    //     $id = $_POST['id'];
    //     // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    //     if ( $result = $conexion->query("SELECT * FROM productos WHERE id = {$id}") ) {
    //         // SE OBTIENEN LOS RESULTADOS
    //         $row = $result->fetch_assoc();

    //         if(!is_null($row)) {
    //             // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
    //             foreach($row as $key => $value) {
    //                 $data[$key] = utf8_encode($value);
    //             }
    //         }
    //         $result->free();
    //     } else {
    //         die('Query Error: '.mysqli_error($conexion));
    //     }
    //     $conexion->close();
    // }

    // // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    // echo json_encode($data, JSON_PRETTY_PRINT);

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