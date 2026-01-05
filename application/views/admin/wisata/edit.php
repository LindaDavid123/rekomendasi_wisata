<!DOCTYPE html>
<html>
<head>
    <title>Edit Wisata - Admin</title>
    <style>
        /* Style form only, no sidebar */
    </style>
</head>
<body style="background:#f7f4ee;">
    <div style="max-width:500px;margin:40px auto;padding:32px;background:#fff;border-radius:18px;box-shadow:0 2px 12px rgba(74,107,61,0.08);">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                <h2 style="color:#2d5016;font-weight:700;margin:0;">Edit Wisata</h2>
                <a href="<?= base_url('admin/wisata') ?>" style="background:#7fb1e3;color:#fff;padding:10px 22px;border:none;border-radius:14px;font-weight:600;font-size:1rem;text-decoration:none;transition:background 0.2s;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <form method="post" action="<?= base_url('admin/wisata/edit/'.$wisata['id']) ?>" enctype="multipart/form-data">
                <div style="margin-bottom:18px;">
                                    <div style="margin-bottom:18px;">
                                        <label>Foto Wisata</label>
                                        <input type="file" name="foto" accept="image/*" class="form-control" style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                                        <?php if (!empty($wisata['foto'])): ?>
                                            <div style="margin-top:10px;">
                                                <img src="<?= base_url('uploads/'.$wisata['foto']) ?>" alt="Foto Wisata" style="max-width:100%;height:auto;border-radius:8px;">
                                            </div>
                                        <?php endif; ?>
                    <label>Nama Wisata</label>
                    <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($wisata['nama']) ?>" style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                        <option value="alam" <?= $wisata['kategori']=='alam'?'selected':'' ?>>Alam</option>
                        <option value="budaya" <?= $wisata['kategori']=='budaya'?'selected':'' ?>>Budaya</option>
                        <option value="sejarah" <?= $wisata['kategori']=='sejarah'?'selected':'' ?>>Sejarah</option>
                        <option value="kuliner" <?= $wisata['kategori']=='kuliner'?'selected':'' ?>>Kuliner</option>
                        <option value="belanja" <?= $wisata['kategori']=='belanja'?'selected':'' ?>>Belanja</option>
                        <option value="edukasi" <?= $wisata['kategori']=='edukasi'?'selected':'' ?>>Edukasi</option>
                        <option value="hiburan" <?= $wisata['kategori']=='hiburan'?'selected':'' ?>>Hiburan</option>
                    </select>
                </div>
                <div style="margin-bottom:18px;">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;resize:none;height:90px;"><?= htmlspecialchars($wisata['deskripsi']) ?></textarea>
                </div>
                <div style="margin-bottom:18px;">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required value="<?= htmlspecialchars($wisata['alamat']) ?>" style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label>Latitude</label>
                    <input type="text" name="latitude" class="form-control" value="<?= htmlspecialchars($wisata['latitude']) ?>" style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label>Longitude</label>
                    <input type="text" name="longitude" class="form-control" value="<?= htmlspecialchars($wisata['longitude']) ?>" style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label>Harga Tiket</label>
                    <input type="number" name="harga_tiket" class="form-control" required value="<?= htmlspecialchars($wisata['harga_tiket']) ?>" style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label>Status</label>
                    <select name="status" class="form-control" required style="display:block;width:100%;box-sizing:border-box;padding:10px;border-radius:8px;border:1px solid #ccc;">
                        <option value="active" <?= $wisata['status']=='active'?'selected':'' ?>>Aktif</option>
                        <option value="nonactive" <?= $wisata['status']=='nonactive'?'selected':'' ?>>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" style="background:#4a6b3d;color:#fff;padding:12px 28px;border:none;border-radius:18px;font-weight:600;font-size:1.1rem;cursor:pointer;">Update</button>
            </form>
        </div>
</body>
</html>
