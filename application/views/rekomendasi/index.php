<style>
    .btn-back-rekomendasi {
        background: #2d5016;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(45,80,22,0.3);
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        margin-bottom: 20px;
    }
    .btn-back-rekomendasi:hover {
        background: #4a6b3d;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 8px 20px rgba(45,80,22,0.4);
    }
</style>

<div class="container py-5">
    <!-- Tombol Kembali -->
    <a href="javascript:history.back()" class="btn-back-rekomendasi">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
    
    <h2 class="mb-4"><i class="fas fa-star text-warning"></i> Rekomendasi Wisata Untuk Anda</h2>
    
    <?php if (isset($is_new_user) && $is_new_user): ?>
        <div class="alert alert-info mb-4">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading">Wisata Populer di Yogyakarta</h5>
                    <p class="mb-2">Berikut adalah destinasi wisata populer berdasarkan rating pengunjung lain.</p>
                    <p class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tips:</strong> Berikan rating pada destinasi untuk mendapatkan rekomendasi yang dipersonalisasi menggunakan <strong>Cosine Similarity</strong> berdasarkan preferensi Anda!
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-success mb-4">
            <div class="d-flex align-items-start">
                <i class="fas fa-check-circle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading">Rekomendasi Personal</h5>
                    <p class="mb-2">Berdasarkan <strong><?= $user_rating_count ?> rating</strong> yang Anda berikan, berikut rekomendasi menggunakan <strong>Cosine Similarity</strong>.</p>
                    <p class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Semakin banyak rating yang Anda berikan, semakin akurat rekomendasi yang kami sajikan!
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <p class="lead mb-4">
        Sistem menggunakan <strong>Hybrid Collaborative + Item-Based Filtering dengan Cosine Similarity</strong> untuk rekomendasi yang dipersonalisasi.
    </p>
    
    <!-- Hybrid Recommendations -->
    <div class="mb-5">
        <h4 class="mb-3">Rekomendasi Hybrid</h4>
        <div class="row">
            <?php if (!empty($recommendations)): ?>
                <?php foreach ($recommendations as $wisata): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm position-relative">
                            <button class="btn-favorite <?= is_favorited($this->session->userdata('user_id'), $wisata['id']) ? 'favorited' : '' ?>" 
                                    data-wisata-id="<?= $wisata['id'] ?>">
                                <i class="<?= is_favorited($this->session->userdata('user_id'), $wisata['id']) ? 'fas' : 'far' ?> fa-heart"></i>
                            </button>
                            
                            <img src="<?= get_wisata_image($wisata['foto']) ?>" class="card-img-top" alt="<?= $wisata['nama'] ?>" style="height: 200px; object-fit: cover;">
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= $wisata['nama'] ?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> <?= $wisata['alamat'] ?>
                                </p>
                                <div class="mb-2">
                                    <?= get_star_rating($wisata['rating_avg']) ?>
                                    <small class="text-muted">(<?= $wisata['jumlah_rating'] ?>)</small>
                                </div>
                                <p class="text-primary fw-bold"><?= format_rupiah($wisata['harga_tiket']) ?></p>
                                <a href="<?= base_url('wisata/detail/' . $wisata['id']) ?>" class="btn btn-primary w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada rekomendasi. Berikan rating pada beberapa wisata untuk mendapatkan rekomendasi yang lebih akurat.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Collaborative Filtering Recommendations -->
    <?php if (!empty($collaborative)): ?>
        <div class="mb-5">
            <h4 class="mb-3">Berdasarkan Pengguna Serupa</h4>
            <p class="text-muted">Wisata yang disukai oleh pengguna dengan preferensi serupa dengan Anda</p>
            <div class="row">
                <?php foreach ($collaborative as $wisata): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= get_wisata_image($wisata['foto']) ?>" class="card-img-top" alt="<?= $wisata['nama'] ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $wisata['nama'] ?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> <?= $wisata['alamat'] ?>
                                </p>
                                <div class="mb-2">
                                    <?= get_star_rating($wisata['rating_avg']) ?>
                                    <small class="text-muted">(<?= $wisata['jumlah_rating'] ?>)</small>
                                </div>
                                <p class="text-primary fw-bold"><?= format_rupiah($wisata['harga_tiket']) ?></p>
                                <a href="<?= base_url('wisata/detail/' . $wisata['id']) ?>" class="btn btn-outline-primary w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Item-Based Recommendations -->
    <?php if (!empty($item_based)): ?>
        <div class="mb-5">
            <h4 class="mb-3">Berdasarkan Wisata yang Anda Sukai</h4>
            <p class="text-muted">Wisata yang mirip dengan tempat yang pernah Anda rating tinggi</p>
            <div class="row">
                <?php foreach ($item_based as $wisata): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= get_wisata_image($wisata['foto']) ?>" class="card-img-top" alt="<?= $wisata['nama'] ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $wisata['nama'] ?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> <?= $wisata['alamat'] ?>
                                </p>
                                <div class="mb-2">
                                    <?= get_star_rating($wisata['rating_avg']) ?>
                                    <small class="text-muted">(<?= $wisata['jumlah_rating'] ?>)</small>
                                </div>
                                <p class="text-primary fw-bold"><?= format_rupiah($wisata['harga_tiket']) ?></p>
                                <a href="<?= base_url('wisata/detail/' . $wisata['id']) ?>" class="btn btn-outline-primary w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
