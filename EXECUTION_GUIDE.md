# 🚀 STEP-BY-STEP EXECUTION GUIDE

**Purpose**: Concrete commands and code changes to execute the cleanup  
**Time Estimate**: ~2-3 hours total  
**Difficulty**: Easy to Medium

---

## 📋 TABLE OF CONTENTS

1. [Phase 1: Cleanup (15 min)](#phase1)
2. [Phase 2: Create New Structure (10 min)](#phase2)
3. [Phase 3: Move Files (10 min)](#phase3)
4. [Phase 4: Fix Security Issues (30 min)](#phase4)
5. [Phase 5: Code Updates (30 min)](#phase5)
6. [Phase 6: Verification (10 min)](#phase6)

---

## 🗑️ PHASE 1: CLEANUP FILES {#phase1}

**Duration**: ~15 minutes  
**Action**: Delete unnecessary files

### Step 1.1: Delete Session Cache Files

```powershell
# Navigate to project
cd C:\xampp\htdocs\rekomendasi_wisata

# Delete all session cache files
Remove-Item -Path "application/cache/ci_session*" -Force -Verbose

# Verify (should show empty or no ci_session files)
Get-ChildItem application/cache/
```

**Expected Output:**
```
Removing session cache files...
After deletion: application/cache/ should contain:
- .gitkeep (or be empty)
```

### Step 1.2: Delete Log Files

```powershell
# Delete log files (keep folder structure)
Remove-Item -Path "application/logs/*" -Force -Verbose

# Create .gitkeep to keep folder in git
"" | Out-File "application/logs/.gitkeep" -Encoding UTF8

# Verify
Get-ChildItem application/logs/
```

**Expected Output:**
```
application/logs/:
    .gitkeep
```

### Step 1.3: Delete Python Cache

```powershell
# Delete Python __pycache__
Remove-Item -Path "python/__pycache__" -Recurse -Force -Verbose

# Verify
Get-ChildItem python/ | Where-Object {$_.Name -like "*__pycache__*"}
# (Should return nothing)
```

### Step 1.4: Delete Other Cache Files

```powershell
# Find and delete .DS_Store (macOS files)
Get-ChildItem -Path . -Filter ".DS_Store" -Recurse -Force | Remove-Item -Force -Verbose

# Find and delete Thumbs.db (Windows cache)
Get-ChildItem -Path . -Filter "Thumbs.db" -Recurse -Force | Remove-Item -Force -Verbose

# Verify
Get-ChildItem -Path . -Filter ".DS_Store" -Recurse -Force
Get-ChildItem -Path . -Filter "Thumbs.db" -Recurse -Force
# (Both should return nothing)
```

### ✅ Phase 1 Complete When:
- [ ] Session cache files deleted
- [ ] Log files deleted (folder empty except .gitkeep)
- [ ] __pycache__ deleted
- [ ] No .DS_Store or Thumbs.db files

---

## 📁 PHASE 2: CREATE NEW FOLDER STRUCTURE {#phase2}

**Duration**: ~10 minutes  
**Action**: Create necessary new folders

### Step 2.1: Create Missing Folders

```powershell
# Create scripts folder
New-Item -ItemType Directory -Path "scripts" -Force

# Create database folder
New-Item -ItemType Directory -Path "database" -Force

# Create screenshots folder
New-Item -ItemType Directory -Path "screenshots" -Force

# Create python/tests folder
New-Item -ItemType Directory -Path "python/tests" -Force

# Verify all folders created
Get-ChildItem -Directory | Select-Object Name
```

**Expected Output:**
```
scripts/
database/
screenshots/
python/tests/
```

### Step 2.2: Create .gitkeep Files (to keep empty folders in git)

```powershell
# Keep empty folders in git
"" | Out-File "database/.gitkeep" -Encoding UTF8
"" | Out-File "scripts/.gitkeep" -Encoding UTF8
"" | Out-File "screenshots/.gitkeep" -Encoding UTF8
"" | Out-File "python/tests/.gitkeep" -Encoding UTF8
"" | Out-File "application/logs/.gitkeep" -Encoding UTF8

# Verify
Get-ChildItem database/, scripts/, screenshots/, python/tests/ -Include ".gitkeep"
```

### ✅ Phase 2 Complete When:
- [ ] All new folders created
- [ ] .gitkeep files in empty folders

---

## 📦 PHASE 3: MOVE FILES {#phase3}

**Duration**: ~10 minutes  
**Action**: Move files to correct locations

### Step 3.1: Move Setup Scripts to /scripts/

```powershell
# Move batch files
Move-Item -Path "python/setup.bat" -Destination "scripts/setup.bat" -Force
Move-Item -Path "python/start_server.bat" -Destination "scripts/start_server.bat" -Force

# Move shell files
Move-Item -Path "python/setup.sh" -Destination "scripts/setup.sh" -Force
Move-Item -Path "python/start_server.sh" -Destination "scripts/start_server.sh" -Force

# Verify
Get-ChildItem scripts/
```

**Expected Output:**
```
scripts/:
    .gitkeep
    setup.bat
    setup.sh
    start_server.bat
    start_server.sh
```

### Step 3.2: Move Database Files to /database/

```powershell
# Move SQL schema file
Move-Item -Path "rekomendasi_wisata.sql" -Destination "database/schema.sql" -Force

# Verify
Get-ChildItem database/
```

**Expected Output:**
```
database/:
    .gitkeep
    schema.sql
```

### Step 3.3: Move Python Documentation to /docs/

```powershell
# Move Python docs (if exist)
if (Test-Path "python/INSTALL_GUIDE.md") {
    Move-Item -Path "python/INSTALL_GUIDE.md" -Destination "docs/python_install.md" -Force
}

if (Test-Path "python/README.md") {
    Move-Item -Path "python/README.md" -Destination "docs/python_readme.md" -Force
}

if (Test-Path "python/STATUS.md") {
    Move-Item -Path "python/STATUS.md" -Destination "docs/python_status.md" -Force
}

# Verify
Get-ChildItem docs/ | Where-Object {$_.Name -like "python_*"}
```

### ✅ Phase 3 Complete When:
- [ ] All setup scripts moved to scripts/
- [ ] Database schema moved to database/
- [ ] Python docs moved to docs/

---

## 🔒 PHASE 4: FIX SECURITY ISSUES {#phase4}

**Duration**: ~30 minutes  
**Action**: Remove hardcoded credentials and use environment variables

### Step 4.1: Create .env.example Template

```bash
# Create .env.example (no actual secrets, just template)
cat > .env.example << 'EOF'
# Application Environment
APP_ENV=development
APP_DEBUG=true

# Database Configuration
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASS=
DB_NAME=rekomendasi_wisata
DB_CHARSET=utf8mb4

# PHP/CodeIgniter
CODEIGNITER_KEY=your_encryption_key_here
SESSION_DRIVER=files
CACHE_DRIVER=file

# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google_callback

# Python Recommendation Engine
PYTHON_API_URL=http://localhost:5000
PYTHON_API_TIMEOUT=30

# Email Configuration
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM=noreply@rekomendasi-wisata.local

# Logging
LOG_LEVEL=debug
LOG_CHANNEL=single

# Features
ENABLE_RECOMMENDATIONS=true
ENABLE_REVIEWS=true
ENABLE_FAVORITES=true
EOF

# Verify
cat .env.example
```

**Or use PowerShell:**
```powershell
$envContent = @"
# Application Environment
APP_ENV=development
APP_DEBUG=true

# Database Configuration
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASS=
DB_NAME=rekomendasi_wisata
DB_CHARSET=utf8mb4

# PHP/CodeIgniter
CODEIGNITER_KEY=your_encryption_key_here
SESSION_DRIVER=files
CACHE_DRIVER=file

# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google_callback

# Python Recommendation Engine
PYTHON_API_URL=http://localhost:5000
PYTHON_API_TIMEOUT=30

# Email Configuration
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM=noreply@rekomendasi-wisata.local

# Logging
LOG_LEVEL=debug
LOG_CHANNEL=single

# Features
ENABLE_RECOMMENDATIONS=true
ENABLE_REVIEWS=true
ENABLE_FAVORITES=true
"@

$envContent | Out-File ".env.example" -Encoding UTF8

# Create local .env (copy from .env.example and edit with real values)
Copy-Item ".env.example" -Destination ".env"

Write-Host ".env.example and .env created successfully"
```

### Step 4.2: Update PHP Database Config

**File**: `application/config/database.php`

```php
<?php
// BEFORE: ❌ Hardcoded credentials
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',  // ← EXPOSED
    'database' => 'rekomendasi_wisata',
);

// AFTER: ✅ Use environment variables
$db['default'] = array(
    'hostname' => getenv('DB_HOST') ?: 'localhost',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
    'database' => getenv('DB_NAME') ?: 'rekomendasi_wisata',
    'port' => getenv('DB_PORT') ?: 3306,
    'dbdriver' => 'mysqli',
    'char_set' => getenv('DB_CHARSET') ?: 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
);
?>
```

### Step 4.3: Create .env Loader for CodeIgniter

**File**: Create `application/config/env.php` (new file)

```php
<?php
/**
 * Environment Variable Loader
 * Load .env file if it exists (development only)
 */

$env_file = dirname(dirname(dirname(__FILE__))) . '/.env';

if (file_exists($env_file)) {
    $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue; // Skip comments
        if (strpos($line, '=') === false) continue; // Skip invalid lines
        
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Remove quotes if present
        $value = trim($value, '"\'');
        
        putenv("$key=$value");
    }
}
?>
```

### Step 4.4: Load .env in CodeIgniter Index

**File**: `index.php` (add at top)

```php
<?php
/**
 * CodeIgniter Index
 */

// Load environment variables
require_once FCPATH . 'application/config/env.php';

// ... rest of CodeIgniter bootstrap code ...
?>
```

### Step 4.5: Update Python App Config

**File**: `python/app.py`

Replace hardcoded config:

```python
# BEFORE: ❌ Hardcoded
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'rekomendasi_wisata',
    'charset': 'utf8mb4'
}

# AFTER: ✅ Use environment variables
import os
from dotenv import load_dotenv

# Load .env file
load_dotenv()

DB_CONFIG = {
    'host': os.environ.get('DB_HOST', 'localhost'),
    'user': os.environ.get('DB_USER', 'root'),
    'password': os.environ.get('DB_PASS', ''),
    'database': os.environ.get('DB_NAME', 'rekomendasi_wisata'),
    'charset': os.environ.get('DB_CHARSET', 'utf8mb4')
}

# Flask config
app.config['JSON_SORT_KEYS'] = False
app.config['JSONIFY_PRETTYPRINT_REGULAR'] = True

# API Configuration
API_TIMEOUT = int(os.environ.get('PYTHON_API_TIMEOUT', 30))

if __name__ == '__main__':
    debug_mode = os.environ.get('APP_DEBUG', 'false').lower() == 'true'
    port = int(os.environ.get('FLASK_PORT', 5000))
    app.run(debug=debug_mode, host='127.0.0.1', port=port)
```

### Step 4.6: Add python-dotenv to Requirements

**File**: `python/requirements.txt`

```
Flask==2.3.0
Flask-CORS==4.0.0
scikit-learn==1.3.0
pandas==2.0.0
numpy==1.24.0
pymysql==1.1.0
python-dotenv==1.0.0
```

### ✅ Phase 4 Complete When:
- [ ] .env.example created with template
- [ ] .env created locally (add to .gitignore)
- [ ] database.php updated to use environment variables
- [ ] env.php loader created
- [ ] app.py updated to use environment variables
- [ ] requirements.txt updated with python-dotenv

---

## 💻 PHASE 5: CODE UPDATES {#phase5}

**Duration**: ~30 minutes  
**Action**: Add Python package structure and configuration

### Step 5.1: Create Python Configuration Module

**File**: `python/config.py` (new file)

```python
"""
Configuration Module for Recommendation Engine
Loads settings from environment variables
"""

import os
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

class Config:
    """Base configuration"""
    DEBUG = os.environ.get('APP_DEBUG', 'false').lower() == 'true'
    ENV = os.environ.get('APP_ENV', 'development')
    
    # Database
    DB_HOST = os.environ.get('DB_HOST', 'localhost')
    DB_PORT = int(os.environ.get('DB_PORT', 3306))
    DB_USER = os.environ.get('DB_USER', 'root')
    DB_PASSWORD = os.environ.get('DB_PASS', '')
    DB_NAME = os.environ.get('DB_NAME', 'rekomendasi_wisata')
    DB_CHARSET = os.environ.get('DB_CHARSET', 'utf8mb4')
    
    DB_CONFIG = {
        'host': DB_HOST,
        'port': DB_PORT,
        'user': DB_USER,
        'password': DB_PASSWORD,
        'database': DB_NAME,
        'charset': DB_CHARSET
    }
    
    # API
    API_TIMEOUT = int(os.environ.get('PYTHON_API_TIMEOUT', 30))
    
    # Recommendation Engine
    ENABLE_RECOMMENDATIONS = os.environ.get('ENABLE_RECOMMENDATIONS', 'true').lower() == 'true'
    ENABLE_CACHE = os.environ.get('ENABLE_CACHE', 'true').lower() == 'true'
    CACHE_TIMEOUT = int(os.environ.get('CACHE_TIMEOUT', 3600))  # 1 hour
    
    # ML Parameters
    KNN_K = int(os.environ.get('KNN_K', 5))
    N_RECOMMENDATIONS = int(os.environ.get('N_RECOMMENDATIONS', 10))
    HYBRID_ALPHA = float(os.environ.get('HYBRID_ALPHA', 0.6))

class DevelopmentConfig(Config):
    """Development configuration"""
    DEBUG = True
    
class ProductionConfig(Config):
    """Production configuration"""
    DEBUG = False

def get_config():
    """Get configuration based on environment"""
    env = os.environ.get('APP_ENV', 'development')
    
    if env == 'production':
        return ProductionConfig()
    else:
        return DevelopmentConfig()
```

### Step 5.2: Create Python Tests Structure

**File**: `python/tests/__init__.py` (empty file)

```python
"""
Tests package for recommendation engine
"""
```

### Step 5.3: Create Python Package Init

**File**: `python/__init__.py` (new file)

```python
"""
Rekomendasi Wisata - Hybrid Recommendation Engine
Combines collaborative and content-based filtering
"""

__version__ = "1.0.0"
__author__ = "Your Name"
__description__ = "AI-powered tourism recommendation system"
```

### Step 5.4: Create Database Seeds File

**File**: `database/seeds.sql` (new file - if needed for sample data)

```sql
-- Sample data for development/testing
-- This file contains sample data to populate the database

-- Note: Only run this on development database!
-- Production data should be managed through admin interface

-- Sample categories for wisata
INSERT INTO wisata_categories (id, nama) VALUES
(1, 'Historical Sites'),
(2, 'Natural Attractions'),
(3, 'Adventure'),
(4, 'Religious Sites'),
(5, 'Museums');

-- Sample wisata (if needed)
-- INSERT INTO wisata (nama, kategori, deskripsi, ...) VALUES
-- (1, 'Temple Name', 1, 'Description', ...);
```

### ✅ Phase 5 Complete When:
- [ ] python/config.py created
- [ ] python/__init__.py created
- [ ] python/tests/__init__.py created
- [ ] database/seeds.sql created

---

## 📝 PHASE 6: UPDATE .GITIGNORE {#phase6}

**Duration**: ~10 minutes  
**Action**: Update comprehensive .gitignore (already done, verify)

**File**: `.gitignore` (verify content)

The .gitignore should include:

```
# Environment variables
.env
.env.local
.env.*.local

# IDE
.vscode/
.idea/
*.sublime-project
*.sublime-workspace
.DS_Store
Thumbs.db

# PHP
vendor/
composer.lock
*.phar

# CodeIgniter
application/cache/*
!application/cache/.gitkeep
application/logs/*
!application/logs/.gitkeep
application/config/database.php.bak
user_guide/

# Python
__pycache__/
*.py[cod]
*$py.class
*.so
.Python
env/
venv/
ENV/
build/
develop-eggs/
dist/
downloads/
eggs/
.eggs/
lib/
lib64/
parts/
sdist/
var/
wheels/
*.egg-info/
.installed.cfg
*.egg
MANIFEST
pip-log.txt
pip-delete-this-directory.txt

# Jupyter Notebook
.ipynb_checkpoints
*.ipynb

# Uploads
uploads/*
!uploads/.gitkeep

# OS
*.log
*.swp
*.swo
*~
.DS_Store
Thumbs.db

# Temporary files
*.tmp
*.temp
.tmp/

# Local development
local.conf
config.local.php
```

### ✅ Phase 6 Complete When:
- [ ] .gitignore properly configured
- [ ] .env file is in .gitignore
- [ ] venv/ is in .gitignore
- [ ] __pycache__/ is in .gitignore
- [ ] application/cache/ and logs/ are kept but entries are ignored
- [ ] uploads/ is in .gitignore but has .gitkeep

---

## ✅ FINAL VERIFICATION {#verification}

After completing all phases, run verification:

```powershell
# 1. Check no sensitive files
Write-Host "Checking for .env files..."
Get-ChildItem -Path . -Filter ".env" -Recurse -Force | Where-Object {$_.FullName -notlike "*example*"}

# Should return NOTHING (except .env.example)

# 2. Check folder structure
Write-Host "Checking folder structure..."
Get-ChildItem -Directory | Sort-Object Name

# Should show all new folders created

# 3. Check for cache files
Write-Host "Checking for cache files..."
Get-ChildItem -Path "application/cache" -Filter "ci_session*" -Recurse -Force

# Should return NOTHING (empty or only .gitkeep)

# 4. Check Python cache
Write-Host "Checking for Python cache..."
Get-ChildItem -Path "python" -Filter "__pycache__" -Recurse -Force

# Should return NOTHING

# 5. Summary
Write-Host "`nFolder Structure Summary:"
Get-ChildItem -Directory | Format-Table Name
Get-ChildItem -File | Format-Table Name | Head -20
```

### ✅ Verification Checklist:
- [ ] No .env file tracked (only .env.example)
- [ ] No cache files present
- [ ] No session files present
- [ ] No log files present (except .gitkeep)
- [ ] No __pycache__ present
- [ ] All new folders created
- [ ] All files moved to correct locations
- [ ] Database config uses environment variables
- [ ] Python config uses environment variables

---

## 🎯 SUMMARY

| Phase | Duration | Status |
|-------|----------|--------|
| 1. Cleanup | 15 min | Delete unnecessary files |
| 2. Create Structure | 10 min | New folders |
| 3. Move Files | 10 min | Reorganize files |
| 4. Security | 30 min | Environment variables |
| 5. Code Updates | 30 min | Python packages |
| 6. Verification | 10 min | Final checks |
| **TOTAL** | **~2-3 hours** | **Production-Ready** |

---

## 📚 NEXT STEPS

After completing all phases:

1. **Git Initialization** (See: `08_git_push_guide.md`)
   ```bash
   git init
   git add .
   git commit -m "feat: Initial commit - Clean project structure"
   ```

2. **Push to GitHub**
   ```bash
   git remote add origin https://github.com/YOUR_USERNAME/rekomendasi-wisata.git
   git push -u origin main
   ```

3. **GitHub Configuration**
   - Add topics
   - Update description
   - Add to profile

---

**Ready to start? Begin with Phase 1: Cleanup!** 🚀

