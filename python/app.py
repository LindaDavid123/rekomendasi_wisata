from flask import Flask, request, jsonify
from sklearn.metrics.pairwise import cosine_similarity
import numpy as np
from db_loader import load_ratings_matrix

app = Flask(__name__)

# Konfigurasi database sesuai project
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'rekomendasi_wisata',
    'charset': 'utf8mb4',
    'cursorclass': None
}

def get_matrix():
    matrix, users, wisata = load_ratings_matrix(db_config)
    return matrix, users, wisata

@app.route('/recommend', methods=['POST'])
def recommend():
    data = request.get_json()
    user_id = data.get('user_id')
    k = data.get('k', 2)

    ratings_matrix, users, wisata = get_matrix()
    if user_id not in users:
        return jsonify({'error': 'User not found'}), 404
    user_index = users.index(user_id)

    sim_matrix = cosine_similarity(ratings_matrix)
    user_sim = sim_matrix[user_index]
    similar_indices = np.argsort(-user_sim)
    similar_indices = [i for i in similar_indices if i != user_index][:k]

    rec_scores = np.zeros(ratings_matrix.shape[1])
    for idx in similar_indices:
        rec_scores += ratings_matrix[idx]
    rec_scores[ratings_matrix[user_index] > 0] = 0

    top_items = np.argsort(-rec_scores)[:k]
    rekomendasi = [{'wisata_id': wisata[i], 'score': float(rec_scores[i])} for i in top_items if rec_scores[i] > 0]
    return jsonify({
        'recommended_items': rekomendasi
    })

if __name__ == '__main__':
    app.run(debug=True)
