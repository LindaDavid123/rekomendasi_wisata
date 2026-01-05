from flask import Flask, request, jsonify
from flask_cors import CORS
from sklearn.metrics.pairwise import cosine_similarity
from sklearn.feature_extraction.text import TfidfVectorizer
import numpy as np
import pandas as pd
import pymysql
from db_loader import (
    load_ratings_matrix, 
    get_wisata_data, 
    get_user_ratings,
    save_recommendation_history,
    get_wisata_features,
    get_recommendation_cache,
    save_recommendation_cache
)
import logging

# Setup logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = Flask(__name__)
CORS(app)

# Konfigurasi database
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'rekomendasi_wisata',
    'charset': 'utf8mb4'
}

# Cache
CACHE = {
    'ratings_matrix': None,
    'users': None,
    'wisata': None,
    'wisata_df': None,
    'tfidf_matrix': None,
    'vectorizer': None
}

def refresh_cache():
    try:
        logger.info("Refreshing cache...")
        CACHE['ratings_matrix'], CACHE['users'], CACHE['wisata'] = load_ratings_matrix(DB_CONFIG)
        CACHE['wisata_df'] = get_wisata_data(DB_CONFIG)
        
        if not CACHE['wisata_df'].empty:
            # Gabung fitur untuk TF-IDF
            CACHE['wisata_df']['combined_features'] = (
                CACHE['wisata_df']['nama'] + ' ' +
                CACHE['wisata_df']['kategori'] + ' ' +
                CACHE['wisata_df']['deskripsi'].fillna('') + ' ' +
                CACHE['wisata_df']['alamat'].fillna('') + ' ' +
                CACHE['wisata_df']['fasilitas'].fillna('')
            )
            
            CACHE['vectorizer'] = TfidfVectorizer(max_features=500, stop_words='english', ngram_range=(1, 2))
            CACHE['tfidf_matrix'] = CACHE['vectorizer'].fit_transform(CACHE['wisata_df']['combined_features'])
        
        logger.info(f"Cache refreshed. Users: {len(CACHE['users'])}, Wisata: {len(CACHE['wisata'])}")
        return True
    except Exception as e:
        logger.error(f"Error refreshing cache: {str(e)}")
        return False

def knn_collaborative_filtering(user_id, k=5, n_recommendations=10):
    try:
        if user_id not in CACHE['users']:
            return []
        
        user_index = CACHE['users'].index(user_id)
        ratings_matrix = CACHE['ratings_matrix']
        user_similarity = cosine_similarity(ratings_matrix)
        user_sim_scores = user_similarity[user_index]
        similar_indices = np.argsort(-user_sim_scores)
        similar_indices = [i for i in similar_indices if i != user_index][:k]
        
        neighbor_ratings = np.zeros(ratings_matrix.shape[1])
        neighbor_weights = np.zeros(ratings_matrix.shape[1])
        
        for neighbor_idx in similar_indices:
            similarity_score = user_sim_scores[neighbor_idx]
            if similarity_score > 0:
                neighbor_ratings += ratings_matrix[neighbor_idx] * similarity_score
                neighbor_weights += (ratings_matrix[neighbor_idx] > 0) * similarity_score
        
        with np.errstate(divide='ignore', invalid='ignore'):
            predicted_ratings = np.divide(neighbor_ratings, neighbor_weights)
            predicted_ratings = np.nan_to_num(predicted_ratings)
        
        user_rated = ratings_matrix[user_index] > 0
        predicted_ratings[user_rated] = 0
        top_indices = np.argsort(-predicted_ratings)[:n_recommendations]
        
        recommendations = []
        for idx in top_indices:
            if predicted_ratings[idx] > 0:
                wisata_id = CACHE['wisata'][idx]
                recommendations.append({
                    'wisata_id': int(wisata_id),
                    'predicted_rating': float(predicted_ratings[idx]),
                    'method': 'collaborative_filtering'
                })
        
        return recommendations
    except Exception as e:
        logger.error(f"Error in KNN collaborative filtering: {str(e)}")
        return []

def knn_content_based(user_id, k=10, n_recommendations=10):
    try:
        user_ratings = get_user_ratings(DB_CONFIG, user_id)
        if not user_ratings:
            return []
        
        liked_wisata_ids = [r['wisata_id'] for r in user_ratings if r['rating'] >= 4]
        if not liked_wisata_ids:
            return []
        
        wisata_df = CACHE['wisata_df']
        tfidf_matrix = CACHE['tfidf_matrix']
        recommendations = []
        
        for liked_id in liked_wisata_ids:
            if liked_id in wisata_df['id'].values:
                liked_idx = wisata_df[wisata_df['id'] == liked_id].index[0]
                similarities = cosine_similarity(tfidf_matrix[liked_idx:liked_idx+1], tfidf_matrix).flatten()
                similar_indices = np.argsort(-similarities)[:k+1]
                
                for idx in similar_indices:
                    sim_wisata_id = int(wisata_df.iloc[idx]['id'])
                    if sim_wisata_id != liked_id and sim_wisata_id not in [r['wisata_id'] for r in user_ratings]:
                        recommendations.append({
                            'wisata_id': sim_wisata_id,
                            'similarity_score': float(similarities[idx]),
                            'based_on': liked_id,
                            'method': 'content_based'
                        })
        
        seen = set()
        unique_recs = []
        for rec in sorted(recommendations, key=lambda x: x['similarity_score'], reverse=True):
            if rec['wisata_id'] not in seen:
                seen.add(rec['wisata_id'])
                unique_recs.append(rec)
                if len(unique_recs) >= n_recommendations:
                    break
        
        return unique_recs
    except Exception as e:
        logger.error(f"Error in KNN content-based: {str(e)}")
        return []

def hybrid_recommendation(user_id, k_collaborative=5, k_content=10, n_recommendations=10, alpha=0.6):
    try:
        collab_recs = knn_collaborative_filtering(user_id, k=k_collaborative, n_recommendations=n_recommendations)
        content_recs = knn_content_based(user_id, k=k_content, n_recommendations=n_recommendations)
        combined = {}
        
        for rec in collab_recs:
            wisata_id = rec['wisata_id']
            combined[wisata_id] = {
                'wisata_id': wisata_id,
                'score': rec['predicted_rating'] * alpha,
                'methods': ['collaborative'],
                'collab_score': rec['predicted_rating']
            }
        
        for rec in content_recs:
            wisata_id = rec['wisata_id']
            content_score = rec['similarity_score'] * 5
            
            if wisata_id in combined:
                combined[wisata_id]['score'] += content_score * (1 - alpha)
                combined[wisata_id]['methods'].append('content_based')
                combined[wisata_id]['content_score'] = content_score
            else:
                combined[wisata_id] = {
                    'wisata_id': wisata_id,
                    'score': content_score * (1 - alpha),
                    'methods': ['content_based'],
                    'content_score': content_score
                }
        
        recommendations = sorted(combined.values(), key=lambda x: x['score'], reverse=True)[:n_recommendations]
        wisata_df = CACHE['wisata_df']
        
        for rec in recommendations:
            wisata_row = wisata_df[wisata_df['id'] == rec['wisata_id']]
            if not wisata_row.empty:
                rec['nama'] = wisata_row.iloc[0]['nama']
                rec['kategori'] = wisata_row.iloc[0]['kategori']
                rec['rating_avg'] = float(wisata_row.iloc[0]['rating_avg']) if wisata_row.iloc[0]['rating_avg'] else 0.0
                rec['harga_tiket'] = float(wisata_row.iloc[0]['harga_tiket']) if wisata_row.iloc[0]['harga_tiket'] else 0.0
                rec['foto'] = wisata_row.iloc[0]['foto']
        
        return recommendations
    except Exception as e:
        logger.error(f"Error in hybrid recommendation: {str(e)}")
        return []

@app.route('/', methods=['GET'])
def home():
    return jsonify({
        'status': 'success',
        'message': 'Wisata Jogja Recommendation API',
        'version': '2.0',
        'methods': ['collaborative_filtering', 'content_based', 'hybrid'],
        'algorithm': 'KNN with Cosine Similarity'
    })

@app.route('/refresh-cache', methods=['POST'])
def refresh():
    success = refresh_cache()
    if success:
        return jsonify({
            'status': 'success',
            'message': 'Cache refreshed successfully',
            'users_count': len(CACHE['users']),
            'wisata_count': len(CACHE['wisata'])
        })
    else:
        return jsonify({'status': 'error', 'message': 'Failed to refresh cache'}), 500

@app.route('/recommend', methods=['GET', 'POST'])
def recommend():
    try:
        # Support both GET and POST
        if request.method == 'POST':
            data = request.get_json() or {}
            user_id = data.get('user_id')
            method = data.get('method', 'hybrid')
            k = data.get('k', 5)
            n_recommendations = data.get('n_recommendations', 10)
            alpha = data.get('alpha', 0.6)
        else:
            user_id = request.args.get('user_id', type=int)
            method = request.args.get('method', 'hybrid')
            k = request.args.get('k', 5, type=int)
            n_recommendations = request.args.get('limit', 10, type=int)
            alpha = request.args.get('alpha', 0.6, type=float)
        
        if not user_id:
            return jsonify({'error': 'user_id is required'}), 400
        
        if CACHE['ratings_matrix'] is None or CACHE['wisata_df'] is None:
            refresh_cache()
        
        if method == 'collaborative':
            recommendations = knn_collaborative_filtering(user_id, k=k, n_recommendations=n_recommendations)
        elif method == 'content_based':
            recommendations = knn_content_based(user_id, k=k, n_recommendations=n_recommendations)
        elif method == 'hybrid':
            recommendations = hybrid_recommendation(user_id, k_collaborative=k, k_content=k*2, n_recommendations=n_recommendations, alpha=alpha)
        else:
            return jsonify({'error': 'Invalid method'}), 400
        
        if recommendations:
            save_recommendation_history(DB_CONFIG, user_id, recommendations, method)
        
        return jsonify({
            'status': 'success',
            'user_id': user_id,
            'method': method,
            'k_neighbors': k,
            'count': len(recommendations),
            'recommendations': recommendations
        })
        
    except Exception as e:
        logger.error(f"Error in recommend endpoint: {str(e)}")
        return jsonify({'status': 'error', 'message': str(e)}), 500

@app.route('/similar-wisata', methods=['GET', 'POST'])
def similar_wisata():
    try:
        # Support both GET and POST
        if request.method == 'POST':
            data = request.get_json() or {}
            wisata_id = data.get('wisata_id')
            k = data.get('k', 10)
        else:
            wisata_id = request.args.get('wisata_id', type=int)
            k = request.args.get('limit', 10, type=int)
        
        if not wisata_id:
            return jsonify({'error': 'wisata_id is required'}), 400
        
        if CACHE['wisata_df'] is None or CACHE['tfidf_matrix'] is None:
            refresh_cache()
        
        wisata_df = CACHE['wisata_df']
        tfidf_matrix = CACHE['tfidf_matrix']
        
        if wisata_id not in wisata_df['id'].values:
            return jsonify({'error': 'Wisata not found'}), 404
        
        wisata_idx = wisata_df[wisata_df['id'] == wisata_id].index[0]
        similarities = cosine_similarity(tfidf_matrix[wisata_idx:wisata_idx+1], tfidf_matrix).flatten()
        similar_indices = np.argsort(-similarities)[1:k+1]
        
        similar_items = []
        for idx in similar_indices:
            row = wisata_df.iloc[idx]
            similar_items.append({
                'wisata_id': int(row['id']),
                'nama': row['nama'],
                'kategori': row['kategori'],
                'similarity_score': float(similarities[idx]),
                'rating_avg': float(row['rating_avg']) if row['rating_avg'] else 0.0,
                'harga_tiket': float(row['harga_tiket']) if row['harga_tiket'] else 0.0,
                'foto': row['foto']
            })
        
        return jsonify({'status': 'success', 'wisata_id': wisata_id, 'similar_items': similar_items})
        
    except Exception as e:
        logger.error(f"Error in similar-wisata endpoint: {str(e)}")
        return jsonify({'status': 'error', 'message': str(e)}), 500

@app.route('/stats', methods=['GET'])
def stats():
    try:
        if CACHE['ratings_matrix'] is None:
            refresh_cache()
        
        ratings_matrix = CACHE['ratings_matrix']
        sparsity = 100 * (1 - np.count_nonzero(ratings_matrix) / ratings_matrix.size)
        
        return jsonify({
            'status': 'success',
            'statistics': {
                'total_users': len(CACHE['users']),
                'total_wisata': len(CACHE['wisata']),
                'total_ratings': int(np.count_nonzero(ratings_matrix)),
                'matrix_sparsity': f"{sparsity:.2f}%",
                'avg_ratings_per_user': float(np.count_nonzero(ratings_matrix) / len(CACHE['users'])),
                'cache_status': 'loaded'
            }
        })
    except Exception as e:
        return jsonify({'status': 'error', 'message': str(e)}), 500

if __name__ == '__main__':
    logger.info("Starting Flask Recommendation API...")
    refresh_cache()
    app.run(host='0.0.0.0', port=5000, debug=True)

