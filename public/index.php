<?php
require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

use Framework\Router;

$router = new Router();

// Load the routes
$routes = require basePath('routes.php');
// Get the current request URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request to the appropriate controller
$router->route($uri);
