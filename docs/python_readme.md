# Wisata Jogja Recommendation Microservice

Flask-based recommendation system menggunakan KNN dengan Cosine Similarity.

## Features

- **Collaborative Filtering**: KNN-based user similarity menggunakan cosine similarity
- **Content-Based Filtering**: TF-IDF + Cosine Similarity untuk rekomendasi berdasarkan konten
- **Hybrid Recommendation**: Kombinasi collaborative dan content-based
- **Caching**: Cache recommendations untuk performa lebih baik
- **REST API**: Mudah diintegrasikan dengan aplikasi lain

## Installation

1. Install Python dependencies:

```bash
cd python
pip install -r requirements.txt
```

2. Pastikan database MySQL sudah running dan tabel sudah ada

3. Jalankan server:

```bash
python app.py
```

Server akan berjalan di `http://localhost:5000`

## API Endpoints

### 1. Health Check

```
GET /
```

### 2. Get Recommendations

```
POST /recommend
Content-Type: application/json

{
    "user_id": 12,
    "method": "hybrid",
    "k": 5,
    "n_recommendations": 10,
    "alpha": 0.6
}
```

**Methods:**

- `collaborative`: Collaborative filtering (KNN user-based)
- `content_based`: Content-based filtering (TF-IDF + cosine similarity)
- `hybrid`: Kombinasi keduanya (recommended)

**Parameters:**

- `user_id` (required): ID user
- `method` (optional): Method yang digunakan, default: "hybrid"
- `k` (optional): Jumlah nearest neighbors, default: 5
- `n_recommendations` (optional): Jumlah rekomendasi, default: 10
- `alpha` (optional): Bobot collaborative (0-1), default: 0.6

### 3. Find Similar Wisata

```
POST /similar-wisata
Content-Type: application/json

{
    "wisata_id": 9,
    "k": 10
}
```

### 4. Refresh Cache

```
POST /refresh-cache
```

### 5. Get Statistics

```
GET /stats
```

## Testing

### Test menggunakan Python:

```python
import requests

# Get recommendations
response = requests.post('http://localhost:5000/recommend', json={
    'user_id': 12,
    'method': 'hybrid',
    'n_recommendations': 10
})
print(response.json())
```

### Test menggunakan curl:

```bash
curl -X POST http://localhost:5000/recommend \
  -H "Content-Type: application/json" \
  -d '{"user_id": 12, "method": "hybrid", "n_recommendations": 10}'
```

## Integration dengan CodeIgniter

Contoh integrasi di controller CodeIgniter:

```php
public function get_recommendations($user_id) {
    $api_url = 'http://localhost:5000/recommend';

    $data = array(
        'user_id' => $user_id,
        'method' => 'hybrid',
        'n_recommendations' => 10
    );

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
```

## Algorithm

### 1. Collaborative Filtering (KNN)

- Menghitung cosine similarity antar users berdasarkan rating history
- Mencari K nearest neighbors
- Aggregate ratings dari neighbors dengan weighted average
- Predict ratings untuk items yang belum dirating

### 2. Content-Based Filtering (TF-IDF + Cosine)

- Extract features dari nama, type, description, kategori harga, rating segment
- Build TF-IDF matrix
- Hitung cosine similarity antar wisata
- Rekomendasi wisata yang similar dengan yang disukai user

### 3. Hybrid

- Kombinasi score dari kedua metode dengan weighted average
- Alpha parameter untuk mengatur bobot collaborative vs content-based
- Default alpha = 0.6 (60% collaborative, 40% content-based)

## Penjelasan Model dan Algoritma

### 1. Collaborative Filtering (Memory-Based KNN)
- Menggunakan algoritma K-Nearest Neighbors (KNN) untuk mencari user yang mirip berdasarkan rating wisata.
- Kemiripan antar user dihitung menggunakan **cosine similarity** pada matriks rating.
- Wisata yang belum dirating oleh user target diprediksi berdasarkan rating dari user-user yang mirip.
- Tidak membangun model prediktif, melainkan langsung menggunakan data rating yang ada (memory-based).

### 2. Content-Based Filtering
- Setiap wisata direpresentasikan sebagai vektor fitur gabungan (nama, kategori, deskripsi, alamat, fasilitas) yang diolah dengan **TF-IDF**.
- Kemiripan antar wisata dihitung menggunakan **cosine similarity** pada matriks TF-IDF.
- Wisata yang mirip dengan wisata yang disukai user akan direkomendasikan.

### 3. Hybrid Recommendation
- Menggabungkan hasil collaborative filtering dan content-based filtering.
- Skor akhir rekomendasi adalah kombinasi dari prediksi rating (collaborative) dan skor kemiripan (content-based) dengan bobot tertentu (parameter alpha).
- Memberikan rekomendasi yang lebih personal dan relevan.

### 4. Evaluasi
- Statistik yang dihasilkan: jumlah user, jumlah wisata, total rating, sparsity matriks rating, rata-rata rating per user.
- Evaluasi lanjutan dapat dilakukan dengan membandingkan hasil rekomendasi dengan preferensi aktual user.

---
Semua proses di atas diimplementasikan di file `app.py` dan modul pendukungnya.

## Database Tables

Required tables:

- `users`: User data
- `wisata`: Tourist destination data
- `rating`: User ratings
- `recommendation_history`: History of recommendations (auto-created)
- `similarity_cache`: Cache for recommendations (optional)

## Performance

- First request: ~2-3 seconds (build cache)
- Subsequent requests: ~100-300ms (dengan cache)
- Memory usage: ~50-100MB tergantung dataset size

## Troubleshooting

**Error: ModuleNotFoundError**

```bash
pip install -r requirements.txt
```

**Error: Connection refused (MySQL)**

- Check MySQL service is running
- Check database credentials in app.py

**Error: Memory error**

- Reduce matrix size
- Increase system memory
- Use sparse matrix implementation

## Author

Wisata Jogja Recommendation System v2.0
Powered by Flask + scikit-learn
