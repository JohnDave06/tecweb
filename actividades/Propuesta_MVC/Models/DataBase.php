<?php
namespace APP\Models;

abstract class DataBase {
    protected $conexion;

    public function __construct() {
        $this->conexion = new \mysqli('localhost', 'root', 'contraseña_6', 'marketzone');
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
}
?>