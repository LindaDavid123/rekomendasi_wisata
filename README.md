# 🏨 Rekomendasi Wisata Yogyakarta

**AI-Powered Tourism Recommendation System** using Hybrid Machine Learning Approach (Collaborative Filtering + Content-Based Filtering)

[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.1+-red.svg)](https://codeigniter.com/)
[![Python](https://img.shields.io/badge/Python-3.8+-green.svg)](https://www.python.org/)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen.svg)](#)

---

## 📖 Daftar Isi

- [Deskripsi Proyek](#-deskripsi-proyek)
- [Fitur Utama](#-fitur-utama)
- [Sistem Rekomendasi](#-sistem-rekomendasi)
- [Tech Stack](#-tech-stack)
- [Quick Start](#-quick-start)
- [Instalasi Lengkap](#-instalasi-lengkap)
- [Konfigurasi Database](#-konfigurasi-database)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Dokumentasi API](#-dokumentasi-api)
- [Struktur Proyek](#-struktur-proyek)
- [Screenshots](#-screenshots)
- [Roadmap](#-roadmap)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)
- [Kontak](#-kontak)

---

## 🎯 Deskripsi Proyek

**Rekomendasi Wisata Yogyakarta** adalah sistem web yang dirancang untuk membantu wisatawan menemukan destinasi wisata yang paling sesuai dengan preferensi mereka. 

Dengan teknologi **Hybrid Recommendation Engine**, aplikasi ini menggabungkan dua pendekatan machine learning:
- **Collaborative Filtering**: Menemukan pengguna dengan preferensi serupa
- **Content-Based Filtering**: Merekomendasikan wisata dengan karakteristik serupa

Sistem ini cocok untuk:
- 🎓 **Capstone Project/Portfolio**: Mendemonstrasikan full-stack development dan machine learning
- 💼 **Production Deployment**: Dapat diintegrasikan dengan platform travel atau tourism board
- 🔬 **Research**: Studi tentang recommendation systems di industry pariwisata
- 📚 **Learning Resource**: Educational project untuk memahami recommendation algorithms

---

## ✨ Fitur Utama

### 🔐 Sistem Autentikasi
- ✅ Login/Register dengan email
- ✅ Google OAuth integration
- ✅ Session management
- ✅ Password encryption (bcrypt)
- ✅ Forgot password functionality

### 🎯 Sistem Rekomendasi
- ✅ Hybrid recommendation engine
- ✅ Collaborative filtering (KNN-based)
- ✅ Content-based filtering (TF-IDF)
- ✅ Intelligent caching untuk performance
- ✅ Personalized recommendations
- ✅ Cold start problem handling

### ⭐ Rating & Review System
- ✅ User ratings (1-5 stars)
- ✅ Detailed reviews/comments
- ✅ Rating history
- ✅ Review moderation (admin)
- ✅ Rating statistics per wisata

### ❤️ Favorites/Wishlist
- ✅ Add/remove favorites
- ✅ Favorites list management
- ✅ Quick access to saved destinations
- ✅ Export favorites

### 🏢 Admin Dashboard
- ✅ Wisata CRUD operations
- ✅ User management
- ✅ Rating/review moderation
- ✅ Statistics & analytics
- ✅ Recommendation algorithm monitoring
- ✅ Performance metrics

### 📊 Wisata Directory
- ✅ Browse all attractions
- ✅ Advanced filtering & search
- ✅ Category-based browsing
- ✅ Price range filter
- ✅ Rating-based sorting
- ✅ Detailed information pages

---

## 🤖 Sistem Rekomendasi

### Algoritma Hybrid

Sistem rekomendasi menggunakan **hybrid approach** yang menggabungkan:

#### 1. **Collaborative Filtering (KNN-based)**
```
User Preference Similarity → KNN → Recommend liked attractions of similar users
```
- **Algoritma**: K-Nearest Neighbors (KNN)
- **Similarity Metric**: Cosine Similarity
- **Use Case**: Menemukan pengguna dengan preferensi serupa
- **Keuntungan**: Mengatasi "serendipity" (rekomendasi yang unexpected tapi relevan)

#### 2. **Content-Based Filtering (TF-IDF)**
```
Attraction Features (TF-IDF) → Cosine Similarity → Similar Attractions
```
- **Algoritma**: TF-IDF (Term Frequency-Inverse Document Frequency)
- **Similarity Metric**: Cosine Similarity
- **Features**: Category, description, attributes
- **Keuntungan**: Good for cold start problem, transparent recommendations

#### 3. **Hybrid Combination**
```
Score = (α × Collaborative_Score) + ((1-α) × Content_Based_Score)
```
- **Default α (alpha)**: 0.6 (60% collaborative, 40% content-based)
- **Configurable**: Dapat disesuaikan via environment variable
- **Keuntungan**: Balanced approach menangani berbagai skenario

### Rekomendasi Flow

```
User Request
    ↓
[1] Cek Cache (if existing user)
    ↓
[2] Get User Ratings & Preferences
    ↓
[3] Run Collaborative Filtering
    ├── Find similar users (KNN)
    └── Get their rated attractions
    ↓
[4] Run Content-Based Filtering
    ├── Get user's liked attractions
    ├── Find similar attractions (TF-IDF)
    └── Score by similarity
    ↓
[5] Hybrid Score Combination
    └── Weighted merge of both methods
    ↓
[6] Ranking & Filtering
    ├── Remove already-rated attractions
    ├── Sort by relevance score
    └── Apply filters (price, category, etc)
    ↓
[7] Cache Result (24 hours)
    ↓
Return Recommendations to User
```

### Handling Special Cases

**Cold Start Problem** (New User):
- Tidak ada rating history
- **Solution**: Recommend popular attractions + ask for preferences
- Recommend attractions dengan rating tinggi
- Suggestions berdasarkan category preferences

**New Attraction**:
- Tidak ada ratings yet
- **Solution**: Recommend based on content similarity
- Popular dalam category-nya
- Manual ranking oleh admin

**New User + New Attraction**:
- **Solution**: Show popular destinations
- Gradually learn as user rates attractions

---

## 🛠️ Tech Stack

### Backend
| Technology | Version | Purpose |
|-----------|---------|---------|
| **PHP** | 8.2+ | Server-side scripting |
| **CodeIgniter** | 3.1+ | Web framework & MVC |
| **MySQL/MariaDB** | 10.4+ | Database |
| **Python** | 3.8+ | ML engine |
| **Flask** | 2.0+ | Python web framework |

### Frontend
| Technology | Purpose |
|-----------|---------|
| **HTML5** | Markup |
| **Bootstrap 5** | Responsive UI |
| **JavaScript (Vanilla)** | Client-side logic |
| **jQuery** | DOM manipulation |
| **CSS3** | Styling |

### Machine Learning
| Library | Version | Purpose |
|---------|---------|---------|
| **scikit-learn** | 1.0+ | ML algorithms |
| **pandas** | 1.3+ | Data manipulation |
| **NumPy** | 1.21+ | Numerical computing |
| **TF-IDF** | (scikit-learn) | Text vectorization |

### Database Design
| Table | Purpose |
|-------|---------|
| `users` | User accounts & profiles |
| `wisata` | Attraction data |
| `ratings` | User ratings |
| `reviews` | User reviews |
| `favorites` | User wishlist |
| `recommendation_cache` | Cached recommendations |

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 or higher
- Python 3.8 or higher
- MySQL/MariaDB 10.4+
- Composer (PHP package manager)
- Git

### Installation (5 minutes)

```bash
# 1. Clone repository
git clone https://github.com/yourusername/rekomendasi-wisata.git
cd rekomendasi-wisata

# 2. Copy environment file
cp .env.example .env

# 3. Update .env with your database credentials
nano .env

# 4. Install PHP dependencies (if using Composer)
composer install

# 5. Setup Python environment
cd python
python -m venv venv

# Activate virtual environment
# On Windows:
venv\Scripts\activate
# On Linux/Mac:
source venv/bin/activate

# 6. Install Python dependencies
pip install -r requirements.txt

# 7. Import database
mysql -u root -p rekomendasi_wisata < rekomendasi_wisata.sql

# 8. Start Python service (in python/ directory)
python app.py
# Service will run on http://localhost:5000

# 9. Start PHP development server (in project root)
php -S localhost:8000

# 10. Open in browser
# http://localhost:8000
```

---

## 📋 Instalasi Lengkap

### Step 1: Prepare Environment

```bash
# Clone repository
git clone https://github.com/yourusername/rekomendasi-wisata.git
cd rekomendasi-wisata

# Create .env file from template
cp .env.example .env
```

### Step 2: Configure Database

```bash
# Edit .env file with your database credentials
# Change these values:
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=your_password
DB_NAME=rekomendasi_wisata

# Import database schema
mysql -u root -p < rekomendasi_wisata.sql

# Or if using MariaDB:
mariadb -u root -p < rekomendasi_wisata.sql
```

### Step 3: Setup PHP Application

```bash
# Place files in web root (usually /var/www/html or C:\xampp\htdocs)
# No additional composer packages required for basic setup

# Verify .htaccess is present for URL routing
# If using Apache, enable mod_rewrite:
a2enmod rewrite
systemctl restart apache2
```

### Step 4: Setup Python Microservice

```bash
cd python

# Create virtual environment
python -m venv venv

# Activate virtual environment
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt

# Test installation
python -c "import flask, sklearn, pandas; print('All packages installed!')"
```

### Step 5: Database Verification

```bash
# Connect to MySQL
mysql -u root -p

# Check database
use rekomendasi_wisata;
show tables;

# Expected tables:
# - users
# - wisata
# - ratings
# - reviews
# - favorites
# - recommendation_cache
```

### Step 6: Application Configuration

```bash
# Update CodeIgniter config if needed
# Edit application/config/config.php
# - base_url: http://localhost:8000/
# - index_page: '' (empty for clean URLs)
# - uri_protocol: 'REQUEST_URI'

# Update database config
# Edit application/config/database.php
# Or better: use .env variables (require phpdotenv library)
```

---

## 🔧 Konfigurasi Database

### Database Schema

```sql
-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    nama VARCHAR(255),
    google_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Wisata (Attractions) table
CREATE TABLE wisata (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255),
    kategori VARCHAR(100),
    deskripsi TEXT,
    alamat TEXT,
    harga INT,
    rating_avg FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ratings table
CREATE TABLE ratings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    wisata_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (wisata_id) REFERENCES wisata(id)
);

-- Reviews table
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    wisata_id INT,
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (wisata_id) REFERENCES wisata(id)
);

-- Favorites table
CREATE TABLE favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    wisata_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (wisata_id) REFERENCES wisata(id)
);

-- Recommendation cache
CREATE TABLE recommendation_cache (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    recommendations JSON,
    method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Indexing for Performance

```sql
-- Add indexes to frequently queried columns
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_rating_user ON ratings(user_id);
CREATE INDEX idx_rating_wisata ON ratings(wisata_id);
CREATE INDEX idx_review_user ON reviews(user_id);
CREATE INDEX idx_favorite_user ON favorites(user_id);
CREATE INDEX idx_cache_user ON recommendation_cache(user_id);
```

---

## ▶️ Menjalankan Aplikasi

### Development Environment

```bash
# Terminal 1: Start Python microservice
cd python
source venv/bin/activate  # or venv\Scripts\activate on Windows
python app.py

# Output:
# Running on http://127.0.0.1:5000/ (Press CTRL+C to quit)
```

```bash
# Terminal 2: Start PHP development server
cd rekomendasi-wisata
php -S localhost:8000

# Output:
# [date] PHP 8.2.0 Development Server started...
# Listening on http://localhost:8000
```

```bash
# Terminal 3: Open browser
# http://localhost:8000

# Default credentials:
# Email: admin@example.com
# Password: admin123
```

### Production Environment

See [docs/deployment-guide.md](docs/deployment-guide.md) for:
- Nginx configuration
- Apache configuration
- SSL setup
- Performance tuning
- Security hardening

---

## 📡 Dokumentasi API

### Python Microservice Endpoints

#### Health Check
```http
GET /
```
Response: `{"status": "healthy"}`

#### Get Recommendations
```http
POST /recommend
Content-Type: application/json

{
    "user_id": 12,
    "method": "hybrid",
    "k": 5,
    "n_recommendations": 10,
    "alpha": 0.6
}
```

**Parameters:**
- `user_id` (required): User identifier
- `method` (optional): "collaborative", "content_based", or "hybrid" (default: "hybrid")
- `k` (optional): Number of neighbors (default: 5)
- `n_recommendations` (optional): Number of results (default: 10)
- `alpha` (optional): Collaborative weight 0-1 (default: 0.6)

**Response:**
```json
{
    "recommendations": [
        {
            "wisata_id": 9,
            "nama": "Borobudur Temple",
            "score": 0.87,
            "method": "hybrid"
        },
        ...
    ],
    "execution_time_ms": 45
}
```

#### Find Similar Attractions
```http
POST /similar-wisata
Content-Type: application/json

{
    "wisata_id": 9,
    "k": 5
}
```

#### Refresh Cache
```http
POST /refresh-cache
```

#### Statistics
```http
GET /stats
```

---

## 📁 Struktur Proyek

```
rekomendasi-wisata/
│
├── 📄 README.md                 # Project documentation (this file)
├── 📄 .gitignore               # Git ignore rules
├── 📄 .env.example             # Environment template
├── 📄 index.php                # Application entry point
├── 📄 rekomendasi_wisata.sql   # Database schema
│
├── 📁 application/             # CodeIgniter application
│   ├── config/                 # Configuration files
│   ├── controllers/            # Business logic
│   │   ├── Auth.php
│   │   ├── Rekomendasi.php
│   │   ├── Wisata.php
│   │   ├── Favorit.php
│   │   ├── Dashboard.php
│   │   └── admin/
│   ├── models/                 # Data access layer
│   │   ├── Recommendation_model.php
│   │   ├── Wisata_model.php
│   │   ├── Rating_model.php
│   │   ├── User_model.php
│   │   └── Favorit_model.php
│   ├── views/                  # UI templates
│   │   ├── home/
│   │   ├── auth/
│   │   ├── rekomendasi/
│   │   ├── wisata/
│   │   ├── favorit/
│   │   └── admin/
│   ├── helpers/                # Utility functions
│   ├── libraries/              # Custom libraries
│   ├── logs/                   # Application logs
│   └── cache/                  # Session cache
│
├── 📁 system/                  # CodeIgniter framework (do not modify)
│
├── 📁 assets/                  # Static files
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── images/                 # Images & icons
│
├── 📁 python/                  # Python recommendation engine
│   ├── app.py                  # Flask application
│   ├── db_loader.py            # Database utilities
│   ├── requirements.txt        # Python dependencies
│   ├── venv/                   # Virtual environment
│   ├── README.md               # Python service docs
│   └── tests/                  # Unit tests
│
├── 📁 database/                # Database files
│   ├── schema.sql              # Full schema
│   ├── migrations/             # Future migrations
│   └── seeds/                  # Initial data
│
├── 📁 docs/                    # Documentation
│   ├── architecture.md         # System architecture
│   ├── recommendation-system.md # Algorithm details
│   ├── database-schema.md      # Database design
│   ├── api.md                  # API documentation
│   ├── deployment-guide.md     # Production setup
│   ├── troubleshooting.md      # Common issues
│   └── development-setup.md    # Local dev guide
│
├── 📁 screenshots/             # UI screenshots
│   ├── homepage.png
│   ├── recommendations.png
│   ├── admin-dashboard.png
│   └── database-erd.png
│
└── 📁 uploads/                 # User-uploaded files (git-ignored)
    └── .gitkeep
```

---

## 📸 Screenshots

### Homepage
![Homepage](screenshots/homepage.png)
*User-friendly interface untuk browsing attractions*

### Recommendation Page
![Recommendations](screenshots/recommendations.png)
*AI-powered personalized recommendations*

### Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)
*Complete admin control panel*

### Database ERD
![Database ERD](screenshots/database-erd.png)
*Normalized database schema*

---

## 🚦 Roadmap

### Version 1.0 (Current)
- ✅ User authentication
- ✅ Hybrid recommendation engine
- ✅ Rating & review system
- ✅ Favorites management
- ✅ Admin dashboard
- ✅ Basic UI

### Version 1.1 (Planned)
- [ ] Advanced filtering
- [ ] User profiles
- [ ] Recommendation statistics
- [ ] Export/import features
- [ ] API rate limiting

### Version 2.0 (Future)
- [ ] Mobile app (React Native)
- [ ] Deep learning models (Neural networks)
- [ ] Real-time recommendations
- [ ] Social features
- [ ] Payment integration
- [ ] Analytics dashboard

### Version 3.0 (Research)
- [ ] Graph-based recommendations
- [ ] Context-aware recommendations
- [ ] Multi-criteria decision making
- [ ] Explainable AI (XAI)
- [ ] Federated learning

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan fork repository ini dan submit pull requests.

### Development Workflow

```bash
# 1. Fork repository
# 2. Create feature branch
git checkout -b feature/amazing-feature

# 3. Commit changes
git commit -m "Add amazing feature"

# 4. Push to branch
git push origin feature/amazing-feature

# 5. Submit Pull Request
```

### Code Standards

- Follow PSR-12 for PHP
- Follow PEP 8 for Python
- Add comments for complex logic
- Include tests for new features
- Update documentation

---

## 📜 Lisensi

This project is licensed under the MIT License - see [LICENSE](LICENSE) file for details.

---

## 👥 Kontak

**Author**: [Your Name]  
**Email**: your.email@example.com  
**GitHub**: [@yourusername](https://github.com/yourusername)  
**LinkedIn**: [Your Profile](https://linkedin.com/in/yourprofile)

---

## 🙏 Terima Kasih

- CodeIgniter framework
- scikit-learn machine learning library
- Flask web framework
- Bootstrap UI framework
- All open-source contributors

---

## 📚 Referensi & Resources

### Machine Learning
- [Collaborative Filtering](https://en.wikipedia.org/wiki/Collaborative_filtering)
- [Content-Based Filtering](https://en.wikipedia.org/wiki/Collaborative_filtering#Content-based)
- [Cosine Similarity](https://en.wikipedia.org/wiki/Cosine_similarity)
- [scikit-learn Documentation](https://scikit-learn.org/)

### Web Development
- [CodeIgniter Documentation](https://codeigniter.com/user_guide/)
- [Flask Documentation](https://flask.palletsprojects.com/)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)

### Best Practices
- [Clean Code](https://www.amazon.com/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882)
- [Design Patterns](https://refactoring.guru/design-patterns)
- [API Design](https://restfulapi.net/)

---

**⭐ If you find this project helpful, please give it a star! ⭐**

---

*Last Updated: May 27, 2026*

