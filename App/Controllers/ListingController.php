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
            'tags',
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

        $requiredFields = [
            'title',
            'salary',
            'company',
            'city',
            'state',
            'phone',
            'email',
        ];

        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field], 1)) {
                $errors[] = ucfirst($field) . ' is required.';
            }
        }

        if (!empty($errors)) {
            view('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData,
            ]);
            return;
        } else {
            $fields = [];
            $values = [];
            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $fields = implode(', ', $fields);
            $values = implode(', ', $values);
            $sql = "INSERT INTO listings ($fields) VALUES ($values)";
            $this->db->query($sql, $newListingData);

            redirect('/listings');
        }
    }

    /**
     * Edit a single listing
     *
     * @return void
     */
    public function edit($params)
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            header('Location: /listings');
            exit;
        }

        $queryParams = ['id' => $id];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $queryParams)->fetch();

        view('listings/edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Delete a listing
     *
     * @param array $params
     * @return void
     */
    public function destroy($params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            redirect('/listings');
        }

        $queryParams = ['id' => $id];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $queryParams)->fetch();

        if (!$listing) {
            ErrorController::notFound();
            exit;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $queryParams);

        // Set a success message in the session
        $_SESSION['success_message'] = 'Listing deleted successfully.';
        redirect('/listings');
    }
}
