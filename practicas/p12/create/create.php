<?php
namespace tecweb\myapi;

use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Create extends DataBase {
private $response;

    public function __construct($database='marketzone') {
        $this->response = array();
        parent::__construct($database);
    }

    public function add($productData) {
        $query = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagen, eliminado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 0)";

        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param(
                "sssdiss",
                $productData['nombre'],
                $productData['marca'],
                $productData['modelo'],
                $productData['precio'],
                $productData['unidades'],
                $productData['detalles'],
                $productData['imagen']
            );

            $success = $stmt->execute();
            $stmt->close();

            return $success ? ['status' => 'success', 'message' => 'Producto agregado correctamente'] : ['status' => 'error', 'message' => $this->conexion->error];
        }

        return ['status' => 'error', 'message' => 'Error en la preparación de la consulta'];
        }
}
?>