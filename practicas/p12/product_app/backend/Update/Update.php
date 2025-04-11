<?php
namespace Backend\Update;

require_once __DIR__ . '/../myapi/DataBase.php';
use Backend\myapi\DataBase as DataBase;

class Update extends DataBase {

    public function __construct($db) {
        parent::__construct('root', 'contraseña_6', $db);
    }

    public function edit($producto){
        $id       = $producto['id'];
        $nombre   = $producto['nombre'];
        $marca    = $producto['marca'];
        $modelo   = $producto['modelo'];
        $precio   = $producto['precio'];
        $detalles = $producto['detalles'];
        $unidades = $producto['unidades'];
        $imagen   = $producto['imagen'];

        $this->data = array(
            'status'  => 'error',
            'message' => 'No se pudo editar el producto'
        );

        if(isset($id)) {
            $sql = "UPDATE productos SET nombre = '$nombre', marca = '$marca', modelo = '$modelo', precio = '$precio', detalles = '$detalles', unidades = '$unidades', imagen = '$imagen' WHERE id = $id";
            if($this->conexion->query($sql)){
                $this->data['status'] =  "success";
                $this->data['message'] =  "Producto editado";
            } else {
                $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
    }

    public function checkName($nombre) {
        $response = array('exists' => false);

        if (isset($nombre)) {
            $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
            if ($result = $this->conexion->query($sql)) {
                if ($result->num_rows > 0) {
                    $response['exists'] = true;
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($this->conexion));
            }
        }

        $this->data = $response;
    }
}
$updateObj = new Update('marketzone');

$action = $_GET['action'] ?? $_POST['action'] ?? null;


switch ($action) {
    case 'edit':
        $updateObj->edit($_POST);
        echo $updateObj->getData();
        break;

    case 'checkName':
        $updateObj->checkName($_POST['nombre']);
        echo $updateObj->getData();
        break;
}

?>