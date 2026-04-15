<?php

namespace Framework;

class Session
{
    /**
     * Start the session if it hasn't been started already.
     * 
     * @return void
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Check if a session key exists.
     * 
     * @param string $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get a session value by key.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return self::has($key) ? $_SESSION[$key] : $default;
    }

    /**
     * Set a session value by key.
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Clear session by key
     * 
     * @param string $key
     * @return void
     */
    public static function clear($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Clear all session data and destroy the session.
     * 
     * @return void
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Set flash message to be displayed on the next request.
     * 
     * @param string $key
     * @param string $message
     * @return void
     */
    public static function setFlashMessage($key, $message)
    {
        self::set('flash_' . $key, $message);
    }

    /**
     * Get and clear flash message by key.
     * 
     * @param string $key
     * @return string|null
     */
    public static function getFlashMessage($key)
    {
        $flashMessage = self::get('flash_' . $key);
        self::clear('flash_' . $key);
        return $flashMessage;
    }
}
