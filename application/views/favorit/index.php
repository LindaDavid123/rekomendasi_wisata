<style>
    body {
        background: #E8E4DC;
    }
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
    .back-button {
        background: #2d5016;
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        box-shadow: 0 5px 15px rgba(45,80,22,0.3);
        transition: all 0.3s;
        margin-bottom: 25px;
    }
    .back-button:hover {
        background: #4a6b3d;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 8px 20px rgba(45,80,22,0.4);
        text-decoration: none;
    }
    .page-title {
        color: #2d5016;
        font-weight: bold;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .page-title i {
        color: #dc3545;
        font-size: 1.8rem;
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .btn-favorite {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        border: none;
        border-radius: 50%;
        padding: 8px 10px;
        cursor: pointer;
        transition: all 0.3s;
        z-index: 10;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .btn-favorite:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .btn-favorite i {
        color: #ccc;
        font-size: 1.2rem;
        transition: all 0.3s;
    }
    .btn-favorite.favorited i {
        color: #dc3545;
    }
    .card-img-top {
        border-radius: 15px 15px 0 0;
    }
    .card-body h5 {
        color: #2d5016;
        font-weight: 600;
    }
    .card-footer {
        background: white;
        border-top: 1px solid #e8e8e8;
        border-radius: 0 0 15px 15px;
    }
    .btn-primary {
        background: #2d5016;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background: #4a6b3d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(45,80,22,0.3);
    }
    .alert-info {
        background: #e8f5e9;
        border: 2px solid #4a6b3d;
        border-radius: 15px;
        color: #2d5016;
        padding: 40px 20px;
    }
    .alert-info .alert-link {
        color: #2d5016;
        font-weight: 600;
        text-decoration: underline;
    }
    .alert-info .alert-link:hover {
        color: #4a6b3d;
    }
</style>

<!-- Navbar -->
<div class="navbar-wrapper">
    <a href="<?= base_url('dashboard') ?>" class="navbar-logo" title="Dashboard">W</a>
    
    <nav class="navbar-menu">
        <a href="<?= base_url('dashboard') ?>" class="nav-item">
            <i class="fas fa-home"></i>
            <span class="d-none d-lg-inline">Home</span>
        </a>
        <a href="<?= base_url('wisata') ?>" class="nav-item">
            <i class="fas fa-map-marked-alt"></i>
            <span class="d-none d-lg-inline">Wisata</span>
        </a>
        <a href="<?= base_url('rekomendasi') ?>" class="nav-item">
            <i class="fas fa-magic"></i>
            <span class="d-none d-lg-inline">Rekomendasi</span>
        </a>
        <a href="<?= base_url('favorit') ?>" class="nav-item active">
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

<div class="container py-4">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <h2 class="page-title">
        <i class="fas fa-heart"></i> Wisata Favorit Saya
    </h2>

    <div class="row">
        <?php if (!empty($favorites)): ?>
            <?php foreach ($favorites as $wisata): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm position-relative">

                        <button class="btn-favorite favorited"
                                data-wisata-id="<?= $wisata['id'] ?>"
                                title="Hapus dari Favorit">
                            <i class="fas fa-heart"></i>
                        </button>

                        <img src="<?= get_wisata_image($wisata['foto']) ?>"
                             class="card-img-top"
                             style="height:200px;object-fit:cover">

                        <div class="card-body">
                            <h5><?= $wisata['nama'] ?></h5>
                            <p class="text-muted small">
                                <i class="fas fa-map-marker-alt" style="color: #2d5016;"></i>
                                <?= $wisata['alamat'] ?>
                            </p>

                            <p class="small text-muted">
                                <?= truncate_text($wisata['deskripsi'], 100) ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <strong style="color: #2d5016;">
                                    <?= format_rupiah($wisata['harga_tiket']) ?>
                                </strong>
                                <span class="badge" style="background: #4a6b3d;">
                                    <?= ucfirst($wisata['kategori']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="<?= base_url('wisata/detail/'.$wisata['id']) ?>"
                               class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-inbox fa-2x mb-3"></i>
                    <p class="mb-3">Belum ada favorit.</p>
                    <a href="<?= base_url('wisata') ?>" class="btn btn-primary">
                        <i class="fas fa-compass me-2"></i>Jelajahi Wisata
                    </a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<!-- JS FAVORIT -->
<script>
document.querySelectorAll('.btn-favorite').forEach(btn => {
    btn.addEventListener('click', function () {
        const wisataId = this.dataset.wisataId;
        const button  = this;

        fetch("<?= base_url('favorit/toggle') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "wisata_id=" + wisataId
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message);
                return;
            }
            button.classList.toggle('favorited', data.favorited);
            
            // If unfavorited, reload the page to remove the item
            if (!data.favorited) {
                setTimeout(() => location.reload(), 300);
            }
        });
    });
});
</script>
