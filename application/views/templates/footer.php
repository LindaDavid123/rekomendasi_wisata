<?php 
// Cek apakah dashboard mode (user login dan di halaman dashboard)
$is_dashboard_mode = $this->session->userdata('user_id') && in_array($this->uri->segment(1), ['', 'wisata', 'rekomendasi', 'favorit', 'profil']);
?>
<?php if (!$is_dashboard_mode): ?>
    </div>
    <!-- End Main Content -->
<?php endif; ?>
    
<?php if (!$is_dashboard_mode): ?>
    <!-- Modern Footer -->
    <footer class="mt-5" style="background: linear-gradient(135deg, #2d5016 0%, #4a6b3d 100%);">
        <div class="container py-5">
            <div class="row text-white">
                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4 class="fw-bold mb-3">
                        <i class="fas fa-map-marked-alt me-2"></i>Wisata Jogja
                    </h4>
                    <p class="text-white-50">
                        Platform rekomendasi wisata terbaik di Yogyakarta dengan sistem Hybrid Collaborative dan Item-Based Filtering.
                    </p>
                    <div class="mt-3">
                        <a href="#" class="btn btn-outline-light rounded-circle me-2" style="width: 40px; height: 40px;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light rounded-circle me-2" style="width: 40px; height: 40px;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light rounded-circle me-2" style="width: 40px; height: 40px;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px;">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Jelajahi</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="fas fa-home me-2"></i>Home
                        </a></li>
                        <li class="mb-2"><a href="<?= base_url('wisata') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="fas fa-map me-2"></i>Wisata
                        </a></li>
                        <?php if ($this->session->userdata('user_id')): ?>
                            <li class="mb-2"><a href="<?= base_url('rekomendasi') ?>" class="text-white-50 text-decoration-none hover-link">
                                <i class="fas fa-magic me-2"></i>Rekomendasi
                            </a></li>
                            <li class="mb-2"><a href="<?= base_url('favorit') ?>" class="text-white-50 text-decoration-none hover-link">
                                <i class="fas fa-heart me-2"></i>Favorit
                            </a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Kategori -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Kategori Wisata</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url('wisata?kategori=alam') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="fas fa-tree me-2"></i>Wisata Alam
                        </a></li>
                        <li class="mb-2"><a href="<?= base_url('wisata?kategori=budaya') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="fas fa-landmark me-2"></i>Wisata Budaya
                        </a></li>
                        <li class="mb-2"><a href="<?= base_url('wisata?kategori=kuliner') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="fas fa-utensils me-2"></i>Wisata Kuliner
                        </a></li>
                        <li class="mb-2"><a href="<?= base_url('wisata?kategori=sejarah') ?>" class="text-white-50 text-decoration-none hover-link">
                            <i class="fas fa-book me-2"></i>Wisata Sejarah
                        </a></li>
                    </ul>
                </div>
                
                <!-- Kontak -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Yogyakarta, Indonesia
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            info@wisatajogja.com
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            +62 274 123456
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="border-top border-secondary py-3">
            <div class="container">
                <div class="row align-items-center text-white-50 small">
                    <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        &copy; <?= date('Y') ?> Wisata Jogja. All rights reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="text-white-50 text-decoration-none hover-link me-3">Privacy Policy</a>
                        <a href="#" class="text-white-50 text-decoration-none hover-link">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    
    <style>
        .hover-link:hover {
            color: #fff !important;
            transform: translateX(5px);
            transition: all 0.3s;
        }
    </style>
</body>
</html>
