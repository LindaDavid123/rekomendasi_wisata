# 🎯 PANDUAN INSTALASI & PENGGUNAAN
## Sistem Rekomendasi Wisata Yogyakarta

---

## 📋 Perubahan Terbaru

### ✨ **Desain Baru - Beige Minimalist Style** (Inspired by FlyHigh)
- **Hero Section** dengan background beige/cream (#E8E4DC) yang clean dan modern
- **Navbar** minimalis dengan white background dan dark text
- **Search Form** yang disederhanakan: hanya 3 field utama (Location, Activity, Date)
- **Black Round Search Button** yang elegant
- **Trending Section** dengan horizontal scrollable cards
- **Hero Image** candi Prambanan di sisi kanan
- **Responsive Design** untuk semua ukuran layar

### 🔧 **Backend Authentication Fixed**
- ✅ Login & Register sekarang **sudah berfungsi**
- ✅ Support login dengan **username atau email**
- ✅ Session management sudah diperbaiki
- ✅ Password hashing dengan bcrypt
- ✅ Form validation lengkap

---

## 🚀 Cara Instalasi

### 1. **Setup Database**

Buka phpMyAdmin atau MySQL client, lalu import database:

```sql
-- Buka file database.sql dan jalankan semua query
-- Atau import via phpMyAdmin
```

**Atau jalankan manual:**

```bash
mysql -u root -p
```

```sql
CREATE DATABASE rekomendasi_wisata;
USE rekomendasi_wisata;
SOURCE C:/xampp/htdocs/rekomendasi_wisata/database.sql;
```

### 2. **Konfigurasi Database**

Edit file `application/config/database.php`:

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',           // Sesuaikan
    'password' => '',               // Sesuaikan
    'database' => 'rekomendasi_wisata',
    'dbdriver' => 'mysqli',
    // ...
);
```

### 3. **Konfigurasi Base URL**

Edit file `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/rekomendasi_wisata/';
```

### 4. **Start XAMPP**

- Jalankan **Apache**
- Jalankan **MySQL**

### 5. **Akses Aplikasi**

Buka browser dan kunjungi:
```
http://localhost/rekomendasi_wisata
```

---

## 👤 Akun Default

### **Admin**
- **Username**: `admin`
- **Password**: `password`
- **Email**: `admin@wisatajogja.com`

### **User Baru**
Silakan **daftar** melalui halaman register:
```
http://localhost/rekomendasi_wisata/auth/register
```

**Form Register:**
- Nama Lengkap
- Username (min 3 karakter, unique)
- Email (valid email, unique)
- Password (min 6 karakter)
- Konfirmasi Password

---

## 🎨 Fitur Landing Page Baru

### **Navigation Bar**
- Logo: JogjaTrip
- Menu: Destination, Bookings, Activities
- Auth: Log in, Sign up (button), Search icon

### **Hero Section**
- **Judul Besar**: "Candi Prambanan" (72px, bold)
- **Subtitle**: "Wisata Budaya Yogyakarta"
- **Info**: Temperature (32°C) dan Location (Sleman, DIY)
- **Hero Image**: Foto Prambanan di sebelah kanan

### **Search Form** (Simplified)
- **3 Field Only**:
  1. **Location**: Input text untuk destinasi
  2. **Activity**: Dropdown kategori wisata
  3. **Date**: Date picker
- **Search Button**: Black circular button dengan icon search

### **Trending Section**
- Judul: "Trending 2026"
- Subtitle: "Spot Brilliant reasons..."
- Horizontal scroll cards dengan:
  - Foto wisata
  - Rating badge
  - Nama destinasi
  - Lokasi
- Navigation buttons (left/right arrows)

### **Cards Trending**
Tampil otomatis:
1. Candi Prambanan (⭐ 4.8) - Sleman
2. Pantai Parangtritis (⭐ 4.6) - Bantul  
3. Malioboro Street (⭐ 4.7) - Kota Yogyakarta
4. Tebing Breksi (⭐ 4.5) - Sleman

---

## 🔐 Testing Login & Register

### **Test Register**

1. Kunjungi: `http://localhost/rekomendasi_wisata/auth/register`
2. Isi form:
   ```
   Nama Lengkap: John Doe
   Username: johndoe
   Email: john@example.com
   Password: password123
   Konfirmasi Password: password123
   ```
3. Klik **"Daftar Sekarang"**
4. Jika berhasil → redirect ke halaman login dengan pesan sukses
5. Jika gagal → tampil error validation (username/email sudah ada, password tidak match, dll)

### **Test Login**

1. Kunjungi: `http://localhost/rekomendasi_wisata/auth/login`
2. Isi form dengan salah satu:
   - **Username**: `admin` atau `johndoe`
   - **Email**: `admin@wisatajogja.com` atau `john@example.com`
   - **Password**: `password` (admin) atau `password123` (johndoe)
3. Klik **"Log In"**
4. Jika berhasil → redirect ke dashboard dengan pesan "Login berhasil! Selamat datang, [Nama]"
5. Jika gagal → tampil error "Username/Email atau password salah!"

### **Fitur Login**
✅ Support login dengan **username ATAU email**
✅ Password hashing dengan **bcrypt**
✅ Session persistent
✅ Redirect based on role (admin → admin dashboard, user → home dashboard)
✅ Form validation lengkap
✅ Flash messages untuk feedback

---

## 📱 Responsiveness

### Desktop (> 992px)
- Hero image visible di kanan
- Search form horizontal
- Trending cards 4 kolom scroll

### Tablet (768px - 992px)
- Hero image hidden
- Search form tetap horizontal
- Trending cards 3 kolom scroll

### Mobile (< 768px)
- Navigation collapsed
- Hero title 42px (dari 72px)
- Search form vertical stack
- Trending cards 1-2 kolom scroll

---

## 🎨 Color Palette

### **Primary Colors**
- **Background**: `#E8E4DC` (Beige/Cream)
- **Card**: `#FFFFFF` (White)
- **Text Dark**: `#1a1a1a` (Almost Black)
- **Text Gray**: `#666666`

### **Accent Colors**
- **Button**: `#1a1a1a` (Black)
- **Hover**: `#666666` (Gray)

### **Auth Page Colors** (Login/Register)
- **Background**: `linear-gradient(135deg, #c5d5c5 0%, #d4e0d4 100%)` (Green Pastel)
- **Sidebar**: `linear-gradient(135deg, #a8c5a8 0%, #c5d5c5 100%)`
- **Button**: `linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%)` (Green)

---

## 🐛 Troubleshooting

### **Error: Page Not Found (404)**
- Pastikan `.htaccess` ada di root folder
- Cek `$config['base_url']` di `config/config.php`
- Enable mod_rewrite di Apache

### **Error: Database Connection Failed**
- Cek MySQL sudah running
- Verifikasi username/password di `config/database.php`
- Pastikan database `rekomendasi_wisata` sudah dibuat

### **Error: Login/Register Tidak Berfungsi**
- Cek table `users` sudah ada
- Pastikan field database match:
  - `nama` (bukan `nama_lengkap`)
  - `foto` (bukan `foto_profil`)
  - `google_id` (untuk OAuth)
- Run ulang `database.sql` jika perlu

### **Error: Session Tidak Tersimpan**
- Cek folder `application/cache` writable
- Set session library di `config/autoload.php`:
  ```php
  $autoload['libraries'] = array('database', 'session');
  ```

### **Error: CSS/JS Tidak Load**
- Cek base_url sudah benar
- Periksa folder `assets/` accessible
- Hard refresh browser (Ctrl+F5)

---

## 📁 Struktur Folder

```
rekomendasi_wisata/
├── application/
│   ├── controllers/
│   │   ├── Auth.php          ✅ FIXED - Login & Register
│   │   ├── Home.php           ✅ UPDATED - Landing & Dashboard
│   │   └── ...
│   ├── models/
│   │   ├── User_model.php     ✅ UPDATED - login_by_email()
│   │   └── ...
│   ├── views/
│   │   ├── home/
│   │   │   └── index.php      ✅ NEW DESIGN - Beige Minimalist
│   │   ├── auth/
│   │   │   ├── login.php      ✅ FIXED - Support username/email
│   │   │   └── register.php   ✅ FIXED - All fields match
│   │   └── ...
│   └── config/
│       ├── routes.php         ✅ All routes configured
│       └── database.php       ⚠️ Sesuaikan kredensial
├── assets/                    ✅ Bootstrap 5, Font Awesome
├── database.sql               ✅ UPDATED - Schema match
└── PANDUAN_INSTALASI.md       📖 File ini
```

---

## 🎯 Next Steps (Opsional)

### **Halaman Yang Perlu Update** (Sesuai Todo List)

1. ⬜ **Halaman Wisata (Browse)**
   - Update dengan sidebar navigation
   - Modern card grid layout
   - Filter & search functionality

2. ⬜ **Halaman Detail Wisata**
   - Gallery dengan lightbox
   - Review section
   - Rating display
   - Sidebar integration

3. ⬜ **Halaman Rekomendasi**
   - Tabs untuk tipe rekomendasi
   - Card-based layout
   - AI recommendation display

4. ⬜ **Halaman Favorit**
   - Grid layout untuk wisata favorit
   - Quick actions (remove, share)

5. ⬜ **Halaman Profil**
   - Stats cards (wisata visited, reviews, favorites)
   - Edit profile form
   - Upload foto profil

---

## 💡 Tips Penggunaan

### **Sebagai Visitor (Not Logged In)**
- ✅ Lihat landing page dengan hero section baru
- ✅ Browse trending wisata
- ✅ Search wisata dengan form sederhana
- ✅ Lihat semua destinasi di halaman Wisata
- ❌ Tidak bisa: rating, review, favorit, rekomendasi AI

### **Sebagai User (Logged In)**
- ✅ Semua fitur visitor
- ✅ Dashboard dengan sidebar navigation
- ✅ Rating & review wisata
- ✅ Tambah ke favorit
- ✅ Rekomendasi AI berdasarkan preferensi
- ✅ Edit profil

### **Sebagai Admin**
- ✅ Semua fitur user
- ✅ Admin dashboard
- ✅ Manage wisata (CRUD)
- ✅ Manage users
- ✅ View statistics & analytics

---

## 📞 Support

Jika ada masalah atau pertanyaan:
1. Check troubleshooting section di atas
2. Periksa error log di `application/logs/`
3. Check browser console untuk JS errors
4. Verify database connection & structure

---

## ✅ Checklist Instalasi

- [ ] XAMPP installed & running (Apache + MySQL)
- [ ] Database `rekomendasi_wisata` created
- [ ] File `database.sql` imported successfully
- [ ] `config/database.php` configured
- [ ] `config/config.php` base_url set
- [ ] Open `http://localhost/rekomendasi_wisata`
- [ ] Landing page muncul dengan design beige baru
- [ ] Trending section tampil dengan 4 cards
- [ ] Search form ada 3 fields
- [ ] Test register: form bisa submit
- [ ] Test login dengan admin: `admin` / `password`
- [ ] Login berhasil → redirect ke dashboard
- [ ] Session tersimpan (nama muncul di navbar)

---

## 🎉 Selamat!

Website **Sistem Rekomendasi Wisata Yogyakarta** sudah siap digunakan dengan:
- ✨ Design baru yang modern & minimalist (Beige theme)
- 🔐 Authentication yang berfungsi (Login & Register)
- 📱 Responsive design untuk semua device
- 🎨 UI/UX yang clean dan user-friendly
- 🤖 Hybrid recommendation algorithm (Collaborative + Item-Based)

**Selamat Menjelajahi Yogyakarta! 🏝️**
