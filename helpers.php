<?php

/**
 * Get the file path of the current page
 * 
 * @param string $path
 * @return string
 */

function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a view file
 * 
 * @param string $view
 * @return void
 */
function view($view)
{
    $viewPath = basePath('views/' . $view . '.view.php');
    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        echo "View not found: " . $viewPath;
    }
}

/**
 * Load a partial view file
 * 
 * @param string $partial
 * @return void
 */
function partial($partial)
{
    $partialPath = basePath('views/partials/' . $partial . '.php');
    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "Partial not found: " . $partialPath;
    }
}

/**
 * Inspect a variable (for debugging)
 * 
 * @param mixed $value
 * @return void
 */
function dump($value)
{
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Debug</title>';
    echo '<script src="https://cdn.tailwindcss.com"></script>';
    echo '</head>';
    echo '<body class="bg-gray-900 text-yellow-500 p-4 text-lg">';
    echo '<pre class="bg-gray-800 text-yellow-500 px-4 py-2 mb-2 rounded-md whitespace-pre-wrap break-words">';
    var_dump($value);
    echo '</pre>';
    echo '</body>';
    echo '</html>';
}

/**
 * Inspect a variable and die (for debugging)
 * 
 * @param mixed $value
 * @return void
 */
function dd($value)
{
    die(dump($value));
}
