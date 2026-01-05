import pymysql
import numpy as np

def load_ratings_matrix(db_config):
    conn = pymysql.connect(**db_config)
    cursor = conn.cursor()
    # Get all users and wisata
    cursor.execute('SELECT id FROM users ORDER BY id')
    users = [row[0] for row in cursor.fetchall()]
    cursor.execute('SELECT id FROM wisata ORDER BY id')
    wisata = [row[0] for row in cursor.fetchall()]
    user_idx = {uid: i for i, uid in enumerate(users)}
    wisata_idx = {wid: i for i, wid in enumerate(wisata)}
    # Build matrix
    matrix = np.zeros((len(users), len(wisata)))
    cursor.execute('SELECT user_id, wisata_id, rating FROM rating')
    for user_id, wisata_id, rating in cursor.fetchall():
        i = user_idx[user_id]
        j = wisata_idx[wisata_id]
        matrix[i, j] = rating
    conn.close()
    return matrix, users, wisata
