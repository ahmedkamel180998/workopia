<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show login page
     *
     * @return void
     */
    public function login()
    {
        view('users/login');
    }

    /**
     * Show register page
     *
     * @return void
     */
    public function create()
    {
        view('users/create');
    }
}
