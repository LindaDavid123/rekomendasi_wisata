<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Wisata - Admin</title>
</head>
<body style="background:#f7f4ee;">
    <style>
        .sidebar-admin {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: 240px;
            background: #23282d;
            color: #fff;
            padding: 28px 0 0 0;
            z-index: 100;
            height: 100vh;
            box-shadow: 2px 0 12px rgba(0,0,0,0.04);
        }
        .sidebar-admin h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 28px 32px;
            color: #fff;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }
        .sidebar-admin h2 i {
            margin-right: 10px;
        }
        .sidebar-admin ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-admin ul li {
            margin-bottom: 10px;
        }
        .sidebar-admin ul li a {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            font-size: 1.08rem;
            padding: 12px 32px;
            border-radius: 8px 0 0 8px;
            transition: background 0.18s;
        }
        .sidebar-admin ul li a:hover, .sidebar-admin ul li.active a {
            background: #1a1d21;
        }
        .sidebar-admin ul li a i {
            margin-right: 12px;
            font-size: 1.15rem;
        }
        .main-content-admin {
            margin-left: 240px;
            padding: 0 32px;
        }
        .wisata-header {
            font-size: 2rem;
            font-weight: 700;
            color: #2d5016;
            margin-bottom: 30px;
        }
        .btn-tambah {
            background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 18px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 18px;
            cursor: pointer;
            transition: background 0.2s, transform 0.3s cubic-bezier(.68,-0.55,.27,1.55), box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(74,107,61,0.10);
        }
        .btn-tambah:hover {
            background: #2d5016;
            transform: scale(1.04) translateY(-2px);
            box-shadow: 0 8px 24px rgba(74,107,61,0.18);
        }
        .table {
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(74,107,61,0.08);
            background: #fff;
            overflow: hidden;
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
        .aksi-btn {
            background: #4a6b3d;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 8px 18px;
            font-weight: 600;
            margin-right: 6px;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }
        .aksi-btn:hover {
            background: #2d5016;
            transform: scale(1.08);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="sidebar-admin">
        <h2><i class="fas fa-cog"></i> Admin Panel</h2>
        <ul>
            <li><a href="<?= base_url('admin/dashboard') ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="active"><a href="<?= base_url('admin/wisata') ?>"><i class="fas fa-map-marker-alt"></i> Kelola Wisata</a></li>
            <li><a href="<?= base_url('admin/users') ?>"><i class="fas fa-users"></i> Kelola Users</a></li>
            <li><a href="<?= base_url() ?>"><i class="fas fa-home"></i> Kembali ke Website</a></li>
            <li><a href="<?= base_url('admin/auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="main-content-admin">
        <div class="wisata-header">Daftar Wisata</div>
        <a href="<?= base_url('admin/wisata/tambah') ?>" class="btn-tambah"><i class="fas fa-plus"></i> Tambah Wisata</a>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr><th>Nama</th><th>Kategori</th><th>Harga Tiket</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($wisata) && is_array($wisata)): foreach ($wisata as $w): ?>
                    <tr>
                        <td><?= htmlspecialchars($w['nama']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($w['kategori']) ?></span></td>
                        <td>Rp <?= number_format($w['harga_tiket'],0,',','.') ?></td>
                        <td><span class="badge bg-success text-white"><?= htmlspecialchars($w['status']) ?></span></td>
                        <td>
                            <a href="<?= base_url('admin/wisata/edit/'.$w['id']) ?>" class="aksi-btn"><i class="fas fa-edit"></i> Edit</a>
                            <a href="<?= base_url('admin/wisata/hapus/'.$w['id']) ?>" class="aksi-btn" onclick="return confirm('Hapus data?')"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center">Data wisata belum tersedia.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
