<?php
namespace tecweb\myapi;

abstract class DataBase {
    protected $conexion;

    public function __construct($user, $pass, $db) {
        $this->conexion = @mysqli_connect(
            "localhost",
            $user,
            $pass,
            $db
        );
        if(!$this->conexion){
            die("Error al conectar con la base de datos");
        }              
    }
}
?>