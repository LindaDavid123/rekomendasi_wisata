<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #e8eaf6 0%, #f3e5f5 50%, #e1f5fe 100%);
            min-height: 100vh;
        }
        
        .dashboard-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 100%;
            background: white;
            padding: 15px 40px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            height: auto;
            z-index: 1000;
        }
        
        .sidebar-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-right: auto;
        }
        
        .sidebar-menu {
            flex: none;
            width: auto;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }
        
        .menu-item {
            width: auto;
            height: auto;
            margin: 0;
            padding: 12px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #666;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .menu-item:hover, .menu-item.active {
            background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
            color: white;
        }
        
        .dashboard-content {
            flex: 1;
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .dashboard-title {
            font-size: 48px;
            font-weight: 700;
            color: #2d3748;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .search-icon, .notif-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #2d3748;
        }
        
        .card-subtitle {
            font-size: 13px;
            color: #999;
            margin-top: 5px;
        }
        
        .category-card {
            background: linear-gradient(135deg, #c3e4ed 0%, #d4f1f4 100%);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .category-card.budaya { background: linear-gradient(135deg, #ffd6a5 0%, #ffe4c4 100%); }
        .category-card.alam { background: linear-gradient(135deg, #c3e4ed 0%, #d4f1f4 100%); }
        .category-card.kuliner { background: linear-gradient(135deg, #d5c3e4 0%, #e4d4f1 100%); }
        
        .category-title {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .category-desc {
            font-size: 13px;
            color: #666;
        }
        
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 380px;
            gap: 30px;
        }
        
        .wishlist-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f7fafc;
            border-radius: 15px;
            margin-bottom: 12px;
        }
        
        .wishlist-title {
            font-size: 14px;
            color: #2d3748;
            margin-bottom: 8px;
        }
        
        .wishlist-percent {
            font-size: 16px;
            font-weight: 700;
            color: #2d3748;
        }
        
        .leaderboard-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .leaderboard-item:last-child {
            border-bottom: none;
        }
        
        .leaderboard-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
        }
        
        .leaderboard-info {
            flex: 1;
        }
        
        .leaderboard-name {
            font-size: 15px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .leaderboard-stats {
            display: flex;
            gap: 15px;
            font-size: 12px;
            color: #999;
            margin-top: 3px;
        }
        
        .leaderboard-score {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .bottom-grid {
                grid-template-columns: 1fr;
            }
            .sidebar {
                flex-wrap: wrap;
            }
        }

        /* Star Rating Styling */
        #ratingForm label[for^="star"] {
            transition: color 0.2s ease;
        }

        #ratingForm input[type="radio"]:checked ~ label,
        #ratingForm label:hover {
            color: #f39c12 !important;
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- Top Navbar -->
    <aside class="sidebar">
        <div class="sidebar-logo">W</div>
        
        <nav class="sidebar-menu">
            <a href="<?= base_url('dashboard') ?>" class="menu-item active">
                <i class="fas fa-home"></i>
                <span class="d-none d-lg-inline">Home</span>
            </a>
            <a href="<?= base_url('wisata') ?>" class="menu-item">
                <i class="fas fa-map-marked-alt"></i>
                <span class="d-none d-lg-inline">Wisata</span>
            </a>
            <a href="<?= base_url('rekomendasi') ?>" class="menu-item">
                <i class="fas fa-magic"></i>
                <span class="d-none d-lg-inline">Rekomendasi</span>
            </a>
            <a href="<?= base_url('favorit') ?>" class="menu-item">
                <i class="fas fa-heart"></i>
                <span class="d-none d-lg-inline">Favorit</span>
            </a>
            <a href="<?= base_url('profil') ?>" class="menu-item">
                <i class="fas fa-user"></i>
                <span class="d-none d-lg-inline">Profil</span>
            </a>
            <a href="<?= base_url('logout') ?>" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span class="d-none d-lg-inline">Logout</span>
            </a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="dashboard-content">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
            <div class="header-actions">
                <div class="search-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="notif-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <img src="<?= $this->session->userdata('foto') ? base_url('uploads/' . $this->session->userdata('foto')) : 'https://i.pravatar.cc/150?img=0' ?>" class="user-avatar" alt="User">
            </div>
        </div>
        
        <!-- Top Grid -->
        <div class="dashboard-grid">
            <!-- Left Column - Kategori Wisata -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Kategori Wisata</h3>
                        <p class="card-subtitle">Mulai jelajahi hari ini</p>
                    </div>
                </div>
                
                <a href="<?= base_url('wisata?kategori=alam') ?>" class="category-card alam">
                    <h4 class="category-title">🏔️ Wisata Alam</h4>
                    <p class="category-desc">Jelajahi keindahan alam Yogyakarta</p>
                </a>
                
                <a href="<?= base_url('wisata?kategori=budaya') ?>" class="category-card budaya">
                    <h4 class="category-title">🏛️ Wisata Budaya</h4>
                    <p class="category-desc">Pelajari budaya dan tradisi lokal</p>
                </a>
                
                <a href="<?= base_url('wisata?kategori=kuliner') ?>" class="category-card kuliner">
                    <h4 class="category-title">🍜 Wisata Kuliner</h4>
                    <p class="category-desc">Nikmati kelezatan kuliner tradisional</p>
                </a>
            </div>
            
            <!-- Right Column - Simple Card -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Statistik</h3>
                        <p class="card-subtitle">Data wisata terkini</p>
                    </div>
                </div>
                
                <div style="padding: 20px;">
                    <?php if (isset($statistics)): ?>
                        <div style="margin-bottom: 20px;">
                            <div style="font-size: 28px; font-weight: 700; color: #4a6b3d;"><?= $statistics['total_wisata'] ?>+</div>
                            <div style="font-size: 14px; color: #999;">Destinasi Wisata</div>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <div style="font-size: 28px; font-weight: 700; color: #4a6b3d;"><?= $statistics['total_users'] ?>+</div>
                            <div style="font-size: 14px; color: #999;">Pengguna Terdaftar</div>
                        </div>
                        <div>
                            <div style="font-size: 28px; font-weight: 700; color: #4a6b3d;"><?= $statistics['total_ratings'] ?>+</div>
                            <div style="font-size: 14px; color: #999;">Rating Diberikan</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Bottom Grid -->
        <div class="bottom-grid">
            <!-- Rating Wisata -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Berikan Rating</h3>
                        <p class="card-subtitle">Rating wisata favorit Anda</p>
                    </div>
                </div>
                
                <form id="ratingForm" method="POST" action="<?= base_url('wisata/submit_rating') ?>">
                    <div style="margin-bottom: 15px;">
                        <label class="form-label" style="font-weight: 600; color: #2d3748;">Pilih Destinasi</label>
                        <select name="wisata_id" class="form-control" style="border-radius: 10px;" required>
                            <option value="">-- Pilih Wisata --</option>
                            <?php if (!empty($popular_wisata)): ?>
                                <?php foreach ($popular_wisata as $wisata): ?>
                                    <option value="<?= $wisata['id'] ?>"><?= $wisata['nama'] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <label class="form-label" style="font-weight: 600; color: #2d3748;">Rating (1-5 Bintang)</label>
                        <div style="display: flex; gap: 10px; font-size: 24px; cursor: pointer;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" style="display: none;" required>
                                <label for="star<?= $i ?>" style="cursor: pointer; color: #ddd; transition: color 0.2s;" onclick="updateStars(<?= $i ?>)">★</label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn" style="width: 100%; background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); color: white; font-weight: 600; border-radius: 10px; padding: 10px;">Kirim Rating</button>
                </form>
            </div>
            
            <!-- Riwayat Rating -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Riwayat Rating</h3>
                        <p class="card-subtitle">Rating yang Anda berikan</p>
                    </div>
                </div>
                
                <div style="max-height: 350px; overflow-y: auto;">
                    <?php if (!empty($user_ratings)): ?>
                        <?php foreach ($user_ratings as $rating): ?>
                            <div style="padding: 12px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <div style="font-weight: 600; color: #2d3748; font-size: 14px;"><?= substr($rating['nama_wisata'], 0, 25) ?></div>
                                    <div style="font-size: 12px; color: #999;"><?= date('d M Y', strtotime($rating['created_at'])) ?></div>
                                </div>
                                <div style="color: #f39c12; font-size: 16px; font-weight: bold;">
                                    <?php for ($i = 0; $i < $rating['rating']; $i++): ?>
                                        ★
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 20px; color: #999;">
                            <p>Belum ada rating. Mulai berikan rating untuk mendapat rekomendasi!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Rekomendasi (Item-Based Collaborative) -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Rekomendasi Untuk Anda</h3>
                        <p class="card-subtitle">🤖 Item-Based Collaborative Filtering</p>
                    </div>
                </div>
                
                <?php if (!empty($recommendations)): ?>
                    <div style="max-height: 350px; overflow-y: auto;">
                        <?php foreach (array_slice($recommendations, 0, 5) as $rec): ?>
                            <div style="padding: 12px; border-bottom: 1px solid #f0f0f0;">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; color: #2d3748; font-size: 14px;"><?= substr($rec['nama'], 0, 28) ?></div>
                                        <div style="font-size: 12px; color: #999; margin-top: 3px;">
                                            📊 Confidence: <?= round($rec['recommendation_score'] * 100, 1) ?>%
                                        </div>
                                    </div>
                                    <a href="<?= base_url('wisata/detail/' . $rec['id']) ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; text-decoration: none;">Lihat</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 20px; color: #999;">
                        <p>Rekomendasi akan muncul setelah Anda memberikan minimal 1 rating</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Info Section -->
        <div style="margin-top: 40px; padding: 25px; background: white; border-radius: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
            <h3 style="font-size: 20px; font-weight: 700; color: #2d3748; margin-bottom: 15px;">
                ℹ️ Cara Kerja Sistem Rekomendasi
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div style="padding: 15px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #4a6b3d;">
                    <h5 style="color: #4a6b3d; margin-bottom: 8px; font-weight: 600;">📝 Rating</h5>
                    <p style="font-size: 13px; color: #666;">Berikan rating (1-5 bintang) pada destinasi wisata yang Anda kunjungi atau minati</p>
                </div>
                <div style="padding: 15px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #4a6b3d;">
                    <h5 style="color: #4a6b3d; margin-bottom: 8px; font-weight: 600;">🔍 Analisis</h5>
                    <p style="font-size: 13px; color: #666;">Sistem menganalisis pola rating Anda menggunakan Collaborative Filtering</p>
                </div>
                <div style="padding: 15px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #4a6b3d;">
                    <h5 style="color: #4a6b3d; margin-bottom: 8px; font-weight: 600;">🎯 Rekomendasi</h5>
                    <p style="font-size: 13px; color: #666;">Dapatkan rekomendasi personal berdasarkan kesamaan (Cosine Similarity) dengan wisata lain</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    function updateStars(rating) {
        // Update visual feedback
        for (let i = 1; i <= 5; i++) {
            const label = document.querySelector(`label[for="star${i}"]`);
            if (i <= rating) {
                label.style.color = '#f39c12';
            } else {
                label.style.color = '#ddd';
            }
        }
    }

    // Hover effect untuk star rating
    document.querySelectorAll('#ratingForm label[for^="star"]').forEach(label => {
        label.addEventListener('mouseover', function() {
            const starNum = this.getAttribute('for').replace('star', '');
            updateStars(starNum);
        });
    });

    document.getElementById('ratingForm').addEventListener('mouseout', function() {
        const checked = document.querySelector('#ratingForm input[type="radio"]:checked');
        if (checked) {
            updateStars(checked.value);
        } else {
            document.querySelectorAll('#ratingForm label[for^="star"]').forEach(label => {
                label.style.color = '#ddd';
            });
        }
    });

    // Reset visual saat form dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const checked = document.querySelector('#ratingForm input[type="radio"]:checked');
        if (checked) {
            updateStars(checked.value);
        }
    });
</script>
</body>
</html>
