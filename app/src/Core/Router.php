<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function get($path, $callback, $middleware = []) {
        $this->addRoute('GET', $path, $callback, $middleware);
    }

    public function post($path, $callback, $middleware = []) {
        $this->addRoute('POST', $path, $callback, $middleware);
    }

    private function addRoute($method, $path, $callback, $middleware) {
        $this->routes[$method][$path] = [
            'callback' => $callback,
            'middleware' => is_array($middleware) ? $middleware : [$middleware]
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Handle base path if project is in a subdirectory
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        // Normalize slashes
        $scriptName = str_replace('\\', '/', $scriptName);
        
        // Remove script path from URI
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }
        
        // Ensure URI starts with /
        if ($uri === '' || $uri === false) {
            $uri = '/';
        }

        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            $callback = $route['callback'];
            $middlewares = $route['middleware'];

            // Execute Middlewares
            foreach ($middlewares as $middleware) {
                $middlewareInstance = new $middleware();
                $middlewareInstance->handle();
            }
            
            if (is_array($callback)) {
                $controller = new $callback[0]();
                $method = $callback[1];
                return $controller->$method();
            }
            
            return call_user_func($callback);
        }

        // 404 Not Found
        http_response_code(404);
        echo "404 Not Found";
    }
}
