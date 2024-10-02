<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ .'/database/config.php';

use App\Helper\JsonResponse;
use App\Repository\CustomerRepository;
use App\Router;


//Connect to database
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
try {
    $pdo = new PDO(DB_DSN,DB_USER,DB_PASSWORD, $options);
} catch (PDOException $exception) {
    JsonResponse::send(['status' => 'error', 'message' => $exception->getMessage(),500]);
    exit();
}

//Get request URI and method
$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route requests to the appropriate method
$router = new Router();

//Set up arguments for controller
$repository = new CustomerRepository($pdo);

$router->add('/register',
    ['controller' => 'CustomerController' ,'action' => 'registerCustomer', 'args' => $repository]);
$router->add('/download-json',
    ['controller' => 'CustomerController' ,'action' => 'downloadCustomersJSON', 'args' => $repository]);

$params = $router->match($path);

if ($params) {
    $action = $params['action'];
    $controller = $params['controller'];

    $controllerClass = "App\\Controller\\$controller";
    if (class_exists($controllerClass)) {
        $controller = $params['args'] ? new $controllerClass($params['args']) : new $controllerClass;
        if (method_exists($controller, $action)) {
            $controller->$action();
        }else {
            JsonResponse::send(['status' => 'error', 'message' => $action.' method does not exist in '.$controllerClass], 404);
        }

    } else {
        JsonResponse::send(['status' => 'error', 'message' => $controllerClass.' does not exist'], 404);
    }
} else {
    // Handle other routes
    header("HTTP/1.0 404 Not Found");
    JsonResponse::send(['status' => 'error', 'message' => 'Not Found'],404);
}

