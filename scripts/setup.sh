#!/bin/bash

# ====================================
# Setup Wisata Jogja Recommendation
# ====================================

echo "===================================="
echo "Wisata Jogja Recommendation Setup"
echo "===================================="
echo ""

# Check Python
echo "[1/4] Checking Python..."
if ! command -v python3 &> /dev/null; then
    echo "ERROR: Python not found!"
    echo "Please install Python 3.8+ from your package manager"
    echo "Ubuntu/Debian: sudo apt install python3 python3-pip"
    echo "Mac: brew install python3"
    exit 1
fi

python3 --version
echo "OK: Python found"
echo ""

# Check pip
echo "[2/4] Checking pip..."
if ! command -v pip3 &> /dev/null; then
    echo "ERROR: pip not found!"
    echo "Installing pip..."
    python3 -m ensurepip --upgrade
fi

pip3 --version
echo "OK: pip found"
echo ""

# Install dependencies
echo "[3/4] Installing dependencies..."
echo "This may take 5-10 minutes..."
echo ""

cd "$(dirname "$0")"
pip3 install -r requirements.txt

if [ $? -ne 0 ]; then
    echo ""
    echo "ERROR: Failed to install dependencies!"
    echo "Try manually: pip3 install -r requirements.txt"
    exit 1
fi

echo ""
echo "OK: All dependencies installed!"
echo ""

# Test database connection
echo "[4/4] Testing database connection..."
python3 -c "import pymysql; conn = pymysql.connect(host='localhost', user='root', password='', database='rekomendasi_wisata'); print('OK: Database connected'); conn.close()" 2>/dev/null

if [ $? -ne 0 ]; then
    echo "WARNING: Cannot connect to database!"
    echo "Please make sure:"
    echo "  1. MySQL is running"
    echo "  2. Database 'rekomendasi_wisata' exists"
    echo "  3. Check credentials in app.py"
    echo ""
    echo "You can still continue, but API won't work without database."
    echo ""
else
    echo "OK: Database connection successful!"
    echo ""
fi

echo "===================================="
echo "Setup Complete!"
echo "===================================="
echo ""
echo "To start the server, run:"
echo "  ./start_server.sh"
echo ""
echo "Or manually:"
echo "  python3 app.py"
echo ""
echo "Server will run at: http://localhost:5000"
echo ""
