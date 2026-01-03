<?php
// Test to see actual errors when accessing Wisata controller
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set environment
define('ENVIRONMENT', 'development');

// CodeIgniter bootstrap
$system_path = 'system';
$application_folder = 'application';

// Paths
define('BASEPATH', realpath($system_path).DIRECTORY_SEPARATOR);
define('FCPATH', __DIR__.DIRECTORY_SEPARATOR);
define('SYSDIR', basename(BASEPATH));
define('APPPATH', realpath($application_folder).DIRECTORY_SEPARATOR);

// Check paths
if (!is_dir(BASEPATH)) {
    echo "System path not found: " . BASEPATH;
    exit(1);
}

if (!is_dir(APPPATH)) {
    echo "Application path not found: " . APPPATH;
    exit(1);
}

// Load CodeIgniter
require_once BASEPATH.'core/CodeIgniter.php';
?>
