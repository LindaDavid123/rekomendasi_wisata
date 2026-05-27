# Deployment Guide

## 🚀 Production Deployment

This guide covers deploying Rekomendasi Wisata to production environments.

---

## 📋 Pre-Deployment Checklist

- [ ] Database backed up
- [ ] Environment variables configured
- [ ] SSL certificate obtained
- [ ] Domain name configured
- [ ] Server specs verified
- [ ] Dependencies installed
- [ ] Cronjobs configured
- [ ] Monitoring setup
- [ ] Error logging configured
- [ ] Security headers added

---

## 🖥️ Server Requirements

### Minimum
- **CPU**: 2 cores
- **RAM**: 2GB
- **Storage**: 20GB SSD
- **Bandwidth**: 5Mbps

### Recommended
- **CPU**: 4 cores
- **RAM**: 4GB
- **Storage**: 50GB SSD
- **Bandwidth**: 10Mbps+

### Software
- Ubuntu 20.04 LTS / CentOS 7+
- PHP 8.2+
- Python 3.8+
- MySQL 5.7+ / MariaDB 10.4+
- Apache 2.4+ or Nginx 1.18+

---

## 🔧 Installation Steps

### Step 1: Server Setup

```bash
# Update system
sudo apt-get update
sudo apt-get upgrade -y

# Install dependencies
sudo apt-get install -y \
    apache2 \
    php8.2 \
    php8.2-mysql \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-json \
    mysql-server \
    python3 \
    python3-pip \
    python3-venv \
    git \
    curl \
    wget \
    certbot \
    python3-certbot-apache

# Enable Apache modules
sudo a2enmod rewrite
sudo a2enmod ssl
sudo systemctl restart apache2
```

### Step 2: Database Setup

```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database
mysql -u root -p < rekomendasi_wisata.sql

# Verify
mysql -u root -p
> USE rekomendasi_wisata;
> SHOW TABLES;
```

### Step 3: Application Deployment

```bash
# Navigate to web root
cd /var/www/html

# Clone repository
git clone https://github.com/yourusername/rekomendasi-wisata.git
cd rekomendasi-wisata

# Copy environment file
cp .env.example .env

# Edit environment file with production values
sudo nano .env
```

### Step 4: Python Service Setup

```bash
# Navigate to python directory
cd python

# Create virtual environment
python3 -m venv venv

# Activate
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt
pip install gunicorn  # For production

# Test
python app.py
```

---

## ⚙️ Apache Configuration

### Virtual Host Setup

```apache
# /etc/apache2/sites-available/rekomendasi-wisata.conf

<VirtualHost *:80>
    ServerName rekomendasi-wisata.com
    ServerAlias www.rekomendasi-wisata.com
    ServerAdmin admin@rekomendasi-wisata.com
    
    DocumentRoot /var/www/html/rekomendasi-wisata
    
    # Redirect HTTP to HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Logs
    ErrorLog ${APACHE_LOG_DIR}/rekomendasi-wisata-error.log
    CustomLog ${APACHE_LOG_DIR}/rekomendasi-wisata-access.log combined
</VirtualHost>

<VirtualHost *:443>
    ServerName rekomendasi-wisata.com
    ServerAlias www.rekomendasi-wisata.com
    ServerAdmin admin@rekomendasi-wisata.com
    
    DocumentRoot /var/www/html/rekomendasi-wisata
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/rekomendasi-wisata.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/rekomendasi-wisata.com/privkey.pem
    
    # Security Headers
    Header set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "DENY"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
    
    # ModRewrite
    <Directory /var/www/html/rekomendasi-wisata>
        RewriteEngine On
        RewriteBase /
        
        # Remove index.php from URLs
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php/$1 [L]
        
        # Allow basic authentication if needed
        Allow from all
    </Directory>
    
    # Proxy to Python service
    ProxyPreserveHost On
    ProxyPass /api http://localhost:5000/
    ProxyPassReverse /api http://localhost:5000/
    
    # Logs
    ErrorLog ${APACHE_LOG_DIR}/rekomendasi-wisata-error.log
    CustomLog ${APACHE_LOG_DIR}/rekomendasi-wisata-access.log combined
</VirtualHost>
```

### Enable Virtual Host

```bash
# Enable site
sudo a2ensite rekomendasi-wisata

# Disable default site if needed
sudo a2dissite 000-default

# Test configuration
sudo apache2ctl configtest

# Restart Apache
sudo systemctl restart apache2
```

---

## 🔒 SSL/TLS Certificate (Let's Encrypt)

```bash
# Obtain certificate
sudo certbot certonly --apache -d rekomendasi-wisata.com -d www.rekomendasi-wisata.com

# Auto-renewal setup
sudo certbot renew --dry-run

# Verify auto-renewal
sudo systemctl list-timers
```

---

## 🐍 Python Service Management

### Systemd Service File

```ini
# /etc/systemd/system/rekomendasi-wisata-ml.service

[Unit]
Description=Rekomendasi Wisata ML Service
After=network.target

[Service]
Type=notify
User=www-data
WorkingDirectory=/var/www/html/rekomendasi-wisata/python
Environment="PATH=/var/www/html/rekomendasi-wisata/python/venv/bin"
ExecStart=/var/www/html/rekomendasi-wisata/python/venv/bin/gunicorn \
    --workers 4 \
    --worker-class sync \
    --bind 127.0.0.1:5000 \
    --timeout 30 \
    app:app
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

### Enable Service

```bash
# Reload systemd
sudo systemctl daemon-reload

# Enable on startup
sudo systemctl enable rekomendasi-wisata-ml.service

# Start service
sudo systemctl start rekomendasi-wisata-ml.service

# Check status
sudo systemctl status rekomendasi-wisata-ml.service
```

---

## 🔐 Environment Configuration

### Production .env

```env
CI_ENVIRONMENT=production

# Database
DB_HOST=localhost
DB_USER=rekomendasi_user
DB_PASSWORD=strong_random_password_here
DB_NAME=rekomendasi_wisata

# Application
APP_URL=https://rekomendasi-wisata.com
APP_DEBUG=FALSE

# Security
SESSION_ENCRYPTION_KEY=generate_with_openssl_rand_base64_32
CSRF_PROTECTION=TRUE

# Python Service
PYTHON_SERVICE_URL=http://localhost:5000

# Logging
LOG_LEVEL=3
ENABLE_QUERY_LOG=FALSE

# Email
EMAIL_PROTOCOL=smtp
EMAIL_SMTP_HOST=smtp.gmail.com
EMAIL_SMTP_PORT=587
EMAIL_SMTP_USER=noreply@rekomendasi-wisata.com
EMAIL_SMTP_PASSWORD=app_password_here

# OAuth
GOOGLE_CLIENT_ID=production_client_id
GOOGLE_CLIENT_SECRET=production_secret
```

---

## 📊 Performance Optimization

### PHP Configuration

```ini
# /etc/php/8.2/apache2/php.ini

; Memory
memory_limit = 256M
max_execution_time = 60
max_input_time = 120

; Opcache
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 10000
opcache.validate_timestamps = 0

; Session
session.gc_maxlifetime = 86400
session.cookie_secure = 1
session.cookie_httponly = 1
session.cookie_samesite = Strict

; Security
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_error.log
```

### MySQL Optimization

```sql
-- /etc/mysql/mysql.conf.d/mysqld.cnf

[mysqld]
-- Performance
max_connections = 200
wait_timeout = 28800
max_allowed_packet = 256M
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2

-- InnoDB
innodb_buffer_pool_size = 1024M
innodb_log_file_size = 512M
innodb_flush_log_at_trx_commit = 2
```

---

## 📈 Monitoring & Logging

### Application Logging

```bash
# Create log directories
mkdir -p /var/log/rekomendasi-wisata
chown www-data:www-data /var/log/rekomendasi-wisata

# Configure PHP logs
tail -f /var/log/php_error.log

# Configure Apache logs
tail -f /var/log/apache2/rekomendasi-wisata-error.log
```

### System Monitoring

```bash
# Monitor disk space
df -h

# Monitor memory
free -h

# Monitor CPU
top

# Monitor processes
ps aux | grep php
ps aux | grep python
```

### Cronjobs

```bash
# /etc/cron.d/rekomendasi-wisata

# Clear old cache (daily)
0 2 * * * www-data /usr/bin/php /var/www/html/rekomendasi-wisata/artisan cache:clear

# Clear old logs (weekly)
0 3 * * 0 www-data find /var/log/rekomendasi-wisata -name "*.log" -mtime +30 -delete

# Database backup (daily)
0 1 * * * root mysqldump -u backup_user -p'password' rekomendasi_wisata | gzip > /backups/rekomendasi_wisata_$(date +%Y%m%d).sql.gz
```

---

## 🔄 Backup Strategy

### Daily Database Backup

```bash
#!/bin/bash
# backup_db.sh

BACKUP_DIR="/backups/rekomendasi-wisata"
DB_NAME="rekomendasi_wisata"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")

mkdir -p $BACKUP_DIR

mysqldump -u root -p'password' $DB_NAME | gzip > $BACKUP_DIR/db_$TIMESTAMP.sql.gz

# Keep only last 30 days
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +30 -delete
```

### Automatic Upload to Cloud

```bash
#!/bin/bash
# backup_cloud.sh

aws s3 cp /backups/rekomendasi-wisata/ s3://backups/rekomendasi-wisata/ --recursive
```

---

## 🚨 Monitoring & Alerts

### Check Service Status

```bash
#!/bin/bash
# health_check.sh

# Check Apache
systemctl is-active --quiet apache2 && echo "Apache: OK" || echo "Apache: DOWN"

# Check MySQL
systemctl is-active --quiet mysql && echo "MySQL: OK" || echo "MySQL: DOWN"

# Check Python service
curl -s http://localhost:5000/ > /dev/null && echo "ML Service: OK" || echo "ML Service: DOWN"

# Check disk space
DISK=$(df / | awk 'NR==2 {print $5}' | cut -d'%' -f1)
if [ $DISK -gt 80 ]; then
    echo "WARNING: Disk usage at $DISK%"
else
    echo "Disk space: OK"
fi
```

---

## 🔄 Zero-Downtime Updates

### Deployment Strategy

```bash
#!/bin/bash
# deploy.sh

cd /var/www/html/rekomendasi-wisata

# 1. Pull latest code
git pull origin main

# 2. Install dependencies
pip install -r python/requirements.txt

# 3. Run database migrations (if any)
# php artisan migrate --force

# 4. Clear cache
rm -rf application/cache/*

# 5. Reload Python service gracefully
sudo systemctl reload rekomendasi-wisata-ml

# 6. Reload Apache
sudo systemctl reload apache2

echo "Deployment complete"
```

---

## 📚 Additional Resources

- [Apache Documentation](https://httpd.apache.org/docs/)
- [PHP Configuration](https://www.php.net/manual/en/ini.php)
- [MySQL Optimization](https://dev.mysql.com/doc/)
- [Let's Encrypt](https://letsencrypt.org/)
- [Gunicorn Documentation](https://gunicorn.org/)

