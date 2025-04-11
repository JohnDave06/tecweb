<?php
namespace Backend\myapi;
abstract class DataBase {
    protected $conexion;
    protected $data = NULL;
    public function __construct($user='root', $pass='samd2704', $db) {
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );
        /**
         * NOTA: si la conexion falló $conexion contendrá false
         */
        if(!$this->conexion) {
            die('¡Base de datos NO conectada!');
        }
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>