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
