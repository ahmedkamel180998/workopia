<?php

namespace App\Controllers;

use Framework\Database;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        view('listings/index', [
            'listings' => $listings,
        ]);
    }

    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /listings');
            exit;
        }

        $params = ['id' => $id];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        view('listings/show', [
            'listing' => $listing,
        ]);
    }

    public function create()
    {
        view('listings/create');
    }
}
