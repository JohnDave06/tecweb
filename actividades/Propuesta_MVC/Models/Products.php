<?php
namespace App\Models;

use App\Models\DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    public function __construct() {
        parent::__construct();
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
            return ['status' => 'error', 'message' => 'ID inválido'];
        }
        $query = "UPDATE productos SET eliminado = 1 WHERE id = ?";
        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("i", $id);
            $success = $stmt->execute();
            $stmt->close();
            return $success ? ['status' => 'success', 'message' => 'Producto eliminado correctamente'] : ['status' => 'error', 'message' => $this->conexion->error];
        }
        return ['status' => 'error', 'message' => 'Error en la preparación de la consulta'];
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
            return $success ? ['status' => 'success', 'message' => 'Producto actualizado correctamente'] : ['status' => 'error', 'message' => $this->conexion->error];
        }
        return ['status' => 'error', 'message' => 'Error en la preparación de la consulta'];
    }

    public function list() {
        $query = "SELECT * FROM productos WHERE eliminado = 0";
        if ($result = $this->conexion->query($query)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        throw new \Exception("Error al obtener los productos: " . $this->conexion->error);
    }

    public function search($search) {
        $query = "SELECT * FROM productos WHERE nombre LIKE ? AND eliminado = 0";
        if ($stmt = $this->conexion->prepare($query)) {
            $search = "%$search%";
            $stmt->bind_param("s", $search);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return ['status' => 'error', 'message' => 'Query Error: ' . $stmt->error];
        }
        return ['status' => 'error', 'message' => 'Error en la preparación de la consulta'];
    }

    public function single($id) {
        $query = "SELECT * FROM productos WHERE id = ? AND eliminado = 0";
        if ($stmt = $this->conexion->prepare($query)) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result->fetch_assoc() ?: ['status' => 'error', 'message' => 'Producto no encontrado'];
            }
            return ['status' => 'error', 'message' => 'Query Error: ' . $stmt->error];
        }
        return ['status' => 'error', 'message' => 'Error en la preparación de la consulta'];
    }

    public function exists($data) {
        $query = "SELECT COUNT(*) as count FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("sss", $data['nombre'], $data['marca'], $data['modelo']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0; // Devuelve true si el producto ya existe
    }
}
?>