<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router
{
    protected $routes = [];

    /**
     * Register the Route in routes array
     * 
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
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
