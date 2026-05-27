@echo off
REM ====================================
REM Setup Wisata Jogja Recommendation
REM ====================================

echo ====================================
echo Wisata Jogja Recommendation Setup
echo ====================================
echo.

REM Check Python
echo [1/4] Checking Python...
python --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Python not found!
    echo Please install Python from https://www.python.org/downloads/
    echo Make sure to check "Add Python to PATH" during installation
    pause
    exit /b 1
)

python --version
echo OK: Python found
echo.

REM Check pip
echo [2/4] Checking pip...
pip --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: pip not found!
    echo Installing pip...
    python -m ensurepip --upgrade
)

pip --version
echo OK: pip found
echo.

REM Install dependencies
echo [3/4] Installing dependencies...
echo This may take 5-10 minutes...
echo.

cd /d %~dp0
pip install -r requirements.txt

if errorlevel 1 (
    echo.
    echo ERROR: Failed to install dependencies!
    echo Try manually: pip install -r requirements.txt
    pause
    exit /b 1
)

echo.
echo OK: All dependencies installed!
echo.

REM Test database connection
echo [4/4] Testing database connection...
python -c "import pymysql; conn = pymysql.connect(host='localhost', user='root', password='', database='rekomendasi_wisata'); print('OK: Database connected'); conn.close()" 2>nul

if errorlevel 1 (
    echo WARNING: Cannot connect to database!
    echo Please make sure:
    echo   1. XAMPP/MySQL is running
    echo   2. Database 'rekomendasi_wisata' exists
    echo   3. Check credentials in app.py
    echo.
    echo You can still continue, but API won't work without database.
    echo.
) else (
    echo OK: Database connection successful!
    echo.
)

echo ====================================
echo Setup Complete!
echo ====================================
echo.
echo To start the server, run:
echo   start_server.bat
echo.
echo Or manually:
echo   python app.py
echo.
echo Server will run at: http://localhost:5000
echo.

pause
