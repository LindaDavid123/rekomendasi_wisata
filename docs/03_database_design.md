# Database Design Documentation

## 🗄️ Database Schema & Design

This document describes the complete database structure, relationships, and design decisions.

---

## 📊 Entity-Relationship Diagram (ERD)

```
┌──────────────────┐         ┌────────────────────┐
│     USERS        │         │      WISATA        │
├──────────────────┤         ├────────────────────┤
│ id (PK)          │         │ id (PK)            │
│ email            │         │ nama               │
│ password         │         │ kategori           │
│ nama             │         │ deskripsi          │
│ google_id        │         │ alamat             │
│ avatar_url       │         │ harga              │
│ created_at       │         │ rating_avg         │
│ updated_at       │         │ total_ratings      │
│ last_login       │         │ created_at         │
│ is_active        │         │ updated_at         │
└────────┬─────────┘         └─────────┬──────────┘
         │                             │
         │1                           1│
         │                             │
    ┌────┴─────┬──────────────┬────────┴─────┐
    │           │              │               │
    │1          │1             │1              │
    │           │              │               │
    ▼           ▼              ▼               ▼
┌─────────┐ ┌─────────┐ ┌──────────┐ ┌──────────────┐
│ RATINGS │ │ REVIEWS │ │ FAVORITES│ │ RECOMMENDATION│
├─────────┤ ├─────────┤ ├──────────┤ │    _CACHE    │
│id (PK)  │ │id (PK)  │ │id (PK)   │ ├──────────────┤
│user_id* │ │user_id* │ │user_id*  │ │id (PK)       │
│wisata_id│ │wisata_id│ │wisata_id*│ │user_id*      │
│rating   │ │review   │ │created_at│ │recommendations
│created_at│ │rating   │ └──────────┘ │method        │
│updated_at│ │created_at              │created_at    │
└─────────┘ │updated_at              │expires_at    │
            │is_moderated            └──────────────┘
            │moderated_by*
            └─────────┘

* = Foreign Key
PK = Primary Key
```

---

## 📝 Table Definitions

### 1. USERS Table

```sql
CREATE TABLE users (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(255) NOT NULL,
    google_id VARCHAR(255) UNIQUE,
    avatar_url VARCHAR(500),
    role ENUM('user', 'admin', 'moderator') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    
    KEY idx_email (email),
    KEY idx_google_id (google_id),
    KEY idx_is_active (is_active),
    KEY idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Purpose**: Store user account information  
**Rows**: ~1,000-10,000 expected  
**Performance**: Indexed on email, google_id  

**Columns**:
- `id`: Primary key
- `email`: Unique identifier for login
- `password`: Bcrypt hashed password
- `nama`: User's full name
- `google_id`: For OAuth login
- `avatar_url`: Profile picture URL
- `role`: User role (user/admin/moderator)
- `is_active`: Account status
- `created_at`: Account creation date
- `updated_at`: Last profile update
- `last_login`: Last login timestamp

### 2. WISATA Table

```sql
CREATE TABLE wisata (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    deskripsi LONGTEXT NOT NULL,
    alamat VARCHAR(500) NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    harga INT UNSIGNED DEFAULT 0,
    jam_buka VARCHAR(50),
    jam_tutup VARCHAR(50),
    rating_avg DECIMAL(3, 2) DEFAULT 0,
    total_ratings INT UNSIGNED DEFAULT 0,
    image_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT UNSIGNED,
    
    KEY idx_kategori (kategori),
    KEY idx_rating_avg (rating_avg),
    KEY idx_harga (harga),
    KEY idx_created_at (created_at),
    FOREIGN KEY (created_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Purpose**: Store tourism attraction information  
**Rows**: ~200-500 expected  
**Performance**: Indexed on kategori, rating_avg, harga  

**Columns**:
- `id`: Primary key
- `nama`: Attraction name
- `kategori`: Category (Historical, Cultural, Natural, etc.)
- `deskripsi`: Detailed description
- `alamat`: Physical address
- `latitude/longitude`: GPS coordinates
- `harga`: Entry price
- `jam_buka/jam_tutup`: Operating hours
- `rating_avg`: Average user rating (denormalized for performance)
- `total_ratings`: Number of ratings (denormalized)
- `image_url`: Photo URL
- `created_at/updated_at`: Timestamps
- `created_by`: Admin who added it

### 3. RATINGS Table

```sql
CREATE TABLE ratings (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    wisata_id INT UNSIGNED NOT NULL,
    rating TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_user_wisata (user_id, wisata_id),
    KEY idx_user_id (user_id),
    KEY idx_wisata_id (wisata_id),
    KEY idx_rating (rating),
    KEY idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Purpose**: Store user ratings for attractions  
**Rows**: ~5,000-50,000 expected  
**Performance**: Indexed on user_id, wisata_id  

**Columns**:
- `id`: Primary key
- `user_id`: Reference to user
- `wisata_id`: Reference to wisata
- `rating`: 1-5 star rating
- `created_at/updated_at`: Timestamps
- **Constraint**: One rating per user per attraction (UNIQUE)

**ML Significance**:
- Core data for collaborative filtering
- Used to build user-item matrix
- Critical for recommendation algorithm

### 4. REVIEWS Table

```sql
CREATE TABLE reviews (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    wisata_id INT UNSIGNED NOT NULL,
    review TEXT NOT NULL,
    rating INT UNSIGNED CHECK (rating BETWEEN 1 AND 5),
    is_moderated BOOLEAN DEFAULT FALSE,
    moderated_by INT UNSIGNED,
    moderation_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_user_id (user_id),
    KEY idx_wisata_id (wisata_id),
    KEY idx_is_moderated (is_moderated),
    KEY idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE,
    FOREIGN KEY (moderated_by) REFERENCES users(id) SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Purpose**: Store detailed user reviews  
**Rows**: ~2,000-20,000 expected  
**Performance**: Indexed on user_id, wisata_id  

**Columns**:
- `id`: Primary key
- `user_id`: Review author
- `wisata_id`: Attraction reviewed
- `review`: Text content (up to 65KB)
- `rating`: Accompanying rating
- `is_moderated`: Content moderation flag
- `moderated_by`: Moderator user
- `moderation_notes`: Why flagged/rejected
- `created_at/updated_at`: Timestamps

**ML Significance**:
- Used for content-based filtering (TF-IDF)
- Provides attraction descriptions
- Used for sentiment analysis (future)

### 5. FAVORITES Table

```sql
CREATE TABLE favorites (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    wisata_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_user_wisata_fav (user_id, wisata_id),
    KEY idx_user_id (user_id),
    KEY idx_wisata_id (wisata_id),
    KEY idx_created_at (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (wisata_id) REFERENCES wisata(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Purpose**: Store user favorites/wishlist  
**Rows**: ~3,000-30,000 expected  
**Performance**: Indexed on user_id  

**Columns**:
- `id`: Primary key
- `user_id`: User who favorited
- `wisata_id`: Favorited attraction
- `created_at`: When added to favorites
- **Constraint**: One favorite per user per attraction (UNIQUE)

### 6. RECOMMENDATION_CACHE Table

```sql
CREATE TABLE recommendation_cache (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    recommendations JSON NOT NULL,
    method VARCHAR(50) NOT NULL,
    execution_time_ms INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    
    KEY idx_user_id (user_id),
    KEY idx_expires_at (expires_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Purpose**: Cache generated recommendations  
**Rows**: ~1,000-5,000 expected  
**Performance**: Indexed on user_id, expires_at  

**Columns**:
- `id`: Primary key
- `user_id`: Cache for which user
- `recommendations`: JSON array of recommendations
- `method`: Which algorithm (collaborative/content/hybrid)
- `execution_time_ms`: Time taken to generate
- `created_at`: When cached
- `expires_at`: When cache expires (24 hours default)

**Sample JSON**:
```json
{
    "recommendations": [
        {
            "wisata_id": 9,
            "nama": "Borobudur Temple",
            "score": 0.87,
            "reason": "hybrid"
        },
        {
            "wisata_id": 12,
            "nama": "Prambanan Temple",
            "score": 0.82,
            "reason": "collaborative"
        }
    ]
}
```

---

## 🔑 Key Relationships

### One-to-Many Relationships

1. **Users → Ratings**
   - One user has many ratings
   - One user has many reviews
   - One user has many favorites

2. **Wisata → Ratings**
   - One wisata has many ratings
   - One wisata has many reviews
   - One wisata has many favorites

3. **Users → Recommendation_Cache**
   - One user has many cached recommendations

### Integrity Constraints

- Foreign key constraints with ON DELETE CASCADE
- Unique constraints to prevent duplicates
- Check constraints for rating range (1-5)
- Unique email constraint for users
- Unique (user_id, wisata_id) for ratings

---

## 📈 Performance Optimization

### Indexing Strategy

```sql
-- Primary lookup indexes
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_rating_user_wisata ON ratings(user_id, wisata_id);
CREATE INDEX idx_wisata_kategori ON wisata(kategori);

-- Sorting/filtering indexes
CREATE INDEX idx_wisata_rating ON wisata(rating_avg DESC);
CREATE INDEX idx_wisata_harga ON wisata(harga);
CREATE INDEX idx_rating_created ON ratings(created_at);

-- ML-related indexes
CREATE INDEX idx_rating_value ON ratings(rating);
CREATE INDEX idx_reviews_wisata ON reviews(wisata_id);
CREATE INDEX idx_cache_expires ON recommendation_cache(expires_at);
```

### Query Optimization Examples

**Efficient User-Item Matrix Query**:
```sql
SELECT 
    r.user_id,
    r.wisata_id,
    r.rating
FROM ratings r
WHERE r.user_id IN (
    SELECT DISTINCT user_id 
    FROM ratings 
    WHERE wisata_id IN (
        SELECT wisata_id FROM ratings 
        WHERE user_id = ? AND rating >= 4
    )
);
```

**Efficient Recommendation Retrieval**:
```sql
SELECT 
    w.*,
    COUNT(r.id) as num_ratings,
    AVG(r.rating) as avg_rating
FROM wisata w
LEFT JOIN ratings r ON w.id = r.wisata_id
WHERE w.kategori = 'Historical'
GROUP BY w.id
ORDER BY avg_rating DESC
LIMIT 10;
```

### Denormalization for Performance

- `wisata.rating_avg`: Average rating (denormalized)
- `wisata.total_ratings`: Count of ratings (denormalized)

**Trigger to maintain denormalization**:
```sql
DELIMITER $$

CREATE TRIGGER update_wisata_rating_after_insert
AFTER INSERT ON ratings
FOR EACH ROW
BEGIN
    UPDATE wisata
    SET 
        rating_avg = (
            SELECT AVG(rating) FROM ratings 
            WHERE wisata_id = NEW.wisata_id
        ),
        total_ratings = (
            SELECT COUNT(*) FROM ratings 
            WHERE wisata_id = NEW.wisata_id
        )
    WHERE id = NEW.wisata_id;
END$$

DELIMITER ;
```

---

## 🔄 Data Consistency

### Transactional Operations

```php
// PHP example: Rate an attraction
$this->db->trans_start();

// Insert/update rating
$this->db->insert('ratings', [
    'user_id' => $user_id,
    'wisata_id' => $wisata_id,
    'rating' => $rating
]);

// Update wisata denormalized fields
$this->db->query("
    UPDATE wisata 
    SET rating_avg = (
        SELECT AVG(rating) FROM ratings 
        WHERE wisata_id = ?
    ),
    total_ratings = (
        SELECT COUNT(*) FROM ratings 
        WHERE wisata_id = ?
    )
    WHERE id = ?
", [$wisata_id, $wisata_id, $wisata_id]);

// Invalidate recommendation cache
$this->db->delete('recommendation_cache', 
    ['user_id' => $user_id]);

$this->db->trans_complete();
```

---

## 📊 Normalization Analysis

**Normal Form**: 3NF (Third Normal Form)

- ✅ All attributes depend on primary key
- ✅ No transitive dependencies
- ✅ No partial dependencies
- ⚠️ Some denormalization for performance

---

## 🔍 Sample Queries

### Get Recommendations for User

```sql
SELECT 
    w.*,
    AVG(r.rating) as user_rating,
    COUNT(r2.id) as total_ratings
FROM wisata w
JOIN ratings r2 ON w.id = r2.wisata_id
LEFT JOIN ratings r ON w.id = r.wisata_id AND r.user_id = 12
WHERE r.id IS NULL  -- Not already rated
GROUP BY w.id
ORDER BY total_ratings DESC
LIMIT 10;
```

### Get Similar Users

```sql
SELECT 
    u.id,
    u.nama,
    SUM(r1.rating * r2.rating) / (
        SQRT(SUM(r1.rating * r1.rating)) * 
        SQRT(SUM(r2.rating * r2.rating))
    ) as similarity
FROM ratings r1
JOIN ratings r2 ON r1.wisata_id = r2.wisata_id
JOIN users u ON r2.user_id = u.id
WHERE r1.user_id = 12
GROUP BY r2.user_id
ORDER BY similarity DESC
LIMIT 5;
```

### Get Trending Attractions

```sql
SELECT 
    w.*,
    COUNT(r.id) as recent_ratings,
    AVG(r.rating) as recent_avg
FROM wisata w
JOIN ratings r ON w.id = r.wisata_id
WHERE r.created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY w.id
HAVING recent_ratings >= 5
ORDER BY recent_avg DESC
LIMIT 10;
```

---

## 🛡️ Data Security

### Access Control
- Passwords: Bcrypt hashing
- Sessions: Secure cookies
- SQL Injection: Prepared statements
- XSS: Input sanitization

### Backup Strategy
```bash
# Daily backup
mysqldump -u root -p rekomendasi_wisata > backup_$(date +%Y%m%d).sql
```

---

## 📈 Scalability Considerations

### Current Limitations
- Single database instance
- No replication
- File-based caching

### Future Improvements
- Database replication (master-slave)
- Redis caching layer
- Sharding by user_id
- Data warehouse for analytics

---

## 📊 Database Statistics

| Table | Est. Rows | Size | Growth Rate |
|-------|-----------|------|------------|
| users | 1,000 | 200KB | 100/month |
| wisata | 300 | 1MB | 10/month |
| ratings | 10,000 | 200KB | 2000/month |
| reviews | 3,000 | 3MB | 500/month |
| favorites | 5,000 | 100KB | 500/month |
| recommendation_cache | 2,000 | 5MB | 1000/day (temp) |

