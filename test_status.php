<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Status Rekomendasi Wisata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-box {
            background: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; }
        h2 { margin-top: 0; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔍 Test Status Aplikasi Rekomendasi Wisata</h1>
    
    <div class="test-box">
        <h2>1. Test Database Connection</h2>
        <?php
        define('BASEPATH', __DIR__ . '/system/');
        define('APPPATH', __DIR__ . '/application/');
        define('ENVIRONMENT', 'development');
        
        include(__DIR__ . '/application/config/database.php');
        
        $mysqli = @mysqli_connect(
            $db['default']['hostname'],
            $db['default']['username'],
            $db['default']['password'],
            $db['default']['database']
        );
        
        if ($mysqli) {
            echo '<p class="success">✓ Database connection: SUCCESS</p>';
            echo '<p class="info">Database: ' . $db['default']['database'] . '</p>';
        } else {
            echo '<p class="error">✗ Database connection: FAILED</p>';
            echo '<p class="error">Error: ' . mysqli_connect_error() . '</p>';
            echo '<p class="info">⚠️ Pastikan MySQL running di XAMPP!</p>';
        }
        ?>
    </div>
    
    <?php if ($mysqli): ?>
    <div class="test-box">
        <h2>2. Test Tabel Wisata</h2>
        <?php
        $result = $mysqli->query("SELECT COUNT(*) as count FROM wisata");
        if ($result) {
            $row = $result->fetch_assoc();
            echo '<p class="success">✓ Tabel wisata: EXISTS</p>';
            echo '<p class="info">Jumlah data: ' . $row['count'] . ' wisata</p>';
            
            if ($row['count'] == 0) {
                echo '<p class="error">⚠️ Tabel wisata kosong! Import data terlebih dahulu.</p>';
            }
        } else {
            echo '<p class="error">✗ Tabel wisata: NOT FOUND</p>';
            echo '<p class="error">Error: ' . $mysqli->error . '</p>';
            echo '<p class="info">⚠️ Import database.sql atau rekomendasi_wisata.sql terlebih dahulu!</p>';
        }
        ?>
    </div>
    
    <div class="test-box">
        <h2>3. Test Sample Data</h2>
        <?php
        $result = $mysqli->query("SELECT id, nama, kategori, harga_tiket FROM wisata LIMIT 3");
        if ($result && $result->num_rows > 0) {
            echo '<p class="success">✓ Sample data wisata:</p>';
            echo '<pre>';
            while ($row = $result->fetch_assoc()) {
                echo "ID: {$row['id']} | {$row['nama']} | {$row['kategori']} | Rp " . number_format($row['harga_tiket']) . "\n";
            }
            echo '</pre>';
        } else {
            echo '<p class="error">✗ Tidak ada data wisata</p>';
        }
        ?>
    </div>
    
    <div class="test-box">
        <h2>4. Test Struktur Tabel</h2>
        <?php
        $columns = $mysqli->query("SHOW COLUMNS FROM wisata");
        if ($columns) {
            echo '<p class="success">✓ Struktur tabel wisata:</p>';
            echo '<pre>';
            while ($col = $columns->fetch_assoc()) {
                echo "{$col['Field']} ({$col['Type']})\n";
            }
            echo '</pre>';
        }
        ?>
    </div>
    <?php endif; ?>
    
    <div class="test-box">
        <h2>5. Test File Structure</h2>
        <?php
        $files_to_check = [
            'application/controllers/Wisata.php' => 'Controller Wisata',
            'application/models/Wisata_model.php' => 'Model Wisata',
            'application/views/wisata/index.php' => 'View Wisata Index',
            'application/views/templates/header.php' => 'Template Header',
            'application/views/templates/footer.php' => 'Template Footer',
            '.htaccess' => 'File .htaccess'
        ];
        
        $all_exists = true;
        foreach ($files_to_check as $file => $label) {
            if (file_exists(__DIR__ . '/' . $file)) {
                echo '<p class="success">✓ ' . $label . ': EXISTS</p>';
            } else {
                echo '<p class="error">✗ ' . $label . ': NOT FOUND</p>';
                $all_exists = false;
            }
        }
        ?>
    </div>
    
    <div class="test-box">
        <h2>6. Test CodeIgniter Config</h2>
        <?php
        include(__DIR__ . '/application/config/config.php');
        echo '<p class="info">Base URL: <code>' . $config['base_url'] . '</code></p>';
        echo '<p class="info">Index Page: <code>' . ($config['index_page'] ?: '(empty)') . '</code></p>';
        ?>
    </div>
    
    <div class="test-box">
        <h2>7. Test Links</h2>
        <p>Coba akses halaman wisata:</p>
        <ul>
            <li><a href="<?= $config['base_url'] ?>wisata" target="_blank"><?= $config['base_url'] ?>wisata</a></li>
            <li><a href="<?= $config['base_url'] ?>index.php/wisata" target="_blank"><?= $config['base_url'] ?>index.php/wisata</a></li>
        </ul>
    </div>
    
    <div class="test-box">
        <h2>📋 Kesimpulan</h2>
        <?php
        if ($mysqli && isset($all_exists) && $all_exists && isset($result) && $result->num_rows > 0) {
            echo '<p class="success">✓ Semua test PASSED!</p>';
            echo '<p class="info">Halaman wisata seharusnya bisa diakses. Jika masih error, cek mod_rewrite Apache atau lihat TROUBLESHOOTING_WISATA.md</p>';
        } else {
            echo '<p class="error">✗ Ada masalah yang perlu diperbaiki!</p>';
            echo '<p class="info">Lihat test di atas dan perbaiki yang berwarna merah. Baca TROUBLESHOOTING_WISATA.md untuk panduan detail.</p>';
        }
        
        if ($mysqli) {
            $mysqli->close();
        }
        ?>
    </div>
    
    <div class="test-box">
        <p><strong>Catatan:</strong> Setelah semua test PASSED, hapus file ini (test_status.php) dari server production untuk keamanan.</p>
    </div>
</body>
</html>
