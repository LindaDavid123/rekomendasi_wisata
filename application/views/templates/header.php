<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Wisata Jogja</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<?php 
// Cek apakah halaman home dan user belum login (landing page)
$is_landing_page = (!$this->session->userdata('user_id') && $this->uri->segment(1) == '');
// Cek apakah halaman wisata atau dashboard (hide navbar brand)
$is_wisata_page = in_array($this->uri->segment(1), ['wisata', 'rekomendasi', 'favorit', 'profil']);
// Cek apakah user sudah login (dashboard mode) - termasuk dashboard, wisata, rekomendasi, favorit, profil
$is_dashboard_mode = $this->session->userdata('user_id') && in_array($this->uri->segment(1), ['dashboard', 'wisata', 'rekomendasi', 'favorit', 'profil']);
?>
<?php if ($is_landing_page || $is_wisata_page): ?>
    <!-- Landing Page / Wisata Page: No header navbar -->
<?php elseif (!$is_dashboard_mode): ?>
    <!-- Regular Navbar (untuk halaman non-dashboard) -->
  
                <!-- Search Bar (tengah) -->
                <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 400px; width: 100%;" action="<?= base_url('wisata') ?>" method="get">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-start-0" placeholder="Cari destinasi wisata..." 
                               value="<?= $this->input->get('q') ?>" style="border-radius: 0 25px 25px 0;">
                    </div>
                </form>
                
                <!-- Menu Kanan -->
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="<?= base_url() ?>">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="<?= base_url('wisata') ?>">
                            <i class="fas fa-map me-1"></i>Wisata
                        </a>
                    </li>
                    
                    <?php if ($this->session->userdata('user_id')): ?>
                        <li class="nav-item">
                            <a class="nav-link px-3" href="<?= base_url('rekomendasi') ?>">
                                <i class="fas fa-magic me-1"></i>Rekomendasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 position-relative" href="<?= base_url('favorit') ?>">
                                <i class="fas fa-heart me-1"></i>Favorit
                            </a>
                        </li>
                        
                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center px-3" href="#" id="navbarDropdown" 
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= get_user_image($this->session->userdata('foto')) ?>" 
                                     class="rounded-circle me-2" width="32" height="32" 
                                     style="object-fit: cover; border: 2px solid #5a8f4a;">
                                <span class="d-none d-lg-inline"><?= $this->session->userdata('nama') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="fw-bold"><?= $this->session->userdata('nama') ?></div>
                                    <small class="text-muted"><?= $this->session->userdata('email') ?></small>
                                </li>
                                <li><a class="dropdown-item py-2" href="<?= base_url('profil') ?>">
                                    <i class="fas fa-user-circle me-2"></i>Profil Saya
                                </a></li>
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2" href="<?= base_url('admin') ?>">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                                    </a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="<?= base_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-success rounded-pill px-4" href="<?= base_url('login') ?>">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-success rounded-pill px-4" href="<?= base_url('register') ?>" 
                               style="background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?>
    
<?php if (!$is_dashboard_mode && !$is_wisata_page): ?>
    <!-- Main Content (untuk non-dashboard pages) -->
    <div class="main-content">
<?php endif; ?>
