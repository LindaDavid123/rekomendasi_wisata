# 🔍 DETAILED CLEANUP & RESTRUCTURING PLAN

**Status**: Step-by-step execution guide  
**Last Updated**: May 27, 2026  
**Priority**: HIGH - Execute before GitHub push

---

## 📋 TABLE OF CONTENTS

1. [Current Project Audit](#audit)
2. [Files to Delete (Cleanup)](#delete)
3. [Files to Move/Reorganize](#reorganize)
4. [Structure Reorganization](#restructure)
5. [Naming Convention Fixes](#naming)
6. [Security Issues Found](#security)
7. [Architecture Issues](#architecture)
8. [Action Checklist](#checklist)

---

## 🔍 CURRENT PROJECT AUDIT {#audit}

### Project Structure Analysis

```
Current Structure (MESSY):
├── application/             ← CodeIgniter app
│   ├── cache/              ✗ TEMP FILES - 50+ session files
│   ├── logs/               ✗ TEMP FILES - Log files
│   ├── config/             ✓ OK but contains hardcoded DB config
│   ├── controllers/        ✓ OK - naming good
│   ├── models/             ✓ OK - naming good
│   └── views/              ✓ OK but could be organized better
├── python/                 ← Python recommendation engine
│   ├── app.py             ✓ Core engine
│   ├── db_loader.py       ✓ Database loader
│   ├── __pycache__/       ✗ GENERATED - Python cache
│   ├── requirements.txt   ✓ OK
│   ├── *.bat, *.sh        ✓ Setup scripts but could move
│   └── README.md          ✓ OK but scattered
├── system/                 ← CodeIgniter framework
├── assets/                 ✓ OK - CSS, JS, images
├── [scattered docs]        ✗ MESSY - docs in different places
└── [scattered config]      ✗ MESSY - config not organized
```

### Project Statistics

- **PHP Controllers**: 14 files (9 main + 5 admin)
- **PHP Models**: 7 files (6 main + 1 admin)
- **Python Files**: 2 core files + setup scripts
- **Views**: 8 folders with multiple files
- **Session Cache Files**: ~50+ files (~500KB)
- **Log Files**: Unknown size (in application/logs)
- **Config Files**: 16 files (mostly framework)

---

## 🗑️ FILES TO DELETE (CLEANUP) {#delete}

### ⚠️ CRITICAL - DELETE THESE

| File/Folder | Location | Size | Reason | Action |
|---|---|---|---|---|
| `ci_session*` | `application/cache/` | ~500KB | Session cache - regenerated on runtime | DELETE ALL |
| `application/logs/*` | `application/logs/` | ? | Runtime logs - not needed in repo | DELETE ALL |
| `__pycache__/` | `python/__pycache__/` | ~1-5MB | Python compiled cache - regenerated | DELETE |
| `.DS_Store` | anywhere | various | macOS files - not needed | DELETE |
| `Thumbs.db` | anywhere | various | Windows thumbnail cache | DELETE |
| `*.tmp` | anywhere | various | Temporary files | DELETE |
| `*.log` | anywhere | various | Log files | DELETE |

### ✓ KEEP BUT IGNORE IN GIT

| File/Folder | Reason |
|---|---|
| `python/venv/` | Virtual environment - huge, regenerated |
| `.env` | Secrets - use .env.example instead |
| `uploads/*` | User uploads - regenerated |
| `*.pyc` | Python compiled - regenerated |

---

## 📦 FILES TO MOVE/REORGANIZE {#reorganize}

### Move These Files

| Current Location | New Location | Reason |
|---|---|---|
| `python/setup.bat` | `scripts/setup.bat` | Setup scripts go to scripts folder |
| `python/setup.sh` | `scripts/setup.sh` | Setup scripts go to scripts folder |
| `python/start_server.bat` | `scripts/start_server.bat` | Setup scripts go to scripts folder |
| `python/start_server.sh` | `scripts/start_server.sh` | Setup scripts go to scripts folder |
| `python/INSTALL_GUIDE.md` | `docs/python_install.md` | Docs organized in docs folder |
| `python/README.md` | `docs/python_readme.md` | Docs organized in docs folder |
| `python/STATUS.md` | `docs/python_status.md` | Docs organized in docs folder |
| `rekomendasi_wisata.sql` | `database/schema.sql` | DB schema goes to database folder |
| `application/config/database.php` | Keep but externalize to .env | Credentials should be in .env |

### Organize These Folders

| Folder | Action | Result |
|---|---|---|
| `application/views/` | Already good but could add folder structure | Current is OK |
| `assets/` | Already good | Current is OK |
| `python/` | Restructure to python/ folder | See next section |

---

## 🏗️ FINAL REPOSITORY STRUCTURE {#restructure}

### Recommended Production-Ready Structure

```
rekomendasi_wisata/
├── 📄 README.md                    ← Main documentation
├── 📄 .env.example                 ← Config template
├── 📄 .gitignore                   ← Git ignore rules
├── 📄 LICENSE                      ← MIT License
├── 📄 CONTRIBUTING.md              ← Contributing guide
├── 📄 CODE_OF_CONDUCT.md           ← Community standards
│
├── 📁 application/                 ← CodeIgniter Web App
│   ├── config/                     ← Configuration files
│   │   ├── autoload.php
│   │   ├── config.php
│   │   ├── database.php            ← ⚠️ USE .env for credentials
│   │   ├── routes.php
│   │   └── ...
│   ├── controllers/                ← Web app controllers (14 files)
│   │   ├── Home.php
│   │   ├── Auth.php
│   │   ├── Rekomendasi.php
│   │   ├── Wisata.php
│   │   ├── Favorit.php
│   │   ├── Profil.php
│   │   ├── Dashboard.php
│   │   ├── Welcome.php
│   │   ├── Google_callback.php
│   │   └── admin/
│   │       ├── Dashboard.php
│   │       ├── Auth.php
│   │       ├── Users.php
│   │       ├── Wisata.php
│   │       └── Wisata_admin.php
│   ├── models/                     ← Web app models (7 files)
│   │   ├── User_model.php
│   │   ├── Wisata_model.php
│   │   ├── Rating_model.php
│   │   ├── Review_model.php
│   │   ├── Favorit_model.php
│   │   ├── Recommendation_model.php
│   │   └── admin/
│   │       └── Admin_model.php
│   ├── views/                      ← Templates
│   │   ├── templates/
│   │   ├── home/
│   │   ├── auth/
│   │   ├── wisata/
│   │   ├── rekomendasi/
│   │   ├── favorit/
│   │   ├── dashboard/
│   │   ├── profil/
│   │   ├── admin/
│   │   └── errors/
│   ├── libraries/
│   ├── helpers/
│   ├── hooks/
│   ├── language/
│   └── cache/                      ← ⚠️ EMPTY (cache ignored in git)
│
├── 📁 python/                      ← Python Recommendation Engine
│   ├── __init__.py                 ← Make it Python package
│   ├── app.py                      ← Flask main app
│   ├── db_loader.py                ← Database loader
│   ├── requirements.txt            ← Dependencies
│   ├── tests/                      ← Unit tests (new)
│   │   ├── __init__.py
│   │   ├── test_recommendation.py
│   │   └── test_db_loader.py
│   └── config.py                   ← Configuration (new)
│
├── 📁 database/                    ← Database Schema (new)
│   ├── schema.sql                  ← Database schema
│   ├── seeds.sql                   ← Sample data (new)
│   └── migrations/                 ← Migration scripts (future)
│
├── 📁 scripts/                     ← Setup Scripts (new)
│   ├── setup.bat
│   ├── setup.sh
│   ├── start_server.bat
│   └── start_server.sh
│
├── 📁 docs/                        ← Documentation (expand)
│   ├── 01_architecture.md
│   ├── 02_recommendation_system.md
│   ├── 03_database_design.md
│   ├── 04_deployment_guide.md
│   ├── 05_api.md
│   ├── 06_github_best_practices.md
│   ├── 07_pre_publish_checklist.md
│   ├── 08_git_push_guide.md
│   ├── 09_troubleshooting.md
│   ├── python_install.md           ← From python/INSTALL_GUIDE.md
│   └── python_readme.md            ← From python/README.md
│
├── 📁 assets/                      ← Frontend Assets
│   ├── css/
│   ├── js/
│   └── images/
│
├── 📁 screenshots/                 ← Portfolio Screenshots (new)
│   ├── homepage.png
│   ├── recommendations.png
│   ├── admin-dashboard.png
│   └── database-erd.png
│
├── 📁 system/                      ← CodeIgniter Framework (unchanged)
├── 📁 uploads/                     ← User Uploads
├── .htaccess                       ← Apache rewrite rules
├── index.php                       ← Entry point
└── [config files]

```

### Folder Structure Summary

**Before**: Messy, scattered, ~2-3 hierarchy levels
**After**: Clean, organized, scalable, production-ready

---

## 📝 NAMING CONVENTION FIXES {#naming}

### Current Status ✓

Your naming is already **GOOD** in most cases:

✓ Controllers: `PascalCase` (Auth.php, Wisata.php, Favorit.php)
✓ Models: `PascalCase` (User_model.php, Wisata_model.php)
✓ Methods: `snake_case` (get_user_data)
✓ Folders: `lowercase` (application, views, models)

### Minor Fixes Needed

| Item | Current | Recommended | Priority |
|------|---------|-------------|----------|
| Python files | `app.py`, `db_loader.py` | Keep as is | LOW |
| Dataset files | Not seen | Use `snake_case` | MEDIUM |
| SQL files | `rekomendasi_wisata.sql` | Move to `database/schema.sql` | HIGH |
| Views | Mixed naming | Keep consistent | LOW |
| Config | `google_oauth.php` | Move to .env variables | HIGH |

---

## 🔒 SECURITY ISSUES FOUND {#security}

### ⚠️ CRITICAL - FIX IMMEDIATELY

#### 1. Database Credentials in Config
```php
// ❌ WRONG - In application/config/database.php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',  // ← EXPOSED
    'database' => 'rekomendasi_wisata',
);

// ✅ RIGHT - Use .env instead
$db['default'] = array(
    'hostname' => $_ENV['DB_HOST'] ?? 'localhost',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? '',
    'database' => $_ENV['DB_NAME'] ?? 'rekomendasi_wisata',
);
```

#### 2. Python DB Config Hardcoded
```python
# ❌ WRONG - In python/app.py
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',  # ← EXPOSED
    'database': 'rekomendasi_wisata',
}

# ✅ RIGHT - Use os.environ
import os
DB_CONFIG = {
    'host': os.environ.get('DB_HOST', 'localhost'),
    'user': os.environ.get('DB_USER', 'root'),
    'password': os.environ.get('DB_PASS', ''),
    'database': os.environ.get('DB_NAME', 'rekomendasi_wisata'),
}
```

#### 3. Google OAuth Credentials
```php
// ⚠️ CHECK: application/config/google_oauth.php
// Should use environment variables, not hardcoded
```

#### 4. Session Exposure Risk
- ✓ Sessions in `application/cache/` - good location
- ✓ Use secure session settings in `config.php`
- ✓ Add `session.secure_cookie` in .env

#### 5. Upload Vulnerability
- ✓ Check `uploads/` folder permissions
- ✓ Validate file types on upload
- ✓ Scan uploaded files for malware (implement)

#### 6. Auth Vulnerability
- ✓ Use `password_hash()` for storing passwords
- ✓ Use `password_verify()` for checking
- ✓ Add CSRF token validation

### Files to Review for Security

```
application/config/database.php    → Move to .env
python/app.py                      → Move DB config to .env  
python/db_loader.py                → Add error handling
application/controllers/Auth.php   → Review password handling
application/config/google_oauth.php → Move to .env
.htaccess                          → Review access rules
```

---

## 🏛️ ARCHITECTURE ISSUES {#architecture}

### ⚠️ ARCHITECTURE CONCERNS

#### 1. Tight Coupling: CodeIgniter ↔ Python
```
Current: PHP directly calls Python API
├── Pro: Simple to implement
└── Con: Not scalable, hard to test independently

Better: Message Queue (Redis) between layers
├── Pro: Decoupled, scalable, reliable
└── Con: More complex setup
```

#### 2. Recommendation Logic Location
```
Current: Mixed in python/app.py
├── Pro: Centralized
└── Con: Hard to maintain, test, or modify

Better: Separate modules
python/
├── models/
│   ├── collaborative_filtering.py
│   ├── content_based_filtering.py
│   └── hybrid_recommender.py
├── services/
│   └── recommendation_service.py
└── app.py (just routes)
```

#### 3. Database Layer Abstraction
```
Current: Direct SQL queries in db_loader.py
├── Pro: Direct control
└── Con: Prone to SQL injection, hard to test

Better: ORM or Repository pattern
python/
├── models/
│   ├── rating.py
│   ├── wisata.py
│   └── user.py
└── repositories/
    └── recommendation_repository.py
```

#### 4. Configuration Management
```
Current: Hardcoded in multiple places
├── app.py: DB config
├── database.php: DB config
├── google_oauth.php: OAuth config

Better: Centralized .env
├── .env (secrets)
├── python/config.py (Python config)
└── application/config/config.php (CodeIgniter config)
```

#### 5. Error Handling
```
Current: Mixed error handling
├── Some try-catch blocks
├── Some error logging
├── No consistent error format

Better: Centralized error handling
├── Custom exception classes
├── Logging middleware
├── Consistent error response format
```

### Recommendations

| Issue | Priority | Fix | Effort |
|-------|----------|-----|--------|
| DB credentials in code | CRITICAL | Move to .env | 30min |
| Recommendation module structure | HIGH | Refactor into modules | 1-2h |
| Error handling | MEDIUM | Add middleware | 1-2h |
| Database abstraction | MEDIUM | Add simple ORM layer | 2-4h |
| Logging | MEDIUM | Centralize logging | 1h |
| Configuration | MEDIUM | .env everywhere | 1h |
| Testing | LOW | Add unit tests | 2-4h |

---

## ✅ ACTION CHECKLIST {#checklist}

### Phase 1: CLEANUP (15 minutes) ⚡

**DELETE:**
- [ ] `application/cache/ci_session*` (all session files)
- [ ] `application/logs/*` (all log files)
- [ ] `python/__pycache__/` (Python cache)
- [ ] Any `.DS_Store` files
- [ ] Any `Thumbs.db` files

**COMMANDS:**
```powershell
# Windows PowerShell
Remove-Item -Path "application/cache/ci_session*" -Force
Remove-Item -Path "application/logs/*" -Force
Remove-Item -Path "python/__pycache__" -Recurse -Force

# Or manually delete using File Explorer
```

### Phase 2: REORGANIZE (20 minutes)

**CREATE NEW FOLDERS:**
- [ ] `scripts/` (for setup scripts)
- [ ] `database/` (for SQL files)
- [ ] `docs/` (already exists, expand)
- [ ] `screenshots/` (for portfolio)
- [ ] `python/tests/` (for unit tests)

**MOVE FILES:**
- [ ] `python/setup.bat` → `scripts/setup.bat`
- [ ] `python/setup.sh` → `scripts/setup.sh`
- [ ] `python/start_server.bat` → `scripts/start_server.bat`
- [ ] `python/start_server.sh` → `scripts/start_server.sh`
- [ ] `python/INSTALL_GUIDE.md` → `docs/python_install.md`
- [ ] `python/README.md` → `docs/python_readme.md`
- [ ] `python/STATUS.md` → `docs/python_status.md`
- [ ] `rekomendasi_wisata.sql` → `database/schema.sql`

### Phase 3: SECURITY FIXES (30 minutes)

**CREATE .env FILE:**
- [ ] Create `.env.example` with template
- [ ] Create `.env` (local only, not tracked)
- [ ] Add DB credentials to .env
- [ ] Add Google OAuth to .env
- [ ] Add Python API URL to .env

**UPDATE FILES:**
- [ ] Update `application/config/database.php` to read from .env
- [ ] Update `python/app.py` to read from .env
- [ ] Update `python/db_loader.py` to read from .env
- [ ] Review `application/controllers/Auth.php` for password handling

**UPDATE .gitignore:**
- [ ] Add `.env` (keep `.env.example`)
- [ ] Add `python/venv/`
- [ ] Add `*.pyc`
- [ ] Add `uploads/*`
- [ ] Add `application/cache/*`
- [ ] Add `application/logs/*`

### Phase 4: STRUCTURE & NAMING (15 minutes)

**CREATE FILES:**
- [ ] `python/__init__.py`
- [ ] `python/config.py`
- [ ] `python/tests/__init__.py`
- [ ] `python/tests/test_recommendation.py`
- [ ] `database/seeds.sql`

**VERIFY NAMING:**
- [ ] Controllers: PascalCase ✓
- [ ] Models: PascalCase ✓
- [ ] Functions: snake_case ✓
- [ ] Files: Appropriate names ✓

### Phase 5: DOCUMENTATION (10 minutes)

**CREATE/UPDATE:**
- [ ] Expand README.md (already done)
- [ ] Create ARCHITECTURE.md
- [ ] Create SECURITY.md
- [ ] Create CONTRIBUTING.md (already done)
- [ ] Create .env.example
- [ ] Update .gitignore

### Phase 6: FINAL VERIFICATION (10 minutes)

**BEFORE PUSH:**
- [ ] No .env file in git (only .env.example)
- [ ] No cache files in git
- [ ] No session files in git
- [ ] No log files in git
- [ ] No venv folder in git
- [ ] No __pycache__ in git
- [ ] Proper .gitignore in place
- [ ] README complete and professional
- [ ] All folders organized
- [ ] All files named correctly
- [ ] Security issues addressed

---

## 📋 DETAILED STEP-BY-STEP EXECUTION

See next section for concrete commands and code changes.

---

## 🎯 NEXT STEPS

This audit covers:
1. ✅ What needs to be deleted
2. ✅ What needs to be moved
3. ✅ What the final structure should be
4. ✅ Security issues to fix
5. ✅ Architecture recommendations
6. ✅ Naming conventions
7. ✅ Action checklist

**Next Phase**: I'll provide concrete PowerShell commands and code changes to execute each phase.

