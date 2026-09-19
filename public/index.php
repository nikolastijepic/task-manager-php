<?php

use App\Controllers\AuthController;
use App\Controllers\TaskController;

session_start();

$envFile = __DIR__ . '/../.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}


spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use App\Core\Router;

$router = new Router();

$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/', [AuthController::class, 'showLogin']);

$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/tasks', [TaskController::class, 'index']);
$router->post('/tasks/create', [TaskController::class, 'store']);
$router->post('/tasks/toggle', [TaskController::class, 'toggle']);
$router->get('/tasks/edit', [TaskController::class, 'edit']);
$router->post('/tasks/update', [TaskController::class, 'update']);
$router->post('/tasks/delete', [TaskController::class, 'destroy']);

$router->dispatch();
