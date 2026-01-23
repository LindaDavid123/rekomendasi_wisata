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
            flex-direction: row;
            min-height: 100vh;
        }
        
        /* Improved Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2d5a3d 0%, #3d6b4d 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        
        .sidebar-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #5a9f6a 0%, #7fb47d 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .sidebar-logo:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        }
        
        .sidebar-menu {
            flex: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .menu-item {
            width: 100%;
            height: auto;
            margin: 0;
            padding: 14px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            color: rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            border-left: 3px solid transparent;
            position: relative;
        }
        
        .menu-item i {
            font-size: 16px;
            min-width: 20px;
            text-align: center;
        }
        
        .menu-item:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }
        
        .menu-item.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-left-color: #7fb47d;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 70%;
            background: #7fb47d;
            border-radius: 0 3px 3px 0;
        }
        
        .dashboard-content {
            flex: 1;
            padding: 40px;
            max-width: 1400px;
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
        }
        
        .hamburger-menu {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 6px;
            background: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .hamburger-menu span {
            width: 25px;
            height: 3px;
            background: #2d3748;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .hamburger-menu.active span:nth-child(1) {
            transform: rotate(45deg) translate(10px, 10px);
        }
        
        .hamburger-menu.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
        
        #sidebarBackdrop {
            transition: all 0.3s ease;
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
            transition: all 0.3s ease;
            color: #2d3748;
        }
        
        .search-icon:hover, .notif-icon:hover {
            background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
            color: white;
            transform: scale(1.05);
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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
        
        /* Responsive Design - Tablet (768px and below) */
        @media (max-width: 768px) {
            .hamburger-menu {
                display: flex;
            }
            
            .sidebar {
                width: 70px;
                padding: 20px 10px;
                transition: all 0.3s ease;
            }
            
            .sidebar-logo {
                width: 50px;
                height: 50px;
                margin-bottom: 20px;
                font-size: 24px;
            }
            
            .menu-item {
                padding: 12px 10px;
                justify-content: center;
                border-left: none;
                border-top: 3px solid transparent;
                border-radius: 8px;
            }
            
            .menu-item span {
                display: none;
            }
            
            .menu-item i {
                font-size: 20px;
            }
            
            .menu-item.active {
                border-left: none;
                border-top-color: #7fb47d;
            }
            
            .menu-item.active::before {
                display: none;
            }
            
            .dashboard-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                padding: 25px;
            }
            
            .dashboard-title {
                font-size: 32px;
            }
            
            .kategori-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        /* Responsive Design - Mobile (576px and below) */
        @media (max-width: 576px) {
            .hamburger-menu {
                display: flex;
            }
            
            .sidebar {
                width: 250px;
                padding: 20px;
                transform: translateX(-250px);
                transition: transform 0.3s ease;
                z-index: 2000;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .sidebar-logo {
                width: 45px;
                height: 45px;
                margin-bottom: 15px;
                font-size: 20px;
            }
            
            .menu-item {
                padding: 10px 8px;
                font-size: 12px;
                border-left: 3px solid transparent;
                border-top: none;
            }
            
            .menu-item i {
                font-size: 18px;
            }
            
            .menu-item span {
                display: inline;
            }
            
            .menu-item.active {
                border-left-color: #7fb47d;
                border-top: none;
            }
            
            .menu-item.active::before {
                display: block;
            }
            
            .dashboard-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .dashboard-header {
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .dashboard-title {
                font-size: 28px;
                flex-basis: 100%;
            }
            
            .search-icon, .notif-icon, .user-avatar {
                width: 40px;
                height: 40px;
            }
            
            .kategori-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .card {
                padding: 20px;
                border-radius: 15px;
            }
            
            .card-title {
                font-size: 18px;
            }
        }
        
        /* Responsive Design - Extra Small (480px and below) */
        @media (max-width: 480px) {
            .dashboard-content {
                margin-left: 60px;
                width: calc(100% - 60px);
                padding: 10px;
            }
            
            .dashboard-title {
                font-size: 24px;
            }
            
            .kategori-grid {
                grid-template-columns: 1fr;
            }
            
            .card {
                padding: 15px;
            }
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
            <div style="display: flex; align-items: center; gap: 15px;">
                <button class="hamburger-menu" id="hamburgerBtn" aria-label="Toggle Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1 class="dashboard-title">Dashboard</h1>
            </div>
            <div class="header-actions">
                <div class="search-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="notif-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <img src="<?= get_user_image($this->session->userdata('foto'), $this->session->userdata('nama_lengkap')) ?>" class="user-avatar" alt="User" onerror="this.src='<?= base_url('assets/images/user-placeholder.png') ?>'">
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
                        <select name="wisata_id" id="wisataSelect" class="form-control" style="border-radius: 12px; border: 2px solid #e0e0e0; padding: 12px 15px; font-size: 14px; transition: all 0.3s;" required>
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
                    
                    <button type="submit" id="submitRatingBtn" class="btn w-100" style="background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); color: white; font-weight: 700; border-radius: 12px; padding: 12px 20px; border: none; transition: all 0.3s; box-shadow: 0 4px 12px rgba(74, 107, 61, 0.3);">
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

    // ==================== TOAST NOTIFICATION ====================
    function showToast(message, type = 'success', duration = 3000) {
        // Create toast container if not exists
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                gap: 10px;
            `;
            document.body.appendChild(toastContainer);
        }

        // Create toast element
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? '#4a6b3d' : type === 'error' ? '#d32f2f' : '#1976d2';
        const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';

        toast.style.cssText = `
            background: ${bgColor};
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
            min-width: 300px;
        `;

        toast.innerHTML = `
            <i class="fas ${icon}" style="font-size: 18px;"></i>
            <span>${message}</span>
        `;

        toastContainer.appendChild(toast);

        // Auto remove after duration
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // Add CSS animations for toast
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // ==================== RATING FORM AJAX ====================
    document.getElementById('ratingForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get form data
        const formData = new FormData(this);
        const wisataId = formData.get('wisata_id');
        const rating = formData.get('rating');

        // Validate
        if (!wisataId) {
            showToast('Pilih destinasi terlebih dahulu', 'error');
            return;
        }
        if (!rating) {
            showToast('Berikan rating terlebih dahulu', 'error');
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitRatingBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

        // Send AJAX request
        fetch('<?= base_url('wisata/submit_rating') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success toast
                showToast('✨ Rating berhasil disimpan! Menampilkan rekomendasi...', 'success', 3000);

                // Reset form
                document.getElementById('ratingForm').reset();
                
                // Reset stars visual
                for (let i = 1; i <= 5; i++) {
                    const label = document.querySelector(`label[for="star${i}"]`);
                    label.style.color = '#ddd';
                    label.style.transform = 'scale(1)';
                }

                // Redirect to rekomendasi page after 1.5 seconds
                setTimeout(() => {
                    window.location.href = '<?= base_url('rekomendasi') ?>';
                }, 1500);
            } else {
                showToast(data.message || 'Gagal mengirim rating', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan, silakan coba lagi', 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

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
        
        // Activate current menu item based on current page
        activateCurrentMenu();
    });
    
    // ==================== SIDEBAR TOGGLE ====================
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.querySelector('.sidebar');
    
    if (!hamburgerBtn || !sidebar) {
        console.error('Hamburger button or sidebar not found');
    }
    
    // Create backdrop for mobile
    const backdrop = document.createElement('div');
    backdrop.id = 'sidebarBackdrop';
    backdrop.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 999;
    `;
    document.body.appendChild(backdrop);
    
    // Toggle sidebar saat hamburger di-klik
    hamburgerBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Hamburger clicked, sidebar open status:', sidebar.classList.contains('open'));
        
        hamburgerBtn.classList.toggle('active');
        sidebar.classList.toggle('open');
        
        // Show/hide backdrop di mobile
        if (window.innerWidth <= 576) {
            if (sidebar.classList.contains('open')) {
                backdrop.style.display = 'block';
            } else {
                backdrop.style.display = 'none';
            }
        }
    });
    
    // Close sidebar saat backdrop di-klik
    backdrop.addEventListener('click', function() {
        hamburgerBtn.classList.remove('active');
        sidebar.classList.remove('open');
        backdrop.style.display = 'none';
    });
    
    // Close sidebar saat menu item di-click di mobile
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 576) {
                hamburgerBtn.classList.remove('active');
                sidebar.classList.remove('open');
                backdrop.style.display = 'none';
            }
        });
    });
    
    // ==================== SIDEBAR ACTIVE MENU DETECTION ====================
    function activateCurrentMenu() {
        const currentPath = window.location.pathname;
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href) {
                // Check if current path includes the menu link
                if (currentPath.includes(href.split('/').filter(Boolean).pop())) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            }
        });
        
        // Special handling for dashboard (home)
        if (currentPath.includes('dashboard') || currentPath.includes('home')) {
            const homeMenu = document.querySelector('.menu-item[href*="dashboard"]') || 
                           document.querySelector('.menu-item[href*="home"]');
            if (homeMenu) {
                homeMenu.classList.add('active');
            }
        }
    }
    
    // Add smooth transition for menu items
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // Remove active class from all items
            document.querySelectorAll('.menu-item').forEach(el => el.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
        });
    });
</script>
</body>
</html>
