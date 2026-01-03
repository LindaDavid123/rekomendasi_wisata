<?php
// Test database connection and wisata table
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');
define('ENVIRONMENT', 'development');

include(__DIR__ . '/application/config/database.php');

// Connect to database
$mysqli = @mysqli_connect(
    $db['default']['hostname'],
    $db['default']['username'],
    $db['default']['password'],
    $db['default']['database']
);

if (!$mysqli) {
    echo "Connection Error: " . mysqli_connect_error();
    exit;
}

// Check if wisata table exists
$result = $mysqli->query("SELECT COUNT(*) as count FROM wisata");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✓ Tabel wisata ada\n";
    echo "✓ Jumlah data wisata: " . $row['count'] . "\n";
} else {
    echo "✗ Error query: " . $mysqli->error . "\n";
}

// Check table structure
$columns = $mysqli->query("SHOW COLUMNS FROM wisata");
if ($columns) {
    echo "\n✓ Struktur tabel wisata:\n";
    while ($col = $columns->fetch_assoc()) {
        echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
} else {
    echo "✗ Error checking structure: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
