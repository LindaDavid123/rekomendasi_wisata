# System Architecture Documentation

## 📐 Overview

This document describes the complete system architecture of the Rekomendasi Wisata application, including components, data flow, and design patterns.

---

## 🏗️ Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                   CLIENT LAYER (Browser)                     │
│  ┌──────────────────────────────────────────────────────┐   │
│  │  HTML5 | Bootstrap 5 | JavaScript | jQuery          │   │
│  └──────────────────────────────────────────────────────┘   │
└────────────────────┬────────────────────────────────────────┘
                     │ HTTP/HTTPS
┌────────────────────▼────────────────────────────────────────┐
│             WEB APPLICATION LAYER (PHP)                      │
│  ┌──────────────────────────────────────────────────────┐   │
│  │  CodeIgniter 3.x Framework                           │   │
│  │  ├── Route Layer (.htaccess / index.php)            │   │
│  │  ├── Controller Layer (Business Logic)              │   │
│  │  ├── Model Layer (Data Access)                      │   │
│  │  └── View Layer (Presentation)                      │   │
│  └──────────────────────────────────────────────────────┘   │
└────────────┬─────────────────┬──────────────────┬────────────┘
             │ HTTP            │ DB Queries       │ REST API
┌────────────▼──┐  ┌──────────▼──────────┐  ┌──▼──────────────┐
│   MySQL/      │  │   Python Service    │  │  External APIs  │
│  MariaDB      │  │  (Recommendation    │  │  (Google OAuth) │
│   Database    │  │   Engine)           │  │                 │
│               │  │                     │  │                 │
│ ┌────────────┐│  │ ┌─────────────────┐ │  └─────────────────┘
│ │ users      ││  │ │ Flask 2.0+      │ │
│ │ wisata     ││  │ ├─────────────────┤ │
│ │ ratings    ││  │ │ Collaborative   │ │
│ │ reviews    ││  │ │ Filtering       │ │
│ │ favorites  ││  │ │ (KNN + Cosine)  │ │
│ │ cache      ││  │ ├─────────────────┤ │
│ └────────────┘│  │ │ Content-Based   │ │
└───────────────┘  │ │ Filtering       │ │
                   │ │ (TF-IDF)        │ │
                   │ ├─────────────────┤ │
                   │ │ Hybrid Score    │ │
                   │ │ Combination     │ │
                   │ └─────────────────┘ │
                   │                     │
                   │ ┌─────────────────┐ │
                   │ │ scikit-learn    │ │
                   │ │ pandas          │ │
                   │ │ numpy           │ │
                   │ └─────────────────┘ │
                   └─────────────────────┘
```

---

## 📦 Component Architecture

### 1. **Frontend Layer**

#### Technology Stack:
- **HTML5**: Semantic markup
- **Bootstrap 5**: Responsive UI components
- **CSS3**: Custom styling
- **JavaScript**: Client-side logic
- **jQuery**: DOM manipulation

#### Key Components:
- Navigation & Header
- User Authentication Forms
- Recommendation Display
- Rating/Review Forms
- Admin Dashboard
- Search & Filter UI

### 2. **Backend Application Layer (PHP/CodeIgniter)**

#### MVC Pattern Implementation:

```
CodeIgniter Application
│
├── M - Model Layer (application/models/)
│   ├── User_model.php          → User operations
│   ├── Wisata_model.php        → Attraction operations
│   ├── Rating_model.php        → Rating management
│   ├── Review_model.php        → Review management
│   ├── Favorit_model.php       → Favorites management
│   └── Recommendation_model.php → Recommendation operations
│
├── V - View Layer (application/views/)
│   ├── home/                   → Homepage templates
│   ├── auth/                   → Authentication templates
│   ├── rekomendasi/            → Recommendation templates
│   ├── wisata/                 → Attraction templates
│   ├── favorit/                → Favorites templates
│   ├── profil/                 → Profile templates
│   ├── dashboard/              → Dashboard templates
│   └── admin/                  → Admin templates
│
└── C - Controller Layer (application/controllers/)
    ├── Auth.php                → Authentication controller
    ├── Home.php                → Homepage controller
    ├── Rekomendasi.php         → Recommendation controller
    ├── Wisata.php              → Attraction controller
    ├── Favorit.php             → Favorites controller
    ├── Profil.php              → Profile controller
    ├── Dashboard.php           → Dashboard controller
    ├── Google_callback.php     → OAuth callback
    └── admin/                  → Admin controllers
        ├── Dashboard.php
        ├── Wisata.php
        ├── Users.php
        └── Reports.php
```

#### Request Flow:

```
HTTP Request
    ↓
Router (.htaccess)
    ↓
index.php (entry point)
    ↓
CodeIgniter Bootstrap
    ↓
Route Match (URL routing)
    ↓
Controller Selection
    ↓
Method Execution
    ├── Input Validation
    ├── Authorization Check
    ├── Model Query
    │   └── Database Operation
    ├── Data Processing
    └── View Rendering
    ↓
HTTP Response (HTML/JSON)
    ↓
Browser Rendering
```

### 3. **Data Access Layer (Models)**

Models handle:
- Database queries
- Data validation
- Business logic
- Relationships
- Caching strategy

### 4. **Machine Learning Layer (Python)**

#### Architecture:

```
Python Microservice (Flask)
│
├── API Layer (Flask Routes)
│   ├── /recommend              → Main recommendation endpoint
│   ├── /similar-wisata         → Similar attractions
│   ├── /stats                  → Statistics
│   └── /refresh-cache          → Cache management
│
├── Recommendation Engine
│   ├── Collaborative Filtering
│   │   ├── Load ratings matrix
│   │   ├── Calculate KNN
│   │   ├── Cosine similarity
│   │   └── Score predictions
│   │
│   ├── Content-Based Filtering
│   │   ├── TF-IDF vectorization
│   │   ├── Feature extraction
│   │   ├── Similarity calculation
│   │   └── Ranking
│   │
│   └── Hybrid Combination
│       ├── Score normalization
│       ├── Weight application (α)
│       ├── Final ranking
│       └── Result filtering
│
├── Data Layer
│   ├── Database connection
│   ├── Caching (Redis/File)
│   ├── Matrix loading
│   └── Feature storage
│
└── ML Libraries
    ├── scikit-learn
    ├── pandas
    └── numpy
```

#### Request Processing:

```
Recommendation Request
    ↓
Input Validation
    ↓
Cache Check
    ├─ Hit: Return cached result
    └─ Miss: Continue processing
    ↓
User Exists Check
    ├─ No: Cold start recommendation
    └─ Yes: Proceed
    ↓
Load Data
    ├── User ratings
    ├── All wisata
    └── Features
    ↓
Method Selection
    ├─ Collaborative → KNN + Cosine
    ├─ Content-Based → TF-IDF + Cosine
    └─ Hybrid → Combine both
    ↓
Score Calculation
    ↓
Result Processing
    ├── Filtering
    ├── Ranking
    └── Formatting
    ↓
Cache Result
    ↓
Return JSON Response
```

---

## 🔄 Data Flow Diagrams

### User Registration Flow

```
User Registration Form
    ↓
Input Validation (Frontend)
    ↓
POST /auth/register (Backend)
    ↓
Validation (Server-side)
    ├─ Email uniqueness
    ├─ Password strength
    └─ Data completeness
    ↓
Create User (Model)
    ├── Hash password
    ├── Insert into DB
    └── Send confirmation email
    ↓
Create Session
    ↓
Redirect to Home
```

### Recommendation Request Flow

```
User Opens /rekomendasi
    ↓
Check Session
    ├─ No session: Redirect to login
    └─ Session valid: Continue
    ↓
Rekomendasi Controller
    ├── Get user_id
    ├── Prepare parameters
    └── Call Python API
    ↓
Python Service (app.py)
    ├── Validate input
    ├── Check cache
    ├── Run algorithm
    └── Return JSON
    ↓
Process Response
    ├── Parse JSON
    ├── Enhance data (fetch wisata details)
    └── Prepare for display
    ↓
Render View
    ├── Load layout
    ├── Pass data
    └── Generate HTML
    ↓
Return to Browser
    ↓
Render & Display
```

### Rating Submission Flow

```
User Submits Rating
    ↓
Validate Form
    ├── Rating 1-5
    ├── Wisata exists
    └── User authenticated
    ↓
POST /wisata/rate
    ↓
Rating Model
    ├── Check existing rating
    ├── Update or insert
    ├── Update wisata average
    └── Clear recommendation cache
    ↓
Update Cache
    └── Invalidate user's recommendations
    ↓
Return Success Response
    ↓
Update UI
    ├── Show confirmation
    ├── Update rating display
    └── Refresh recommendations
```

---

## 🗄️ Database Layer

### Database Connection

```
application/config/database.php
    ↓
$db['default'] configuration
    ├── hostname
    ├── username
    ├── password
    ├── database
    └── driver
    ↓
PDO Connection (CodeIgniter)
    ↓
Query Execution
```

### Caching Strategy

```
Level 1: In-Memory Cache (PHP)
    └── Query results

Level 2: Database Cache Table
    └── recommendation_cache

Level 3: File-Based Cache (Python)
    └── Recommendation results (24h TTL)
```

---

## 🔐 Security Architecture

### Authentication Flow

```
User Login
    ↓
Form Submission (HTTPS)
    ↓
Input Sanitization
    ├── XSS prevention
    └── SQL injection prevention
    ↓
Credential Verification
    ├── Email lookup
    ├── Password hash comparison
    └── Account status check
    ↓
Session Creation
    ├── Session ID generation
    ├── User data storage
    └── Expiration setting
    ↓
Secure Cookie
    ├── HTTP-only flag
    ├── Secure flag (HTTPS)
    └── SameSite policy
```

### Authorization

```
Request Comes In
    ↓
Check Session
    ├─ No session: Redirect to login
    └─ Valid session: Continue
    ↓
Check User Role
    ├── Admin
    ├── User
    └── Guest (read-only)
    ↓
Check Resource Permission
    └── Can user access resource?
    ↓
Execute Action
```

---

## 🎯 Design Patterns

### 1. **MVC Pattern**
- Separation of concerns
- Models: Data logic
- Views: Presentation
- Controllers: Business logic

### 2. **Repository Pattern** (Models)
- Centralized data access
- Query abstraction
- Easier testing

### 3. **Singleton Pattern** (Database)
- Single database connection
- Efficient resource usage

### 4. **Factory Pattern** (Controllers)
- Controller instantiation
- Plugin loading

### 5. **Observer Pattern** (Hooks)
- Event handling
- Extensibility

### 6. **Adapter Pattern** (OAuth)
- Google OAuth integration
- Abstraction layer

---

## 📊 Performance Considerations

### 1. **Caching Strategy**
- Query result caching
- Recommendation caching (24 hours)
- Session caching

### 2. **Database Optimization**
- Proper indexing
- Foreign key constraints
- Normalized schema
- Query optimization

### 3. **Frontend Optimization**
- CSS/JS minification
- Image optimization
- Lazy loading
- CDN for static assets

### 4. **API Optimization**
- Response compression
- Pagination
- Result caching
- Rate limiting

---

## 🚀 Scalability Considerations

### Current Architecture Limits:
- Single server deployment
- File-based session storage
- Database performance at scale

### Future Improvements:
- Load balancing
- Redis caching
- Database replication
- Microservices separation
- Containerization (Docker)

---

## 📋 Technology Dependencies

| Component | Technology | Version | Purpose |
|-----------|-----------|---------|---------|
| Server | Apache/Nginx | Latest | Web server |
| Language (Backend) | PHP | 8.2+ | Server-side scripting |
| Framework | CodeIgniter | 3.1+ | Web framework |
| Database | MySQL/MariaDB | 10.4+ | Data storage |
| Language (ML) | Python | 3.8+ | ML engine |
| ML Framework | Flask | 2.0+ | API framework |
| ML Libraries | scikit-learn | 1.0+ | ML algorithms |
| Frontend | Bootstrap | 5.0+ | UI framework |

---

## 🔄 Integration Points

### 1. **PHP to Python**
```
HTTP POST http://localhost:5000/recommend
├── Request: JSON with user_id
├── Process: ML engine
└── Response: JSON with recommendations
```

### 2. **External OAuth**
```
Google OAuth Flow
├── Redirect to Google
├── User authorization
├── Callback to application
└── Session creation
```

### 3. **Database**
```
All components connect via:
├── Direct queries (PHP)
├── Via REST API (Python)
└── Cache invalidation
```

---

## 📝 Deployment Architecture

### Development
```
localhost
├── PHP development server (port 8000)
├── Python development server (port 5000)
└── Local MySQL (port 3306)
```

### Production
```
Production Server
├── Apache/Nginx (port 80/443)
├── PHP-FPM
├── Python Gunicorn (port 5000, proxied)
├── MySQL database (port 3306, internal only)
└── SSL certificates
```

---

## 📚 Additional Resources

- [CodeIgniter Architecture](https://codeigniter.com/user_guide/)
- [Flask Architecture](https://flask.palletsprojects.com/)
- [MVC Pattern](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)
- [Microservices Pattern](https://microservices.io/)

