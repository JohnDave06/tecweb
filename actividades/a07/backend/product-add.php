<?php
    // include_once __DIR__.'/database.php';

    // // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    // $data = array(
    //     'status'  => 'error',
    //     'message' => 'Ya existe un producto con ese nombre'
    // );
    // if(isset($_POST['nombre'])) {
    //     // SE TRANSFORMA EL POST A UN STRING EN JSON, Y LUEGO A OBJETO
    //     $jsonOBJ = json_decode( json_encode($_POST) );
    //     // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
    //     $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
	//     $result = $conexion->query($sql);
        
    //     if ($result->num_rows == 0) {
    //         $conexion->set_charset("utf8");
    //         $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
    //         if($conexion->query($sql)){
    //             $data['status'] =  "success";
    //             $data['message'] =  "Producto agregado";
    //         } else {
    //             $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
    //         }
    //     }

    //     $result->free();
    //     // Cierra la conexion
    //     $conexion->close();
    // }

    // // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    // echo json_encode($data, JSON_PRETTY_PRINT);

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