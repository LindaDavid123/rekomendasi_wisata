<style>
    body { background: #f7f4ee; }
    .dashboard-header {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2d5016;
        margin-bottom: 30px;
        text-align: left;
        letter-spacing: 1px;
    }
    .stat-card {
        border-radius: 20px;
        box-shadow: 0 4px 18px rgba(74,107,61,0.08);
        padding: 30px 20px;
        background: linear-gradient(135deg, #e2dbce 0%, #f7f4ee 100%);
        color: #222;
        margin-bottom: 20px;
        transition: transform 0.3s cubic-bezier(.68,-0.55,.27,1.55), box-shadow 0.2s;
        text-align: center;
        cursor: pointer;
    }
    .stat-card:hover {
        transform: scale(1.04) translateY(-4px);
        box-shadow: 0 12px 32px rgba(74,107,61,0.18);
        background: linear-gradient(135deg, #d6cfc2 0%, #ece7df 100%);
    }
    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 8px;
    }
    .stat-card p {
        font-size: 1.1rem;
        font-weight: 600;
        color: #4a6b3d;
    }
    .card {
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(74,107,61,0.08);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .card-header {
        background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
        color: #fff;
        font-weight: 700;
        font-size: 1.2rem;
        padding: 18px 24px;
        border-radius: 18px 18px 0 0;
    }
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 1rem;
    }
    .badge {
        font-size: 0.95rem;
        border-radius: 12px;
        padding: 6px 14px;
        font-weight: 600;
    }
    .table tr {
        transition: background 0.2s;
    }
    .table tr:hover {
        background: #f7f4ee;
    }
    .stat-animate {
        animation: statPop 1.1s cubic-bezier(.68,-0.55,.27,1.55);
    }
    @keyframes statPop {
        0% { opacity: 0; transform: scale(0.92); }
        80% { opacity: 1; transform: scale(1.04); }
        100% { opacity: 1; transform: scale(1); }
    }
</style>
<div class="dashboard-header">Dashboard Admin</div>
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-md-2">
        <div class="stat-card stat-animate">
            <h3><?= $total_wisata ?></h3>
            <p><i class="fas fa-map-marker-alt"></i> Total Wisata</p>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-animate">
            <h3><?= $total_users ?></h3>
            <p><i class="fas fa-users"></i> Total Users</p>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-animate">
            <h3><?= $total_ratings ?></h3>
            <p><i class="fas fa-star"></i> Total Ratings</p>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-animate">
            <h3><?= $total_reviews ?></h3>
            <p><i class="fas fa-comment"></i> Total Reviews</p>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-animate">
            <h3><?= $total_favorit ?></h3>
            <p><i class="fas fa-heart"></i> Total Favorit</p>
        </div>
    </div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Wisata Terbaru</div>
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Wisata Rating Tertinggi</div>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">User Terbaru</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                            </tr>
                        </thead>
                        <tbody class="user-terbaru-tbody">
                            <?php foreach ($recent_users as $user): ?>
                                <tr>
                                    <td><?= $user['email'] ?></td>
                                    <td><span class="badge bg-success text-white"><?= $user['role'] ?></span></td>
                                    <td><?= format_datetime($user['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Interaktif (Chart.js) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Contoh data chart, ganti dengan data dinamis jika perlu
var ctxRatings = document.getElementById('ratingsChart');
if (ctxRatings) {
    new Chart(ctxRatings, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Rating per Bulan',
                data: [12, 19, 8, 15, 22, 18, 25, 20, 17, 14, 10, 16],
                borderColor: '#4a6b3d',
                backgroundColor: 'rgba(74,107,61,0.08)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
}
var ctxCategories = document.getElementById('categoriesChart');
if (ctxCategories) {
    new Chart(ctxCategories, {
        type: 'doughnut',
        data: {
            labels: ['Alam', 'Budaya', 'Sejarah', 'Kuliner', 'Belanja', 'Edukasi', 'Hiburan'],
            datasets: [{
                label: 'Kategori Wisata',
                data: [8, 5, 6, 3, 2, 2, 4],
                backgroundColor: [
                    '#4a6b3d', '#7fb1e3', '#e2dbce', '#f7f4ee', '#dc3545', '#ffc107', '#5a8f4a'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}
function refreshAdminStats() {
    // Add cache-busting query param
    const url = '<?= base_url('admin/dashboard/get_stats') ?>' + '?_=' + new Date().getTime();
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) return;
            document.querySelector('.stat-card:nth-child(1) h3').textContent = data.total_wisata;
            document.querySelector('.stat-card:nth-child(2) h3').textContent = data.total_users;
            document.querySelector('.stat-card:nth-child(3) h3').textContent = data.total_ratings;
            document.querySelector('.stat-card:nth-child(4) h3').textContent = data.total_reviews;
            document.querySelector('.stat-card:nth-child(5) h3').textContent = data.total_favorit;
            // Update user terbaru table
            var tbody = document.querySelector('.user-terbaru-tbody');
            if (tbody && data.recent_users) {
                tbody.innerHTML = '';
                data.recent_users.forEach(function(user) {
                    tbody.innerHTML += `<tr><td>${user.email}</td><td><span class='badge bg-success text-white'>${user.role}</span></td><td>${user.created_at}</td></tr>`;
                });
            }
        });
}
setInterval(refreshAdminStats, 10000); // refresh setiap 10 detik
</script>
        </div>
    </div>
</div>
