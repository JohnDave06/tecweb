<?php
namespace tecweb\myapi;

use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Update extends DataBase {
    private $response;

    public function __construct($database='marketzone') {
        $this->response = array();
        parent::__construct($database);
    }

    public function update($productData) {
        $query = "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, unidades = ?, detalles = ?, imagen = ? WHERE id = ? AND eliminado = 0";

        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param(
                "sssdissi",
                $productData['nombre'],
                $productData['marca'],
                $productData['modelo'],
                $productData['precio'],
                $productData['unidades'],
                $productData['detalles'],
                $productData['imagen'],
                $productData['id']
            );

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Producto actualizado correctamente'];
            } else {
                return ['status' => 'error', 'message' => 'Error en la actualización: ' . $stmt->error];
            }
        } else {
            return ['status' => 'error', 'message' => 'Error en la preparación de la consulta: ' . $this->conexion->error];
        }
    }

    public function edit($productData) {
        $query = "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, unidades = ?, detalles = ?, imagen = ? WHERE id = ?";
    
        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param(
                "sssdissi",
                $productData['nombre'],
                $productData['marca'],
                $productData['modelo'],
                $productData['precio'],
                $productData['unidades'],
                $productData['detalles'],
                $productData['imagen'],
                $productData['id']
            );
    
            $success = $stmt->execute();
            $stmt->close();
    
            return $success ? ['status' => 'success', 'message' => 'Producto actualizado correctamente'] : ['status' => 'error', 'message' => $stmt->error];
        }
    
        return ['status' => 'error', 'message' => 'Error en la preparación de la consulta'];
    }
}
?>