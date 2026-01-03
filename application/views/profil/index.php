<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Sidebar -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="<?= get_user_image($user['foto']) ?>" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="<?= $user['nama'] ?>">
                    <h5><?= $user['nama'] ?></h5>
                    <p class="text-muted"><?= $user['email'] ?></p>
                    <a href="<?= base_url('profil/edit') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Statistik Saya</h6>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-star text-warning"></i> Rating Diberikan</span>
                        <span class="badge bg-primary rounded-pill"><?= $statistics['total_ratings'] ?></span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-comment text-info"></i> Review</span>
                        <span class="badge bg-primary rounded-pill"><?= $statistics['total_reviews'] ?></span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-heart text-danger"></i> Favorit</span>
                        <span class="badge bg-primary rounded-pill"><?= $statistics['total_favorites'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Recent Ratings -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-star"></i> Rating Terbaru</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recent_ratings)): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Wisata</th>
                                        <th>Rating</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_ratings as $rating): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?= get_wisata_image($rating['foto']) ?>" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <span><?= $rating['nama'] ?></span>
                                                </div>
                                            </td>
                                            <td><?= get_star_rating($rating['rating']) ?></td>
                                            <td><?= time_elapsed_string($rating['created_at']) ?></td>
                                            <td>
                                                <a href="<?= base_url('wisata/detail/' . $rating['wisata_id']) ?>" class="btn btn-sm btn-primary">
                                                    Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada rating</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Favorite Wisata -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-heart"></i> Wisata Favorit</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($favorites)): ?>
                        <div class="row">
                            <?php foreach (array_slice($favorites, 0, 3) as $wisata): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="<?= get_wisata_image($wisata['foto']) ?>" class="card-img-top" alt="<?= $wisata['nama'] ?>" style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <h6 class="card-title"><?= $wisata['nama'] ?></h6>
                                            <p class="text-muted small mb-2">
                                                <i class="fas fa-map-marker-alt"></i> <?= $wisata['alamat'] ?>
                                            </p>
                                            <a href="<?= base_url('wisata/detail/' . $wisata['id']) ?>" class="btn btn-sm btn-primary w-100">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($favorites) > 3): ?>
                            <div class="text-center">
                                <a href="<?= base_url('favorit') ?>" class="btn btn-outline-primary">
                                    Lihat Semua Favorit
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted text-center">Belum ada wisata favorit</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
