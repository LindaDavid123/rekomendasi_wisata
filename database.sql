-- Database: rekomendasi_wisata
-- Sistem Rekomendasi Wisata Yogyakarta dengan Hybrid Collaborative & Item-Based Filtering

CREATE DATABASE IF NOT EXISTS rekomendasi_wisata;
USE rekomendasi_wisata;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P'),
    no_telepon VARCHAR(20),
    alamat TEXT,
    foto VARCHAR(255) DEFAULT 'default.jpg',
    google_id VARCHAR(100),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_google_id (google_id),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Wisata (Tempat Wisata)
CREATE TABLE IF NOT EXISTS wisata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(200) NOT NULL,
    kategori ENUM('alam', 'budaya', 'sejarah', 'kuliner', 'belanja', 'edukasi', 'hiburan') NOT NULL,
    deskripsi TEXT NOT NULL,
    alamat TEXT NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    harga_tiket DECIMAL(10, 2) DEFAULT 0,
    jam_buka TIME,
    jam_tutup TIME,
    foto VARCHAR(255),
    fasilitas TEXT,
    kontak VARCHAR(100),
    website VARCHAR(200),
    rating_avg DECIMAL(3, 2) DEFAULT 0.00,
    jumlah_rating INT DEFAULT 0,
    jumlah_review INT DEFAULT 0,
    jumlah_favorit INT DEFAULT 0,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    INDEX idx_kategori (kategori),
    INDEX idx_rating (rating_avg),
    INDEX idx_status (status),
    FULLTEXT INDEX idx_search (nama, deskripsi, alamat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Rating
CREATE TABLE IF NOT EXISTS rating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    wisata_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_wisata (user_id, wisata_id),
    INDEX idx_user (user_id),
    INDEX idx_wisata (wisata_id),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Reviews
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    wisata_id INT NOT NULL,
    review TEXT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    foto_review VARCHAR(255),
    helpful_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_wisata (wisata_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Favorit
CREATE TABLE IF NOT EXISTS favorit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    wisata_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_wisata (user_id, wisata_id),
    INDEX idx_user (user_id),
    INDEX idx_wisata (wisata_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Similarity Cache (untuk menyimpan hasil perhitungan similarity antar item)
CREATE TABLE IF NOT EXISTS similarity_cache (
    id INT AUTO_INCREMENT PRIMARY KEY,
    wisata_id_1 INT NOT NULL,
    wisata_id_2 INT NOT NULL,
    similarity_score DECIMAL(5, 4) NOT NULL,
    calculated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (wisata_id_1) REFERENCES wisata(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id_2) REFERENCES wisata(id) ON DELETE CASCADE,
    UNIQUE KEY unique_pair (wisata_id_1, wisata_id_2),
    INDEX idx_wisata1 (wisata_id_1),
    INDEX idx_wisata2 (wisata_id_2),
    INDEX idx_score (similarity_score)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Recommendation History (menyimpan riwayat rekomendasi yang diberikan)
CREATE TABLE IF NOT EXISTS recommendation_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    wisata_id INT NOT NULL,
    recommendation_score DECIMAL(5, 4) NOT NULL,
    recommendation_type ENUM('collaborative', 'item_based', 'hybrid') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_wisata (wisata_id),
    INDEX idx_type (recommendation_type),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Admin Default
INSERT INTO users (username, email, password, nama, role) VALUES
('admin', 'admin@wisatajogja.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');
-- Password default: password

-- Insert Sample Data Wisata Yogyakarta
INSERT INTO wisata (nama, kategori, deskripsi, alamat, latitude, longitude, harga_tiket, foto, fasilitas) VALUES
('Candi Borobudur', 'sejarah', 'Candi Buddha terbesar di dunia yang merupakan situs warisan dunia UNESCO. Dibangun pada abad ke-8 dan ke-9 dengan arsitektur yang menakjubkan.', 'Borobudur, Magelang, Jawa Tengah', -7.607874, 110.203751, 50000, 'borobudur.jpg', 'Parkir, Toilet, Musholla, Cafe, Toko Souvenir'),
('Candi Prambanan', 'sejarah', 'Kompleks candi Hindu terbesar di Indonesia yang juga merupakan situs warisan dunia UNESCO. Dibangun pada abad ke-9 dengan relief yang indah.', 'Sleman, Yogyakarta', -7.752020, 110.491467, 50000, 'prambanan.jpg', 'Parkir, Toilet, Musholla, Cafe, Museum'),
('Malioboro', 'belanja', 'Jalan legendaris di Yogyakarta yang menjadi pusat perbelanjaan dan wisata. Terkenal dengan pedagang kaki lima dan toko-toko souvenir.', 'Jl. Malioboro, Yogyakarta', -7.792970, 110.365963, 0, 'malioboro.jpg', 'Parkir, Toilet, ATM, Toko'),
('Keraton Yogyakarta', 'budaya', 'Istana resmi Kesultanan Ngayogyakarta Hadiningrat. Kompleks bangunan bersejarah yang masih dihuni oleh Sultan dan keluarganya.', 'Jl. Rotowijayan, Yogyakarta', -7.805274, 110.364281, 15000, 'keraton.jpg', 'Parkir, Toilet, Musholla, Museum, Guide'),
('Pantai Parangtritis', 'alam', 'Pantai yang terkenal dengan legenda Nyi Roro Kidul. Memiliki pemandangan sunset yang indah dan ombak yang besar.', 'Parangtritis, Bantul, Yogyakarta', -8.024926, 110.329704, 10000, 'parangtritis.jpg', 'Parkir, Toilet, Warung, Penyewaan ATV'),
('Taman Sari', 'sejarah', 'Bekas taman atau kebun istana Keraton Yogyakarta. Memiliki kolam pemandian dan terowongan bawah tanah yang menarik.', 'Jl. Taman, Yogyakarta', -7.810251, 110.359711, 15000, 'tamansari.jpg', 'Parkir, Toilet, Musholla, Guide'),
('Goa Pindul', 'alam', 'Wisata cave tubing yang populer di Gunungkidul. Menawarkan pengalaman menyusuri goa dengan ban pelampung.', 'Gunungkidul, Yogyakarta', -7.937735, 110.611992, 35000, 'goapindul.jpg', 'Parkir, Toilet, Kamar Ganti, Locker, Cafe'),
('Hutan Pinus Mangunan', 'alam', 'Hutan pinus dengan spot foto yang instagramable. Menawarkan pemandangan alam yang sejuk dan asri.', 'Mangunan, Bantul, Yogyakarta', -7.937053, 110.426277, 10000, 'mangunan.jpg', 'Parkir, Toilet, Warung, Spot Foto'),
('Kaliurang', 'alam', 'Kawasan wisata pegunungan yang sejuk di lereng Gunung Merapi. Cocok untuk berlibur bersama keluarga.', 'Kaliurang, Sleman, Yogyakarta', -7.597500, 110.426944, 0, 'kaliurang.jpg', 'Parkir, Toilet, Hotel, Restaurant'),
('Museum Ullen Sentalu', 'budaya', 'Museum yang menyimpan koleksi budaya Jawa, khususnya Dinasti Mataram. Arsitektur unik dengan taman yang indah.', 'Kaliurang, Sleman, Yogyakarta', -7.616667, 110.416667, 50000, 'ullensentalu.jpg', 'Parkir, Toilet, Guide, Cafe'),
('Tebing Breksi', 'alam', 'Bekas tambang batu yang disulap menjadi obyek wisata dengan relief dan ukiran di dinding tebing.', 'Prambanan, Sleman, Yogyakarta', -7.759167, 110.502778, 10000, 'breksi.jpg', 'Parkir, Toilet, Warung, Spot Foto'),
('Alun-Alun Kidul', 'budaya', 'Alun-alun selatan Keraton Yogyakarta yang terkenal dengan dua pohon beringin kembar dan wahana permainan.', 'Jl. Alun-Alun Kidul, Yogyakarta', -7.813056, 110.364167, 0, 'alunalunkidul.jpg', 'Parkir, Toilet, Warung, Permainan'),
('Bukit Bintang Jogja', 'alam', 'Tempat wisata dengan pemandangan kota Yogyakarta dari ketinggian. Populer untuk menikmati sunset dan malam hari.', 'Patuk, Gunungkidul, Yogyakarta', -7.866944, 110.485278, 10000, 'bukitbintang.jpg', 'Parkir, Toilet, Warung, Spot Foto'),
('Heha Sky View', 'hiburan', 'Wisata dengan berbagai wahana dan spot foto dengan pemandangan kota Yogyakarta dari ketinggaan.', 'Gunungkidul, Yogyakarta', -7.881944, 110.516667, 25000, 'hehaskyview.jpg', 'Parkir, Toilet, Restaurant, Spot Foto'),
('De Mata Trick Eye Museum', 'hiburan', 'Museum seni 3D yang interaktif dengan berbagai latar belakang untuk berfoto.', 'Jl. Gejayan, Yogyakarta', -7.775278, 110.385556, 100000, 'demata.jpg', 'Parkir, Toilet, AC, Cafe');

