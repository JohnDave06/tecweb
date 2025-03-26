<?php
    // include_once __DIR__.'/database.php';

    // // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    // $data = array(
    //     'status'  => 'error',
    //     'message' => 'La consulta falló'
    // );
    // // SE VERIFICA HABER RECIBIDO EL ID
    // if( isset($_POST['id']) ) {
    //     $jsonOBJ = json_decode( json_encode($_POST) );
    //     // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    //     $sql =  "UPDATE productos SET nombre='{$jsonOBJ->nombre}', marca='{$jsonOBJ->marca}',";
    //     $sql .= "modelo='{$jsonOBJ->modelo}', precio={$jsonOBJ->precio}, detalles='{$jsonOBJ->detalles}',"; 
    //     $sql .= "unidades={$jsonOBJ->unidades}, imagen='{$jsonOBJ->imagen}' WHERE id={$jsonOBJ->id}";
    //     $conexion->set_charset("utf8");
    //     if ( $conexion->query($sql) ) {
    //         $data['status'] =  "success";
    //         $data['message'] =  "Producto actualizado";
	// 	} else {
    //         $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
    //     }
	// 	$conexion->close();
    // } 
    
    // // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    // echo json_encode($data, JSON_PRETTY_PRINT);

    namespace tecweb\myapi;

    require_once __DIR__ . '/myapi/Products.php';
    
    use tecweb\myapi\Products;
    
    // Obtener los datos del producto desde la solicitud
    $data = json_decode(file_get_contents("php://input"), true); // Decodificar el JSON recibido
    
    // Depuración: Verificar los datos recibidos
    error_log('Datos recibidos: ' . json_encode($data));
    
    if (!empty($data['id']) && !empty($data['nombre']) && !empty($data['marca']) && 
        !empty($data['modelo']) && isset($data['precio']) && isset($data['unidades']) && 
        !empty($data['detalles']) && !empty($data['imagen'])) {
        // Crear una instancia de la clase Products
        $products = new Products('root', 'contraseña_6', 'marketzone');
    
        // Llamar al método edit() para actualizar el producto
        $result = $products->edit($data);
    
        // Devolver la respuesta en formato JSON
        echo json_encode($result);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
    }
?>