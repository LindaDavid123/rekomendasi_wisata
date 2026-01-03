<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-3">
        <div class="stat-card blue">
            <h3><?= $total_wisata ?></h3>
            <p><i class="fas fa-map-marker-alt"></i> Total Wisata</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <h3><?= $total_users ?></h3>
            <p><i class="fas fa-users"></i> Total Users</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <h3><?= $total_ratings ?></h3>
            <p><i class="fas fa-star"></i> Total Ratings</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card red">
            <h3><?= $total_reviews ?></h3>
            <p><i class="fas fa-comment"></i> Total Reviews</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Wisata -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Wisata Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_wisata as $wisata): ?>
                                <tr>
                                    <td><?= $wisata['nama'] ?></td>
                                    <td><span class="badge bg-secondary"><?= $wisata['kategori'] ?></span></td>
                                    <td><?= number_format($wisata['rating_avg'], 1) ?> <i class="fas fa-star text-warning"></i></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Rated -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Wisata Rating Tertinggi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Rating</th>
                                <th>Jumlah Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_rated as $wisata): ?>
                                <tr>
                                    <td><?= $wisata['nama'] ?></td>
                                    <td><?= number_format($wisata['rating_avg'], 1) ?> <i class="fas fa-star text-warning"></i></td>
                                    <td><?= $wisata['jumlah_rating'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Users -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">User Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_users as $user): ?>
                                <tr>
                                    <td><?= $user['nama'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['role'] == 'admin' ? 'danger' : 'primary' ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td><?= time_elapsed_string($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts (Optional) -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Rating per Bulan</h5>
            </div>
            <div class="card-body">
                <canvas id="ratingsChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kategori Wisata</h5>
            </div>
            <div class="card-body">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>
</div>
