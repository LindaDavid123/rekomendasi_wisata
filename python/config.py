"""
Configuration Module for Recommendation Engine
Loads settings from environment variables
"""

import os
from dotenv import load_dotenv

# Load environment variables from .env file
load_dotenv()

class Config:
    """Base configuration"""
    DEBUG = os.environ.get('APP_DEBUG', 'false').lower() == 'true'
    ENV = os.environ.get('APP_ENV', 'development')
    
    # Database Configuration
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
    
    # Flask Configuration
    JSON_SORT_KEYS = False
    JSONIFY_PRETTYPRINT_REGULAR = True
    
    # API Configuration
    API_TIMEOUT = int(os.environ.get('PYTHON_API_TIMEOUT', 30))
    FLASK_PORT = int(os.environ.get('FLASK_PORT', 5000))
    
    # Recommendation Engine Configuration
    ENABLE_RECOMMENDATIONS = os.environ.get('ENABLE_RECOMMENDATIONS', 'true').lower() == 'true'
    ENABLE_CACHE = os.environ.get('ENABLE_CACHE', 'true').lower() == 'true'
    CACHE_TIMEOUT = int(os.environ.get('CACHE_TIMEOUT', 3600))  # 1 hour
    
    # ML Parameters
    KNN_K = int(os.environ.get('KNN_K', 5))
    N_RECOMMENDATIONS = int(os.environ.get('N_RECOMMENDATIONS', 10))
    HYBRID_ALPHA = float(os.environ.get('HYBRID_ALPHA', 0.6))  # 60% collaborative, 40% content-based
    
    # Logging
    LOG_LEVEL = os.environ.get('LOG_LEVEL', 'info')

class DevelopmentConfig(Config):
    """Development configuration"""
    DEBUG = True
    TESTING = False

class TestingConfig(Config):
    """Testing configuration"""
    DEBUG = True
    TESTING = True
    PRESERVE_CONTEXT_ON_EXCEPTION = False

class ProductionConfig(Config):
    """Production configuration"""
    DEBUG = False
    TESTING = False

def get_config():
    """Get configuration based on environment"""
    env = os.environ.get('APP_ENV', 'development')
    
    if env == 'production':
        return ProductionConfig()
    elif env == 'testing':
        return TestingConfig()
    else:
        return DevelopmentConfig()

# Initialize config
config = get_config()
