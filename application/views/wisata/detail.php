<style>
    body {
        background: #f5f7fa;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .detail-hero {
        position: relative;
        height: 450px;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .detail-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .detail-hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 30px;
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
        margin-bottom: 20px;
    }
    .back-button:hover {
        background: #4a6b3d;
        color: white;
        transform: translateX(-5px);
        box-shadow: 0 8px 20px rgba(45,80,22,0.4);
    }
    .info-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s;
    }
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .price-tag {
        background: #2d5016;
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        display: inline-block;
        font-size: 1.5rem;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(45,80,22,0.3);
    }
    .rating-box {
        background: #4a6b3d;
        color: white;
        padding: 25px;
        border-radius: 15px;
        text-align: center;
    }
    .rating-box h1 {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .rating-stars {
        font-size: 2rem;
        cursor: pointer;
    }
    .rating-stars i {
        transition: all 0.2s;
        cursor: pointer;
        color: #ddd;
    }
    .rating-stars i.fas {
        color: #ffc107 !important;
    }
    .rating-stars i.far {
        color: #ddd !important;
    }
    .rating-stars i:hover {
        transform: scale(1.2);
    }
    .info-badge {
        background: #f8f9fa;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        border-left: 4px solid #2d5016;
    }
    .review-item {
        background: white;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px;
        border-left: 4px solid #4a6b3d;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #4a6b3d;
        background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%); /* default bg */
    }
    .user-avatar[src*="girl.png"] {
        background: linear-gradient(135deg, #ffe2f2 0%, #fff6fa 100%);
    }
    .user-avatar[src*="boy.png"] {
        background: linear-gradient(135deg, #e2f0ff 0%, #f6fbff 100%);
    }
    .similar-card {
        transition: all 0.3s;
        border-radius: 15px;
        padding: 12px;
        margin-bottom: 10px;
        background: white;
        border: 2px solid transparent;
    }
    .similar-card:hover {
        background: #f8f9fa;
        border-color: #4a6b3d;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(45,80,22,0.15);
    }
    .similar-card img {
        border-radius: 12px;
        border: 2px solid #e8f5e9;
        transition: all 0.3s;
    }
    .similar-card:hover img {
        border-color: #4a6b3d;
    }
    .btn-favorite {
        border: none;
        background: none;
        padding: 0;
        cursor: pointer;
        font-size: 2rem;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #dc3545;
    }
    .btn-favorite i {
        transition: all 0.3s;
    }
    .btn-favorite:hover i {
        transform: scale(1.2);
        filter: drop-shadow(0 4px 8px rgba(220,53,69,0.3));
    }
    .btn-favorite.favorited i {
        color: #dc3545;
    }
    .favorite-section {
        background: linear-gradient(135deg, #fff5f7 0%, #ffe8ec 100%);
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        border: 2px dashed #ffb3c1;
        transition: all 0.3s;
    }
    .favorite-section:hover {
        border-color: #ff69b4;
        box-shadow: 0 5px 20px rgba(220,53,69,0.15);
    }
    .favorite-section .btn-favorite {
        justify-content: center;
        font-size: 3rem;
        margin-bottom: 10px;
    }
    .favorite-text {
        font-weight: 600;
        color: #2d5016;
        font-size: 0.95rem;
    }
    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #2d5016;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title:before {
        content: '';
        width: 4px;
        height: 30px;
        background: #2d5016;
        border-radius: 10px;
    }
</style>

<div class="container py-4">
    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Hero Image -->
            <div class="detail-hero mb-4">
                <img src="<?php echo get_wisata_image($wisata['foto'])?>" alt="<?php echo $wisata['nama']?>">
                <div class="detail-hero-overlay">
                    <h1 class="mb-2"><?php echo $wisata['nama']?></h1>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i><?php echo $wisata['alamat']?></p>
                    <span class="badge bg-light text-dark px-3 py-2"><i class="fas fa-tag me-2"></i><?php echo ucfirst($wisata['kategori'])?></span>
                </div>
            </div>

            <!-- Price & Favorite -->
            <div class="info-card card mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-2"><i class="fas fa-ticket-alt me-2"></i>Harga Tiket Masuk</p>
                            <div class="price-tag"><?php echo format_rupiah($wisata['harga_tiket'])?></div>
                        </div>
                        <?php if ($this->session->userdata('user_id')): ?>
                            <div class="col-md-6">
                                <div class="favorite-section">
                                    <button class="btn-favorite"
                                            data-wisata-id="<?php echo $wisata['id']?>"
                                            title="<?php echo isset($is_favorite) && $is_favorite ? 'Hapus dari Favorit' : 'Tambah ke Favorit'?>">
                                        <i class="<?php echo isset($is_favorite) && $is_favorite ? 'fas' : 'far'?> fa-heart"></i>
                                    </button>
                                    <div class="favorite-text">
                                        <?php echo isset($is_favorite) && $is_favorite ? 'Hapus Favorit' : 'Tambah Favorit'?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Rating Section -->
            <div class="info-card card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Rating & Ulasan</h5>
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="rating-box">
                                <h1><?php echo number_format($wisata['rating_avg'], 1)?></h1>
                                <div class="mb-2"><?php echo get_star_rating($wisata['rating_avg'])?></div>
                                <p class="mb-0"><?php echo $wisata['jumlah_rating']?> Rating</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <?php if ($this->session->userdata('user_id')): ?>
                                <div class="rating-section">
                                    <form id="userRatingForm" method="post" action="<?php echo base_url('wisata/submit_rating')?>">
                                        <input type="hidden" name="wisata_id" value="<?php echo $wisata['id']?>">
                                        <label class="form-label fw-bold mb-3">Beri Rating Anda:</label>
                                        <div class="rating-stars" id="user-rating-stars">
                                            <?php $current_rating = is_array($user_rating) && isset($user_rating['rating']) ? $user_rating['rating'] : (is_numeric($user_rating) ? $user_rating : 0); ?>
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fa-star <?php echo $i <= $current_rating ? 'fas' : 'far'?>" data-value="<?php echo $i?>"></i>
                                            <?php endfor; ?>
                                            <input type="hidden" name="rating" id="user-rating-value" value="<?php echo $current_rating?>">
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3">Kirim Rating</button>
                                    </form>
                                    <div id="user-rating-message" class="mt-2"></div>
                                    <?php if ($current_rating > 0): ?>
                                        <p class="text-success mt-2"><i class="fas fa-check-circle me-2"></i>Anda memberikan <?php echo $current_rating?> bintang</p>
                                    <?php endif; ?>
                                </div>
                                <script>
                                    // Rating stars interaction
                                    const stars = document.querySelectorAll('#user-rating-stars .fa-star');
                                    const ratingInput = document.getElementById('user-rating-value');

                                    stars.forEach(function(star) {
                                        // Click to select rating
                                        star.addEventListener('click', function() {
                                            const value = parseInt(this.getAttribute('data-value'));
                                            ratingInput.value = value;

                                            // Update all stars
                                            stars.forEach(function(s) {
                                                const starValue = parseInt(s.getAttribute('data-value'));
                                                if (starValue <= value) {
                                                    s.classList.remove('far');
                                                    s.classList.add('fas');
                                                } else {
                                                    s.classList.remove('fas');
                                                    s.classList.add('far');
                                                }
                                            });
                                        });

                                        // Hover effect
                                        star.addEventListener('mouseenter', function() {
                                            const value = parseInt(this.getAttribute('data-value'));
                                            stars.forEach(function(s) {
                                                const starValue = parseInt(s.getAttribute('data-value'));
                                                if (starValue <= value) {
                                                    s.style.color = '#ffc107';
                                                }
                                            });
                                        });

                                        star.addEventListener('mouseleave', function() {
                                            const currentValue = parseInt(ratingInput.value) || 0;
                                            stars.forEach(function(s) {
                                                const starValue = parseInt(s.getAttribute('data-value'));
                                                if (starValue <= currentValue) {
                                                    s.style.color = '#ffc107';
                                                } else {
                                                    s.style.color = '#ddd';
                                                }
                                            });
                                        });
                                    });

                                    // Toast notification function
                                    function showToast(message, type = 'success', duration = 3000) {
                                        const toastContainer = document.getElementById('toastContainer') || (() => {
                                            const container = document.createElement('div');
                                            container.id = 'toastContainer';
                                            container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;';
                                            document.body.appendChild(container);
                                            return container;
                                        })();

                                        const toast = document.createElement('div');
                                        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
                                        toast.style.cssText = 'min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease;';
                                        toast.innerHTML = `
                                            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                                            ${message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        `;
                                        toastContainer.appendChild(toast);

                                        setTimeout(() => toast.remove(), duration);
                                    }

                                    // Form submit
                                    document.getElementById('userRatingForm').addEventListener('submit', function(e) {
                                        e.preventDefault();

                                        const rating = parseInt(ratingInput.value);
                                        if (!rating || rating < 1 || rating > 5) {
                                            showToast('Silakan pilih rating 1-5 bintang', 'error');
                                            return;
                                        }

                                        var form = this;
                                        var formData = new FormData(form);
                                        var submitBtn = form.querySelector('button[type="submit"]');
                                        var originalText = submitBtn.innerHTML;
                                        submitBtn.disabled = true;
                                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

                                        fetch(form.action, {
                                            method: 'POST',
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                showToast('✨ Rating berhasil disimpan! Menampilkan rekomendasi...', 'success', 3000);
                                                setTimeout(() => {
                                                    window.location.href = '<?= base_url('rekomendasi') ?>';
                                                }, 1500);
                                            } else {
                                                showToast(data.message || 'Gagal mengirim rating', 'error');
                                                submitBtn.disabled = false;
                                                submitBtn.innerHTML = originalText;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            showToast('Terjadi kesalahan, silakan coba lagi', 'error');
                                            submitBtn.disabled = false;
                                            submitBtn.innerHTML = originalText;
                                        });
                                    });
                                </script>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <a href="<?php echo base_url('login')?>" class="alert-link">Login</a> untuk memberikan rating dan ulasan
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="info-card card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Informasi Lengkap</h5>

                    <div class="info-badge">
                        <h6 class="mb-2"><i class="fas fa-align-left text-primary me-2"></i>Deskripsi</h6>
                        <p class="mb-0"><?php echo nl2br($wisata['deskripsi'])?></p>
                    </div>

                    <?php if ($wisata['jam_buka'] || $wisata['jam_tutup']): ?>
                        <div class="info-badge">
                            <h6 class="mb-2"><i class="fas fa-clock text-success me-2"></i>Jam Operasional</h6>
                            <p class="mb-0"><strong><?php echo $wisata['jam_buka']?> - <?php echo $wisata['jam_tutup']?></strong></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($wisata['latitude'] && $wisata['longitude']): ?>
                        <div class="info-badge">
                            <h6 class="mb-2"><i class="fas fa-map-marked-alt text-danger me-2"></i>Peta Lokasi</h6>
                            <a href="https://www.google.com/maps?q=<?php echo $wisata['latitude']?>,<?php echo $wisata['longitude']?>"
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt me-2"></i>Buka di Google Maps
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($wisata['fasilitas']): ?>
                        <div class="info-badge">
                            <h6 class="mb-2"><i class="fas fa-concierge-bell text-info me-2"></i>Fasilitas</h6>
                            <p class="mb-0"><?php echo nl2br($wisata['fasilitas'])?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($wisata['kontak']): ?>
                        <div class="info-badge">
                            <h6 class="mb-2"><i class="fas fa-phone text-warning me-2"></i>Kontak</h6>
                            <p class="mb-0"><?php echo $wisata['kontak']?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Reviews -->
            <div class="info-card card mb-4">
                <div class="card-body">
                    <h5 class="section-title">Ulasan Pengunjung (<?php echo count($reviews)?>)</h5>

                    <?php if ($this->session->userdata('user_id')): ?>
                        <div class="bg-light p-4 rounded mb-4">
                            <form id="reviewForm" method="post" action="<?php echo base_url('wisata/submit_review')?>">
                                <input type="hidden" name="wisata_id" value="<?php echo $wisata['id']?>">
                                <input type="hidden" name="rating" value="5">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="fas fa-edit me-2"></i>Tulis Ulasan Anda</label>
                                    <textarea name="review" class="form-control" rows="4" placeholder="Bagikan pengalaman Anda..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($reviews)): ?>
                        <div class="reviews-list">
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item">
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            <div class="user-avatar bg-gradient-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width: 50px; height: 50px;">
                                                <?php echo strtoupper(substr($review['username'], 0, 1))?>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold"><?php echo $review['username']?></h6>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                <?php echo isset($review['created_at']) ? format_datetime($review['created_at']) : 'Tidak ada tanggal'?>
                                            </small>
                                        </div>
                                    </div>
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($review['review']))?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada ulasan. Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Similar Wisata -->
            <?php if (! empty($similar_wisata)): ?>
                <div class="info-card card sticky-top" style="top: 20px;">
                    <div class="card-header text-white" style="background: #2d5016; border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-compass me-2"></i>Wisata Serupa</h5>
                    </div>
                    <div class="card-body p-3">
                        <?php foreach ($similar_wisata as $index => $similar): ?>
                            <a href="<?php echo base_url('wisata/detail/' . $similar['id'])?>" class="text-decoration-none">
                                <div class="similar-card">
                                    <div class="d-flex">
                                        <img src="<?php echo get_wisata_image($similar['foto'])?>"
                                             class="rounded me-3"
                                             style="width: 90px; height: 90px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark"><?php echo $similar['nama']?></h6>
                                            <small class="text-muted d-block mb-2">
                                                <i class="fas fa-map-marker-alt me-1"></i><?php echo substr($similar['alamat'], 0, 40)?>...
                                            </small>
                                            <div class="mb-1">
                                                <?php echo get_star_rating($similar['rating_avg'])?>
                                                <small class="text-muted">(<?php echo $similar['jumlah_rating']?>)</small>
                                            </div>
                                            <span class="badge bg-primary"><?php echo format_rupiah($similar['harga_tiket'])?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php if ($index < count($similar_wisata) - 1): ?>
                                <hr class="my-2">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reviewForm');
    if (!form) return;

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Mengirim...';

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
            });

            let data = null;
            try {
                data = await response.json();
            } catch (_) {
                // Biarkan handling di bawah ketika data null
            }

            if (!response.ok || !data || !data.success) {
                const message = data && data.message ? data.message : 'Ulasan gagal dikirim. Coba lagi.';
                throw new Error(message);
            }

            // Reload to show new review without berpindah halaman lain
            window.location.reload();
        } catch (err) {
            alert(err.message || 'Ulasan gagal dikirim. Coba lagi.');
            submitBtn.disabled = false;
            submitBtn.innerText = 'Kirim Ulasan';
        }
    });
});
</script>

<!-- JS FAVORITE TOGGLE -->
<script>
document.querySelectorAll('.btn-favorite').forEach(btn => {
    btn.addEventListener('click', function () {
        const wisataId = this.dataset.wisataId;
        const button  = this;
        const icon = button.querySelector('i');
        const section = button.closest('.favorite-section');
        const textDiv = section.querySelector('.favorite-text');

        fetch("<?php echo base_url('favorit/toggle')?>", {
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

            // Update icon
            if (data.favorited) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                button.title = 'Hapus dari Favorit';
                textDiv.textContent = 'Hapus Favorit';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                button.title = 'Tambah ke Favorit';
                textDiv.textContent = 'Tambah Favorit';
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Terjadi kesalahan, silakan coba lagi');
        });
    });
});
</script>
