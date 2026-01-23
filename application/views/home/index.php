<style>
        body {
            overflow-x: hidden;
        }
        
        .form-select:focus, .form-control:focus {
            box-shadow: none;
            border-color: transparent;
            outline: none;
        }
        
        @media (max-width: 992px) {
            .hero-image {
                display: none !important;
            }
        }
        
        @media (max-width: 992px) {
            .hero-section .row {
                flex-direction: column;
            }
            
            .hero-section .col-lg-6 {
                margin-top: 30px;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .stat-card {
                padding: 30px 20px !important;
            }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 48px !important;
                line-height: 1.1 !important;
            }
            
            .search-card {
                margin-left: 15px;
                margin-right: 15px;
                padding: 15px 20px !important;
            }
            
            .search-card form {
                flex-direction: column !important;
            }
            
            .search-card form > div {
                min-width: 100% !important;
            }
            
            .container-fluid {
                padding: 15px 20px !important;
            }
            
            .stat-card {
                padding: 25px 15px !important;
            }
            
            .stat-card h3 {
                font-size: 36px !important;
            }
            
            .stat-card p {
                font-size: 13px !important;
            }
        }
        
        @media (max-width: 576px) {
            h1 {
                font-size: 36px !important;
            }
            
            .landing-hero section {
                padding-top: 40px !important;
                padding-bottom: 40px !important;
            }
            
            .stat-card {
                padding: 20px 15px !important;
            }
            
            .stat-card h3 {
                font-size: 32px !important;
            }
            
            .stat-card div {
                font-size: 28px !important;
            }
        }
    </style>
    
    <!-- Hero Section -->
    <section class="landing-hero" style="background: #E8E4DC; position: relative; min-height: 100vh; padding: 0;">
        <!-- Navigation Bar -->
        <div class="container-fluid" style="padding: 20px 50px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo" style="font-size: 24px; font-weight: 700; color: #1a1a1a;">
                    JogjaTrip
                </div>
                <nav class="d-none d-lg-flex gap-4" style="color: #1a1a1a;">
                    <a href="<?= base_url('wisata') ?>" style="color: #1a1a1a; text-decoration: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#1a1a1a'">Destination</a>
                    <a href="#" style="color: #1a1a1a; text-decoration: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#1a1a1a'">Bookings</a>
                    <a href="#" style="color: #1a1a1a; text-decoration: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#1a1a1a'">Activities</a>
                </nav>
                <div class="d-flex gap-3 align-items-center">
                    <a href="<?= base_url('auth/login') ?>" style="color: #1a1a1a; text-decoration: none; font-weight: 500; transition: all 0.3s;" onmouseover="this.style.color='#666'" onmouseout="this.style.color='#1a1a1a'">Log in</a>
                    <a href="<?= base_url('auth/register') ?>" class="btn btn-dark rounded-pill px-4 py-2" style="font-weight: 500; background: #1a1a1a; border: none;">Sign up</a>
                    <button class="btn btn-link p-0" style="color: #1a1a1a;"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        
        <!-- Hero Content -->
        <div class="container" style="padding-top: 60px; padding-bottom: 60px; position: relative;">
            <div class="row align-items-start" style="min-height: auto;">
                <!-- Left Column - Content -->
                <div class="col-lg-6 pe-lg-4">
                    <!-- Header -->
                    <div class="mb-3" style="color: #999; font-size: 14px; letter-spacing: 1.5px; font-weight: 500;">
                        ✨ JELAJAHI DESTINASI TERBAIK
                    </div>
                    <h1 style="font-size: 64px; font-weight: 800; line-height: 1.15; margin-bottom: 25px; color: #1a1a1a; letter-spacing: -1px;">
                        Temukan<br>Pengalaman Wisata<br>Sempurna
                    </h1>
                    <p style="font-size: 16px; color: #666; margin-bottom: 50px; line-height: 1.7; font-weight: 400;">
                        Jelajahi lebih dari 15 destinasi wisata pilihan di Yogyakarta dengan rekomendasi personal dari komunitas traveler kami
                    </p>
                    
                    <!-- Search Box Card - Horizontal -->
                    <div id="search-box" class="search-card bg-white rounded-4" style="padding: 20px 30px; margin-bottom: 0; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);">
                        <form action="<?= base_url('wisata') ?>" method="GET" class="d-flex gap-0 align-items-end" style="flex-wrap: wrap; gap: 15px;">
            
                            <!-- Location -->
                            <div style="flex: 1; min-width: 150px; text-align: left;">
                                <label class="form-label fw-bold small d-none" style="color: #666; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Lokasi</label>
                                <input type="text" name="location" class="form-control border-0 bg-transparent" placeholder="Lokasi..." style="font-size: 15px; color: #1a1a1a; font-weight: 500; padding: 10px 0; border-bottom: 2px solid #E8E4DC !important;" value="Yogyakarta">
                            </div>
                            
                            <!-- Activity -->
                            <div style="flex: 1; min-width: 150px; text-align: left;">
                                <label class="form-label fw-bold small d-none" style="color: #666; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Kategori</label>
                                <select name="kategori" class="form-select border-0 bg-transparent" style="font-size: 15px; color: #1a1a1a; font-weight: 500; padding: 10px 0; border-bottom: 2px solid #E8E4DC !important;">
                                    <option value="">Kategori</option>
                                    <option value="budaya">Wisata Budaya</option>
                                    <option value="alam">Wisata Alam</option>
                                    <option value="kuliner">Kuliner</option>
                                    <option value="sejarah">Sejarah</option>
                                </select>
                            </div>
                            
                            <!-- Date -->
                            <div style="flex: 1; min-width: 150px; text-align: left;">
                                <label class="form-label fw-bold small d-none" style="color: #666; font-size: 12px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control border-0 bg-transparent" placeholder="Tanggal kunjung" style="font-size: 15px; color: #1a1a1a; font-weight: 500; padding: 10px 0; border-bottom: 2px solid #E8E4DC !important;">
                            </div>
                            
                            <!-- Search Button -->
                            <button type="submit" class="btn rounded-pill d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #1a1a1a; border: none; color: white; transition: all 0.3s; flex-shrink: 0;" onmouseover="this.style.background='#333'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#1a1a1a'; this.style.transform='scale(1)'">
                                <i class="fas fa-arrow-right" style="font-size: 18px;"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column - Statistics -->
                <div class="col-lg-6 ps-lg-5" style="display: flex; align-items: center; margin-top: 40px; margin-top: 0px;">
                    <!-- Statistics Grid 2x2 -->
                    <div class="row g-4 w-100">
                        <!-- Statistic Card 1 -->
                        <div class="col-sm-6">
                            <div class="stat-card" style="background: linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%); padding: 35px 30px; border-radius: 24px; text-align: center; transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06); cursor: pointer; border: 1px solid rgba(232, 228, 220, 0.5);" 
                                onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 48px rgba(0, 0, 0, 0.12)'; this.style.background='linear-gradient(135deg, #F0ECE4 0%, #F5F3F0 100%)'" 
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(0, 0, 0, 0.06)'; this.style.background='linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%)'">
                                <h3 style="font-size: 42px; font-weight: 800; color: #1a1a1a; margin-bottom: 8px;">
                                    15<span style="color: #999; font-size: 26px; font-weight: 600;">+</span>
                                </h3>
                                <p style="color: #666; font-size: 15px; margin: 0; font-weight: 600;">Destinasi Wisata</p>
                            </div>
                        </div>

                        <!-- Statistic Card 2 -->
                        <div class="col-sm-6">
                            <div class="stat-card" style="background: linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%); padding: 35px 30px; border-radius: 24px; text-align: center; transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06); cursor: pointer; border: 1px solid rgba(232, 228, 220, 0.5);" 
                                onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 48px rgba(0, 0, 0, 0.12)'; this.style.background='linear-gradient(135deg, #F0ECE4 0%, #F5F3F0 100%)'" 
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(0, 0, 0, 0.06)'; this.style.background='linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%)'">
                                <h3 style="font-size: 42px; font-weight: 800; color: #1a1a1a; margin-bottom: 8px;">
                                    3<span style="color: #999; font-size: 26px; font-weight: 600;">+</span>
                                </h3>
                                <p style="color: #666; font-size: 15px; margin: 0; font-weight: 600;">Travelers Aktif</p>
                            </div>
                        </div>

                        <!-- Statistic Card 3 -->
                        <div class="col-sm-6">
                            <div class="stat-card" style="background: linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%); padding: 35px 30px; border-radius: 24px; text-align: center; transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06); cursor: pointer; border: 1px solid rgba(232, 228, 220, 0.5);" 
                                onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 48px rgba(0, 0, 0, 0.12)'; this.style.background='linear-gradient(135deg, #F0ECE4 0%, #F5F3F0 100%)'" 
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(0, 0, 0, 0.06)'; this.style.background='linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%)'">
                                <h3 style="font-size: 42px; font-weight: 800; color: #1a1a1a; margin-bottom: 8px;">
                                    1<span style="color: #999; font-size: 26px; font-weight: 600;">+</span>
                                </h3>
                                <p style="color: #666; font-size: 15px; margin: 0; font-weight: 600;">Rating Rata-rata</p>
                            </div>
                        </div>

                        <!-- Statistic Card 4 -->
                        <div class="col-sm-6">
                            <div class="stat-card" style="background: linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%); padding: 35px 30px; border-radius: 24px; text-align: center; transition: all 0.4s cubic-bezier(0.23, 1, 0.320, 1); box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06); cursor: pointer; border: 1px solid rgba(232, 228, 220, 0.5);" 
                                onmouseover="this.style.transform='translateY(-12px)'; this.style.boxShadow='0 20px 48px rgba(0, 0, 0, 0.12)'; this.style.background='linear-gradient(135deg, #F0ECE4 0%, #F5F3F0 100%)'" 
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(0, 0, 0, 0.06)'; this.style.background='linear-gradient(135deg, #F5F3F0 0%, #FAFAF8 100%)'">
                                <h3 style="font-size: 42px; font-weight: 800; color: #1a1a1a; margin-bottom: 8px;">
                                    0<span style="color: #999; font-size: 26px; font-weight: 600;">+</span>
                                </h3>
                                <p style="color: #666; font-size: 15px; margin: 0; font-weight: 600;">Review Komunitas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trending Section -->
    <section class="trending-section" style="background: linear-gradient(135deg, #FAFAF8 0%, #F5F3F0 100%); padding: 100px 0; position: relative;">
        <!-- Decorative element -->
        <div style="position: absolute; top: 0; right: 0; width: 400px; height: 400px; background: rgba(232, 228, 220, 0.3); border-radius: 50%; transform: translate(100px, -100px); z-index: 0;"></div>
        
        <div class="container" style="position: relative; z-index: 1;">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <p style="color: #999; font-size: 14px; text-transform: uppercase; letter-spacing: 1.5px; margin: 0 0 15px 0; font-weight: 600;">🔥 POPULER SEKARANG</p>
                    <h2 style="font-size: 48px; font-weight: 800; color: #1a1a1a; margin: 0;">Destinasi Trending</h2>
                    <p style="color: #999; margin-top: 12px; font-size: 16px;">Lihat destinasi wisata terpopuler yang dipilih oleh komunitas traveler kami</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border: 2px solid #E8E4DC; background: white; color: #1a1a1a; transition: all 0.3s;" onclick="scrollTrending('left')" onmouseover="this.style.background='#1a1a1a'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='#1a1a1a'">
                        <i class="fas fa-chevron-left" style="font-size: 18px;"></i>
                    </button>
                    <button class="btn rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #1a1a1a; color: white; border: none; transition: all 0.3s;" onclick="scrollTrending('right')" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-chevron-right" style="font-size: 18px;"></i>
                    </button>
                </div>
            </div>
            
            <!-- Cards Container -->
            <div class="trending-scroll" id="trendingScroll" style="display: flex; gap: 24px; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 30px;">
                <?php 
                $trending_images = [
                    ['title' => 'Candi Borobudur', 'location' => 'Magelang', 'rating' => '4.9', 'img' => 'https://images.unsplash.com/photo-1537177927566-aa8e14786b4f?w=500&h=350&fit=crop', 'id' => 1],
                    ['title' => 'Candi Prambanan', 'location' => 'Sleman', 'rating' => '4.8', 'img' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=500&h=350&fit=crop', 'id' => 2],
                    ['title' => 'Pantai Parangtritis', 'location' => 'Bantul', 'rating' => '4.6', 'img' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=500&h=350&fit=crop', 'id' => 5],
                    ['title' => 'Keraton Yogyakarta', 'location' => 'Yogyakarta', 'rating' => '4.7', 'img' => 'https://images.unsplash.com/photo-1586861203919-c97b961d0e6b?w=500&h=350&fit=crop', 'id' => 4],
                    ['title' => 'Malioboro Street', 'location' => 'Yogyakarta', 'rating' => '4.7', 'img' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=500&h=350&fit=crop', 'id' => 3],
                    ['title' => 'Hutan Pinus Mangunan', 'location' => 'Bantul', 'rating' => '4.5', 'img' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=500&h=350&fit=crop', 'id' => 8],
                    ['title' => 'Goa Pindul', 'location' => 'Gunungkidul', 'rating' => '4.6', 'img' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=350&fit=crop', 'id' => 7],
                    ['title' => 'Tebing Breksi', 'location' => 'Sleman', 'rating' => '4.5', 'img' => 'https://images.unsplash.com/photo-1501706362039-c06b2d715385?w=500&h=350&fit=crop', 'id' => 11]
                ];
                foreach($trending_images as $item): 
                ?>
                <div class="trending-card" style="flex: 0 0 320px; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 50px rgba(0, 0, 0, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 30px rgba(0, 0, 0, 0.08)'">
                    <!-- Image Container -->
                    <div style="position: relative; overflow: hidden; height: 240px;">
                        <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                        
                        <!-- Rating Badge -->
                        <div style="position: absolute; top: 16px; right: 16px; background: white; backdrop-filter: blur(10px); padding: 8px 14px; border-radius: 30px; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                            <i class="fas fa-star" style="color: #FFB81C; font-size: 14px;"></i> 
                            <span style="color: #1a1a1a;"><?= $item['rating'] ?></span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div style="padding: 24px;">
                        <h5 style="font-size: 20px; font-weight: 800; color: #1a1a1a; margin-bottom: 10px; line-height: 1.3;"><?= $item['title'] ?></h5>
                        <p style="color: #999; font-size: 14px; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-map-pin" style="font-size: 13px; color: #1a1a1a;"></i>
                            <span><?= $item['location'] ?></span>
                        </p>
                        
                        <!-- CTA Button -->
                        <a href="<?= base_url('wisata/detail/' . $item['id']) ?>" style="display: block; width: 100%; margin-top: 16px; padding: 12px 16px; background: #F5F3F0; color: #1a1a1a; border: none; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all 0.3s; cursor: pointer; text-align: center; text-decoration: none;" onmouseover="this.style.background='#1a1a1a'; this.style.color='white'" onmouseout="this.style.background='#F5F3F0'; this.style.color='#1a1a1a'">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <style>
        .trending-scroll::-webkit-scrollbar {
            height: 8px;
        }
        .trending-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .trending-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .trending-scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .form-select:focus, .form-control:focus {
            box-shadow: none;
            border-color: transparent;
            outline: none;
        }
        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 42px !important;
            }
            .search-card {
                margin-left: 15px;
                margin-right: 15px;
            }
        }
    </style>
    
    <script>
        function scrollTrending(direction) {
            const container = document.getElementById('trendingScroll');
            const scrollAmount = 320;
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    </script>
    
    <!-- Features Section -->
    <section class="feature-section" style="padding: 100px 0; background: white;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="font-size: 48px; font-weight: 800; color: #2d3748; margin-bottom: 20px;">
                    Kenapa Memilih Kami?
                </h2>
                <p style="font-size: 18px; color: #718096; max-width: 600px; margin: 0 auto;">
                    Teknologi AI dan pengalaman pengguna yang luar biasa untuk perjalanan Anda
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-radius: 25px; padding: 40px 30px; text-align: center; transition: all 0.3s; border: 2px solid transparent;">
                        <div class="feature-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; margin: 0 auto 25px;">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 700; color: #2d3748; margin-bottom: 15px;">
                            Rekomendasi AI
                        </h3>
                        <p style="color: #718096; line-height: 1.8;">
                            Algoritma Hybrid Collaborative + Item-Based Filtering untuk rekomendasi personal
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-radius: 25px; padding: 40px 30px; text-align: center; transition: all 0.3s; border: 2px solid transparent;">
                        <div class="feature-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; margin: 0 auto 25px;">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 700; color: #2d3748; margin-bottom: 15px;">
                            Rating & Review
                        </h3>
                        <p style="color: #718096; line-height: 1.8;">
                            Baca pengalaman traveler lain dan bagikan pengalaman Anda sendiri
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card" style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-radius: 25px; padding: 40px 30px; text-align: center; transition: all 0.3s; border: 2px solid transparent;">
                        <div class="feature-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; margin: 0 auto 25px;">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: 700; color: #2d3748; margin-bottom: 15px;">
                            Wishlist & Favorit
                        </h3>
                        <p style="color: #718096; line-height: 1.8;">
                            Simpan destinasi favorit Anda dan rencanakan perjalanan dengan mudah
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <h2 style="font-size: 48px; font-weight: 800; color: #2d3748; margin-bottom: 20px;">
                    Siap Memulai Petualangan?
                </h2>
                <p style="font-size: 20px; color: #718096; margin-bottom: 40px; max-width: 700px; margin-left: auto; margin-right: auto;">
                    Daftar sekarang dan dapatkan rekomendasi wisata personal dari AI kami. 
                    Gratis untuk selamanya!
                </p>
                <div style="display: flex; gap: 20px; justify-content: center;">
                    <a href="<?= base_url('register') ?>" class="btn-primary-gradient" style="font-size: 18px;">
                        <i class="fas fa-user-plus"></i>
                        Daftar Gratis
                    </a>
                    <a href="<?= base_url('login') ?>" class="btn-outline-custom" style="font-size: 18px;">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                </div>
            </div>
        </div>
        
    </section>            
            
    

