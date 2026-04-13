<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show all listings
     *
     * @return void
     */
    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        view('listings/index', [
            'listings' => $listings,
        ]);
    }

    /**
     * Show a single listing
     *
     * @return void
     */
    public function show($params)
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            header('Location: /listings');
            exit;
        }

        $queryParams = ['id' => $id];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $queryParams)->fetch();

        view('listings/show', [
            'listing' => $listing,
        ]);
    }

    /**
     * Show the form to create a new listing
     *
     * @return void
     */
    public function create()
    {
        view('listings/create');
    }

    /**
     * Store a new listing
     *
     * @return void
     */
    public function store()
    {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'requirements',
            'benefits',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
        ];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        $newListingData['user_id'] = 4;

        $newListingData = array_map([Validation::class, 'sanitize'], $newListingData);
    }
}
