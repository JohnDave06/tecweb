<?php
namespace tecweb\myapi;

use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Read extends DataBase {
    private $response;

    public function __construct($database='marketzone') {
        $this->response = array();
        parent::__construct($database);
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
}
?>