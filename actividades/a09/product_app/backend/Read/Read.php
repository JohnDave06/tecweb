<?php
namespace Backend\Read;

require_once __DIR__ . '/../myapi/DataBase.php';
use Backend\myapi\DataBase as DataBase;

class Read extends DataBase {
    public function __construct($db) {
        parent::__construct('root', 'contraseña_6', $db);
    }

    public function list() {
        $this->data = []; // Reiniciar el atributo data

        // Ejecutar la consulta para obtener los productos no eliminados
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $this->data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }

        $this->conexion->close();
    }

    public function search($search){
        $this -> data = array();

        if($result = $this->conexion->query("SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0")){
            $rows = $result->fetch_all(MYSQLI_ASSOC);   
            if(!is_null($rows)){
                foreach($rows as $num => $row){
                    foreach($row as $key => $value){
                        $this->data[$num][$key]=$value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function single($id){
        $this -> data = array();

        if($result = $this->conexion->query("SELECT * FROM productos WHERE id = $id")){
            $row = $result->fetch_assoc();   
            if(!is_null($row)){
                foreach($row as $key => $value){
                    $this->data[$key]=$value;
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }
}


$readObj = new Read('marketzone');

$action = $_GET['action'] ?? $_POST['action'] ?? null;

switch ($action) {
    case 'list':
        $readObj->list();
        echo $readObj->getData();
        break;

    case 'search':
        $readObj->search($_GET['search']);
        echo $readObj->getData();
        break;
    
    case 'single':
        $readObj->single($_POST['id']);
        echo $readObj->getData();
}
?>