<?php
namespace Backend\Delete;

require_once __DIR__ . '/../myapi/DataBase.php';
use Backend\myapi\DataBase as DataBase;

class Delete extends DataBase {
    public function __construct($db) {
        parent::__construct('root', 'contraseña_6', $db);
    }
    public function delete($producto){
        $id = $producto['id'];
        $this->data = array(
            'status'  => 'error',
            'message' => 'No se pudo eliminar el producto'
        );

        if(isset($id)) {
            $sql = "UPDATE productos SET eliminado = 1 WHERE id = $id";
            if($this->conexion->query($sql)){
                $this->data['status'] =  "success";
                $this->data['message'] =  "Producto eliminado";
            } else {
                $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
    }
    
}


$deleateObj = new Delete('marketzone');

    $deleateObj->delete($_POST);
    echo $deleateObj->getData();

?>