<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Admin - Wisata Jogja</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header p-3">
                <h4 class="text-white"><i class="fas fa-cog"></i> Admin Panel</h4>
            </div>
            
            <ul class="list-unstyled components">
                <li>
                    <a href="<?= base_url('admin/dashboard') ?>" class="text-white d-block p-3">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/wisata') ?>" class="text-white d-block p-3">
                        <i class="fas fa-map-marker-alt"></i> Kelola Wisata
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/users') ?>" class="text-white d-block p-3">
                        <i class="fas fa-users"></i> Kelola Users
                    </a>
                </li>
                <li>
                    <a href="<?= base_url() ?>" class="text-white d-block p-3">
                        <i class="fas fa-home"></i> Kembali ke Website
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('logout') ?>" class="text-white d-block p-3">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="ms-3"><?= isset($title) ? $title : 'Admin' ?></span>
                    <div class="ms-auto">
                        <span class="navbar-text">
                            <i class="fas fa-user"></i> <?= $this->session->userdata('nama') ?>
                        </span>
                    </div>
                </div>
            </nav>
            
            <div class="container-fluid mt-4">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $this->session->flashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $this->session->flashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
