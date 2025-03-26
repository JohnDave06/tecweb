<?php
    // include_once __DIR__.'/database.php';

    // // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    // $data = array(
    //     'status'  => 'error',
    //     'message' => 'La consulta falló'
    // );
    // // SE VERIFICA HABER RECIBIDO EL ID
    // if( isset($_POST['id']) ) {
    //     $id = $_POST['id'];
    //     // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    //     $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
    //     if ( $conexion->query($sql) ) {
    //         $data['status'] =  "success";
    //         $data['message'] =  "Producto eliminado";
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