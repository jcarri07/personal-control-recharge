<?php
/**
 * config/env.php
 * Cargador ligero y nativo de variables de entorno (.env)
 */

if (!function_exists('loadEnv')) {
    function loadEnv($path = null) {
        if ($path === null) {
            $path = dirname(__DIR__) . '/.env';
        }
        if (!file_exists($path)) {
            return false;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name  = trim($name);
                $value = trim($value);
                // Remover comillas si existen
                $value = trim($value, '"\'');
                putenv("{$name}={$value}");
                $_ENV[$name]    = $value;
                $_SERVER[$name] = $value;
            }
        }
        return true;
    }
}

if (!function_exists('env')) {
    function env($key, $default = null) {
        $val = getenv($key);
        if ($val === false) {
            $val = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
        }
        return $val;
    }
}

// Cargar automáticamente las variables de entorno
loadEnv();
?>

