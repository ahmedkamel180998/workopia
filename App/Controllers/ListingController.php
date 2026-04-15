<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Authorization;

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

        $listing = $this->getListingById($id);

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
        $newListingData['user_id'] = Session::get('user')['user_id'];

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

        $listing = $this->getListingById($id);

        view('listings/edit', [
            'listing' => $listing,
        ]);
    }

    /**
     * Update a listing
     *
     * @param array $params
     * @return void
     */
    public function update($params)
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            header('Location: /listings');
            exit;
        }
        $listing = $this->getListingById($id);
        $allowedFields = [
            'title',
            'description',
            'salary',
            'tags',
            'address',
            'city',
            'state',
            'phone',
            'email',
        ];

        $updatedData = array_intersect_key($_POST, array_flip($allowedFields));
        $updatedData = array_map([Validation::class, 'sanitize'], $updatedData);

        $requiredFields = [
            'title',
            'salary',
            'city',
            'state',
            'phone',
            'email',
        ];

        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($updatedData[$field]) || !Validation::string($updatedData[$field], 1)) {
                $errors[] = ucfirst($field) . ' is required.';
            }
        }

        if (!empty($errors)) {
            view('listings/edit', [
                'errors' => $errors,
                'listing' => $listing
            ]);
            exit;
        } else {
            // Convert empty strings to null for optional fields then add the ID to the data array
            foreach ($updatedData as $field => $value) {
                if ($value === '') {
                    $updatedData[$field] = null;
                }
            }
            $updatedData['id'] = $id;

            // Build the SET part of the SQL query
            $fieldsToUpdate = [];
            foreach ($updatedData as $field => $value) {
                $fieldsToUpdate[] = "$field = :$field";
            }
            $fieldsToUpdate = implode(', ', $fieldsToUpdate);

            // Prepare the update query
            $updateQuery = "UPDATE listings SET $fieldsToUpdate WHERE id = :id";

            // Execute the update query
            $this->db->query($updateQuery, $updatedData);

            // Set a success message in the session then redirect to the listing page
            $_SESSION['success_message'] = 'Listing updated successfully.';
            redirect('/listings/' . $id);
        }
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
            exit;
        }

        $listing = $this->getListingById($id);

        // Check if the logged-in user owns the listing before allowing deletion
        if (!Authorization::owns($listing->user_id)) {
            $_SESSION['error_message'] = 'You are not authorized to delete this listing.';
            redirect('/listings/' . $listing->id);
            exit;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', ['id' => $id]);

        // Set a success message in the session
        $_SESSION['success_message'] = 'Listing deleted successfully.';
        redirect('/listings');
    }

    // ====================================== PRIVATE METHODS ======================================
    /**
     * Fetch a listing by ID
     * 
     * @param int $id
     * @return object|null
     */
    private function getListingById($id)
    {
        $queryParams = ['id' => $id];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $queryParams)->fetch();
        if (!$listing) {
            ErrorController::notFound();
            exit;
        }
        return $listing;
    }
}
