<?php
require '../helpers.php';
spl_autoload_register(function ($class) {
    $path = basePath("Framework/{$class}.php");
    if (file_exists($path)) {
        require $path;
    }
});

// require basePath('Framework/Database.php');
$dbConfig = require basePath('config/db.php');
$db = new Database($dbConfig);
// require basePath('Framework/Router.php');
// Instantiate the router
$router = new Router();
// Load the routes
$routes = require basePath('routes.php');
// Get the current request URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
// Route the request to the appropriate controller
$router->route($method, $uri);
