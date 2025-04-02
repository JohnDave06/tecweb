<?php
require_once __DIR__ . '/Controllers/ProductController.php';

use App\Controllers\ProductController;

// Crear instancia del controlador
$controller = new ProductController();

// Obtener la URI y normalizarla
$baseUri = '/tecweb/actividades/Propuesta_MVC';
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = str_replace($baseUri, '', strtok($requestUri, '?'));
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Registrar la solicitud para depuración
error_log("Request URI: $requestUri | Request Method: $requestMethod");

// Definir rutas
$routes = [
    '/' => ['method' => 'GET', 'action' => 'list'], // Ruta raíz
    '/products/add' => ['method' => 'POST', 'action' => 'add'],
    '/products/delete' => ['method' => 'POST', 'action' => 'delete'],
    '/products/create' => ['method' => 'GET', 'action' => 'create'],
    '/products/update' => ['method' => 'POST', 'action' => 'update'],
    '/products/edit' => ['method' => 'GET', 'action' => 'edit'],
    '/products/list' => ['method' => 'GET', 'action' => 'list'],
    '/products/search' => ['method' => 'GET', 'action' => 'search'],
    '/products/single' => ['method' => 'POST', 'action' => 'single'],
];

// Validar la ruta
if (isset($routes[$requestUri])) {
    $route = $routes[$requestUri];

    if ($requestMethod === $route['method']) {
        $inputData = ($requestMethod === 'POST') ? json_decode(file_get_contents("php://input"), true) : $_GET;

        if (method_exists($controller, $route['action'])) {
            $controller->{$route['action']}($inputData);
        } else {
            http_response_code(500);
            error_log("Error: Método '{$route['action']}' no implementado.");
            echo json_encode(['status' => 'error', 'message' => 'Método no implementado']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Método HTTP no permitido']);
    }
} else {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'Ruta no encontrada']);
}
?>