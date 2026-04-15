<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize
{
    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    public function isAuthenticated()
    {
        return Session::has('user');
    }

    /**
     * Handle the user's request
     * 
     * @param string $role
     * @return bool
     */
    public function handle($role)
    {
        // Check if role is guest and user is authenticated
        // so this will prevent authenticated users from accessing guest-only routes
        if ($role === 'guest' && $this->isAuthenticated()) {
            redirect('/');
        } elseif ($role === 'auth' && !$this->isAuthenticated()) {
            // Check if role is auth and user is not authenticated
            // so this will prevent unauthenticated users from accessing auth-only routes
            redirect('/auth/login');
        }
    }
}
