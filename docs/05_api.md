# API Documentation

## 📡 REST API Reference

Complete API documentation for the Python Recommendation Microservice.

---

## 🔗 Base URL

**Development**:
```
http://localhost:5000
```

**Production**:
```
https://rekomendasi-wisata.com/api
```

---

## 🔐 Authentication

Current implementation uses **no authentication** for local development.

**Production**: Add API key validation

```python
def require_api_key(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        api_key = request.headers.get('X-API-Key')
        if not api_key or api_key != os.getenv('API_KEY'):
            return jsonify({'error': 'Unauthorized'}), 401
        return f(*args, **kwargs)
    return decorated_function
```

---

## 📍 Endpoints

### 1. Health Check

**Endpoint**:
```http
GET /
```

**Description**: Check if service is running

**Response**:
```json
{
    "status": "healthy",
    "version": "1.0.0",
    "timestamp": "2026-05-27T10:30:00Z"
}
```

**Status Code**: 200 OK

---

### 2. Get Recommendations

**Endpoint**:
```http
POST /recommend
```

**Description**: Get personalized recommendations for a user

**Headers**:
```
Content-Type: application/json
```

**Request Body**:
```json
{
    "user_id": 12,
    "method": "hybrid",
    "k": 5,
    "n_recommendations": 10,
    "alpha": 0.6
}
```

**Parameters**:

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| user_id | integer | Yes | - | User ID |
| method | string | No | "hybrid" | "collaborative", "content_based", "hybrid" |
| k | integer | No | 5 | Number of neighbors (collaborative) |
| n_recommendations | integer | No | 10 | Number of results to return |
| alpha | number | No | 0.6 | Collaborative weight (0-1) |

**Response**:
```json
{
    "recommendations": [
        {
            "wisata_id": 9,
            "nama": "Borobudur Temple",
            "kategori": "Historical",
            "score": 0.87,
            "reason": "Similar to attractions you liked"
        },
        {
            "wisata_id": 12,
            "nama": "Prambanan Temple",
            "kategori": "Historical",
            "score": 0.82,
            "reason": "Popular among similar users"
        }
    ],
    "method": "hybrid",
    "execution_time_ms": 47,
    "cache_hit": false,
    "timestamp": "2026-05-27T10:30:00Z"
}
```

**Status Codes**:
- 200 OK - Success
- 400 Bad Request - Invalid parameters
- 404 Not Found - User not found
- 500 Internal Server Error - Server error

**Example cURL**:
```bash
curl -X POST http://localhost:5000/recommend \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 12,
    "method": "hybrid",
    "n_recommendations": 5
  }'
```

**Example Python**:
```python
import requests

payload = {
    "user_id": 12,
    "method": "hybrid",
    "n_recommendations": 5
}

response = requests.post(
    'http://localhost:5000/recommend',
    json=payload
)

recommendations = response.json()
print(recommendations)
```

**Example JavaScript**:
```javascript
fetch('http://localhost:5000/recommend', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        user_id: 12,
        method: 'hybrid',
        n_recommendations: 5
    })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

---

### 3. Find Similar Attractions

**Endpoint**:
```http
POST /similar-wisata
```

**Description**: Find attractions similar to a given attraction

**Request Body**:
```json
{
    "wisata_id": 9,
    "k": 5
}
```

**Parameters**:

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| wisata_id | integer | Yes | - | Source attraction ID |
| k | integer | No | 5 | Number of similar attractions |

**Response**:
```json
{
    "wisata_id": 9,
    "nama": "Borobudur Temple",
    "similar_attractions": [
        {
            "wisata_id": 12,
            "nama": "Prambanan Temple",
            "similarity_score": 0.92
        },
        {
            "wisata_id": 15,
            "nama": "Candi Sewu",
            "similarity_score": 0.88
        }
    ],
    "timestamp": "2026-05-27T10:30:00Z"
}
```

**Example**:
```bash
curl -X POST http://localhost:5000/similar-wisata \
  -H "Content-Type: application/json" \
  -d '{
    "wisata_id": 9,
    "k": 3
  }'
```

---

### 4. Get Statistics

**Endpoint**:
```http
GET /stats
```

**Description**: Get system statistics and metrics

**Response**:
```json
{
    "total_users": 1234,
    "total_attractions": 287,
    "total_ratings": 12543,
    "average_rating": 4.2,
    "total_recommendations": 45632,
    "cache_hit_rate": 0.78,
    "average_execution_time_ms": 45,
    "uptime_seconds": 864000,
    "database_records": {
        "users": 1234,
        "wisata": 287,
        "ratings": 12543,
        "reviews": 5432,
        "favorites": 8765
    }
}
```

**Example**:
```bash
curl http://localhost:5000/stats
```

---

### 5. Refresh Cache

**Endpoint**:
```http
POST /refresh-cache
```

**Description**: Clear all cached recommendations (admin only)

**Optional Parameters**:
```json
{
    "user_id": 12
}
```

If `user_id` provided, clears only that user's cache. Otherwise, clears all.

**Response**:
```json
{
    "message": "Cache cleared successfully",
    "records_deleted": 1243,
    "timestamp": "2026-05-27T10:30:00Z"
}
```

**Example**:
```bash
curl -X POST http://localhost:5000/refresh-cache
```

---

### 6. Get User Preferences

**Endpoint**:
```http
GET /user/<user_id>/preferences
```

**Description**: Get detailed user preferences and history

**Response**:
```json
{
    "user_id": 12,
    "total_ratings": 25,
    "average_rating_given": 4.1,
    "favorite_categories": [
        "Historical",
        "Cultural",
        "Nature"
    ],
    "rated_attractions": [
        {
            "wisata_id": 9,
            "nama": "Borobudur",
            "rating": 5,
            "rated_at": "2026-05-15T10:30:00Z"
        }
    ],
    "last_recommendation": "2026-05-27T09:00:00Z"
}
```

---

## ⚠️ Error Handling

### Error Response Format

```json
{
    "error": true,
    "code": "INVALID_USER_ID",
    "message": "User ID must be a positive integer",
    "details": {
        "received": "abc",
        "expected": "integer"
    },
    "timestamp": "2026-05-27T10:30:00Z"
}
```

### Common Error Codes

| Code | Status | Description |
|------|--------|-------------|
| INVALID_USER_ID | 400 | User ID is invalid |
| USER_NOT_FOUND | 404 | User does not exist |
| INVALID_METHOD | 400 | Algorithm method not recognized |
| INVALID_PARAMETERS | 400 | Parameter validation failed |
| DATABASE_ERROR | 500 | Database connection error |
| SERVICE_UNAVAILABLE | 503 | Service temporarily down |

---

## 🔄 Rate Limiting

Current implementation has **no rate limiting** in development.

**Production configuration** (example):

```python
from flask_limiter import Limiter
from flask_limiter.util import get_remote_address

limiter = Limiter(
    app=app,
    key_func=get_remote_address,
    default_limits=["200 per day", "50 per hour"]
)

@app.route('/recommend', methods=['POST'])
@limiter.limit("30 per minute")
def recommend():
    # ...
```

---

## 🔐 Security Considerations

### CORS (Cross-Origin Resource Sharing)

Currently enabled for all origins. Production should restrict:

```python
CORS(app, resources={
    r"/recommend": {"origins": ["https://rekomendasi-wisata.com"]},
    r"/stats": {"origins": ["*"]}
})
```

### Request Validation

```python
def validate_recommend_params(data):
    """Validate recommendation request parameters"""
    user_id = data.get('user_id')
    
    if not user_id or not isinstance(user_id, int):
        raise ValueError("user_id must be a positive integer")
    
    if user_id < 1:
        raise ValueError("user_id must be greater than 0")
    
    method = data.get('method', 'hybrid')
    if method not in ['collaborative', 'content_based', 'hybrid']:
        raise ValueError("Invalid method")
    
    # ... more validation
```

---

## 📊 Response Format

All responses follow JSON:API standard (simplified):

```json
{
    "data": {
        // Main response data
    },
    "meta": {
        "timestamp": "2026-05-27T10:30:00Z",
        "version": "1.0.0"
    },
    "errors": [
        // Any errors
    ]
}
```

---

## 🧪 Testing Endpoints

### Quick Test Script

```python
#!/usr/bin/env python3
import requests
import json

BASE_URL = "http://localhost:5000"

def test_health():
    """Test health check"""
    response = requests.get(f"{BASE_URL}/")
    print("Health Check:", response.json())

def test_recommend():
    """Test recommendations"""
    payload = {
        "user_id": 12,
        "method": "hybrid",
        "n_recommendations": 5
    }
    response = requests.post(f"{BASE_URL}/recommend", json=payload)
    print("Recommendations:", json.dumps(response.json(), indent=2))

def test_stats():
    """Test statistics"""
    response = requests.get(f"{BASE_URL}/stats")
    print("Statistics:", json.dumps(response.json(), indent=2))

if __name__ == "__main__":
    test_health()
    test_recommend()
    test_stats()
```

---

## 📈 Performance Tips

1. **Cache Recommendations**: Set `expires_at` to 24 hours
2. **Batch Requests**: Use bulk endpoints if available
3. **Connection Pooling**: Reuse HTTP connections
4. **Compression**: Enable gzip compression
5. **CDN**: Cache static responses

---

## 🔄 Integration Examples

### From CodeIgniter Controller

```php
<?php
class Rekomendasi extends CI_Controller {
    
    public function get_recommendations($user_id) {
        $data = array(
            'user_id' => $user_id,
            'method' => 'hybrid',
            'n_recommendations' => 10
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://localhost:5000/recommend",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
            ],
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);
        
        $recommendations = json_decode($response, true);
        return $recommendations;
    }
}
```

---

## 📚 Related Documentation

- [System Architecture](01_architecture.md)
- [Recommendation System](02_recommendation_system.md)
- [Database Design](03_database_design.md)

