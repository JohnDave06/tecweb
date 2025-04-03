<?php
namespace tecweb\myapi;

use tecweb\myapi\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Delete extends DataBase {
    private $response;

    public function __construct($database='marketzone') {
        $this->response = array();
        parent::__construct($database);
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
}
?>