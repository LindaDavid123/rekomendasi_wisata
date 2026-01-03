<!DOCTYPE html>
<html>
<head>
    <title>Debug Wisata Page</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 20px; margin: 10px 0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        h2 { margin-top: 0; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔍 Debug Halaman Wisata</h1>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div class='card'>";
echo "<h2>1. Cek PHP Version</h2>";
echo "<p class='success'>✓ PHP Version: " . phpversion() . "</p>";
echo "</div>";

// Check database connection
echo "<div class='card'>";
echo "<h2>2. Cek Database Connection</h2>";

define('BASEPATH', __DIR__ . '/system/');
define('ENVIRONMENT', 'development');

try {
    include(__DIR__ . '/application/config/database.php');
    
    $mysqli = @new mysqli(
        $db['default']['hostname'],
        $db['default']['username'],
        $db['default']['password'],
        $db['default']['database']
    );
    
    if ($mysqli->connect_error) {
        echo "<p class='error'>✗ Connection failed: " . $mysqli->connect_error . "</p>";
        echo "<p class='warning'>Pastikan MySQL/MariaDB berjalan di XAMPP Control Panel</p>";
    } else {
        echo "<p class='success'>✓ Database connected successfully</p>";
        
        // Check wisata table
        echo "<h3>Cek Tabel Wisata:</h3>";
        $result = $mysqli->query("SELECT COUNT(*) as count FROM wisata");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p class='success'>✓ Tabel wisata ditemukan</p>";
            echo "<p class='success'>✓ Jumlah data: " . $row['count'] . " wisata</p>";
            
            if ($row['count'] == 0) {
                echo "<p class='warning'>⚠ Tabel kosong! Import database terlebih dahulu.</p>";
            }
        } else {
            echo "<p class='error'>✗ Tabel wisata tidak ditemukan: " . $mysqli->error . "</p>";
            echo "<p class='warning'>⚠ Silakan import file database.sql atau rekomendasi_wisata.sql</p>";
        }
        
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Exception: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Check file permissions
echo "<div class='card'>";
echo "<h2>3. Cek File & Folder</h2>";

$files_to_check = [
    'application/controllers/Wisata.php',
    'application/models/Wisata_model.php',
    'application/views/wisata/index.php',
    'application/views/templates/header.php',
    'application/views/templates/footer.php',
    'application/config/routes.php',
    'application/config/config.php',
    '.htaccess'
];

foreach ($files_to_check as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "<p class='success'>✓ " . $file . "</p>";
    } else {
        echo "<p class='error'>✗ " . $file . " (TIDAK DITEMUKAN)</p>";
    }
}

echo "</div>";

// Check Apache mod_rewrite
echo "<div class='card'>";
echo "<h2>4. Cek Apache Configuration</h2>";

if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p class='success'>✓ mod_rewrite enabled</p>";
    } else {
        echo "<p class='error'>✗ mod_rewrite disabled</p>";
        echo "<p class='warning'>⚠ Aktifkan mod_rewrite di httpd.conf</p>";
    }
} else {
    echo "<p class='warning'>⚠ Tidak dapat mengecek Apache modules (mungkin menggunakan CGI/FastCGI)</p>";
}

echo "</div>";

// Check routes
echo "<div class='card'>";
echo "<h2>5. Cek Routes Configuration</h2>";

$routes_file = __DIR__ . '/application/config/routes.php';
if (file_exists($routes_file)) {
    include($routes_file);
    echo "<p class='success'>✓ Routes file loaded</p>";
    
    if (isset($route['wisata'])) {
        echo "<p class='success'>✓ Route 'wisata' ditemukan: " . $route['wisata'] . "</p>";
    } else {
        echo "<p class='error'>✗ Route 'wisata' tidak ditemukan</p>";
    }
} else {
    echo "<p class='error'>✗ Routes file tidak ditemukan</p>";
}

echo "</div>";

// Test URL
echo "<div class='card'>";
echo "<h2>6. Test URL</h2>";
echo "<p>Base URL: <code>http://localhost/rekomendasi_wisata/</code></p>";
echo "<p>URL Wisata: <code>http://localhost/rekomendasi_wisata/wisata</code></p>";
echo "<br>";
echo "<a href='http://localhost/rekomendasi_wisata/' style='display:inline-block; padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px; margin:5px;'>Test Home</a>";
echo "<a href='http://localhost/rekomendasi_wisata/wisata' style='display:inline-block; padding:10px 20px; background:#28a745; color:white; text-decoration:none; border-radius:5px; margin:5px;'>Test Wisata</a>";
echo "</div>";

// Show errors if any
echo "<div class='card'>";
echo "<h2>7. Troubleshooting Guide</h2>";
echo "<ol>";
echo "<li>Pastikan Apache dan MySQL berjalan di XAMPP Control Panel</li>";
echo "<li>Import database dari file <code>database.sql</code> atau <code>rekomendasi_wisata.sql</code></li>";
echo "<li>Pastikan base_url di <code>application/config/config.php</code> sesuai</li>";
echo "<li>Aktifkan mod_rewrite di Apache (httpd.conf)</li>";
echo "<li>Cek error log di <code>application/logs/</code></li>";
echo "</ol>";
echo "</div>";

?>

</body>
</html>
