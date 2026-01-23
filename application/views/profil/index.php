<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
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
    .nav-home {
        padding: 12px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #666;
        transition: all 0.3s;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
    }
    .nav-home:hover {
        background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
        color: white;
        text-decoration: none;
    }
    .nav-logout {
        padding: 12px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #666;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
    }
    .nav-logout:hover {
        background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
        color: white;
        text-decoration: none;
    }
    .page-wrapper {
        padding-top: 20px;
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
        margin-bottom: 30px;
    }
    .back-button:hover {
        background: #4a6b3d;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 8px 20px rgba(45,80,22,0.4);
        text-decoration: none;
    }
    .profile-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a6b3d 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        text-align: center;
        box-shadow: 0 10px 30px rgba(45,80,22,0.2);
        margin-bottom: 40px;
    }
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        object-fit: cover;
        margin: 0 auto 20px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%); /* default bg */
    }
    .profile-avatar[src*="girl.png"] {
        background: linear-gradient(135deg, #ffe2f2 0%, #fff6fa 100%);
    }
    .profile-avatar[src*="boy.png"] {
        background: linear-gradient(135deg, #e2f0ff 0%, #f6fbff 100%);
    }
    .profile-name {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .profile-email {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 20px;
    }
    .btn-edit-profile {
        background: white;
        color: #2d5016;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-edit-profile:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        color: #2d5016;
        text-decoration: none;
    }
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border-left: 4px solid #2d5016;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #2d5016;
    }
    .stat-icon.rating {
        color: #ffc107;
    }
    .stat-icon.review {
        color: #17a2b8;
    }
    .stat-icon.favorite {
        color: #dc3545;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #2d5016;
        margin-bottom: 5px;
    }
    .stat-label {
        color: #666;
        font-weight: 600;
        font-size: 0.95rem;
    }
    .section-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #2d5016;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-title:before {
        content: '';
        width: 4px;
        height: 30px;
        background: #2d5016;
        border-radius: 10px;
    }
    .section-title i {
        color: #4a6b3d;
    }
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        overflow: hidden;
        margin-bottom: 30px;
    }
    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .card-header {
        background: linear-gradient(135deg, #2d5016 0%, #4a6b3d 100%);
        color: white;
        border: none;
        padding: 20px;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 600;
    }
    .table {
        margin: 0;
    }
    .table thead {
        background: #f8f9fa;
        border-top: 2px solid #e8e8e8;
    }
    .table th {
        color: #2d5016;
        font-weight: 600;
        border-color: #e8e8e8;
        padding: 15px;
    }
    .table td {
        padding: 15px;
        vertical-align: middle;
    }
    .table tbody tr {
        border-color: #e8e8e8;
        transition: all 0.3s;
    }
    .table tbody tr:hover {
        background: #f8f9fa;
    }
    .btn-primary {
        background: #2d5016;
        border-color: #2d5016;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background: #4a6b3d;
        border-color: #4a6b3d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(45,80,22,0.3);
    }
    .btn-outline-primary {
        color: #2d5016;
        border-color: #2d5016;
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-outline-primary:hover {
        background: #2d5016;
        border-color: #2d5016;
        color: white;
    }
    .wisata-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        height: 100%;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    .wisata-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .wisata-card img {
        height: 180px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }
    .wisata-card .card-body {
        padding: 15px;
    }
    .wisata-card .card-title {
        color: #2d5016;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 1rem;
    }
    .wisata-location {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .wisata-location i {
        color: #2d5016;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }
    .empty-state p {
        color: #999;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
</style>

<!-- Navbar -->
<div class="navbar-wrapper">
    <a href="<?= base_url('dashboard') ?>" class="navbar-logo" title="Dashboard">
        W
    </a>
    
    <div class="navbar-menu">
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
        <a href="<?= base_url('favorit') ?>" class="nav-item">
            <i class="fas fa-heart"></i>
            <span class="d-none d-lg-inline">Favorit</span>
        </a>
        <a href="<?= base_url('profil') ?>" class="nav-item active">
            <i class="fas fa-user"></i>
            <span class="d-none d-lg-inline">Profil</span>
        </a>
        <a href="<?= base_url('auth/logout') ?>" class="nav-item">
            <i class="fas fa-sign-out-alt"></i>
            <span class="d-none d-lg-inline">Logout</span>
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="page-wrapper">
    <div class="container py-4">

    <?php if ($user): ?>
        <!-- Profile Header -->
        <div class="profile-header">
            <img src="<?= get_user_image($user['foto'] ?? null) ?>" class="profile-avatar" alt="<?= $user['nama'] ?? 'User' ?>">
            <h1 class="profile-name"><?= $user['nama'] ?? 'Pengguna' ?></h1>
            <p class="profile-email">
                <i class="fas fa-envelope me-2"></i><?= $user['email'] ?? 'email@example.com' ?>
            </p>
            <a href="<?= base_url('profil/edit') ?>" class="btn-edit-profile">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>

        <!-- Statistics -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon rating"><i class="fas fa-star"></i></div>
                <div class="stat-number"><?= $statistics['total_ratings'] ?? 0 ?></div>
                <div class="stat-label">Total Rating</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon review"><i class="fas fa-comment-dots"></i></div>
                <div class="stat-number"><?= $statistics['total_reviews'] ?? 0 ?></div>
                <div class="stat-label">Total Ulasan</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon favorite"><i class="fas fa-heart"></i></div>
                <div class="stat-number"><?= $statistics['total_favorites'] ?? 0 ?></div>
                <div class="stat-label">Total Favorit</div>
            </div>
        </div>

            <div class="card" style="border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <div class="card-header" style="background: linear-gradient(135deg, #3a6ea5 0%, #7fb1e3 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                    <h3 style="color: white; margin: 0; font-size: 18px; font-weight: 700;">
                        <i class="fas fa-star me-2"></i>Riwayat Rating Terbaru
                    </h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if (!empty($recent_ratings)): ?>
                        <div class="table-responsive" style="margin: 0;">
                            <table class="table" style="margin: 0; border: none;">
                                <thead>
                                    <tr style="background: linear-gradient(135deg, #f5f7fa 0%, #f0f5f9 100%); border-bottom: 2px solid #3a6ea5;">
                                        <th style="padding: 16px 20px; font-weight: 700; color: #3a6ea5; border: none;">
                                            <i class="fas fa-mountain me-2"></i>Wisata
                                        </th>
                                        <th style="padding: 16px 20px; font-weight: 700; color: #3a6ea5; border: none; text-align: center;">
                                            <i class="fas fa-star me-2"></i>Rating
                                        </th>
                                        <th style="padding: 16px 20px; font-weight: 700; color: #3a6ea5; border: none;">
                                            <i class="fas fa-calendar-alt me-2"></i>Tanggal
                                        </th>
                                        <th style="padding: 16px 20px; font-weight: 700; color: #3a6ea5; border: none; text-align: center;">
                                            <i class="fas fa-cog me-2"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_ratings as $rating): ?>
                                        <tr style="border-bottom: 1px solid #f0f0f0; transition: all 0.3s;">
                                            <td style="padding: 14px 20px; border: none; color: #2d3748; font-weight: 500;">
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= get_wisata_image($rating['foto'] ?? null) ?>" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: none;">
                                                    <span><?= substr($rating['nama'] ?? 'Wisata', 0, 25) ?></span>
                                                </div>
                                            </td>
                                            <td style="padding: 14px 20px; border: none; color: #f39c12; font-weight: bold; text-align: center;">
                                                <?= get_star_rating($rating['rating'] ?? 0) ?>
                                            </td>
                                            <td style="padding: 14px 20px; border: none; color: #666; font-size: 13px;">
                                                <?= format_datetime($rating['created_at'] ?? date('Y-m-d H:i:s')) ?>
                                            </td>
                                            <td style="padding: 14px 20px; border: none; text-align: center;">
                                                <a href="<?= base_url('wisata/detail/' . $rating['wisata_id']) ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #3a6ea5 0%, #7fb1e3 100%); color: white; padding: 6px 14px; border-radius: 8px; border: none; text-decoration: none; transition: all 0.3s; font-size: 12px; font-weight: 600;">
                                                    <i class="fas fa-eye me-1"></i>Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 20px; color: #999;">
                            <i class="fas fa-inbox" style="font-size: 32px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                            <p style="margin: 0;">Belum ada rating</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Favorite Wisata -->
        <div>
            <h2 class="section-title">
                <i class="fas fa-heart"></i> Wisata Favorit Terbaru
            </h2>
            
            <div class="card">
                <div class="card-body p-4">
                    <?php if (!empty($favorites)): ?>
                        <div class="row">
                            <?php foreach (array_slice($favorites, 0, 3) as $wisata): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="wisata-card">
                                        <img src="<?= get_wisata_image($wisata['foto'] ?? null) ?>" alt="<?= $wisata['nama'] ?? 'Wisata' ?>">
                                        <div class="card-body">
                                            <h6 class="wisata-card-title"><?= $wisata['nama'] ?? 'Wisata' ?></h6>
                                            <div class="wisata-location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?= substr($wisata['alamat'] ?? '', 0, 40) . (strlen($wisata['alamat'] ?? '') > 40 ? '...' : '') ?></span>
                                            </div>
                                            <a href="<?= base_url('wisata/detail/' . $wisata['id']) ?>" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($favorites) > 3): ?>
                            <div class="text-center mt-4">
                                <a href="<?= base_url('favorit') ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-heart me-2"></i>Lihat Semua Favorit (<?= count($favorites) ?>)
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-heart-o"></i>
                            <p>Belum ada wisata favorit</p>
                            <a href="<?= base_url('wisata') ?>" class="btn btn-primary">
                                <i class="fas fa-compass me-2"></i>Jelajahi Wisata
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning alert-lg text-center">
            <h5>Profil tidak ditemukan</h5>
            <p>Data pengguna tidak tersedia. Silakan hubungi administrator.</p>
        </div>
    <?php endif; ?>
    </div>
</div>
