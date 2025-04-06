<?php
namespace routes;

use Exception;

class Router {
    private array $routes = [];
    private array $instances = [];

    // Регистрируем любой объект (контроллер, сервис, репозиторий)
    public function add(string $key, object $instance): void {
        $this->instances[$key] = $instance;
    }

    public function addRoute(string $method, string $path, array|callable $handler): void {
        $this->routes[$method][$path] = $handler;
    }

    public function get(string $key): object {
        if (!isset($this->instances[$key])) {
            throw new Exception("Dependency {$key} not found");
        }
        return $this->instances[$key];
    }

    public function dispatch(string $method, string $uri): void {
        // Убираем GET-параметры из URL
        $uri = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];

            if (is_callable($handler)) {
                $handler();
                return;
            } elseif (is_array($handler) && count($handler) === 2) {
                [$controllerClass, $methodName] = $handler;

                if (isset($this->instances[$controllerClass])) {
                    $controller = $this->instances[$controllerClass];

                    if (method_exists($controller, $methodName)) {
                        $data = $_GET + ($_POST ?? []);

                        $controller->$methodName($data);
                        return;
                    }
                }
            }

            echo "Handler not found";
            return;
        }

        echo "Route not found";
    }
}
