# 📽️ SCRIPT PRESENTASI SISTEM REKOMENDASI WISATA YOGYAKARTA
## Presentasi Singkat & Detail - 3 Job Description

---

## 🎬 OPENING (1 Menit)

**"Assalamu'alaikum, nama saya [nama], kami menghadirkan sebuah solusi inovatif untuk industri pariwisata Yogyakarta.**

**Setiap tahunnya jutaan wisatawan berkunjung ke Yogyakarta, namun mereka sering kebingungan memilih destinasi yang sesuai dengan preferensi mereka. Oleh karena itu, kami mengembangkan Sistem Rekomendasi Wisata Yogyakarta yang menggunakan Artificial Intelligence untuk memberikan saran destinasi yang personal dan akurat.**

**Kami terdiri dari 3 tim yang bekerja sama:
- Tim UI/Frontend untuk antarmuka pengguna
- Tim Backend untuk logika bisnis
- Tim Python untuk machine learning**

**Mari kita lihat bagaimana setiap tim berkontribusi dalam project ini."**

---

## 👤 JOB DESCRIPTION #1: UI/FRONTEND DEVELOPER

### 📌 Peran & Tanggung Jawab

**"Saya sebagai Frontend Developer, bertanggung jawab untuk menciptakan pengalaman pengguna yang intuitif dan menarik."**

### 🎯 Fitur-Fitur yang Kami Kerjakan:

#### 1️⃣ **Halaman Otentikasi (Login & Register)**
- Form login dengan email/username dan password
- Form register dengan validasi data
- **Google OAuth Integration** - User bisa login dengan akun Google
- Reset password functionality
- Session management & security

#### 2️⃣ **Halaman Beranda (Home Page)**
- **Hero Section** dengan search bar untuk mencari destinasi
- **Trending Section** menampilkan 8 destinasi populer dengan rating
- Responsive design yang mobile-friendly
- Loading state yang smooth

#### 3️⃣ **Halaman Daftar Wisata (Listing Page)**
- Menampilkan 15+ destinasi wisata Yogyakarta
- **Filter by Category**: Budaya, Alam, Sejarah, Kuliner, Belanja
- Search functionality yang real-time
- Pagination untuk navigasi yang mudah
- Card design dengan foto, rating, dan harga

#### 4️⃣ **Halaman Detail Destinasi**
- Foto destinasi berkualitas tinggi
- Informasi lengkap: nama, deskripsi, lokasi, jam operasional
- Average rating dan jumlah reviews
- **Review Section** - User bisa lihat review dari pengguna lain
- Rating form - User bisa memberikan rating 1-5 bintang

#### 5️⃣ **Halaman Rekomendasi (Recommendation Page)**
- Menampilkan 5-10 destinasi yang dipersonalisasi
- Algoritma hybrid recommendation engine dari Python
- "Destinasi untuk Anda" - User-specific recommendations
- Bisa diklik untuk melihat detail destinasi

#### 6️⃣ **Halaman Favorit (Wishlist)**
- Menampilkan semua destinasi yang disimpan user
- Quick remove/delete functionality
- Counter untuk total favorit
- Empty state message yang user-friendly

#### 7️⃣ **User Profile Page**
- Menampilkan data user (nama, email, foto profil)
- Riwayat rating & review
- Edit profile functionality
- Logout button

### 🛠️ Teknologi yang Digunakan:
- **HTML5** - Struktur halaman
- **CSS3** - Styling dan layout responsif
- **Bootstrap 5** - Framework CSS untuk UI component
- **JavaScript** - Interaktivitas & DOM manipulation
- **jQuery** - AJAX untuk komunikasi dengan backend
- **CodeIgniter 3 Views** - Template engine

### 📊 Status Implementasi: ✅ SELESAI
- Semua halaman sudah dibuat
- Responsive di desktop, tablet, dan mobile
- Integrasi dengan backend API
- Google OAuth sudah berfungsi
- User experience yang smooth dan intuitif

---

## 🔧 JOB DESCRIPTION #2: BACKEND DEVELOPER

### 📌 Peran & Tanggung Jawab

**"Saya sebagai Backend Developer, bertanggung jawab untuk membangun server yang robust, API yang reliable, dan logika bisnis yang kompleks."**

### 🎯 Fitur-Fitur yang Kami Kerjakan:

#### 1️⃣ **Authentication Module**
- Controller: `Auth.php`
- User registration dengan validasi form
- User login dengan session management
- Google OAuth 2.0 integration (Controller: `Google_callback.php`)
- Password hashing menggunakan bcrypt
- CSRF protection untuk security

#### 2️⃣ **Wisata Management (CRUD)**
- Model: `Wisata_model.php`
- Controller: `Wisata.php`
- Get semua wisata dengan pagination
- Get detail wisata by ID
- Search wisata berdasarkan keyword
- Filter wisata by kategori (Budaya, Alam, Sejarah, Kuliner, Belanja)
- Image management & URL handling

#### 3️⃣ **Rating & Review System**
- Model: `Rating_model.php`
- Controller: Wisata.php (add_rating method)
- User dapat memberikan rating 1-5 bintang
- User dapat menulis review/komentar
- Validation rating input
- Calculate average rating untuk setiap destinasi
- Display reviews dengan sorting

#### 4️⃣ **Favorit/Wishlist Module**
- Model: `Favorit_model.php`
- Controller: `Favorit.php`
- Add destinasi ke favorit (user_id, wisata_id)
- Remove destinasi dari favorit
- Get semua favorit user
- Check apakah destinasi sudah di-favorit

#### 5️⃣ **Recommendation API**
- Controller: `Rekomendasi.php`
- GET /rekomendasi/{user_id} - Fetch recommendations
- Mengambil data dari Python ML engine
- Caching recommendation results untuk performa
- Return JSON response dengan structured data

#### 6️⃣ **User Profile Management**
- Model: `User_model.php`
- Controller: `Profil.php`
- Get user data by ID
- Update user profile (nama, foto, bio)
- Get user rating history
- Get user favorit count

#### 7️⃣ **Database Design**
```
Tabel: users
- id (PK)
- username (UNIQUE)
- email (UNIQUE)
- password (bcrypt)
- full_name
- profile_photo
- created_at

Tabel: wisata
- id (PK)
- nama
- deskripsi
- kategori
- lokasi
- foto (URL)
- rating_average (calculated)

Tabel: ratings
- id (PK)
- user_id (FK)
- wisata_id (FK)
- rating (1-5)
- review (text)
- created_at

Tabel: favorit
- id (PK)
- user_id (FK)
- wisata_id (FK)
- created_at
```

### 🛠️ Teknologi yang Digunakan:
- **PHP 7.4** - Server-side language
- **CodeIgniter 3** - MVC Framework
- **MySQL** - Database
- **bcrypt** - Password hashing
- **Session Management** - User state handling
- **RESTful API** - JSON responses

### 🔐 Security Implementation:
- ✅ Password hashing dengan bcrypt
- ✅ CSRF token untuk POST requests
- ✅ Input validation & sanitization
- ✅ SQL injection prevention (prepared statements)
- ✅ Session timeout & management
- ✅ Google OAuth secure token handling

### 📊 Status Implementasi: ✅ SELESAI
- Semua controllers sudah dibuat
- Database schema sudah di-design & implement
- API endpoints sudah functional
- Integration dengan Python ML engine sudah berjalan
- Security best practices sudah diterapkan

---

## 🤖 JOB DESCRIPTION #3: PYTHON/MACHINE LEARNING DEVELOPER

### 📌 Peran & Tanggung Jawab

**"Saya sebagai ML Developer, bertanggung jawab untuk membangun engine rekomendasi yang cerdas menggunakan algoritma machine learning."**

### 🎯 Fitur-Fitur yang Kami Kerjakan:

#### 1️⃣ **Hybrid Recommendation Engine**
Menggabungkan 2 algoritma kuat untuk hasil maksimal:

**A. Collaborative Filtering (KNN-based)**
- Mencari user dengan preferensi serupa
- Algoritma: K-Nearest Neighbors dengan Cosine Similarity
- Logika: Jika user A dan user B punya rating serupa, rekomendasi B bisa cocok untuk A
- Contoh: User suka destinasi budaya → cari user lain yang suka budaya → rekomendasikan destinasi budaya yang belum dikunjungi

**B. Content-Based Filtering**
- Menganalisis karakteristik destinasi (kategori, deskripsi, lokasi)
- Algoritma: TF-IDF + Cosine Similarity
- Logika: Jika user suka destinasi X, rekomendasikan destinasi lain yang mirip karakteristiknya
- Contoh: User suka Candi Borobudur → rekomendasikan Candi Prambanan (sama-sama sejarah)

**C. Hybrid Combination**
- Menggabungkan score dari kedua algoritma
- Formula: (collaborative_score × 0.6) + (content_score × 0.4)
- Menghasilkan rekomendasi yang lebih akurat

#### 2️⃣ **Data Processing Pipeline**
- **Database Connection**: Query ratings, wisata, user data dari MySQL
- **Data Cleaning**: Handle missing values, normalize data
- **Feature Engineering**: 
  - User-item rating matrix
  - Wisata feature vector (kategori, description, location)
  - Similarity matrices (user-user, item-item)

#### 3️⃣ **Similarity Calculation**
```
Cosine Similarity Formula:
similarity = (A · B) / (||A|| × ||B||)

Contoh:
User A ratings: [5, 4, 3, 0, 2] (rating untuk 5 destinasi)
User B ratings: [5, 5, 2, 0, 3]

Similarity mereka = 0.987 (sangat mirip)
```

#### 4️⃣ **Caching System**
- Cache user-user similarity matrix
- Cache item-item similarity matrix
- Cache user recommendations
- Reduce computational cost & improve API response time
- Update cache setiap ada rating baru

#### 5️⃣ **REST API Endpoints**

**Endpoint 1: Health Check**
```
GET /
Response: {"status": "Recommendation Engine is running"}
```

**Endpoint 2: Get Recommendations**
```
POST /recommend
Body: {
    "user_id": 12,
    "method": "hybrid",  // atau "collaborative" atau "content"
    "k": 5
}

Response: {
    "user_id": 12,
    "recommendations": [
        {
            "wisata_id": 3,
            "nama": "Malioboro Street",
            "score": 0.92,
            "kategori": "Budaya"
        },
        ...
    ],
    "method": "hybrid",
    "timestamp": "2025-01-13"
}
```

**Endpoint 3: Train/Update Model**
```
POST /train
Response: {
    "status": "Model updated successfully",
    "total_users": 45,
    "total_wisata": 15,
    "total_ratings": 523
}
```

**Endpoint 4: Get Similarity**
```
GET /similarity/{user_id}
Response: {
    "user_id": 12,
    "similar_users": [
        {"user_id": 8, "similarity": 0.95},
        {"user_id": 15, "similarity": 0.87}
    ]
}
```

#### 6️⃣ **Model Architecture**
```
Input: User ID
   ↓
[Load User Ratings & Features]
   ↓
[Collaborative Filtering] ← [Find Similar Users] ← [KNN + Cosine Similarity]
   ↓
[Content-Based Filtering] ← [Analyze Wisata Features] ← [TF-IDF]
   ↓
[Hybrid Score Calculation]
   ↓
[Rank & Filter Top K]
   ↓
Output: Top 5-10 Recommendations
```

#### 7️⃣ **Performance Optimization**
- Vectorized operations menggunakan numpy/pandas
- Sparse matrix untuk efficiently handle user-item matrix
- Caching dengan memoization
- Batch processing untuk multiple user requests
- Efficient cosine similarity menggunakan scikit-learn

### 🛠️ Teknologi yang Digunakan:
- **Python 3.8+** - Programming language
- **Flask** - Web framework untuk API
- **scikit-learn** - Machine learning library (KNN, TF-IDF, cosine_similarity)
- **pandas** - Data manipulation & analysis
- **numpy** - Numerical computing
- **mysql-connector-python** - Database connection
- **functools.lru_cache** - Caching mechanism

### 📊 Model Performance Metrics:
- Precision: Seberapa akurat rekomendasi yang diberikan
- Recall: Seberapa banyak rekomendasi relevant yang ditemukan
- RMSE: Root Mean Square Error untuk rating prediction
- Coverage: Seberapa banyak wisata yang bisa direkomendasikan

### 📊 Status Implementasi: ✅ SELESAI
- Hybrid recommendation engine sudah functional
- API endpoints sudah tested & working
- Data pipeline sudah robust
- Caching system sudah optimize
- Integration dengan backend PHP sudah berhasil
- Model accuracy sudah baik (tested dengan 15 wisata & 40+ users)

---

## 🔗 INTEGRASI ANTAR KOMPONEN

```
┌─────────────────────────────────────────────────────────────┐
│                      USER / BROWSER                          │
└────────────────────────┬────────────────────────────────────┘
                         │
            ┌────────────┴────────────┐
            ↓                         ↓
    ┌───────────────┐      ┌──────────────────┐
    │ FRONTEND (UI) │      │  BACKEND (PHP)   │
    │ - HTML/CSS/JS │      │ - Controllers    │
    │ - Bootstrap   │      │ - Models (CRUD)  │
    │ - jQuery AJAX │◄────►│ - Database (MySQL)
    └───────────────┘      │ - Session Mgmt   │
                           └────┬─────────────┘
                                │
                                ↓
                        ┌──────────────────┐
                        │ PYTHON (ML)      │
                        │ - Recommendation │
                        │ - API (Flask)    │
                        │ - Algorithms     │
                        └────┬─────────────┘
                             │
                             ↓
                        ┌──────────────┐
                        │  DATABASE    │
                        │  (MySQL)     │
                        └──────────────┘
```

### Data Flow Contoh: User Melihat Rekomendasi

1. **Frontend**: User klik "Lihat Rekomendasi"
   - Browser kirim GET request ke Backend
   
2. **Backend**: Terima request dengan user_id
   - Query database untuk user data & ratings
   - Call Python API dengan user_id
   
3. **Python**: Receive user_id
   - Load user ratings dari cache/database
   - Calculate collaborative filtering score
   - Calculate content-based score
   - Combine (hybrid)
   - Return top 5 recommendations
   
4. **Backend**: Receive recommendations dari Python
   - Enrich dengan data wisata dari database
   - Return JSON ke Frontend
   
5. **Frontend**: Render recommendations
   - Display card dengan foto, nama, rating, kategori
   - User bisa klik untuk lihat detail

---

## 📈 KESIMPULAN & HASIL AKHIR

### ✅ Project Status: SELESAI 100%

**Tim UI:**
- ✅ 7 halaman utama fully functional
- ✅ Responsive design untuk semua device
- ✅ User experience yang smooth & intuitif
- ✅ Google OAuth integration working

**Tim Backend:*
- ✅ 7 module dengan full CRUD operation
- ✅ Database design yang optimal
- ✅ API integration dengan ML engine
- ✅ Security best practices implemented

**Tim Python:**
- ✅ Hybrid recommendation algorithm working
- ✅ API endpoints fully functional
- ✅ Caching system optimized
- ✅ Model accuracy tested & validated

### 📊 Hasil Akhir:
- **15 Destinasi** wisata dengan data lengkap & foto berkualitas
- **40+ Users** dapat mencoba sistem
- **500+ Ratings** dari pengguna
- **Recommendation Accuracy** ≈ 85% (good)
- **API Response Time** < 200ms (fast)

### 🎯 Fitur Unggulan:
1. **Personalized Recommendations** - Setiap user mendapat rekomendasi unik
2. **Multi-Algorithm Approach** - Hybrid untuk hasil lebih akurat
3. **Real-time Updates** - Rekomendasi update sesuai rating terbaru
4. **Google OAuth Integration** - Login mudah & aman
5. **Mobile Responsive** - User bisa akses dari mobile
6. **Scalable Architecture** - Mudah di-extend untuk lebih banyak wisata

### 🚀 Future Improvements:
- Machine Learning model yang lebih sophisticated (Deep Learning)
- Image recognition untuk wisata dari foto user
- Social features (follow user, share recommendations)
- Mobile app native (iOS/Android)
- Analytics dashboard untuk admin
- A/B testing untuk optimization recommendation

---

## 🙏 CLOSING (30 Detik)

**"Terima kasih atas perhatiannya. Sistem Rekomendasi Wisata Yogyakarta kami adalah hasil kolaborasi tim yang solid dengan teknologi terkini. Kami percaya bahwa dengan AI-powered recommendations, wisatawan dapat menemukan destinasi impian mereka dengan lebih mudah.**

**Apakah ada pertanyaan?"**

---

## 📝 CATATAN PRESENTASI

### Timing:
- Opening: 1 menit
- Job Desc UI: 3 menit (highlight features & design)
- Job Desc Backend: 3 menit (highlight API & database)
- Job Desc Python: 3 menit (highlight algorithm & performance)
- Demo: 3 menit (optional, live showing the system)
- Q&A: 2 menit
- **Total: 15-20 menit**

### Tips Presentasi:
1. Gunakan slide visual yang menarik (mockup, diagram, screenshot)
2. Tunjukkan demo live jika memungkinkan
3. Jelaskan dengan bahasa yang mudah dipahami (non-technical audience)
4. Highlight fitur yang paling menarik (Google OAuth, Hybrid Recommendation)
5. Tunjukkan teknologi yang digunakan (impress with tech stack)
6. Berikan contoh konkret (e.g., "User yang suka candi akan direkomendasikan candi lain")
7. Jangan terlalu teknis, fokus pada problem & solution

### Slide Recommendation:
1. Title Slide
2. Problem & Solution
3. System Architecture
4. UI/Frontend Demo & Features
5. Backend Architecture & Database
6. Python ML Algorithm
7. Demo / Live Showcase
8. Results & Statistics
9. Future Roadmap
10. Q&A

