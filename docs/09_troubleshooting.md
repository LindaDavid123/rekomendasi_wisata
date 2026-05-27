# Troubleshooting Guide

## 🆘 Common Issues and Solutions

---

## 📋 Installation Issues

### Issue: "Connection refused" when installing

**Symptom**: 
```
Error: SQLSTATE[HY000] [2002] Connection refused
```

**Solution**:
```bash
# Check MySQL is running
sudo systemctl status mysql

# Start MySQL if not running
sudo systemctl start mysql

# On Windows:
# Use XAMPP Control Panel to start MySQL

# Verify connection
mysql -u root -p
> exit
```

### Issue: "Unknown database" error

**Symptom**:
```
Database 'rekomendasi_wisata' doesn't exist
```

**Solution**:
```bash
# Import database
mysql -u root -p < rekomendasi_wisata.sql

# Verify
mysql -u root -p
> use rekomendasi_wisata;
> show tables;
```

### Issue: Python dependencies not installing

**Symptom**:
```
ERROR: Could not find a version that satisfies the requirement scikit-learn
```

**Solution**:
```bash
# Ensure you're in venv
cd python
source venv/bin/activate  # or venv\Scripts\activate

# Upgrade pip first
pip install --upgrade pip

# Then install requirements
pip install -r requirements.txt

# Or install packages individually
pip install scikit-learn==1.3.0
pip install pandas==2.0.0
pip install numpy==1.24.0
```

---

## 🔐 Authentication Issues

### Issue: Login always fails

**Symptom**:
```
Invalid email or password (even with correct credentials)
```

**Solution**:
1. Check user exists in database:
```bash
mysql -u root -p rekomendasi_wisata
> SELECT * FROM users WHERE email='user@example.com';
```

2. Verify password is hashed:
```php
// Should be long hash, not plain text
$password_hash = password_hash('password123', PASSWORD_BCRYPT);
var_dump($password_hash);
// Output: $2y$10$... (bcrypt hash)
```

3. Check authentication logic:
```php
// In Auth.php controller
if (password_verify($submitted_password, $user->password)) {
    // Correct
} else if ($submitted_password === $user->password) {
    // Wrong - comparing plain text
}
```

### Issue: Google OAuth not working

**Symptom**:
```
Google callback returns error
```

**Solution**:
1. Verify Google credentials in .env:
```
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google_callback
```

2. Check OAuth configuration in controller:
```php
// In Google_callback.php
if (!$this->session->userdata('google_access_token')) {
    // Token not received - check redirect URL
}
```

3. Verify redirect URL matches in Google Console:
- Go to Google Cloud Console
- APIs & Services → Credentials
- Edit OAuth app
- Authorized redirect URIs must match exactly

---

## 🗄️ Database Issues

### Issue: "Table doesn't exist"

**Symptom**:
```
SQLSTATE[42S02]: Table 'rekomendasi_wisata.wisata' doesn't exist
```

**Solution**:
```bash
# Re-import database
mysql -u root -p rekomendasi_wisata < rekomendasi_wisata.sql

# Or create specific table
mysql -u root -p rekomendasi_wisata
> CREATE TABLE wisata (...);
```

### Issue: Ratings not saving

**Symptom**:
```
Form submits but rating doesn't appear
```

**Solution**:
1. Check foreign key constraint:
```sql
-- Verify user exists
SELECT * FROM users WHERE id = 1;

-- Verify wisata exists
SELECT * FROM wisata WHERE id = 1;

-- If not, insert them first
INSERT INTO users (id, email, password, nama) VALUES (...);
INSERT INTO wisata (id, nama, ...) VALUES (...);
```

2. Check for unique constraint violation:
```sql
-- User can only rate wisata once
SELECT COUNT(*) FROM ratings WHERE user_id = 1 AND wisata_id = 1;
-- If > 1, need to update instead of insert
```

3. Verify column types:
```sql
DESCRIBE ratings;
-- Columns should be: id (INT), user_id (INT), wisata_id (INT), rating (TINYINT 1-5)
```

### Issue: Slow database queries

**Symptom**:
```
Page takes 10+ seconds to load
```

**Solution**:
1. Check for missing indexes:
```sql
-- Add indexes for frequently queried columns
CREATE INDEX idx_user_id ON ratings(user_id);
CREATE INDEX idx_wisata_id ON ratings(wisata_id);
CREATE INDEX idx_email ON users(email);
```

2. Analyze slow queries:
```sql
-- Enable slow query log
SET GLOBAL slow_query_log = 'ON';

-- View log
TAIL /var/log/mysql/slow.log
```

3. Optimize queries:
```php
// Bad - N+1 query problem
foreach ($wisatas as $wisata) {
    $ratings = $this->db->where('wisata_id', $wisata->id)->get('ratings');
}

// Good - JOIN query
$query = $this->db->select('w.*, COUNT(r.id) as rating_count')
    ->from('wisata w')
    ->join('ratings r', 'w.id = r.wisata_id', 'left')
    ->group_by('w.id')
    ->get();
```

---

## 🤖 Recommendation Engine Issues

### Issue: Python service won't start

**Symptom**:
```
python app.py
Error: ModuleNotFoundError: No module named 'flask'
```

**Solution**:
```bash
# Activate virtual environment
cd python
source venv/bin/activate  # or venv\Scripts\activate on Windows

# Install dependencies
pip install -r requirements.txt

# Try again
python app.py
```

### Issue: No recommendations returned

**Symptom**:
```
Empty recommendations array
```

**Solution**:
1. Check if user has rated attractions:
```bash
curl -X POST http://localhost:5000/recommend \
  -H "Content-Type: application/json" \
  -d '{"user_id": 999}'
# If user_id doesn't exist with ratings, no collaborative recommendations
```

2. Add test data:
```sql
INSERT INTO users (id, email, password, nama) VALUES (1, 'user@test.com', 'hash', 'Test User');
INSERT INTO wisata (id, nama, kategori, deskripsi, ...) VALUES (1, 'Borobudur', 'Historical', ..., ...);
INSERT INTO ratings (user_id, wisata_id, rating) VALUES (1, 1, 5);
```

3. Test recommendation algorithm:
```bash
# Debug the recommendation request
curl -v http://localhost:5000/recommend \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "method": "content_based",
    "n_recommendations": 5
  }'
```

### Issue: Recommendation taking too long

**Symptom**:
```
Request timeout (>30 seconds)
```

**Solution**:
1. Check data size:
```python
# In Python app
import logging
logging.debug(f"Matrix size: {ratings_matrix.shape}")
logging.debug(f"Wisata features size: {wisata_features.shape}")
```

2. Reduce data:
```python
# Limit neighbors
k = 3  # Instead of 10

# Limit results
n_recommendations = 5  # Instead of 20
```

3. Implement caching (already done):
```sql
-- Check cache hit rate
SELECT COUNT(*) as cache_hits FROM recommendation_cache WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR);
```

---

## 🌐 Frontend Issues

### Issue: Page styling broken

**Symptom**:
```
No CSS, plain HTML rendering
```

**Solution**:
1. Check CSS file loaded:
```bash
# Open browser DevTools (F12)
# Check Network tab
# Verify bootstrap.css shows status 200 (not 404)
```

2. Verify assets folder structure:
```
assets/
├── css/
│   └── bootstrap.css
│   └── style.css
├── js/
│   └── bootstrap.bundle.js
│   └── jquery.js
└── images/
```

3. Check base URL in config:
```php
// application/config/config.php
$config['base_url'] = 'http://localhost:8000/';
```

### Issue: JavaScript not working

**Symptom**:
```
Buttons don't respond, AJAX calls fail
```

**Solution**:
1. Check console for errors (F12 → Console)
2. Verify jQuery loaded:
```javascript
console.log(typeof jQuery);  // Should be "function"
```

3. Check script tags:
```html
<!-- In view file -->
<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
<!-- Or -->
<script src="assets/js/jquery.js"></script>
```

4. Verify AJAX calls:
```javascript
// Wrong
$.get('wisata/get_recommendations');  // Relative URL might fail

// Better
$.get('<?php echo base_url("wisata/get_recommendations"); ?>');
```

---

## 🔄 Cache Issues

### Issue: Changes not showing (stale cache)

**Symptom**:
```
Updated data not visible, old data still showing
```

**Solution**:
1. Clear application cache:
```bash
rm -rf application/cache/*
```

2. Clear recommendation cache:
```sql
TRUNCATE TABLE recommendation_cache;
```

3. Clear browser cache:
```
Ctrl+Shift+Delete (most browsers)
Or Settings → Clear browsing data
```

4. Add cache-busting headers (in controller):
```php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
```

### Issue: Cache not being saved

**Symptom**:
```
Recommendations always computed (not cached)
```

**Solution**:
1. Check cache folder permissions:
```bash
ls -la application/cache/
chmod 755 application/cache/
```

2. Verify cache directory exists and is writable:
```bash
touch application/cache/test.txt
# If error, permissions issue
```

3. Check cache table (if using DB cache):
```sql
SELECT COUNT(*) FROM recommendation_cache;
-- Should show > 0 records
```

---

## 🐛 PHP-Specific Issues

### Issue: "Class not found" error

**Symptom**:
```
Unable to locate the specified class: User_model
```

**Solution**:
1. Verify model file exists:
```bash
ls -la application/models/User_model.php
# If not, create it
```

2. Check model naming (case-sensitive on Linux):
```php
// models/User_model.php NOT user_model.php
class User_model extends CI_Model
```

3. Load model properly:
```php
$this->load->model('User_model');
```

### Issue: "Undefined variable" warnings

**Symptom**:
```
Notice: Undefined variable: $user_id in ...
```

**Solution**:
```php
// Bad
$recommendations = $this->Recommendation_model->get($user_id);

// Good - check first
if (isset($user_id)) {
    $recommendations = $this->Recommendation_model->get($user_id);
}

// Or with null coalescing
$user_id = $this->session->userdata('user_id') ?? 0;
```

### Issue: CORS error when calling Python API

**Symptom**:
```
No 'Access-Control-Allow-Origin' header
```

**Solution**:
1. Check Python service CORS setup:
```python
from flask_cors import CORS
CORS(app)  # Allow all origins (development only!)
```

2. For production, restrict origins:
```python
CORS(app, resources={
    r"/recommend": {"origins": ["https://yourdomain.com"]}
})
```

3. Verify Python service is running on correct port:
```bash
# Should output: Running on http://127.0.0.1:5000/
python python/app.py
```

---

## 🖥️ Server/Deployment Issues

### Issue: 404 errors on clean URLs

**Symptom**:
```
URL: http://localhost:8000/wisata/detail/1
Result: 404 Not Found
```

**Solution**:
1. Enable mod_rewrite:
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

2. Create/verify .htaccess:
```apache
# .htaccess in project root
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

3. Check config:
```php
// application/config/config.php
$config['base_url'] = 'http://localhost:8000/';
$config['index_page'] = '';  // Empty for clean URLs
$config['uri_protocol'] = 'REQUEST_URI';
```

---

## 🆘 Getting Help

### If issue not in this guide:

1. **Check existing GitHub Issues**
   - https://github.com/yourusername/rekomendasi-wisata/issues

2. **Search documentation**
   - `/docs/` folder has detailed guides

3. **Open a new Issue**
   - Include error message, steps to reproduce, environment

4. **Check logs**
   - PHP: `/var/log/apache2/error.log` or `application/logs/`
   - Python: Console output from `python app.py`
   - MySQL: `/var/log/mysql/error.log`

---

## 📚 Useful Commands

```bash
# View PHP errors
tail -f /var/log/apache2/error.log

# View MySQL errors
tail -f /var/log/mysql/error.log

# Check running services
ps aux | grep -E "apache2|mysql|python"

# Test database
mysql -u root -p rekomendasi_wisata -e "SELECT VERSION();"

# Test Python service
curl http://localhost:5000/

# Check disk space
df -h

# Check memory
free -h

# View system logs
journalctl -xe
```

