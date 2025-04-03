<?php
namespace tecweb\myapi;

abstract class DataBase {
    protected $conexion;
    protected $data = [];

    public function __construct($database) {
        $this->conexion = @mysqli_connect(
            'localhost',
            'root',
            'contraseña_6',
            'marketzone'
        );
        if(!$this->conexion){
            die("Error al conectar con la base de datos");
        }              
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>