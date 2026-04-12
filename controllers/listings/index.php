<?php
$config = require basePath('config/db.php');
$db = new Database($config);
$listings = $db->query('SELECT * FROM listings')->fetchAll();

view('listings/index', [
    'listings' => $listings,
]);
