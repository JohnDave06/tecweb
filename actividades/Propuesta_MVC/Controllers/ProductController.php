<?php
namespace App\Controllers;

use App\Models\Products;
require_once __DIR__ . '/../Models/Products.php';

class ProductController {
    private $productsModel;

    public function __construct() {
        $this->productsModel = new Products();
    }

    public function create() {
        require_once __DIR__ . '/../Views/products/create.php'; // Carga la vista para agregar un producto
    }

    public function add() {
        $data = $_POST;
    
        if (!empty($data['nombre']) && !empty($data['marca']) && !empty($data['modelo']) &&
            isset($data['precio']) && $data['precio'] > 0 &&
            isset($data['unidades']) && $data['unidades'] >= 0 &&
            !empty($data['detalles']) && !empty($data['imagen'])) {
            try {
                $result = $this->productsModel->add($data);
                if ($result['status'] === 'success') {
                    header("Location: /tecweb/actividades/Propuesta_MVC/products/list?success=Producto agregado exitosamente.");
                    exit;
                } else {
                    header("Location: /tecweb/actividades/Propuesta_MVC/products/list?error=" . urlencode($result['message']));
                    exit;
                }
            } catch (\Exception $e) {
                header("Location: /tecweb/actividades/Propuesta_MVC/products/list?error=Ocurrió un error al agregar el producto.");
                exit;
            }
        } else {
            header("Location: /tecweb/actividades/Propuesta_MVC/products/list?error=Datos incompletos o inválidos.");
            exit;
        }
    }

    public function delete() {
        $id = $_POST['id'] ?? null;
    
        if ($id) {
            try {
                $result = $this->productsModel->delete($id);
                if ($result['status'] === 'success') {
                    header("Location: /tecweb/actividades/Propuesta_MVC/products/list?success=Producto eliminado exitosamente.");
                    exit;
                } else {
                    header("Location: /tecweb/actividades/Propuesta_MVC/products/list?error=" . urlencode($result['message']));
                    exit;
                }
            } catch (\Exception $e) {
                header("Location: /tecweb/actividades/Propuesta_MVC/products/list?error=Ocurrió un error al eliminar el producto.");
                exit;
            }
        } else {
            header("Location: /tecweb/actividades/Propuesta_MVC/products/list?error=ID del producto no proporcionado.");
            exit;
        }
    }

    public function update() {
        $data = $_POST;
    
        try {
            // Verifica si ya existe otro producto con los mismos datos
            if ($this->productsModel->exists($data) && $data['id'] != $this->productsModel->getIdByDetails($data)) {
                header("Location: /tecweb/actividades/Propuesta_MVC/products/edit?id={$data['id']}&error=Ya existe otro producto con los mismos datos.");
                exit;
            }
            $result = $this->productsModel->edit($data);
            if ($result['status'] === 'success') {
                header("Location: /tecweb/actividades/Propuesta_MVC/products/list?success=Producto actualizado exitosamente.");
                exit;
            } else {
                header("Location: /tecweb/actividades/Propuesta_MVC/products/edit?id={$data['id']}&error=Error al actualizar el producto.");
                exit;
            }
        } catch (\Exception $e) {
            header("Location: /tecweb/actividades/Propuesta_MVC/products/edit?id={$data['id']}&error=Ocurrió un error al actualizar el producto.");
            exit;
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
                $product = $this->productsModel->single($id);
                if (isset($product['status']) && $product['status'] === 'error') {
                    throw new \Exception($product['message']);
                }
                require_once __DIR__ . '/../Views/products/edit.php';
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "ID del producto no proporcionado.";
        }
    }
    
    public function list() {
        try {
            $products = $this->productsModel->list();
            require_once __DIR__ . '/../Views/products/list.php';
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function search() {
        $query = $_GET['search'] ?? '';
        try {
            $products = $this->productsModel->search($query);
            echo json_encode($products);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function single() {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if ($id) {
            try {
                $result = $this->productsModel->single($id);
                echo json_encode($result);
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID del producto requerido']);
        }
    }
}
?>