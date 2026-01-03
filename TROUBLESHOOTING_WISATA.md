## Troubleshooting Halaman Wisata Tidak Bisa Diakses

### 1. Pastikan XAMPP Apache dan MySQL Berjalan
1. Buka XAMPP Control Panel
2. Pastikan Apache dan MySQL memiliki status "Running" (hijau)
3. Jika belum running, klik tombol "Start" pada kedua service tersebut

### 2. Cek Database Sudah Terinstall
1. Buka browser dan akses: `http://localhost/phpmyadmin`
2. Pastikan database `rekomendasi_wisata` sudah ada
3. Jika belum ada, import database:
   - Klik menu "Import"
   - Pilih file `rekomendasi_wisata.sql` atau `database.sql`
   - Klik "Go" untuk mengimport

### 3. Cek Tabel Wisata Ada Data
1. Di phpMyAdmin, pilih database `rekomendasi_wisata`
2. Klik tabel `wisata`
3. Pastikan ada data di dalamnya
4. Jika tidak ada data, import file `DATA_WISATA_PREPROCESSED.csv` atau jalankan script SQL yang ada

### 4. Test Akses Halaman Wisata
Coba akses URL berikut di browser:
- `http://localhost/rekomendasi_wisata/wisata`
- `http://localhost/rekomendasi_wisata/index.php/wisata`

### 5. Cek Error Log
Jika masih error, aktifkan error display:
1. Buka file `index.php` di root folder
2. Ubah baris yang berisi `error_reporting(0)` menjadi `error_reporting(E_ALL)`
3. Ubah `ini_set('display_errors', 0)` menjadi `ini_set('display_errors', 1)`
4. Refresh halaman wisata di browser
5. Lihat error yang muncul

### 6. Cek File .htaccess
File `.htaccess` di root folder harus berisi:
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

### 7. Cek Base URL di Config
1. Buka `application/config/config.php`
2. Pastikan `$config['base_url']` sesuai:
   ```php
   $config['base_url'] = 'http://localhost/rekomendasi_wisata/';
   ```

### 8. Cek Apache mod_rewrite Aktif
1. Buka `C:\xampp\apache\conf\httpd.conf`
2. Cari baris `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Hapus tanda `#` di depannya jika ada
4. Restart Apache

### Common Error Messages dan Solusinya:

#### Error: 404 Not Found
- **Penyebab**: Route tidak ditemukan atau .htaccess tidak berfungsi
- **Solusi**: 
  - Coba akses `http://localhost/rekomendasi_wisata/index.php/wisata`
  - Pastikan mod_rewrite Apache aktif (point 8)

#### Error: Database connection failed
- **Penyebab**: MySQL tidak running atau konfigurasi database salah
- **Solusi**: 
  - Pastikan MySQL running di XAMPP
  - Cek `application/config/database.php` pastikan username/password benar

#### Error: Table 'wisata' doesn't exist
- **Penyebab**: Database belum diimport atau tabel belum dibuat
- **Solusi**: Import file database.sql (point 2)

#### Error: Call to undefined method
- **Penyebab**: Model atau library tidak terload
- **Solusi**: 
  - Pastikan semua file ada di folder yang benar
  - Periksa nama file dan class sesuai dengan pemanggilan

### Setelah Troubleshooting
Jika masih bermasalah, catat:
1. URL yang diakses
2. Error message yang muncul (screenshot jika perlu)
3. Status Apache dan MySQL di XAMPP
4. Hasil pengecekan database (apakah ada atau tidak)
