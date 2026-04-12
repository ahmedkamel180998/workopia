<?php

namespace App\Controllers;

class ErrorController
{
    /**
     * Handle 404 Not Found errors
     *
     * @param string $message Optional custom error message
     */
    public static function notFound($message = 'Resource not found')
    {
        http_response_code(404);
        view('error', ['status' => '404', 'message' => $message]);
    }

    /**
     * Handle 403 Unauthorized errors
     *
     * @param string $message Optional custom error message
     */
    public static function unauthorized($message = 'You are not authorized to access this resource')
    {
        http_response_code(403);
        view('error', ['status' => '403', 'message' => $message]);
    }

    /**
     * Handle 500 Internal Server Error
     *
     * @param string $message Optional custom error message
     */
    public static function error($message = 'Internal Server Error')
    {
        http_response_code(500);
        view('error', ['status' => '500', 'message' => $message]);
    }
}
