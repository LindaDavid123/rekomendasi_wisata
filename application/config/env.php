<?php
/**
 * Environment Variable Loader for CodeIgniter
 * 
 * This file loads environment variables from .env file
 * Useful for local development and sensitive configuration
 * 
 * Load this file early in your CodeIgniter bootstrap
 */

$env_file = dirname(dirname(dirname(__FILE__))) . '/.env';

if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Skip invalid lines
        if (strpos($line, '=') === false) {
            continue;
        }
        
        // Parse variable
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Remove quotes if present
        if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
            (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
            $value = substr($value, 1, -1);
        }
        
        // Set environment variable
        putenv("$key=$value");
        
        // Make available via $_ENV
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
?>
