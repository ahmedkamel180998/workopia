<?php
require '../helpers.php';
require basePath('Database.php');
$dbConfig = require basePath('config/db.php');
$db = new Database($dbConfig);
require basePath('Router.php');
// Instantiate the router
$router = new Router();
// Load the routes
$routes = require basePath('routes.php');
// Get the current request URI and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
// Route the request to the appropriate controller
$router->route($method, $uri);
