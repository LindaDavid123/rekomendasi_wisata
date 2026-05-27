<?php
/**
 * Dashboard View - User Dashboard (Sistem Rekomendasi Wisata)
 * 
 * Database Tables Used:
 * - users (id, username, email, nama, foto, role)
 * - wisata (id, nama, kategori, rating_avg, jumlah_rating)
 * - rating (id, user_id, wisata_id, rating, created_at)
 * - reviews (id, user_id, wisata_id, review, created_at)
 * - favorit (id, user_id, wisata_id)
 * - recommendation_history (id, user_id, wisata_id, recommendation_score)
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard - Rekomendasi Wisata Jogja' ?></title>
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
            background: linear-gradient(135deg, #f0f5f2 0%, #e8f4f0 50%, #f0f8f6 100%);
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
            background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%); /* default bg */
        }
        .user-avatar[src*="girl.png"] {
            background: linear-gradient(135deg, #ffe2f2 0%, #fff6fa 100%);
        }
        .user-avatar[src*="boy.png"] {
            background: linear-gradient(135deg, #e2f0ff 0%, #f6fbff 100%);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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

        /* Styling untuk form control */
        .form-control {
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4a6b3d;
            box-shadow: 0 0 0 0.2rem rgba(74, 107, 61, 0.15);
        }

        /* Rating card hover effects */
        #ratingForm label[for^="star"] {
            transition: all 0.2s ease;
        }

        #ratingForm label[for^="star"]:hover {
            text-shadow: 0 0 10px rgba(243, 156, 18, 0.5);
        }
        
        
        .category-card {
            background: linear-gradient(135deg, #dfeee9 0%, #e8f5f2 100%);
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
        .category-card.alam { background: linear-gradient(135deg, #dfeee9 0%, #e8f5f2 100%); }
        .category-card.kuliner { background: linear-gradient(135deg, #d5e4ed 0%, #e4f1f8 100%); }
        
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

        /* Dashboard specific styling */
        .dashboard-header {
            background: none;
            color: #2d3748;
        }

        .dashboard-content {
            padding: 40px;
        }

        /* Smooth scrollbar styling */
        div[style*="overflow-y: auto"]::-webkit-scrollbar {
            width: 8px;
        }

        div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
            border-radius: 10px;
        }

        div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover {
            background: #3a5a2d;
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
                <img src="<?= get_user_image($this->session->userdata('foto') ?? $this->session->userdata('foto_profil') ?? null) ?>" class="user-avatar" alt="User">
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
        </div>
        
        <!-- Bottom Grid -->
        <div class="bottom-grid">
            <!-- Rating Wisata -->
            <div class="card" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                    <h3 class="card-title" style="color: white; margin: 0; font-size: 18px; font-weight: 700;">
                        <i class="fas fa-star me-2"></i>Berikan Rating
                    </h3>
                    <p style="color: rgba(255,255,255,0.8); margin: 5px 0 0 0; font-size: 13px;">Rating wisata favorit Anda untuk mendapat rekomendasi</p>
                </div>
                
                <form id="ratingForm" method="POST" action="<?= base_url('wisata/submit_rating') ?>" style="padding: 25px;">
                    <div style="margin-bottom: 20px;">
                        <label class="form-label" style="font-weight: 700; color: #2d3748; margin-bottom: 10px; display: block;">
                            <i class="fas fa-map-pin me-2" style="color: #4a6b3d;"></i>Pilih Destinasi
                        </label>
                        <select name="wisata_id" class="form-control" style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 12px 15px; font-size: 14px; transition: all 0.3s;" required>
                            <option value="">-- Pilih Wisata --</option>
                            <?php if (!empty($popular_wisata)): ?>
                                <?php foreach ($popular_wisata as $wisata): ?>
                                    <option value="<?= $wisata['id'] ?>"><?= $wisata['nama'] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label class="form-label" style="font-weight: 700; color: #2d3748; margin-bottom: 12px; display: block;">
                            <i class="fas fa-heart me-2" style="color: #f39c12;"></i>Rating (1-5 Bintang)
                        </label>
                        <div style="display: flex; gap: 8px; font-size: 32px; cursor: pointer;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" style="display: none;" required>
                                <label for="star<?= $i ?>" style="cursor: pointer; color: #ddd; transition: all 0.2s; transform: scale(1);" onmouseover="previewStars(<?= $i ?>)" onmouseout="resetStars()" onclick="updateStars(<?= $i ?>)">★</label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); color: white; font-weight: 700; border-radius: 12px; padding: 12px 20px; border: none; transition: all 0.3s; box-shadow: 0 4px 12px rgba(74, 107, 61, 0.3);">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Rating
                    </button>
                </form>
            </div>
            
            <!-- Riwayat Rating -->
            <div class="card" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #3a6ea5 0%, #7fb1e3 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                    <h3 class="card-title" style="color: white; margin: 0; font-size: 18px; font-weight: 700;">
                        <i class="fas fa-history me-2"></i>Riwayat Rating
                    </h3>
                    <p style="color: rgba(255,255,255,0.8); margin: 5px 0 0 0; font-size: 13px;">Rating yang telah Anda berikan</p>
                </div>
                
                <div style="max-height: 400px; overflow-y: auto;">
                    <?php if (!empty($user_ratings)): ?>
                        <?php foreach ($user_ratings as $rating): ?>
                            <div style="padding: 16px 25px; border-bottom: 1px solid #f0f0f0; transition: all 0.3s; display: flex; justify-content: space-between; align-items: flex-start;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #2d3748; font-size: 14px; margin-bottom: 6px;">
                                        <i class="fas fa-mountain me-2" style="color: #3a6ea5;"></i><?= substr($rating['nama_wisata'], 0, 30) ?>
                                    </div>
                                    <div style="font-size: 12px; color: #999; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-calendar-alt" style="color: #3a6ea5;"></i><?= format_datetime($rating['created_at']) ?>
                                    </div>
                                </div>
                                <div style="color: #f39c12; font-size: 16px; font-weight: bold; min-width: 100px; text-align: right;">
                                    <?php for ($i = 0; $i < $rating['rating']; $i++): ?>
                                        <i class="fas fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 25px; color: #999;">
                            <i class="fas fa-inbox" style="font-size: 32px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                            <p style="margin: 0;">Belum ada rating. Mulai berikan rating untuk mendapat rekomendasi!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Rekomendasi (Hybrid Collaborative + Item-Based) -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">Rekomendasi Untuk Anda</h3>
                        <p class="card-subtitle">🤖 Hybrid Collaborative Filtering</p>
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
                    <p style="font-size: 13px; color: #666;">Sistem menganalisis pola rating Anda menggunakan Hybrid Collaborative Filtering + Item-Based</p>
                </div>
                <div style="padding: 15px; background: #f7fafc; border-radius: 12px; border-left: 4px solid #4a6b3d;">
                    <h5 style="color: #4a6b3d; margin-bottom: 8px; font-weight: 600;">🎯 Rekomendasi</h5>
                    <p style="font-size: 13px; color: #666;">Dapatkan rekomendasi personal berdasarkan Cosine Similarity dengan wisata lain</p>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    function updateStars(rating) {
        // Update visual feedback dengan animasi
        for (let i = 1; i <= 5; i++) {
            const label = document.querySelector(`label[for="star${i}"]`);
            const input = document.querySelector(`#star${i}`);
            if (i <= rating) {
                label.style.color = '#f39c12';
                label.style.transform = 'scale(1.15)';
                input.checked = true;
            } else {
                label.style.color = '#ddd';
                label.style.transform = 'scale(1)';
            }
        }
    }

    function previewStars(rating) {
        for (let i = 1; i <= 5; i++) {
            const label = document.querySelector(`label[for="star${i}"]`);
            if (i <= rating) {
                label.style.color = '#f39c12';
                label.style.transform = 'scale(1.15)';
            } else {
                label.style.color = '#ddd';
                label.style.transform = 'scale(1)';
            }
        }
    }

    function resetStars() {
        const checked = document.querySelector('#ratingForm input[type="radio"]:checked');
        if (checked) {
            updateStars(checked.value);
        } else {
            for (let i = 1; i <= 5; i++) {
                const label = document.querySelector(`label[for="star${i}"]`);
                label.style.color = '#ddd';
                label.style.transform = 'scale(1)';
            }
        }
    }

    // Hover effect untuk star rating
    document.querySelectorAll('#ratingForm label[for^="star"]').forEach(label => {
        label.addEventListener('mouseover', function() {
            const starNum = this.getAttribute('for').replace('star', '');
            previewStars(starNum);
        });
        label.addEventListener('mouseout', resetStars);
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
