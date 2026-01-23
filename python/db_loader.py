import pymysql
import numpy as np
import pandas as pd
from datetime import datetime
import json
import logging

logger = logging.getLogger(__name__)

def get_db_connection(db_config):
    """Create database connection"""
    try:
        return pymysql.connect(**db_config)
    except Exception as e:
        logger.error(f"Database connection error: {str(e)}")
        raise

def load_ratings_matrix(db_config):
    """
    Load ratings matrix untuk collaborative filtering
    Returns: matrix (numpy array), users (list), wisata (list)
    """
    try:
        conn = get_db_connection(db_config)
        cursor = conn.cursor()
        
        # Get all users and wisata
        cursor.execute('SELECT id FROM users WHERE status = "active" ORDER BY id')
        users = [row[0] for row in cursor.fetchall()]
        
        cursor.execute('SELECT id FROM wisata ORDER BY id')
        wisata = [row[0] for row in cursor.fetchall()]
        
        # Create index mappings
        user_idx = {uid: i for i, uid in enumerate(users)}
        wisata_idx = {wid: i for i, wid in enumerate(wisata)}
        
        # Build matrix
        matrix = np.zeros((len(users), len(wisata)))
        
        cursor.execute('SELECT user_id, wisata_id, rating FROM rating')
        for user_id, wisata_id, rating in cursor.fetchall():
            if user_id in user_idx and wisata_id in wisata_idx:
                i = user_idx[user_id]
                j = wisata_idx[wisata_id]
                matrix[i, j] = rating
        
        conn.close()
        
        logger.info(f"Loaded ratings matrix: {matrix.shape}, sparsity: {100*(1-np.count_nonzero(matrix)/matrix.size):.2f}%")
        return matrix, users, wisata
        
    except Exception as e:
        logger.error(f"Error loading ratings matrix: {str(e)}")
        raise

def get_wisata_data(db_config):
    """
    Load wisata data untuk content-based filtering
    Returns: pandas DataFrame
    """
    try:
        conn = get_db_connection(db_config)
        
        query = """
        SELECT 
            id, nama, kategori, rating_avg, jumlah_rating,
            harga_tiket, latitude, longitude,
            foto, deskripsi, alamat, fasilitas,
            status
        FROM wisata
        WHERE status = 'active'
        ORDER BY id
        """
        
        df = pd.read_sql(query, conn)
        conn.close()
        
        # Fill NaN values
        df['deskripsi'] = df['deskripsi'].fillna('')
        df['kategori'] = df['kategori'].fillna('hiburan')
        df['alamat'] = df['alamat'].fillna('')
        df['fasilitas'] = df['fasilitas'].fillna('')
        
        logger.info(f"Loaded {len(df)} wisata records")
        return df
        
    except Exception as e:
        logger.error(f"Error loading wisata data: {str(e)}")
        raise

def get_user_ratings(db_config, user_id):
    """
    Get all ratings by a specific user
    Returns: list of dicts
    """
    try:
        conn = get_db_connection(db_config)
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        
        query = """
        SELECT 
            r.id, r.user_id, r.wisata_id, r.rating, r.created_at,
            w.nama as wisata_nama, w.kategori as wisata_kategori
        FROM rating r
        JOIN wisata w ON r.wisata_id = w.id
        WHERE r.user_id = %s
        ORDER BY r.created_at DESC
        """
        
        cursor.execute(query, (user_id,))
        ratings = cursor.fetchall()
        conn.close()
        
        return ratings
        
    except Exception as e:
        logger.error(f"Error getting user ratings: {str(e)}")
        return []

def get_wisata_features(db_config, wisata_id):
    """
    Get features untuk single wisata
    Returns: dict
    """
    try:
        conn = get_db_connection(db_config)
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        
        query = """
        SELECT 
            id, nama, kategori, rating_avg, jumlah_rating,
            harga_tiket, latitude, longitude,
            foto, deskripsi, alamat, fasilitas
        FROM wisata
        WHERE id = %s
        """
        
        cursor.execute(query, (wisata_id,))
        wisata = cursor.fetchone()
        conn.close()
        
        return wisata
        
    except Exception as e:
        logger.error(f"Error getting wisata features: {str(e)}")
        return None

def save_recommendation_history(db_config, user_id, recommendations, method):
    """
    Save recommendation history ke database
    """
    try:
        conn = get_db_connection(db_config)
        cursor = conn.cursor()
        
        # Convert recommendations to JSON
        rec_json = json.dumps(recommendations)
        
        query = """
        INSERT INTO recommendation_history 
        (user_id, recommendations, method, created_at)
        VALUES (%s, %s, %s, %s)
        """
        
        cursor.execute(query, (user_id, rec_json, method, datetime.now()))
        conn.commit()
        conn.close()
        
        logger.info(f"Saved recommendation history for user {user_id}")
        
    except Exception as e:
        logger.error(f"Error saving recommendation history: {str(e)}")

def get_recommendation_cache(db_config, user_id, method):
    """
    Get cached recommendations if available
    Returns: list or None
    """
    try:
        conn = get_db_connection(db_config)
        cursor = conn.cursor(pymysql.cursors.DictCursor)
        
        query = """
        SELECT recommendations, created_at
        FROM similarity_cache
        WHERE user_id = %s AND method = %s
        AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ORDER BY created_at DESC
        LIMIT 1
        """
        
        cursor.execute(query, (user_id, method))
        result = cursor.fetchone()
        conn.close()
        
        if result:
            return json.loads(result['recommendations'])
        return None
        
    except Exception as e:
        logger.error(f"Error getting recommendation cache: {str(e)}")
        return None

def save_recommendation_cache(db_config, user_id, recommendations, method):
    """
    Save recommendations ke cache
    """
    try:
        conn = get_db_connection(db_config)
        cursor = conn.cursor()
        
        rec_json = json.dumps(recommendations)
        
        # Delete old cache
        cursor.execute("DELETE FROM similarity_cache WHERE user_id = %s AND method = %s", (user_id, method))
        
        # Insert new cache
        query = """
        INSERT INTO similarity_cache 
        (user_id, method, recommendations, created_at)
        VALUES (%s, %s, %s, %s)
        """
        
        cursor.execute(query, (user_id, method, rec_json, datetime.now()))
        conn.commit()
        conn.close()
        
        logger.info(f"Saved recommendation cache for user {user_id}")
        
    except Exception as e:
        logger.error(f"Error saving recommendation cache: {str(e)}")

def get_popular_wisata(db_config, limit=10):
    """
    Get popular wisata berdasarkan rating dan vote count
    """
    try:
        conn = get_db_connection(db_config)
        
        query = """
        SELECT 
            id, nama, type, vote_average, vote_count,
            htm_weekday, image,
            (vote_average * LOG10(vote_count + 1)) as popularity_score
        FROM wisata
        WHERE vote_count > 0
        ORDER BY popularity_score DESC
        LIMIT %s
        """
        
        df = pd.read_sql(query, conn, params=(limit,))
        conn.close()
        
        return df.to_dict('records')
        
    except Exception as e:
        logger.error(f"Error getting popular wisata: {str(e)}")
        return []

def get_wisata_by_type(db_config, wisata_type, limit=10):
    """
    Get wisata berdasarkan tipe
    """
    try:
        conn = get_db_connection(db_config)
        
        query = """
        SELECT 
            id, nama, type, vote_average, vote_count,
            htm_weekday, image
        FROM wisata
        WHERE type = %s
        ORDER BY vote_average DESC, vote_count DESC
        LIMIT %s
        """
        
        df = pd.read_sql(query, conn, params=(wisata_type, limit))
        conn.close()
        
        return df.to_dict('records')
        
    except Exception as e:
        logger.error(f"Error getting wisata by type: {str(e)}")
        return []

