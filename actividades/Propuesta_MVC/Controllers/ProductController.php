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
                if ($this->productsModel->exists($data)) {
                    echo "<script>alert('El producto ya existe en la base de datos.'); window.history.back();</script>";
                    return;
                }
    
                $result = $this->productsModel->add($data);
                if ($result['status'] === 'success') {
                    echo "<script>alert('Producto agregado exitosamente.'); window.location.href = '/tecweb/actividades/Propuesta_MVC/products/list';</script>";
                    exit;
                } else {
                    echo "<script>alert('Error al agregar el producto.'); window.history.back();</script>";
                }
            } catch (\Exception $e) {
                echo "<script>alert('Ocurrió un error al agregar el producto.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Datos incompletos o inválidos.'); window.history.back();</script>";
        }
    }

    public function delete() {
        $id = $_POST['id'] ?? null;
    
        if ($id) {
            try {
                $result = $this->productsModel->delete($id);
                if ($result['status'] === 'success') {
                    header("Location: /tecweb/actividades/Propuesta_MVC/products/list");
                    exit;
                } else {
                    echo "<script>alert('Error al eliminar el producto.'); window.history.back();</script>";
                }
            } catch (\Exception $e) {
                echo "<script>alert('Ocurrió un error al eliminar el producto.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('ID del producto no proporcionado.'); window.history.back();</script>";
        }
    }

    public function update() {
        $data = $_POST;

        try {
            if ($this->productsModel->exists($data) && $data['id'] != $this->productsModel->getIdByDetails($data)) {
                echo "<script>alert('Ya existe otro producto con los mismos datos.'); window.history.back();</script>";
                return;
            }

            $result = $this->productsModel->edit($data);
            if ($result['status'] === 'success') {
                echo "<script>alert('Producto actualizado exitosamente.'); window.location.href = '/tecweb/actividades/Propuesta_MVC/products/list';</script>";
                exit;
            } else {
                echo "<script>alert('Error al actualizar el producto.'); window.history.back();</script>";
            }
        } catch (\Exception $e) {
            echo "<script>alert('Ocurrió un error al actualizar el producto.'); window.history.back();</script>";
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null; // Obtén el ID del producto desde la URL
        if ($id) {
            try {
                $product = $this->productsModel->single($id); // Obtén los datos del producto desde el modelo
                if (isset($product['status']) && $product['status'] === 'error') {
                    throw new \Exception($product['message']);
                }
                require_once __DIR__ . '/../Views/products/edit.php'; // Carga la vista de edición
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "ID del producto no proporcionado.";
        }
    }
    
    public function list() {
        try {
            $products = $this->productsModel->list(); // Obtén los productos desde el modelo
            require_once __DIR__ . '/../Views/products/list.php'; // Carga la vista
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