<?php

namespace Framework;

use Framework\Session;

class Authorization
{
    /**
     * Check if the current logged-in user owns the resource
     * 
     * @param int $resourceUserId The ID of the user who owns the resource
     * @return bool
     */
    public static function owns($resourceUserId)
    {
        $sessionUser = Session::get('user');

        if (!$sessionUser) {
            redirect('/auth/login');
            exit;
        }

        if (isset($sessionUser['user_id']) && $sessionUser['user_id'] == $resourceUserId) {
            return true;
        }

        return false;
    }
}
