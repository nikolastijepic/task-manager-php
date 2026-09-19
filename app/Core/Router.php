<?php

namespace App\Core;

use App\Core\Csrf;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        if (isset($this->routes[$method][$uri])) {
            if ($method === 'POST') {
                $submittedToken = $_POST['csrf_token'] ?? null;
                if (!Csrf::validate($submittedToken)) {
                    http_response_code(403);
                    die('403 Forbidden: Neispravan ili nepostojeći CSRF token.');
                }
            }

            [$controllerClass, $action] = $this->routes[$method][$uri];

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }

        http_response_code(404);
        require_once __DIR__ . '/../../views/errors/404.php';
        exit;
    }
}
