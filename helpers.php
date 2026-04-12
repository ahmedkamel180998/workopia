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
 * @param array $data
 * @return void
 */
function view($view, $data = [])
{
    $viewPath = basePath('views/' . $view . '.view.php');
    if (file_exists($viewPath)) {
        extract($data);
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
 * Split a function arguments string respecting nesting and quotes
 * 
 * @param string $str
 * @return array
 */
function splitArgs(string $str): array
{
    $args = [];
    $current = '';
    $depth = 0;
    $inSingle = false;
    $inDouble = false;
    $len = strlen($str);

    for ($i = 0; $i < $len; $i++) {
        $ch = $str[$i];
        $prev = $i > 0 ? $str[$i - 1] : '';

        if ($ch === "'" && !$inDouble && $prev !== '\\') {
            $inSingle = !$inSingle;
        } elseif ($ch === '"' && !$inSingle && $prev !== '\\') {
            $inDouble = !$inDouble;
        }

        if (!$inSingle && !$inDouble) {
            if ($ch === '(' || $ch === '[') $depth++;
            elseif ($ch === ')' || $ch === ']') $depth--;

            if ($ch === ',' && $depth === 0) {
                $args[] = trim($current);
                $current = '';
                continue;
            }
        }

        $current .= $ch;
    }

    if (trim($current) !== '') {
        $args[] = trim($current);
    }

    return $args;
}

/**
 * Extract the raw argument string from a dump/dd call in source
 * 
 * @param string $file
 * @param int $line
 * @return string
 */
function extractArgString(string $file, int $line): string
{
    $lines = file($file);
    $buffer = '';

    for ($i = $line - 1; $i < count($lines); $i++) {
        $buffer .= $lines[$i];

        if (preg_match('/(?:dump|dd)\s*\(/', $buffer, $m, PREG_OFFSET_CAPTURE)) {
            $start = strpos($buffer, '(', $m[0][1]);
            $depth = 0;

            for ($j = $start; $j < strlen($buffer); $j++) {
                if ($buffer[$j] === '(') $depth++;
                if ($buffer[$j] === ')') $depth--;
                if ($depth === 0) {
                    return substr($buffer, $start + 1, $j - $start - 1);
                }
            }
        }
    }

    return '';
}

/**
 * Extract argument names from the calling code via backtrace
 * 
 * @return array
 */
function getArgNames(): array
{
    $backtrace = debug_backtrace();
    // [0] = getArgNames, [1] = dump (file/line points to where dump was called)
    // If via dd: [0] = getArgNames, [1] = dump, [2] = dd (file/line points to where dd was called)
    $callerIndex = 1;
    if (isset($backtrace[2]) && ($backtrace[2]['function'] ?? '') === 'dd') {
        $callerIndex = 2;
    }

    $caller = $backtrace[$callerIndex] ?? null;
    if (!$caller || !isset($caller['file'], $caller['line'])) {
        return [];
    }

    $argStr = extractArgString($caller['file'], $caller['line']);
    return $argStr !== '' ? splitArgs($argStr) : [];
}

/**
 * Render a debug table for dumped values
 * 
 * @param array $values
 * @param array $argNames
 * @return string
 */
function renderDumpTable(array $values, array $argNames): string
{
    $rows = '';
    foreach ($values as $index => $value) {
        $name = htmlspecialchars($argNames[$index] ?? "arg$index");
        ob_start();
        var_dump($value);
        $dump = htmlspecialchars(ob_get_clean());

        $rows .= <<<ROW
        <tr>
            <td class="bg-gray-800 text-yellow-500 p-2 align-top font-mono border border-gray-600">$name</td>
            <td class="bg-gray-800 text-yellow-500 p-2 border border-gray-600">
                <pre class="whitespace-pre-wrap break-words">$dump</pre>
            </td>
        </tr>
        ROW;
    }

    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Debug</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-900 text-yellow-500 p-4 text-lg">
        <table class="w-full mb-4 border-collapse">
            <tr>
                <th class="text-left text-sm bg-gray-700 p-2 border border-gray-600 w-1/6">Variable</th>
                <th class="text-left text-sm bg-gray-700 p-2 border border-gray-600">Value</th>
            </tr>
            $rows
        </table>
    </body>
    </html>
    HTML;
}

/**
 * Inspect a variable (for debugging)
 * 
 * @param mixed $value
 * @return void
 */
function dump(...$values): void
{
    $argNames = getArgNames();
    echo renderDumpTable($values, $argNames);
}

/**
 * Inspect a variable and die (for debugging)
 * 
 * @param mixed $value
 * @return void
 */
function dd(...$values): void
{
    die(dump(...$values));
}

/**
 * Format a number as currency
 * 
 * @param string $number
 * @param int $decimals Number of decimal places
 * @return string
 */
function formatCurrency($number, $decimals = 2): string
{
    return '$' . number_format(floatval($number), $decimals);
}
