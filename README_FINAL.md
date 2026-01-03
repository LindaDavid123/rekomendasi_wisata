# 🎉 SISTEM REKOMENDASI WISATA JOGJA - CODEIGNITER 3

## ✅ INSTALASI LENGKAP - SIAP PAKAI!

Semua file sudah diorganisir dengan struktur MVC CodeIgniter 3 yang proper.

---

## 📂 STRUKTUR FOLDER FINAL

```
rekomendasi_wisata/
│
├── ci3_files/                    # Semua file CI3 yang sudah diorganisir
│   ├── controllers/              # 9 Controllers
│   │   ├── admin/                # 3 Admin Controllers
│   │   │   ├── Dashboard.php
│   │   │   ├── Wisata_admin.php
│   │   │   └── Users.php
│   │   ├── Auth.php              # Login, Register, Google OAuth
│   │   ├── Favorit.php           # Favorites management
│   │   ├── Home.php              # Homepage
│   │   ├── Profil.php            # User profile
│   │   ├── Rekomendasi.php       # Hybrid recommendations
│   │   └── Wisata.php            # Browse wisata, detail, rating
│   │
│   ├── models/                   # 6 Models
│   │   ├── Favorit_model.php
│   │   ├── Rating_model.php
│   │   ├── Recommendation_model.php  # HYBRID ALGORITHM (500+ lines!)
│   │   ├── Review_model.php
│   │   ├── User_model.php
│   │   └── Wisata_model.php
│   │
│   ├── views/                    # 20+ View files
│   │   ├── templates/
│   │   │   ├── header.php
│   │   │   ├── footer.php
│   │   │   ├── admin_header.php
│   │   │   └── admin_footer.php
│   │   ├── home/
│   │   │   └── index.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── wisata/
│   │   │   ├── index.php         # Browse with filters
│   │   │   └── detail.php        # Detail, rating, review
│   │   ├── rekomendasi/
│   │   │   └── index.php
│   │   ├── favorit/
│   │   │   └── index.php
│   │   ├── profil/
│   │   │   ├── index.php
│   │   │   └── edit.php
│   │   └── admin/
│   │       ├── dashboard.php
│   │       ├── wisata/
│   │       └── users/
│   │
│   ├── libraries/                # 2 Libraries
│   │   ├── Google_oauth.php      # Google OAuth 2.0
│   │   └── Template.php
│   │
│   ├── config/                   # 4 Config files
│   │   ├── autoload.php
│   │   ├── database.php
│   │   ├── google_oauth.php
│   │   └── routes.php
│   │
│   ├── helpers/
│   │   └── wisata_helper.php     # 8 helper functions
│   │
│   ├── assets/                   # CSS & JS
│   │   ├── css/
│   │   │   ├── style.css
│   │   │   └── admin.css
│   │   └── js/
│   │       ├── main.js           # AJAX rating/favorite
│   │       └── admin.js          # Charts
│   │
│   ├── database.sql              # Database schema + sample data
│   ├── .htaccess                 # URL rewriting
│   ├── INSTALL.ps1               # Auto installer
│   ├── README.md                 # Full documentation
│   └── FILE_LIST.md              # File summary
│
├── database.sql                  # Database schema (backup)
└── uploads/                      # Upload folders
    ├── wisata/
    ├── users/
    └── temp/
```

---

## 🚀 INSTALASI SUPER CEPAT

### Prasyarat
- XAMPP (Apache + MySQL + PHP 7.4+)
- CodeIgniter 3 (download dari https://codeigniter.com/download)
- Extract CI3 ke: `c:\xampp\htdocs\wisata_ci3\`

### Langkah Instalasi

#### **OPSI 1: AUTO INSTALL (RECOMMENDED)** ⚡

1. Buka PowerShell di folder `c:\xampp\htdocs\rekomendasi_wisata\ci3_files\`
2. Jalankan:
   ```powershell
   .\INSTALL.ps1
   ```
3. Script akan otomatis copy semua file ke folder CI3!

#### **OPSI 2: Manual Copy** 📁

Buka PowerShell di `c:\xampp\htdocs\rekomendasi_wisata\`:

```powershell
# Copy semua file ke folder CI3
Copy-Item -Path "ci3_files\controllers\*" -Destination "..\wisata_ci3\application\controllers\" -Recurse -Force
Copy-Item -Path "ci3_files\models\*" -Destination "..\wisata_ci3\application\models\" -Recurse -Force
Copy-Item -Path "ci3_files\views\*" -Destination "..\wisata_ci3\application\views\" -Recurse -Force
Copy-Item -Path "ci3_files\libraries\*" -Destination "..\wisata_ci3\application\libraries\" -Recurse -Force
Copy-Item -Path "ci3_files\config\*" -Destination "..\wisata_ci3\application\config\" -Force
Copy-Item -Path "ci3_files\helpers\*" -Destination "..\wisata_ci3\application\helpers\" -Recurse -Force
Copy-Item -Path "ci3_files\assets\*" -Destination "..\wisata_ci3\assets\" -Recurse -Force
Copy-Item -Path "ci3_files\.htaccess" -Destination "..\wisata_ci3\.htaccess" -Force

# Buat folder uploads
New-Item -Path "..\wisata_ci3\uploads\wisata" -ItemType Directory -Force
New-Item -Path "..\wisata_ci3\uploads\users" -ItemType Directory -Force
New-Item -Path "..\wisata_ci3\uploads\temp" -ItemType Directory -Force
```

---

### 📚 SETUP DATABASE

1. Start **Apache** dan **MySQL** di XAMPP
2. Buka **phpMyAdmin**: http://localhost/phpmyadmin
3. Buat database baru: `wisata_jogja`
4. Import file: `ci3_files\database.sql`

---

### ⚙️ KONFIGURASI

Edit file: `wisata_ci3\application\config\config.php`

```php
$config['base_url'] = 'http://localhost/wisata_ci3/';
```

Jika nama folder CI3 berbeda, sesuaikan!

---

### 🎯 AKSES APLIKASI

**Website**: http://localhost/wisata_ci3/

**Admin Login**:
- Email: `admin@wisata.com`
- Password: `password`

---

## ✨ FITUR LENGKAP

### 🔥 Core Features
- ✅ **Hybrid Recommendation System**
  - Collaborative Filtering (60% weight)
  - Item-Based Filtering (40% weight)
  - Cosine Similarity Algorithm
  - Fallback to popular wisata
  
- ✅ **Google OAuth 2.0 Integration**
  - Login dengan Google
  - Auto create account
  - Link existing account

- ✅ **Rating & Review System**
  - 5-star rating
  - User reviews
  - Average rating calculation
  - Real-time AJAX rating

- ✅ **Favorites Management**
  - Add/remove favorites
  - AJAX toggle button
  - Favorite list page

### 🎨 User Features
- Browse wisata dengan filter (kategori, harga, search)
- Detail wisata dengan foto, deskripsi, lokasi
- Rating & review wisata
- Rekomendasi personal (hybrid, collaborative, item-based)
- Manage favorites
- User profile & statistics
- Edit profile & change password

### 🛠️ Admin Features
- Dashboard dengan statistik & charts
- CRUD Wisata (Create, Read, Update, Delete)
- Upload foto wisata
- Import wisata dari CSV
- User management
- Toggle user role (admin/user)
- Delete users
- View user statistics

### 💻 Technical Features
- Responsive Bootstrap 5 design
- AJAX operations (rating, favorite toggle)
- Clean URLs (with .htaccess)
- Form validation
- Flash messages
- Session management
- Image upload & preview
- Pagination
- Search & filter

---

## 📊 DATABASE

7 Tables:
- **users** - User accounts (email/password + Google OAuth)
- **wisata** - Tourism destinations
- **rating** - User ratings
- **reviews** - User reviews
- **favorit** - User favorites
- **similarity_cache** - Cached item similarities
- **recommendation_history** - Recommendation logs

Sample data: 10 wisata Yogyakarta (Borobudur, Prambanan, Malioboro, dll)

---

## 🎓 CARA MENGGUNAKAN

### Sebagai User
1. **Register** atau **Login** (bisa pakai Google)
2. **Browse Wisata** - Filter berdasarkan kategori, harga, atau search
3. **Detail Wisata** - Lihat detail, berikan rating & review
4. **Favorit** - Tambahkan wisata favorit
5. **Rekomendasi** - Dapatkan rekomendasi personal

### Sebagai Admin
1. **Login** dengan akun admin
2. **Dashboard** - Lihat statistik & charts
3. **Kelola Wisata** - CRUD wisata, upload foto, import CSV
4. **Kelola Users** - View users, toggle role, delete

---

## 🔧 TROUBLESHOOTING

### Error: "404 Page Not Found"
**Solusi**: 
- Pastikan mod_rewrite Apache enabled
- Check .htaccess di root folder CI3
- Pastikan base_url benar di config.php

### Error: "Unable to connect to database"
**Solusi**: 
- Start MySQL di XAMPP
- Check database.php: hostname, username, password
- Pastikan database `wisata_jogja` sudah dibuat

### Google OAuth tidak bekerja
**Solusi**:
- Setup Client ID & Secret di Google Cloud Console
- Edit config/google_oauth.php
- Pastikan redirect URI benar

### Upload foto error
**Solusi**: 
- Buat folder: `uploads/wisata/`, `uploads/users/`, `uploads/temp/`
- Set permission (Windows biasanya otomatis OK)

---

## 📱 STRUKTUR FILE YANG SUDAH DIBUAT

### ✅ COMPLETE (100%)

**Controllers**: 9 files
- Home, Auth, Wisata, Rekomendasi, Favorit, Profil
- Admin: Dashboard, Wisata_admin, Users

**Models**: 6 files
- User, Wisata, Rating, Review, Favorit
- Recommendation (Hybrid Algorithm)

**Views**: 20+ files
- Templates (header, footer, admin)
- Home, Auth (login, register)
- Wisata (index, detail)
- Rekomendasi, Favorit
- Profil (index, edit)
- Admin (dashboard)

**Config**: 4 files
- database, routes, autoload, google_oauth

**Libraries**: 2 files
- Google_oauth, Template

**Helpers**: 1 file
- wisata_helper (8 functions)

**Assets**: 4 files
- CSS (style, admin)
- JS (main, admin)

**Database**: 1 file
- database.sql (schema + sample data)

**Documentation**: 3 files
- README.md, FILE_LIST.md, INSTALL.ps1

---

## 🎉 READY TO USE!

Sistem sudah **100% complete** dengan semua fitur core.

File-file sudah diorganisir dengan struktur MVC CodeIgniter 3 yang proper dan bersih.

**Tinggal copy ke folder CI3, import database, dan akses!**

---

## 📞 NEXT STEPS

1. ✅ Jalankan `INSTALL.ps1` atau copy manual
2. ✅ Import `database.sql` ke phpMyAdmin
3. ✅ Edit `config/config.php` untuk base_url
4. ✅ Akses http://localhost/wisata_ci3/
5. 🎊 **Selesai! Sistem siap digunakan!**

---

**Selamat Menggunakan! 🚀**

**Happy Coding! 💻**
