<head>
    <!-- ...existing head content... -->

</head>
<body>
    <!-- Navbar/Header Modern (match dashboard) -->
    <div class="navbar-wrapper">
        <a href="<?= base_url('dashboard') ?>" class="navbar-logo" title="Dashboard">W</a>
        
        <nav class="navbar-menu">
            <a href="<?= base_url('dashboard') ?>" class="nav-item">
                <i class="fas fa-home"></i>
                <span class="d-none d-lg-inline">Home</span>
            </a>
            <a href="<?= base_url('wisata') ?>" class="nav-item active">
                <i class="fas fa-map-marked-alt"></i>
                <span class="d-none d-lg-inline">Wisata</span>
            </a>
            <a href="<?= base_url('rekomendasi') ?>" class="nav-item">
                <i class="fas fa-magic"></i>
                <span class="d-none d-lg-inline">Rekomendasi</span>
            </a>
            <a href="<?= base_url('favorit') ?>" class="nav-item">
                <i class="fas fa-heart"></i>
                <span class="d-none d-lg-inline">Favorit</span>
            </a>
            <a href="<?= base_url('profil') ?>" class="nav-item">
                <i class="fas fa-user"></i>
                <span class="d-none d-lg-inline">Profil</span>
            </a>
            <a href="<?= base_url('auth/logout') ?>" class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span class="d-none d-lg-inline">Logout</span>
            </a>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="browse-container">
            <!-- Filter Sidebar -->
            <aside class="filter-sidebar">
                <form method="get" action="<?= base_url('wisata') ?>" id="filterForm">
                    <!-- Kategori Filter -->
                    <div class="filter-card">
                        <h6><i class="fas fa-layer-group me-2"></i>Kategori</h6>
                        <div class="filter-option">
                            <input type="radio" name="kategori" value="" id="cat-all" 
                                   <?= !$this->input->get('kategori') ? 'checked' : '' ?> 
                                   onchange="this.form.submit()">
                            <label for="cat-all">Semua Kategori</label>
                        </div>
                        <?php 
                        $kategori_list = ['alam', 'budaya', 'sejarah', 'kuliner', 'belanja', 'edukasi', 'hiburan'];
                        foreach ($kategori_list as $kat): ?>
                            <div class="filter-option">
                                <input type="radio" name="kategori" value="<?= $kat ?>" id="cat-<?= $kat ?>" 
                                       <?= $this->input->get('kategori') == $kat ? 'checked' : '' ?>
                                       onchange="this.form.submit()">
                                <label for="cat-<?= $kat ?>"><?= ucfirst($kat) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Harga Filter -->
                    <div class="filter-card">
                        <h6><i class="fas fa-tags me-2"></i>Rentang Harga</h6>
                        <div class="filter-option">
                            <input type="radio" name="harga" value="" id="price-all" 
                                   <?= !$this->input->get('harga') ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="price-all">Semua Harga</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" name="harga" value="50000" id="price-50k" 
                                   <?= $this->input->get('harga') == '50000' ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="price-50k">< Rp 50.000</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" name="harga" value="100000" id="price-100k" 
                                   <?= $this->input->get('harga') == '100000' ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="price-100k">< Rp 100.000</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" name="harga" value="200000" id="price-200k" 
                                   <?= $this->input->get('harga') == '200000' ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="price-200k">< Rp 200.000</label>
                        </div>
                    </div>
                    
                    <!-- Rating Filter -->
                    <div class="filter-card">
                        <h6><i class="fas fa-star me-2"></i>Rating</h6>
                        <div class="filter-option">
                            <input type="radio" name="rating" value="" id="rating-all" 
                                   <?= !$this->input->get('rating') ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="rating-all">Semua Rating</label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" name="rating" value="4" id="rating-4" 
                                   <?= $this->input->get('rating') == '4' ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="rating-4">
                                <i class="fas fa-star text-warning"></i> 4+ Ke atas
                            </label>
                        </div>
                        <div class="filter-option">
                            <input type="radio" name="rating" value="3" id="rating-3" 
                                   <?= $this->input->get('rating') == '3' ? 'checked' : '' ?>
                                   onchange="this.form.submit()">
                            <label for="rating-3">
                                <i class="fas fa-star text-warning"></i> 3+ Ke atas
                            </label>
                        </div>
                    </div>
                    
                    <!-- Search Box -->
                    <div class="filter-card">
                        <h6><i class="fas fa-search me-2"></i>Cari Wisata</h6>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Nama destinasi..." 
                               value="<?= $this->input->get('search') ?>"
                               style="border-radius: 12px; border: 2px solid #e0e0e0;">
                        <button type="submit" class="btn btn-success w-100 mt-2 rounded-pill">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                    
                    <?php if ($this->input->get()): ?>
                        <a href="<?= base_url('wisata') ?>" class="btn btn-outline-secondary w-100 rounded-pill">
                            <i class="fas fa-redo me-2"></i>Reset Filter
                        </a>
                    <?php endif; ?>
                </form>
            </aside>
            
            <!-- Wisata Grid -->
            <main class="wisata-grid">
                <!-- Header dengan Sort -->
                <div class="wisata-header">
                    <div>
                        <h3 class="mb-1 fw-bold" style="color: #2d5016;">Jelajahi Wisata</h3>
                        <p class="text-muted mb-0">
                            <?= isset($total_results) ? $total_results : count($wisata_list) ?> destinasi ditemukan
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <label class="mb-0 text-muted small">Urutkan:</label>
                        <select name="sort" class="form-select" style="width: auto; border-radius: 12px;" 
                                onchange="window.location.href='<?= base_url('wisata?') ?>' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value}).toString()">
                            <option value="rating" <?= $this->input->get('sort') == 'rating' || !$this->input->get('sort') ? 'selected' : '' ?>>Rating Tertinggi</option>
                            <option value="newest" <?= $this->input->get('sort') == 'newest' ? 'selected' : '' ?>>Terbaru</option>
                            <option value="price_asc" <?= $this->input->get('sort') == 'price_asc' ? 'selected' : '' ?>>Harga Terendah</option>
                            <option value="price_desc" <?= $this->input->get('sort') == 'price_desc' ? 'selected' : '' ?>>Harga Tertinggi</option>
                        </select>
                    </div>
                </div>
                
                <!-- Wisata Cards Grid -->
                <div class="row g-4">
                    <?php if (!empty($wisata_list)): ?>
                        <?php foreach ($wisata_list as $wisata): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="wisata-card">
                                    <div class="card-img-wrapper">
                                        <img src="<?= get_wisata_image($wisata['foto']) ?>" alt="<?= $wisata['nama'] ?>">
                                        
                                        <!-- Category Badge -->
                                        <span class="category-badge">
                                            <i class="fas fa-tag me-1"></i><?= ucfirst($wisata['kategori']) ?>
                                        </span>
                                        
                                        <!-- Favorite Button -->
                                        <?php if ($this->session->userdata('user_id')): ?>
                                            <button class="favorite-btn <?= is_favorited($wisata['id']) ? 'favorited' : '' ?>" 
                                                    data-wisata-id="<?= $wisata['id'] ?>">
                                                <i class="<?= is_favorited($wisata['id']) ? 'fas' : 'far' ?> fa-heart"></i>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <!-- Price Tag -->
                                        <div class="price-tag">
                                            <div class="amount"><?= format_rupiah($wisata['harga_tiket']) ?></div>
                                            <small class="text-muted d-block" style="font-size: 10px;">per orang</small>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <h5 class="wisata-title"><?= $wisata['nama'] ?></h5>
                                        
                                        <p class="text-muted mb-3 small">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <?= truncate_text($wisata['alamat'], 50) ?>
                                        </p>
                                        
                                        <div class="rating-row">
                                            <div class="stars">
                                                <?= get_star_rating($wisata['rating_avg']) ?>
                                            </div>
                                            <span class="fw-bold" style="color: #2d5016;"><?= number_format($wisata['rating_avg'], 1) ?></span>
                                            <span class="text-muted small">(<?= $wisata['jumlah_rating'] ?>)</span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <span class="stat-item">
                                                <i class="fas fa-comments"></i>
                                                <?= $wisata['jumlah_review'] ?> reviews
                                            </span>
                                            <span class="stat-item">
                                                <i class="fas fa-heart"></i>
                                                <?= $wisata['jumlah_favorit'] ?> favorit
                                            </span>
                                        </div>
                                        
                                        <a href="<?= base_url('wisata/detail/' . $wisata['id']) ?>" class="btn-detail">
                                            <i class="fas fa-info-circle me-2"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Tidak ada wisata ditemukan</h4>
                                <p class="text-muted">Coba ubah filter pencarian Anda</p>
                                <a href="<?= base_url('wisata') ?>" class="btn btn-success rounded-pill px-4 mt-3">
                                    <i class="fas fa-redo me-2"></i>Reset Filter
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination -->
                <?php if (isset($pagination) && $pagination): ?>
                    <div class="d-flex justify-content-center mt-5">
                        <nav>
                            <?= $pagination ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <style>
                /* Pagination override khusus halaman wisata */
                .pagination .page-item.active .page-link,
                .pagination .page-link:focus,
                .pagination .page-link:active {
                    background-color: #4a6b3d !important;
                    border-color: #4a6b3d !important;
                    color: #fff !important;
                    box-shadow: 0 2px 8px rgba(74,107,61,0.10);
                }
        body { background: #E8E4DC; }
        .navbar-wrapper { width: 100%; background: white; padding: 15px 40px; display: flex; flex-direction: row; align-items: center; justify-content: flex-start; box-shadow: 0 2px 15px rgba(0,0,0,0.08); position: sticky; top: 0; height: auto; z-index: 1000; }
        .navbar-logo { width: 50px; height: 50px; background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: 700; margin-right: auto; text-decoration: none; }
        .navbar-menu { display: flex; flex-direction: row; align-items: center; gap: 10px; }
        .nav-item { padding: 12px 20px; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 8px; color: #666; transition: all 0.3s; cursor: pointer; text-decoration: none; font-weight: 500; font-size: 14px; }
        .nav-item:hover, .nav-item.active { background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); color: white; }
        .btn-back { background: #2d5016; color: white; border: none; padding: 8px 20px; border-radius: 50px; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; margin-right: 15px; }
        .btn-back:hover { background: #4a6b3d; color: white; transform: translateX(-3px); box-shadow: 0 5px 15px rgba(45,80,22,0.3); }
        .browse-container { display: flex; gap: 30px; padding: 30px 0; }
        .filter-sidebar { width: 280px; flex-shrink: 0; }
        .filter-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .filter-card h6 { font-weight: 700; color: #2d5016; margin-bottom: 20px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        .filter-option { display: flex; align-items: center; padding: 12px 16px; border-radius: 12px; margin-bottom: 8px; cursor: pointer; transition: all 0.3s; background: #f8f9fa; }
        .filter-option:hover { background: #e8f5e9; transform: translateX(5px); }
        .filter-option input[type="radio"], .filter-option input[type="checkbox"] { margin-right: 12px; accent-color: #4a6b3d; }
        .filter-option label { flex: 1; margin: 0; cursor: pointer; font-weight: 500; color: #2d5016; }
        .filter-option .count { background: #4a6b3d; color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; }
        .wisata-grid { flex: 1; }
        .wisata-header { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .wisata-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s; height: 100%; }
        .wisata-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .wisata-card .card-img-wrapper { position: relative; height: 220px; overflow: hidden; }
        .wisata-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .wisata-card:hover img { transform: scale(1.1); }
        .category-badge { position: absolute; top: 15px; left: 15px; background: rgba(74, 107, 61, 0.95); color: white; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .favorite-btn { position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.95); border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .favorite-btn:hover { transform: scale(1.1); }
        .favorite-btn.favorited i { color: #dc3545; }
        .price-tag { position: absolute; bottom: 15px; right: 15px; background: white; padding: 8px 16px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .price-tag .amount { color: #4a6b3d; font-weight: 700; font-size: 16px; }
        .wisata-card .card-body { padding: 20px; }
        .wisata-card .wisata-title { font-weight: 700; color: #2d5016; margin-bottom: 10px; font-size: 18px; }
        .rating-row { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
        .rating-row .stars { color: #ffc107; }
        .stat-item { display: inline-flex; align-items: center; gap: 6px; margin-right: 15px; color: #6c757d; font-size: 13px; }
        .btn-detail { width: 100%; background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%); color: white; border: none; padding: 12px; border-radius: 12px; font-weight: 600; transition: all 0.3s; }
        .btn-detail:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(74, 107, 61, 0.3); color: white; }
    </style>
</body>
