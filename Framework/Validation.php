<?php

namespace Framework;

class Validation
{
    /**
     * Validate a string value
     * 
     * @param string $value
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function string($value, $min = 1, $max = INF): bool
    {
        if (is_string($value)) {
            $value = trim($value);
            $length = strlen($value);
            return $length >= $min && $length <= $max;
        }
        return false;
    }

    /**
     * Validate an email address
     * 
     * @param string $value
     * @return mixed
     */
    public static function email($value): mixed
    {
        $value = trim($value);
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Match a value against another value
     * 
     * @param string $value
     * @param string $matchValue
     * @return bool
     */
    public static function match($value, $matchValue): bool
    {
        $value = trim($value);
        $matchValue = trim($matchValue);
        return $value === $matchValue;
    }

    /**
     * Sanitize a dirty value
     *
     * @param string $value
     * @return string
     */
    public static function sanitize($value): string
    {
        $value = trim($value);
        $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        return $value;
    }
}
