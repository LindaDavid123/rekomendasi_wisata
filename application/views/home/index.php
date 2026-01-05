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
        
        @media (max-width: 768px) {
            h1 {
                font-size: 42px !important;
            }
            .search-card {
                margin-left: 15px;
                margin-right: 15px;
            }
            .container-fluid {
                padding: 15px 20px !important;
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
        <div class="container" style="padding-top: 80px; padding-bottom: 60px; position: relative;">
            <div class="row align-items-center" style="min-height: calc(100vh - 100px);">
                <div class="col-lg-6">
                    <div class="mb-3" style="color: #666; font-size: 14px; letter-spacing: 1px;">
                        — Wisata Budaya Yogyakarta
                    </div>
                    <h1 style="font-size: 72px; font-weight: 700; line-height: 1.1; margin-bottom: 30px; color: #1a1a1a;">
                        Candi<br>Prambanan
                    </h1>
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-thermometer-half" style="color: #1a1a1a;"></i>
                            <span style="color: #1a1a1a; font-weight: 500;">~32°C</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="color: #1a1a1a; font-weight: 500;">Sleman, DIY</span>
                        </div>
                    </div>
            
            <!-- Search Box Card -->
                    <div id="search-box" class="search-card bg-white rounded-4 shadow-lg p-4" style="max-width: 650px; margin-top: 40px;">
                        <form action="<?= base_url('wisata') ?>" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
                
                            <!-- Location -->
                            <div class="flex-fill" style="min-width: 180px;">
                                <label class="form-label fw-bold small" style="color: #1a1a1a; font-size: 13px; margin-bottom: 8px;">Location</label>
                                <input type="text" name="location" class="form-control border-0 bg-transparent p-0" placeholder="Enter Your Destination..." style="font-size: 15px; color: #1a1a1a; font-weight: 500;" value="Yogyakarta">
                            </div>
                            
                            <div class="vr" style="width: 1px; background: #ddd; height: 40px; margin: 0 15px;"></div>
                            
                            <!-- Activity -->
                            <div class="flex-fill" style="min-width: 150px;">
                                <label class="form-label fw-bold small" style="color: #1a1a1a; font-size: 13px; margin-bottom: 8px;">Activity</label>
                                <select name="kategori" class="form-select border-0 bg-transparent p-0" style="font-size: 15px; color: #1a1a1a; font-weight: 500;">
                                    <option value="">Bungee Jump</option>
                                    <option value="budaya">Wisata Budaya</option>
                                    <option value="alam">Wisata Alam</option>
                                    <option value="kuliner">Kuliner</option>
                                    <option value="sejarah">Sejarah</option>
                                </select>
                            </div>
                            
                            <div class="vr" style="width: 1px; background: #ddd; height: 40px; margin: 0 15px;"></div>
                            
                            <!-- Date -->
                            <div class="flex-fill" style="min-width: 140px;">
                                <label class="form-label fw-bold small" style="color: #1a1a1a; font-size: 13px; margin-bottom: 8px;">Date</label>
                                <input type="date" name="tanggal" class="form-control border-0 bg-transparent p-0" placeholder="Set date" style="font-size: 15px; color: #1a1a1a; font-weight: 500;">
                            </div>
                            
                            <!-- Search Button -->
                            <button type="submit" class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #1a1a1a; border: none; flex-shrink: 0; margin-left: 10px;">
                                <i class="fas fa-search" style="font-size: 16px;"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Hero Image -->
                <div class="col-lg-6 position-relative d-none d-lg-block">
                    <div class="hero-image" style="position: relative; height: 600px; margin-top: -50px;">
                        <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?w=900&h=700&fit=crop" alt="Prambanan Temple" style="width: 100%; height: 100%; object-fit: cover; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Trending Section -->
    <section class="trending-section" style="background: white; padding: 80px 0;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin: 0;">Trending 2026</h2>
                    <p style="color: #666; margin-top: 8px;">Spot Brilliant reasons Entrata should be your one-stop-shop!</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark rounded-circle" style="width: 40px; height: 40px; padding: 0; border: 2px solid #1a1a1a;" onclick="scrollTrending('left')">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-dark rounded-circle" style="width: 40px; height: 40px; padding: 0; background: #1a1a1a; border: none;" onclick="scrollTrending('right')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            <div class="trending-scroll" id="trendingScroll" style="display: flex; gap: 20px; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 20px;">
                <?php 
                $trending_images = [
                    ['title' => 'Candi Prambanan', 'location' => 'Sleman', 'rating' => '4.8', 'img' => 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=400&h=300&fit=crop'],
                    ['title' => 'Pantai Parangtritis', 'location' => 'Bantul', 'rating' => '4.6', 'img' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop'],
                    ['title' => 'Malioboro Street', 'location' => 'Kota Yogyakarta', 'rating' => '4.7', 'img' => 'https://images.unsplash.com/photo-1601399363869-4da2c3a54f0e?w=400&h=300&fit=crop'],
                    ['title' => 'Tebing Breksi', 'location' => 'Sleman', 'rating' => '4.5', 'img' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop']
                ];
                foreach($trending_images as $item): 
                ?>
                <div class="trending-card" style="flex: 0 0 300px; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="position: relative;">
                        <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>" style="width: 100%; height: 200px; object-fit: cover;">
                        <div style="position: absolute; top: 15px; right: 15px; background: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 13px;">
                            <i class="fas fa-star" style="color: #ffc107; font-size: 12px;"></i> <?= $item['rating'] ?>
                        </div>
                    </div>
                    <div style="padding: 20px;">
                        <h5 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;"><?= $item['title'] ?></h5>
                        <p style="color: #666; font-size: 14px; margin: 0;">
                            <i class="fas fa-map-marker-alt" style="font-size: 12px;"></i> <?= $item['location'] ?>
                        </p>
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
    
    <!-- Stats Section -->
    <?php if (isset($statistics)): ?>
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><?= $statistics['total_wisata'] ?>+</div>
                        <div class="stat-label">Destinasi Wisata</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><?= $statistics['total_users'] ?>+</div>
                        <div class="stat-label">Happy Travelers</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><?= $statistics['total_ratings'] ?>+</div>
                        <div class="stat-label">Rating Diberikan</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number"><?= $statistics['total_reviews'] ?>+</div>
                        <div class="stat-label">Review Dituliskan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
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
            
    

