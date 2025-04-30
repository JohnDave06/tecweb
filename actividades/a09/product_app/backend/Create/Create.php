<?php
namespace Backend\Create;

require_once __DIR__ . '/../myapi/DataBase.php';
use Backend\myapi\DataBase as DataBase;

class Create extends DataBase {
    public function __construct($db) {
        parent::__construct('root', 'contraseña_6', $db);
    }

    public function add($producto){
        $nombre   = $producto['nombre'];
        $marca    = $producto['marca'];
        $modelo   = $producto['modelo'];
        $precio   = $producto['precio'];
        $detalles = $producto['detalles'];
        $unidades = $producto['unidades'];
        $imagen   = $producto['imagen'];

        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );

        if(isset($nombre)) {
            $sql = "SELECT * FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
            $result = $this->conexion->query($sql);
            
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO productos VALUES (null, '$nombre', '$marca', '$modelo', '$precio', '$detalles', '$unidades', '$imagen', 0)";
                if($this->conexion->query($sql)){
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
            }
            $result->free();
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


$createObj = new Create('marketzone');

$action = $_GET['action'] ?? $_POST['action'] ?? null;

switch ($action) {
    case 'add':
        $createObj->add($_POST);
        echo $createObj->getData();
        break;

    case 'checkName':
        $createObj->checkName($_POST['nombre']);
        echo $createObj->getData();
        break;
}
?>