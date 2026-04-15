<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router
{
    protected $routes = [];

    /**
     * Register the Route in routes array
     * 
     * @param string $method
     * @param string $uri
     * @param string $action
     * @param array $middleware
     * @return void
     */
    public function registerRoute($method, $uri, $action, $middleware = [])
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware,
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function get($uri, $controller, $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function post($uri, $controller, $middleware = [])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }

    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function put($uri, $controller, $middleware = [])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function delete($uri, $controller, $middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     * Route the request to the appropriate controller
     * 
     * @param string $method
     * @param string $uri
     * @return void
     */
    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }
        foreach ($this->routes as $route) {
            // Split the current uri into segments
            $uriSegments = explode('/', trim($uri, '/'));

            // Split the route uri into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;
            // Check if the number of segments match and the request method matches
            if (count($uriSegments) === count($routeSegments) && $route['method'] === $requestMethod) {
                $params = [];
                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    // If uri segments don't match and the route segment is not a parameter, then it's not a match
                    if ($uriSegments[$i] !== $routeSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    // If uri segment doesn't match but the route segment is a parameter,
                    // then we extract the parameter value
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    // Check if the route has middleware
                    if (!empty($route['middleware'])) {
                        foreach ($route['middleware'] as $role) {
                            (new Authorize())->handle($role);
                        }
                    }
                    $controllerClass = "App\\Controllers\\{$route['controller']}";
                    $controllerMethod = $route['controllerMethod'];

                    // Check if the controller class exists
                    if (!class_exists($controllerClass)) {
                        ErrorController::error("Controller class '{$controllerClass}' not found");
                        exit;
                    }
                    // Then check if the method exists in the controller
                    if (!method_exists($controllerClass, $controllerMethod)) {
                        ErrorController::error("Method '{$controllerMethod}' not found in controller '{$controllerClass}'");
                        exit;
                    }
                    // If both the class and method exist, instantiate the controller and call the method
                    $controllerInstance = new $controllerClass();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFound();
        exit;
    }
}
