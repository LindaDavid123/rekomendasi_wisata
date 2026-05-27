<style>
    .navbar-wrapper {
        width: 100%;
        background: white;
        padding: 15px 40px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        position: sticky;
        top: 0;
        height: auto;
        z-index: 1000;
    }
    .navbar-logo {
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
        text-decoration: none;
    }
    .navbar-menu {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }
    .nav-item {
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
    .nav-item:hover, .nav-item.active {
        background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
        color: white;
    }
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

<!-- Navbar -->
<div class="navbar-wrapper">
    <a href="<?php echo base_url('dashboard')?>" class="navbar-logo" title="Dashboard">W</a>

    <nav class="navbar-menu">
        <a href="<?php echo base_url('dashboard')?>" class="nav-item">
            <i class="fas fa-home"></i>
            <span class="d-none d-lg-inline">Home</span>
        </a>
        <a href="<?php echo base_url('wisata')?>" class="nav-item">
            <i class="fas fa-map-marked-alt"></i>
            <span class="d-none d-lg-inline">Wisata</span>
        </a>
        <a href="<?php echo base_url('rekomendasi')?>" class="nav-item active">
            <i class="fas fa-magic"></i>
            <span class="d-none d-lg-inline">Rekomendasi</span>
        </a>
        <a href="<?php echo base_url('favorit')?>" class="nav-item">
            <i class="fas fa-heart"></i>
            <span class="d-none d-lg-inline">Favorit</span>
        </a>
        <a href="<?php echo base_url('profil')?>" class="nav-item">
            <i class="fas fa-user"></i>
            <span class="d-none d-lg-inline">Profil</span>
        </a>
        <a href="<?php echo base_url('auth/logout')?>" class="nav-item">
            <i class="fas fa-sign-out-alt"></i>
            <span class="d-none d-lg-inline">Logout</span>
        </a>
    </nav>
</div>

<div class="container py-5">
    <!-- Tombol Kembali -->
    <a href="javascript:history.back()" class="btn-back-rekomendasi">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <h2 class="mb-4"><i class="fas fa-star text-warning"></i> Rekomendasi Wisata Untuk Anda</h2>

    <!-- API Status Badge -->
    <?php if (isset($using_python_api)): ?>
    <div class="mb-3">
        <?php if ($using_python_api): ?>
        <span class="badge bg-success" style="font-size: 14px; padding: 8px 15px;">
            <i class="fas fa-check-circle"></i> Menggunakan Python KNN + Cosine Similarity
        </span>
        <?php else: ?>
        <span class="badge bg-warning text-dark" style="font-size: 14px; padding: 8px 15px;">
            <i class="fas fa-exclamation-triangle"></i> Menggunakan Metode PHP (Fallback)
        </span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

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
                    <p class="mb-2">Berdasarkan <strong><?php echo $user_rating_count?> rating</strong> yang Anda berikan, berikut rekomendasi menggunakan <strong>Cosine Similarity</strong>.</p>
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
            <?php if (! empty($recommendations)): ?>
                <?php foreach ($recommendations as $wisata): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm position-relative">
                            <button class="btn-favorite <?php echo is_favorited($this->session->userdata('user_id'), $wisata['id']) ? 'favorited' : ''?>"
                                    data-wisata-id="<?php echo $wisata['id']?>">
                                <i class="<?php echo is_favorited($this->session->userdata('user_id'), $wisata['id']) ? 'fas' : 'far'?> fa-heart"></i>
                            </button>

                            <img src="<?php echo get_wisata_image($wisata['foto'])?>" class="card-img-top" alt="<?php echo $wisata['nama']?>" style="height: 200px; object-fit: cover;">

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $wisata['nama']?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo $wisata['alamat']?>
                                </p>
                                <div class="mb-2">
                                    <?php echo get_star_rating($wisata['rating_avg'])?>
                                    <small class="text-muted">(<?php echo $wisata['jumlah_rating']?>)</small>
                                </div>
                                <p class="text-primary fw-bold"><?php echo format_rupiah($wisata['harga_tiket'])?></p>
                                <a href="<?php echo base_url('wisata/detail/' . $wisata['id'])?>" class="btn btn-primary w-100">Detail</a>
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
    <?php if (! empty($collaborative)): ?>
        <div class="mb-5">
            <h4 class="mb-3">Berdasarkan Pengguna Serupa</h4>
            <p class="text-muted">Wisata yang disukai oleh pengguna dengan preferensi serupa dengan Anda</p>
            <div class="row">
                <?php foreach ($collaborative as $wisata): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo get_wisata_image($wisata['foto'])?>" class="card-img-top" alt="<?php echo $wisata['nama']?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $wisata['nama']?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo $wisata['alamat']?>
                                </p>
                                <div class="mb-2">
                                    <?php echo get_star_rating($wisata['rating_avg'])?>
                                    <small class="text-muted">(<?php echo $wisata['jumlah_rating']?>)</small>
                                </div>
                                <p class="text-primary fw-bold"><?php echo format_rupiah($wisata['harga_tiket'])?></p>
                                <a href="<?php echo base_url('wisata/detail/' . $wisata['id'])?>" class="btn btn-outline-primary w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Item-Based Recommendations -->
    <?php if (! empty($item_based)): ?>
        <div class="mb-5">
            <h4 class="mb-3">Berdasarkan Wisata yang Anda Sukai</h4>
            <p class="text-muted">Wisata yang mirip dengan tempat yang pernah Anda rating tinggi</p>
            <div class="row">
                <?php foreach ($item_based as $wisata): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo get_wisata_image($wisata['foto'])?>" class="card-img-top" alt="<?php echo $wisata['nama']?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $wisata['nama']?></h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo $wisata['alamat']?>
                                </p>
                                <div class="mb-2">
                                    <?php echo get_star_rating($wisata['rating_avg'])?>
                                    <small class="text-muted">(<?php echo $wisata['jumlah_rating']?>)</small>
                                </div>
                                <p class="text-primary fw-bold"><?php echo format_rupiah($wisata['harga_tiket'])?></p>
                                <a href="<?php echo base_url('wisata/detail/' . $wisata['id'])?>" class="btn btn-outline-primary w-100">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function refreshRecommendations() {
    fetch('<?php echo base_url('rekomendasi/get_realtime')?>')
        .then(response => response.json())
        .then(data => {
            if (!data.recommendations) return;
            var container = document.querySelector('.mb-5 .row');
            if (container) {
                container.innerHTML = '';
                data.recommendations.forEach(function(wisata) {
                    container.innerHTML += `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm position-relative">
                            <img src='${wisata.foto ? '<?php echo base_url('uploads/')?>'+wisata.foto : '<?php echo base_url('assets/images/no-image.png')?>'}' class='card-img-top' alt='${wisata.nama}' style='height:200px;object-fit:cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>${wisata.nama}</h5>
                                <p class='text-muted mb-2'><i class='fas fa-map-marker-alt'></i> ${wisata.alamat}</p>
                                <div class='mb-2'>${wisata.rating_avg ? '⭐ ' + wisata.rating_avg : ''} <small class='text-muted'>(${wisata.jumlah_rating})</small></div>
                                <p class='text-primary fw-bold'>${wisata.harga_tiket ? 'Rp ' + wisata.harga_tiket : ''}</p>
                                <a href='<?php echo base_url('wisata/detail/')?>${wisata.id}' class='btn btn-primary w-100'>Detail</a>
                            </div>
                        </div>
                    </div>`;
                });
            }
        });
}
setInterval(refreshRecommendations, 10000); // refresh setiap 10 detik
</script>
