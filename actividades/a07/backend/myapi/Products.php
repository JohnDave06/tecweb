<?php
namespace tecweb\myapi;
use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = NULL;
    public function __construct($user='root', $pass='contraseña_6', $db) {
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }

    public function list() {
        $this->data = array();
        if($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado=0")){
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)){
                foreach($rows as $num => $rows){
                    foreach($rows as $key => $value){
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        }else{
            die('Query Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function singleByName($name) {
        $this->data = [];
        $query = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";

        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("s", $name);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $this->data = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
            } else {
                die('Query Error: ' . $stmt->error);
            }

            $stmt->close();
        } else {
            die('Query Error: ' . $this->conexion->error);
        }
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

}
?>