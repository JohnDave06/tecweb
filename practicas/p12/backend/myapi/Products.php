<?php
namespace tecweb\myapi;

use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = [];

    public function __construct($user = 'root', $pass = 'contraseña_6', $db = 'marketzone') {
        parent::__construct($user, $pass, $db);
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

    public function delete($id) {
        if (!is_numeric($id)) {
            return ['error' => 'ID inválido'];
        }
    
        $query = "UPDATE productos SET eliminado = 1 WHERE id = ?";
    
        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("i", $id);
    
            $success = $stmt->execute();
            $stmt->close();
    
            return $success ? ['success' => true, 'message' => 'Producto eliminado correctamente'] : ['error' => $stmt->error];
        }
    
        return ['error' => 'Error en la preparación de la consulta'];
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

    public function list() {
        $this->data = [];
        $query = "SELECT * FROM productos WHERE eliminado = 0";

        if ($result = $this->conexion->query($query)) {
            $this->data = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        } else {
            $this->data = ['error' => 'Query Error: ' . $this->conexion->error];
        }

        return $this->data;
    }

    public function search($search) {
        $this->data = [];
        $query = "SELECT * FROM productos WHERE nombre LIKE ? AND eliminado = 0";

        if ($stmt = $this->conexion->prepare($query)) {
            $search = "%$search%";
            $stmt->bind_param("s", $search);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $this->data = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
            } else {
                $this->data = ['error' => 'Query Error: ' . $stmt->error];
            }

            $stmt->close();
        } else {
            $this->data = ['error' => 'Query Error: ' . $this->conexion->error];
        }

        return $this->data;
    }

    public function single($id) {
        $this->data = [];
        $query = "SELECT * FROM productos WHERE id = ? AND eliminado = 0";

        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $this->data = $result->fetch_assoc();
                $result->free();
            } else {
                $this->data = ['error' => 'Query Error: ' . $stmt->error];
            }

            $stmt->close();
        } else {
            $this->data = ['error' => 'Query Error: ' . $this->conexion->error];
        }

        return $this->data ?: ['error' => 'Producto no encontrado'];
    }

    public function singleByName($name) {
        $this->data = [];
        $query = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";

        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("s", $name);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $this->data = $result->fetch_assoc();
                $result->free();
            } else {
                $this->data = ['error' => 'Query Error: ' . $stmt->error];
            }

            $stmt->close();
        } else {
            $this->data = ['error' => 'Query Error: ' . $this->conexion->error];
        }

        return $this->data ?: ['error' => 'Producto no encontrado'];
    }

    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>
