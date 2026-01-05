# 🚀 Setup Wisata Jogja Recommendation System

## Requirements
- Python 3.8+ (Download dari https://www.python.org/downloads/)
- MySQL/XAMPP
- pip (sudah include dengan Python)

## Cara Install di Laptop Baru

### 1. Install Python
- Download Python dari https://www.python.org/downloads/
- **PENTING**: Centang "Add Python to PATH" saat install
- Verify instalasi:
```bash
python --version
pip --version
```

### 2. Setup Project

#### Windows:
```bash
# Clone atau copy project ini
cd C:\xampp\htdocs\rekomendasi_wisata\python

# Install dependencies
pip install -r requirements.txt

# Jalankan server
python app.py
```

Atau gunakan batch file:
```bash
start_server.bat
```

#### Linux/Mac:
```bash
cd /path/to/rekomendasi_wisata/python

# Install dependencies
pip install -r requirements.txt

# Jalankan server
python3 app.py
```

Atau gunakan shell script:
```bash
chmod +x start_server.sh
./start_server.sh
```

### 3. Setup Database
Pastikan MySQL sudah running dan database `rekomendasi_wisata` sudah dibuat.

### 4. Test API
Buka browser: http://localhost:5000

Atau gunakan curl:
```bash
curl http://localhost:5000/
```

## Troubleshooting

### Error: Python not found
- Pastikan Python sudah diinstall
- Tambahkan Python ke PATH:
  - Windows: System Properties > Environment Variables > Path
  - Tambahkan: `C:\Users\[USER]\AppData\Local\Programs\Python\Python3xx`

### Error: pip not found
Install pip:
```bash
python -m ensurepip --upgrade
```

### Error: ModuleNotFoundError
Install ulang dependencies:
```bash
pip install -r requirements.txt
```

### Error: MySQL Connection
- Pastikan MySQL/XAMPP sudah running
- Check credentials di `app.py` (default: root, no password)

### Port 5000 sudah digunakan
Edit `app.py` line terakhir, ganti port:
```python
app.run(host='0.0.0.0', port=5001, debug=True)
```

## Virtual Environment (Opsional tapi Recommended)

Untuk menghindari konflik package:

### Windows:
```bash
cd C:\xampp\htdocs\rekomendasi_wisata\python

# Buat virtual environment
python -m venv venv

# Aktifkan
venv\Scripts\activate

# Install dependencies
pip install -r requirements.txt

# Jalankan server
python app.py
```

### Linux/Mac:
```bash
cd /path/to/rekomendasi_wisata/python

# Buat virtual environment
python3 -m venv venv

# Aktifkan
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt

# Jalankan server
python3 app.py
```

## Konfigurasi Database

Edit `app.py` jika perlu ubah config database:
```python
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',  # Ubah jika ada password
    'database': 'rekomendasi_wisata',
    'charset': 'utf8mb4',
    'cursorclass': None
}
```

## Testing

Test menggunakan script Python:
```bash
python test_api.py
```

Test manual menggunakan curl atau Postman dengan endpoint:
- GET http://localhost:5000/
- POST http://localhost:5000/recommend
- POST http://localhost:5000/similar-wisata
- GET http://localhost:5000/stats

## Dependencies yang Diinstall

Dari `requirements.txt`:
- Flask==3.0.0 (Web framework)
- Flask-CORS==4.0.0 (CORS support)
- pymysql==1.1.0 (MySQL connector)
- numpy==1.24.3 (Numerical computing)
- pandas==2.0.3 (Data manipulation)
- scikit-learn==1.3.2 (Machine learning)
- scipy==1.11.4 (Scientific computing)

Total size: ~150MB

## Tidak Perlu Install

❌ Miniconda
❌ Anaconda
❌ Jupyter Notebook
❌ IDE khusus

Cukup Python standar dari python.org + pip!

## FAQ

**Q: Apakah harus pakai Miniconda?**
A: Tidak! Python standar sudah cukup.

**Q: Apakah bisa dijalankan di hosting/server?**
A: Ya, bisa deploy ke Heroku, Railway, PythonAnywhere, dll.

**Q: Berapa lama proses instalasi?**
A: ~5-10 menit (tergantung kecepatan internet)

**Q: Apakah bisa run tanpa internet?**
A: Setelah dependencies terinstall, bisa offline (kecuali MySQL di cloud)

**Q: RAM minimum?**
A: 4GB RAM cukup untuk dataset normal

## Support

Jika ada masalah, cek:
1. Python version: `python --version`
2. Installed packages: `pip list`
3. Server logs di terminal
4. MySQL status
