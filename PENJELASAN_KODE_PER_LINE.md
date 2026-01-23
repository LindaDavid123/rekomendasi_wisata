# 📖 PENJELASAN KODE APP.PY PER LINE
## Fokus: Content-Based, KNN, Collaborative Filtering

---

## 📌 SECTION 1: IMPORT & LIBRARY (Lines 1-18)

```python
from flask import Flask, request, jsonify
```
**Penjelasan:**
- `Flask` = Web framework untuk membuat API server
- `request` = Object untuk menerima HTTP request dari client
- `jsonify` = Function untuk convert Python dictionary menjadi JSON response

**Kegunaan:** Membuat REST API yang bisa menerima request dan mengirim response JSON

---

```python
from flask_cors import CORS
```
**Penjelasan:**
- CORS = Cross-Origin Resource Sharing
- Memungkinkan request dari domain berbeda (misal: frontend di domain A, backend di domain B)

**Kegunaan:** Agar Frontend (CodeIgniter) bisa komunikasi dengan Backend (Flask) tanpa CORS error

---

```python
from sklearn.metrics.pairwise import cosine_similarity
```
**Penjelasan:**
- `cosine_similarity` = Function dari scikit-learn untuk menghitung cosine similarity antara 2 vector
- Cosine similarity mengukur sudut antara 2 vector (0 = berbeda, 1 = sama)

**Formula:** 
```
similarity = (A · B) / (||A|| × ||B||)
```

**Kegunaan:** Dipakai di 2 tempat:
1. **Collaborative Filtering** - Hitung kesamaan rating antar user
2. **Content-Based Filtering** - Hitung kesamaan karakteristik antar wisata

---

```python
from sklearn.feature_extraction.text import TfidfVectorizer
```
**Penjelasan:**
- TF-IDF = Term Frequency - Inverse Document Frequency
- Convert text (deskripsi wisata) menjadi numerical vector
- TF = berapa sering kata muncul (frequency)
- IDF = seberapa unik kata tersebut (importance)

**Contoh:**
```
Wisata A: "Candi Borobudur candi kuno peninggalan"
Wisata B: "Candi Prambanan candi kuno peninggalan"

TF-IDF vector A: [0.45, 0.3, 0.2, 0.1]
TF-IDF vector B: [0.44, 0.31, 0.19, 0.12]  (mirip karena sama-sama candi)
```

**Kegunaan:** Untuk Content-Based Filtering, convert wisata description menjadi vector

---

```python
import numpy as np
import pandas as pd
import pymysql
```
**Penjelasan:**
- `numpy` = Library untuk operasi mathematical/array (fast computation)
- `pandas` = Library untuk data manipulation (DataFrame, columns, rows)
- `pymysql` = Library untuk connect ke MySQL database

**Kegunaan:** Operasi data, manipulation, dan database connection

---

```python
from db_loader import (
    load_ratings_matrix,
    get_wisata_data,
    get_user_ratings,
    save_recommendation_history,
    get_wisata_features,
    get_recommendation_cache,
    save_recommendation_cache
)
```
**Penjelasan:**
- Import functions dari file `db_loader.py`
- Setiap function menangani berbeda operasi database:
  - `load_ratings_matrix` = Load rating matrix dari database
  - `get_wisata_data` = Get semua wisata
  - `get_user_ratings` = Get rating dari user tertentu
  - dll

**Kegunaan:** Reuse code yang sudah ada di db_loader.py

---

## 📌 SECTION 2: CACHE INITIALIZATION (Lines 34-41)

```python
# Cache
CACHE = {
    'ratings_matrix': None,
    'wisata': None,
    'wisata_df': None,
    'tfidf_matrix': None,
    'vectorizer': None
}
```

**Penjelasan:**
Cache adalah temporary storage di memory untuk data yang sering dipakai.

**Setiap key:**
- `ratings_matrix` = Matrix berisi rating dari semua user untuk semua wisata (shape: [n_users, n_wisata])
  ```
       Wisata1  Wisata2  Wisata3
  User1   5        4        0
  User2   5        5        2
  User3   3        0        5
  ```

- `users` = List berisi user IDs (misal: [1, 2, 3, 4, 5])
- `wisata` = List berisi wisata IDs (misal: [1, 2, 3, 4, 5])
- `wisata_df` = DataFrame berisi data lengkap semua wisata (nama, kategori, deskripsi, dll)
- `tfidf_matrix` = Matrix TF-IDF untuk semua wisata (hasil dari TfidfVectorizer)
- `vectorizer` = Object TfidfVectorizer yang sudah di-fit (bisa dipakai untuk transform data baru)

**Kegunaan:** Cache supaya tidak perlu load dari database berkali-kali (lambat), loading dari memory lebih cepat

---

## 📌 SECTION 3: REFRESH CACHE FUNCTION (Lines 43-65)

```python
def refresh_cache():
    try:
        logger.info("Refreshing cache...")
```
**Penjelasan:**
- `def refresh_cache():` = Define function bernama refresh_cache
- `try:` = Mulai try-except block untuk error handling

---

```python
        CACHE['ratings_matrix'], CACHE['users'], CACHE['wisata'] = load_ratings_matrix(DB_CONFIG)
```
**Penjelasan:**
- `load_ratings_matrix(DB_CONFIG)` = Function dari db_loader yang return 3 values
- Unpack hasil ke 3 key di CACHE dictionary
- `ratings_matrix` = Matrix [n_users x n_wisata] berisi rating
- `users` = List user IDs
- `wisata` = List wisata IDs

**Contoh:**
```python
# load_ratings_matrix return:
# ([[5, 4, 0], [5, 5, 2], [3, 0, 5]], [1, 2, 3], [1, 2, 3])
# ratings_matrix shape: (3, 3) - 3 users, 3 wisata
# users: [1, 2, 3]
# wisata: [1, 2, 3]
```

---

```python
        CACHE['wisata_df'] = get_wisata_data(DB_CONFIG)
```
**Penjelasan:**
- `get_wisata_data(DB_CONFIG)` = Query database untuk get semua wisata
- Return DataFrame dengan columns: id, nama, kategori, deskripsi, alamat, fasilitas, rating_avg, harga_tiket, foto

**Contoh struktur:**
```
| id | nama           | kategori | deskripsi | alamat | fasilitas | rating_avg | harga_tiket | foto |
|----|----------------|----------|-----------|--------|-----------|------------|-------------|------|
| 1  | Candi Borobudur| Sejarah  | text...   | Magelang| Parkir... | 4.9        | 25000       | url  |
| 2  | Candi Prambanan| Sejarah  | text...   | Sleman | Parkir... | 4.8        | 30000       | url  |
```

---

```python
        if not CACHE['wisata_df'].empty:
```
**Penjelasan:**
- `if not CACHE['wisata_df'].empty:` = Check apakah DataFrame kosong
- `.empty` = Property DataFrame yang return True jika kosong, False jika ada data
- Logika: Hanya lanjut jika ada data wisata

**Kegunaan:** Prevent error jika database kosong

---

```python
            CACHE['wisata_df']['combined_features'] = (
                CACHE['wisata_df']['nama'] + ' ' +
                CACHE['wisata_df']['kategori'] + ' ' +
                CACHE['wisata_df']['deskripsi'].fillna('') + ' ' +
                CACHE['wisata_df']['alamat'].fillna('') + ' ' +
                CACHE['wisata_df']['fasilitas'].fillna('')
            )
```

**Penjelasan per line:**
- `CACHE['wisata_df']['combined_features'] =` = Create/add new column ke DataFrame
- `CACHE['wisata_df']['nama'] + ' ' +` = Ambil column nama, tambah space, concat dengan column selanjutnya
- `CACHE['wisata_df']['deskripsi'].fillna('')` = Ambil column deskripsi, replace NaN dengan empty string ''
- Semua di-concat jadi 1 string panjang per wisata

**Contoh hasil:**
```
Wisata 1: "Candi Borobudur Sejarah Candi kuno peninggalan dinasti Sailendra... Magelang Parkir, toilet, restoran"
Wisata 2: "Candi Prambanan Sejarah Candi kuno kompleks Hindu... Sleman Parkir, toilet, museum"
```

**Kegunaan:** String gabungan ini akan di-pass ke TfidfVectorizer untuk Content-Based Filtering

---

```python
            CACHE['vectorizer'] = TfidfVectorizer(max_features=500, stop_words='english', ngram_range=(1, 2))
```

**Penjelasan:**
- `TfidfVectorizer(...)` = Create object untuk convert text ke TF-IDF matrix
- `max_features=500` = Ambil max 500 unique words (features) dari semua text
- `stop_words='english'` = Abaikan common English words (the, a, is, dll) yang tidak meaningful
- `ngram_range=(1, 2)` = Gunakan 1-gram dan 2-gram
  - 1-gram = single word (contoh: "Candi", "Kuno")
  - 2-gram = 2 words bersama (contoh: "Candi Borobudur", "kuno peninggalan")

**Kegunaan:** Initialize vectorizer yang akan di-fit dengan combined_features

---

```python
            CACHE['tfidf_matrix'] = CACHE['vectorizer'].fit_transform(CACHE['wisata_df']['combined_features'])
```

**Penjelasan:**
- `fit_transform(...)` = 2 step operation:
  1. **fit** = Learn dari data (identify 500 most important words)
  2. **transform** = Convert text ke matrix
- Input: series of strings (combined_features dari setiap wisata)
- Output: sparse matrix shape [n_wisata x 500]

**Contoh hasil:**
```
Shape: (15, 500)  - 15 wisata, 500 features/words
[
  [0.23, 0.15, 0.0, 0.18, ...],  # TF-IDF vector wisata 1
  [0.24, 0.14, 0.0, 0.19, ...],  # TF-IDF vector wisata 2
  ...
]
```

**Setiap nilai** = TF-IDF score untuk word itu di wisata itu
- Semakin tinggi = semakin penting/unik word itu untuk wisata itu

---

## 📌 SECTION 4: KNN COLLABORATIVE FILTERING (Lines 67-99)

Ini adalah **COLLABORATIVE FILTERING** menggunakan KNN (K-Nearest Neighbors)

```python
def knn_collaborative_filtering(user_id, k=5, n_recommendations=10):
```

**Penjelasan:**
- `def knn_collaborative_filtering(...)` = Define function untuk collaborative filtering
- `user_id` = User mana yang mau di-rekomendasikan
- `k=5` = Ambil 5 nearest neighbors (default, bisa di-override)
- `n_recommendations=10` = Return 10 rekomendasi (default)

---

```python
        if user_id not in CACHE['users']:
            return []
```

**Penjelasan:**
- Check apakah user_id ada di database
- Jika tidak ada, return empty list (tidak bisa rekomendasi)

---

```python
        user_index = CACHE['users'].index(user_id)
```

**Penjelasan:**
- CACHE['users'] adalah list: [1, 5, 3, 8, 2, ...]
- `.index(user_id)` = Find index position dari user_id dalam list
- Contoh: Jika CACHE['users'] = [1, 5, 3] dan user_id=3, maka user_index=2

**Kegunaan:** Karena ratings_matrix adalah 2D array, butuh integer index (bukan user_id)

---

```python
        ratings_matrix = CACHE['ratings_matrix']
```

**Penjelasan:**
- Ambil ratings_matrix dari cache (2D numpy array)
- Shape: [n_users, n_wisata]

---

```python
        user_similarity = cosine_similarity(ratings_matrix)
```

**Penjelasan:**
- `cosine_similarity(ratings_matrix)` = Compare setiap row (user) dengan setiap row lain
- Return: 2D matrix shape [n_users, n_users] berisi similarity scores

**Contoh:**
```python
ratings_matrix:
       W1  W2  W3
User1  5   4   0
User2  5   5   2
User3  3   0   5

user_similarity = cosine_similarity(ratings_matrix):
       User1  User2  User3
User1  1.0    0.95   0.25
User2  0.95   1.0    0.30
User3  0.25   0.30   1.0

Arti: User1 & User2 mirip 95%, User1 & User3 mirip 25%
```

---

```python
        user_sim_scores = user_similarity[user_index]
```

**Penjelasan:**
- Ambil row dari user_index dalam user_similarity matrix
- Ini berisi similarity score antara target user dengan SEMUA user lain

**Contoh:**
```python
Jika user_index = 0 (User1), maka:
user_sim_scores = [1.0, 0.95, 0.25]
Arti: User1 vs User1=1.0, User1 vs User2=0.95, User1 vs User3=0.25
```

---

```python
        similar_indices = np.argsort(-user_sim_scores)
```

**Penjelasan:**
- `np.argsort(...)` = Sort array dan return indices (posisi) bukan values
- `-user_sim_scores` = Negative untuk sort descending (besar ke kecil)
- Return: array indices yang sudah di-sort by similarity score (terbesar dulu)

**Contoh:**
```python
user_sim_scores = [1.0, 0.95, 0.25]
np.argsort(-user_sim_scores) = [0, 1, 2]
Arti: Index 0 (score 1.0) paling mirip, terus 1 (0.95), terus 2 (0.25)
```

---

```python
        similar_indices = [i for i in similar_indices if i != user_index][:k]
```

**Penjelasan:**
- `[i for i in similar_indices if i != user_index]` = List comprehension, filter keluar index user sendiri
- `[:k]` = Ambil hanya k neighbors pertama (top k)

**Contoh:**
```python
similar_indices = [0, 1, 2]
user_index = 0
Setelah filter: [1, 2]
Ambil k=2: [1, 2]
Arti: Top 2 neighbors dari user 0 adalah user 1 dan user 2
```

---

```python
        neighbor_ratings = np.zeros(ratings_matrix.shape[1])
        neighbor_weights = np.zeros(ratings_matrix.shape[1])
```

**Penjelasan:**
- `ratings_matrix.shape[1]` = Number of wisata
- `np.zeros(...)` = Create array of zeros dengan length = n_wisata

**Contoh:**
```python
Jika ada 15 wisata:
neighbor_ratings = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
neighbor_weights = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
```

**Kegunaan:**
- `neighbor_ratings` = Akan diisi dengan weighted sum of neighbor ratings
- `neighbor_weights` = Akan diisi dengan sum of weights (untuk averaging)

---

```python
        for neighbor_idx in similar_indices:
            similarity_score = user_sim_scores[neighbor_idx]
            if similarity_score > 0:
                neighbor_ratings += ratings_matrix[neighbor_idx] * similarity_score
                neighbor_weights += (ratings_matrix[neighbor_idx] > 0) * similarity_score
```

**Penjelasan per baris:**

1. `for neighbor_idx in similar_indices:` = Loop untuk setiap neighbor
2. `similarity_score = user_sim_scores[neighbor_idx]` = Get similarity score neighbor itu
3. `if similarity_score > 0:` = Hanya process jika similarity positive
4. `neighbor_ratings += ratings_matrix[neighbor_idx] * similarity_score`
   - Ambil rating array dari neighbor
   - Multiply dengan similarity_score (weighted)
   - Accumulate ke neighbor_ratings
5. `neighbor_weights += (ratings_matrix[neighbor_idx] > 0) * similarity_score`
   - `ratings_matrix[neighbor_idx] > 0` = Boolean array, 1 jika ada rating, 0 jika belum
   - Multiply dengan similarity_score
   - Accumulate ke neighbor_weights

**Contoh:**
```python
# Neighbor 1: rating=[5, 4, 0, 2], similarity=0.95
neighbor_ratings += [5, 4, 0, 2] * 0.95 = [4.75, 3.8, 0, 1.9]
neighbor_weights += [1, 1, 0, 1] * 0.95 = [0.95, 0.95, 0, 0.95]

# Neighbor 2: rating=[5, 5, 2, 0], similarity=0.85
neighbor_ratings += [5, 5, 2, 0] * 0.85 = [4.75+4.25, 3.8+4.25, 0+1.7, 1.9+0] = [9, 8.05, 1.7, 1.9]
neighbor_weights += [1, 1, 1, 0] * 0.85 = [0.95+0.85, 0.95+0.85, 0+0.85, 0.95+0] = [1.8, 1.8, 0.85, 0.95]
```

---

```python
        with np.errstate(divide='ignore', invalid='ignore'):
            predicted_ratings = np.divide(neighbor_ratings, neighbor_weights)
            predicted_ratings = np.nan_to_num(predicted_ratings)
```

**Penjelasan:**

1. `with np.errstate(divide='ignore', invalid='ignore'):` = Suppress divide by zero warning
2. `predicted_ratings = np.divide(neighbor_ratings, neighbor_weights)` = Weighted average
   - Bagi neighbor_ratings dengan neighbor_weights
   - Hasilnya adalah predicted rating dari neighbors
3. `predicted_ratings = np.nan_to_num(predicted_ratings)` = Replace NaN dengan 0
   - NaN terjadi jika neighbor_weights[i] = 0 (tidak ada neighbor yang rate wisata itu)

**Contoh:**
```python
neighbor_ratings = [9, 8.05, 1.7, 1.9]
neighbor_weights = [1.8, 1.8, 0.85, 0.95]
predicted_ratings = [9/1.8, 8.05/1.8, 1.7/0.85, 1.9/0.95]
                  = [5.0, 4.47, 2.0, 2.0]
Arti: Predict user akan rate wisata1=5.0, wisata2=4.47, wisata3=2.0, wisata4=2.0
```

---

```python
        user_rated = ratings_matrix[user_index] > 0
        predicted_ratings[user_rated] = 0
```

**Penjelasan:**

1. `user_rated = ratings_matrix[user_index] > 0` = Boolean array
   - True jika user sudah rate wisata itu, False jika belum
2. `predicted_ratings[user_rated] = 0` = Set predicted rating ke 0 untuk wisata yang sudah di-rate
   - Jangan rekomendasikan yang sudah di-rate user

**Contoh:**
```python
# User sudah rate wisata 1, 2, 4
user_rated = [True, True, False, True]
predicted_ratings = [5.0, 4.47, 2.0, 2.0]
predicted_ratings[user_rated] = 0
# Result: [0, 0, 2.0, 0]  # Hanya wisata3 yang di-rekomendasikan
```

---

```python
        top_indices = np.argsort(-predicted_ratings)[:n_recommendations]
```

**Penjelasan:**
- `np.argsort(-predicted_ratings)` = Sort indices by predicted rating (descending)
- `[:n_recommendations]` = Ambil top n_recommendations

**Contoh:**
```python
predicted_ratings = [0, 0, 2.0, 0, 1.5, 3.2, 0.8]
np.argsort(-predicted_ratings) = [5, 2, 4, 6, 0, 1, 3]
[:10] = [5, 2, 4, 6, 0, 1, 3]  (semua, karena hanya ada 7)
Arti: Top recommendation wisata index 5 (score 3.2), then 2 (score 2.0), then 4 (score 1.5)
```

---

```python
        recommendations = []
        for idx in top_indices:
            if predicted_ratings[idx] > 0:
                wisata_id = CACHE['wisata'][idx]
                recommendations.append({
                    'wisata_id': int(wisata_id),
                    'predicted_rating': float(predicted_ratings[idx]),
                    'method': 'collaborative_filtering'
                })
```

**Penjelasan:**

1. `recommendations = []` = Create empty list untuk hasil
2. `for idx in top_indices:` = Loop untuk setiap top recommendation
3. `if predicted_ratings[idx] > 0:` = Filter keluar yang punya score 0
4. `wisata_id = CACHE['wisata'][idx]` = Get wisata ID dari index
5. `recommendations.append({...})` = Add dict ke list

**Dict yang di-add:**
- `wisata_id` = Wisata ID (integer)
- `predicted_rating` = Score yang di-predict (float)
- `method` = "collaborative_filtering"

**Contoh hasil:**
```python
[
  {'wisata_id': 5, 'predicted_rating': 3.2, 'method': 'collaborative_filtering'},
  {'wisata_id': 2, 'predicted_rating': 2.0, 'method': 'collaborative_filtering'},
  {'wisata_id': 4, 'predicted_rating': 1.5, 'method': 'collaborative_filtering'},
]
```

---

## 📌 SECTION 5: KNN CONTENT-BASED FILTERING (Lines 101-140)

Ini adalah **CONTENT-BASED FILTERING** menggunakan TF-IDF + Cosine Similarity

```python
def knn_content_based(user_id, k=10, n_recommendations=10):
```

**Penjelasan:**
- `k=10` = Ambil 10 wisata terdekat dari setiap liked wisata
- Content-based tidak menggunakan "K-Nearest Neighbors" dalam arti traditional KNN, tapi konsepnya mirip

---

```python
        user_ratings = get_user_ratings(DB_CONFIG, user_id)
        if not user_ratings:
            return []
```

**Penjelasan:**
- `get_user_ratings(...)` = Query database untuk get semua rating dari user ini
- Return: list of dicts like [{'wisata_id': 1, 'rating': 5}, {'wisata_id': 3, 'rating': 4}, ...]
- Jika tidak ada rating, return empty list

---

```python
        liked_wisata_ids = [r['wisata_id'] for r in user_ratings if r['rating'] >= 4]
```

**Penjelasan:**
- List comprehension: ambil wisata_id dari rating yang >= 4
- `rating >= 4` = Ambil hanya wisata yang user suka (4-5 bintang)

**Contoh:**
```python
user_ratings = [
  {'wisata_id': 1, 'rating': 5},
  {'wisata_id': 2, 'rating': 3},  # Tidak suka, skip
  {'wisata_id': 3, 'rating': 4},
]
liked_wisata_ids = [1, 3]
```

---

```python
        if not liked_wisata_ids:
            return []
```

**Penjelasan:**
- Jika tidak ada wisata yang di-like (semua rating < 4), return empty list
- Tidak bisa rekomendasikan tanpa data liked wisata

---

```python
        wisata_df = CACHE['wisata_df']
        tfidf_matrix = CACHE['tfidf_matrix']
        recommendations = []
```

**Penjelasan:**
- Ambil wisata DataFrame dan TF-IDF matrix dari cache
- Initialize empty recommendations list

---

```python
        for liked_id in liked_wisata_ids:
```

**Penjelasan:**
- Loop untuk setiap wisata yang user suka
- Untuk setiap wisata, cari wisata serupa

---

```python
            if liked_id in wisata_df['id'].values:
                liked_idx = wisata_df[wisata_df['id'] == liked_id].index[0]
```

**Penjelasan:**

1. `if liked_id in wisata_df['id'].values:` = Check apakah wisata ada di database
2. `wisata_df[wisata_df['id'] == liked_id]` = Filter DataFrame untuk wisata itu
3. `.index[0]` = Get index position (bukan wisata_id, tapi position dalam DataFrame)

**Contoh:**
```python
wisata_df:
     id  nama
0    1   Borobudur
1    3   Prambanan
2    5   Parangtritis

wisata_df['id'].values = [1, 3, 5]
liked_id = 3
wisata_df[wisata_df['id'] == liked_id] = DataFrame dengan row wisata_id=3
.index[0] = 1 (position dalam DataFrame, bukan wisata_id)
```

---

```python
                similarities = cosine_similarity(tfidf_matrix[liked_idx:liked_idx+1], tfidf_matrix).flatten()
```

**Penjelasan:**

1. `tfidf_matrix[liked_idx:liked_idx+1]` = Ambil TF-IDF vector dari wisata yang di-like
   - `[liked_idx:liked_idx+1]` menghasilkan 2D array (matrix) bukan 1D array
   - Ini penting karena cosine_similarity expect 2D input
2. `cosine_similarity(..., tfidf_matrix)` = Compare wisata dengan SEMUA wisata
   - Return 2D array shape [1, n_wisata]
3. `.flatten()` = Convert 2D ke 1D array

**Contoh:**
```python
liked_idx = 1 (Candi Prambanan)
tfidf_matrix[1:2] = [[0.23, 0.15, 0.0, 0.18, ...]]  (1 x 500)
cosine_similarity(tfidf_matrix[1:2], tfidf_matrix) = [[0.95, 1.0, 0.23, 0.15, ...]]  (1 x 15)
.flatten() = [0.95, 1.0, 0.23, 0.15, ...]  (15,)

Arti:
- Wisata 0 mirip 95% dengan Prambanan
- Wisata 1 (Prambanan sendiri) mirip 100%
- Wisata 2 mirip 23%
```

---

```python
                similar_indices = np.argsort(-similarities)[:k+1]
```

**Penjelasan:**
- `np.argsort(-similarities)` = Sort indices by similarity (descending)
- `[:k+1]` = Ambil top k+1 (include wisata itu sendiri)
- Alasan k+1 karena wisata itu sendiri akan di-filter nanti

---

```python
                for idx in similar_indices:
                    sim_wisata_id = int(wisata_df.iloc[idx]['id'])
                    if (sim_wisata_id != liked_id and 
                        sim_wisata_id not in [r['wisata_id'] for r in user_ratings]):
```

**Penjelasan:**

1. `for idx in similar_indices:` = Loop untuk setiap similar wisata
2. `wisata_df.iloc[idx]['id']` = Get wisata ID dari DataFrame
   - `.iloc[idx]` = Get row by position index
   - `['id']` = Get column id
3. `if sim_wisata_id != liked_id` = Filter keluar wisata yang sama
4. `sim_wisata_id not in [r['wisata_id'] for r in user_ratings]` = Filter keluar yang sudah di-rate
   - `[r['wisata_id'] for r in user_ratings]` = List wisata yang sudah user rate

---

```python
                        recommendations.append({
                            'wisata_id': sim_wisata_id,
                            'similarity_score': float(similarities[idx]),
                            'based_on': liked_id,
                            'method': 'content_based'
                        })
```

**Penjelasan:**
- Append recommendation dict dengan:
  - `wisata_id` = Wisata yang di-rekomendasikan
  - `similarity_score` = Seberapa mirip dengan wisata yang user suka
  - `based_on` = Based on wisata apa (wisata yang user suka)
  - `method` = "content_based"

**Contoh:**
```python
{
  'wisata_id': 2,
  'similarity_score': 0.87,
  'based_on': 1,
  'method': 'content_based'
}
# Arti: Rekomendasikan wisata 2, mirip 87% dengan wisata 1 (yang user suka)
```

---

```python
        seen = set()
        unique_recs = []
        for rec in sorted(recommendations, key=lambda x: x['similarity_score'], reverse=True):
            if rec['wisata_id'] not in seen:
                seen.add(rec['wisata_id'])
                unique_recs.append(rec)
                if len(unique_recs) >= n_recommendations:
                    break
```

**Penjelasan:**

1. `seen = set()` = Create set untuk track wisata yang sudah di-add
2. `sorted(recommendations, key=lambda x: x['similarity_score'], reverse=True)` 
   - Sort recommendations by similarity_score (descending)
   - `key=lambda x: x['similarity_score']` = Ambil value dari key similarity_score
3. `for rec in sorted(...)` = Loop sorted recommendations
4. `if rec['wisata_id'] not in seen:` = Check apakah wisata sudah ada
5. `seen.add(rec['wisata_id'])` = Add wisata ke set (prevent duplicate)
6. `unique_recs.append(rec)` = Add ke unique list
7. `if len(unique_recs) >= n_recommendations: break` = Stop kalau sudah cukup

**Contoh:**
```python
recommendations = [
  {'wisata_id': 2, 'similarity_score': 0.87},
  {'wisata_id': 3, 'similarity_score': 0.85},
  {'wisata_id': 2, 'similarity_score': 0.80},  # Duplicate wisata 2
  {'wisata_id': 4, 'similarity_score': 0.75},
]
# Setelah sorting by score: [0.87, 0.85, 0.80, 0.75]

# Loop:
# Rec 1 (wisata 2, 0.87): tidak di seen, add. seen={2}, unique_recs=[rec1]
# Rec 2 (wisata 3, 0.85): tidak di seen, add. seen={2,3}, unique_recs=[rec1,rec2]
# Rec 3 (wisata 2, 0.80): sudah di seen, skip
# Rec 4 (wisata 4, 0.75): tidak di seen, add. seen={2,3,4}, unique_recs=[rec1,rec2,rec4]
# Jika n_recommendations=3, break

# Result: [wisata 2 (0.87), wisata 3 (0.85), wisata 4 (0.75)]
```

**Kegunaan:** Eliminate duplicate recommendations dan keep hanya top n

---

```python
        return unique_recs
```

**Penjelasan:**
- Return final content-based recommendations

---

## 📌 SECTION 6: HYBRID RECOMMENDATION (Lines 142-190)

Ini menggabungkan COLLABORATIVE + CONTENT-BASED

```python
def hybrid_recommendation(user_id, k_collaborative=5, k_content=10, n_recommendations=10, alpha=0.6):
```

**Penjelasan:**
- `k_collaborative=5` = Number of neighbors untuk collaborative filtering
- `k_content=10` = Number of similar wisata untuk content-based
- `n_recommendations=10` = Return top 10
- `alpha=0.6` = Weight untuk collaborative (60%), content (40%)

---

```python
        collab_recs = knn_collaborative_filtering(user_id, k=k_collaborative, n_recommendations=n_recommendations)
        content_recs = knn_content_based(user_id, k=k_content, n_recommendations=n_recommendations)
```

**Penjelasan:**
- Call 2 algorithm separate
- `collab_recs` = Recommendations dari collaborative filtering
- `content_recs` = Recommendations dari content-based filtering

---

```python
        combined = {}
```

**Penjelasan:**
- Create empty dict untuk combine recommendations dari 2 algorithm
- Key = wisata_id, Value = combined score + metadata

---

```python
        for rec in collab_recs:
            wisata_id = rec['wisata_id']
            combined[wisata_id] = {
                'wisata_id': wisata_id,
                'score': rec['predicted_rating'] * alpha,
                'methods': ['collaborative'],
                'collab_score': rec['predicted_rating']
            }
```

**Penjelasan:**

1. Loop untuk setiap collaborative recommendation
2. `wisata_id = rec['wisata_id']` = Extract wisata ID
3. `'score': rec['predicted_rating'] * alpha`
   - Weight collaborative score dengan alpha (0.6)
   - Contoh: predicted_rating=4.0, alpha=0.6 → score=2.4
4. `'methods': ['collaborative']` = Track method yang dipakai
5. `'collab_score': rec['predicted_rating']` = Save original collab score

**Contoh result:**
```python
combined = {
  3: {
    'wisata_id': 3,
    'score': 3.0 * 0.6 = 1.8,
    'methods': ['collaborative'],
    'collab_score': 3.0
  },
  5: {
    'wisata_id': 5,
    'score': 4.0 * 0.6 = 2.4,
    'methods': ['collaborative'],
    'collab_score': 4.0
  }
}
```

---

```python
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
```

**Penjelasan:**

1. `content_score = rec['similarity_score'] * 5`
   - Similarity score range 0-1, multiply 5 untuk scale ke rating scale
   - Contoh: similarity=0.8 → content_score=4.0 (comparable dengan rating scale 1-5)

2. `if wisata_id in combined:`
   - Jika wisata sudah ada di combined (dari collab), update score
   - `combined[wisata_id]['score'] += content_score * (1 - alpha)`
     - Add content score dengan weight (1-alpha) = 0.4
     - Contoh: wisata 3, collab_score=1.8, content_score=3.5
       - New score = 1.8 + (3.5 * 0.4) = 1.8 + 1.4 = 3.2
   - Append 'content_based' ke methods

3. `else:`
   - Jika wisata hanya dari content-based, add ke combined dict
   - Score = content_score * 0.4

**Contoh result setelah loop content-based:**
```python
combined = {
  3: {
    'wisata_id': 3,
    'score': 1.8 + (3.5 * 0.4) = 3.2,
    'methods': ['collaborative', 'content_based'],
    'collab_score': 3.0,
    'content_score': 3.5
  },
  5: {
    'wisata_id': 5,
    'score': 2.4,
    'methods': ['collaborative'],
    'collab_score': 4.0
  },
  7: {
    'wisata_id': 7,
    'score': 4.5 * 0.4 = 1.8,
    'methods': ['content_based'],
    'content_score': 4.5
  }
}
```

---

```python
        recommendations = sorted(combined.values(), key=lambda x: x['score'], reverse=True)[:n_recommendations]
```

**Penjelasan:**

1. `combined.values()` = Get all dict values (kombinasi semua)
2. `sorted(..., key=lambda x: x['score'], reverse=True)` = Sort by score (highest first)
3. `[:n_recommendations]` = Ambil top n

**Contoh:**
```python
Setelah sort by score:
[
  wisata 3 (score 3.2),
  wisata 5 (score 2.4),
  wisata 7 (score 1.8)
]
[:10] = semua 3 (karena hanya 3, dan limit 10)
```

---

```python
        wisata_df = CACHE['wisata_df']
        
        for rec in recommendations:
            wisata_row = wisata_df[wisata_df['id'] == rec['wisata_id']]
            if not wisata_row.empty:
                rec['nama'] = wisata_row.iloc[0]['nama']
                rec['kategori'] = wisata_row.iloc[0]['kategori']
                rec['rating_avg'] = float(wisata_row.iloc[0]['rating_avg']) if wisata_row.iloc[0]['rating_avg'] else 0.0
                rec['harga_tiket'] = float(wisata_row.iloc[0]['harga_tiket']) if wisata_row.iloc[0]['harga_tiket'] else 0.0
                rec['foto'] = wisata_row.iloc[0]['foto']
```

**Penjelasan:**

1. `wisata_row = wisata_df[wisata_df['id'] == rec['wisata_id']]`
   - Filter DataFrame untuk wisata yang di-rekomendasikan
2. `if not wisata_row.empty:` = Check apakah wisata ada
3. `rec['nama'] = wisata_row.iloc[0]['nama']` 
   - Add nama wisata ke recommendation dict
   - `.iloc[0]` = Get first (dan only) row
4. Similar untuk kategori, rating, harga, foto

**Kegunaan:** Enrich recommendation dengan metadata wisata (untuk ditampilkan di Frontend)

**Contoh final result:**
```python
recommendations = [
  {
    'wisata_id': 3,
    'score': 3.2,
    'methods': ['collaborative', 'content_based'],
    'collab_score': 3.0,
    'content_score': 3.5,
    'nama': 'Malioboro Street',
    'kategori': 'Budaya',
    'rating_avg': 4.7,
    'harga_tiket': 0.0,
    'foto': 'https://...'
  },
  {
    'wisata_id': 5,
    'score': 2.4,
    'methods': ['collaborative'],
    'collab_score': 4.0,
    'nama': 'Pantai Parangtritis',
    'kategori': 'Alam',
    'rating_avg': 4.6,
    'harga_tiket': 15000.0,
    'foto': 'https://...'
  }
]
```

---

```python
        return recommendations
```

**Penjelasan:**
- Return final hybrid recommendations (sorted, enriched, ready to display)

---

## 📌 SUMMARY: ALGORITMA FLOW

### Collaborative Filtering (KNN):
```
1. Get user_id
2. Find similar users (KNN using cosine similarity pada rating matrix)
3. Get ratings dari similar users untuk wisata yang belum di-rate user
4. Weighted average (weight by similarity score)
5. Return top N wisata yang diprediksi user akan suka
```

### Content-Based Filtering:
```
1. Get user_id & ratings
2. Ambil wisata yang user like (rating >= 4)
3. Find similar wisata (using TF-IDF + cosine similarity)
4. Filter keluar yang sudah di-rate
5. Return top N wisata yang mirip dengan yang user suka
```

### Hybrid:
```
1. Get collab recommendations
2. Get content recommendations
3. Combine score: (collab_score * 0.6) + (content_score * 0.4)
4. Sort by combined score
5. Enrich dengan metadata wisata
6. Return top N hybrid recommendations
```

---

## 📌 KEY CONCEPTS

### Cosine Similarity:
- Ukuran seberapa mirip 2 vector
- Range: 0 (berbeda) sampai 1 (identik)
- Formula: `cos(θ) = (A · B) / (||A|| × ||B||)`

### TF-IDF:
- Convert text menjadi numerical vector
- TF = seberapa sering kata muncul
- IDF = seberapa unik/penting kata
- Hasil: vector yang represent unique characteristics dari text

### KNN (K-Nearest Neighbors):
- Find K data points terdekat dari target point
- Gunakan untuk: collaborative filtering (user-to-user) dan content-based (item-to-item)
- "Terdekat" diukur dengan cosine similarity

### Alpha (Weight):
- alpha = 0.6 → collaborative 60%, content 40%
- Bisa di-adjust berdasarkan mana yang lebih akurat untuk use case

---

## 📌 EXAMPLE WALKTHROUGH

**Scenario: Get recommendation untuk User 5**

### Step 1: Call `hybrid_recommendation(user_id=5, alpha=0.6)`

### Step 2: Collaborative Filtering
```
User ratings matrix:
       W1  W2  W3  W4  W5
User1  5   4   0   3   5
User2  5   5   2   0   4
User3  3   0   5   4   2
User4  4   3   4   5   3
User5  5   0   0   0   0  ← Target user (user 5)

Cosine similarity user 5 vs semua user:
User1: 0.95 ✓ (mirip)
User2: 0.89
User3: 0.25
User4: 0.85 ✓

Top 5 neighbors: User1 (0.95), User4 (0.85), User2 (0.89), ...

Weighted average rating dari neighbors untuk wisata yang belum di-rate user 5:
W2: (4*0.95 + 3*0.85 + 5*0.89) / (0.95 + 0.85 + 0.89) = 4.18
W3: (0*0.95 + 4*0.85 + 2*0.89) / (0.95 + 0.85 + 0.89) = 1.96
W4: (3*0.95 + 5*0.85 + 0*0.89) / (0.95 + 0.85 + 0.89) = 3.43
W5: (5*0.95 + 3*0.85 + 4*0.89) / (0.95 + 0.85 + 0.89) = 4.10

collab_recs = [
  {wisata_id: 2, predicted_rating: 4.18},
  {wisata_id: 5, predicted_rating: 4.10},
  {wisata_id: 4, predicted_rating: 3.43},
]
```

### Step 3: Content-Based Filtering
```
User 5 ratings: [5, 0, 0, 0, 0]
Liked wisata (>=4): [1]

Wisata 1 characteristics: "Candi Borobudur Sejarah..."
TF-IDF similarity dengan wisata lain:
W2 (Candi Prambanan): 0.92 (mirip, sama-sama candi)
W3 (Parangtritis): 0.15 (berbeda, alam vs sejarah)
W4 (Keraton): 0.85 (mirip, sama-sama sejarah)
W5 (Taman Sari): 0.78 (mirip, sama-sama budaya)

content_recs = [
  {wisata_id: 2, similarity_score: 0.92},
  {wisata_id: 4, similarity_score: 0.85},
  {wisata_id: 5, similarity_score: 0.78},
]
```

### Step 4: Combine (alpha=0.6)
```
combined = {
  2: score = 4.18*0.6 + 0.92*5*0.4 = 2.51 + 1.84 = 4.35 ✓ Top 1
  4: score = 3.43*0.6 + 0.85*5*0.4 = 2.06 + 1.70 = 3.76 ✓ Top 2
  5: score = 4.10*0.6 + 0.78*5*0.4 = 2.46 + 1.56 = 4.02 ✓ Top 3
  3: score = 0 + 0.15*5*0.4 = 0.30
}

Final recommendations (top 3):
1. Wisata 2 (score 4.35, methods: collab+content)
2. Wisata 5 (score 4.02, methods: collab+content)
3. Wisata 4 (score 3.76, methods: collab+content)
```

### Step 5: Enrich dengan metadata
```
recommendations = [
  {
    wisata_id: 2,
    score: 4.35,
    methods: ['collaborative', 'content_based'],
    nama: 'Candi Prambanan',
    kategori: 'Sejarah',
    rating_avg: 4.8,
    harga_tiket: 30000,
    foto: 'https://...'
  },
  ...
]
```

---

Semua penjelasan sudah detail per line untuk Collaborative, Content-Based, dan KNN! 🎯

