<?php 
    $avatar_options = [
        'avatar:girl' => '👧 Cewek',
        'avatar:boy' => '👦 Cowok',
        'avatar:cat' => '🐱 Kucing',
        'avatar:dog' => '🐶 Anjing',
        'avatar:fox' => '🦊 Rubah',
        'avatar:panda' => '🐼 Panda',
        'avatar:flower' => '🌸 Bunga',
        'avatar:flower_lily' => '🌷 Bunga Lili',
        'avatar:flower_blue' => '🪻 Bunga Biru',
        'avatar:flower_yellow' => '🌼 Bunga Kuning',
        'avatar:butterfly' => '🦋 Kupu-kupu',
        'avatar:bunny' => '🐰 Kelinci',
        'avatar:robot' => '🤖 Robot',
    ];
    $foto_value = $user['foto'] ?? null;
    $current_avatar = ($foto_value && strpos($foto_value, 'avatar:') === 0) ? $foto_value : '';
?>

<style>
    .profile-edit-wrapper { max-width: 900px; margin: 0 auto; }
    .card-modern { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
    .card-header-modern { background: linear-gradient(135deg, #2d5016 0%, #4a6b3d 100%); color: white; padding: 18px 22px; }
    .card-header-modern h4 { margin: 0; font-weight: 700; letter-spacing: 0.3px; }
    .form-label { font-weight: 600; color: #2d5016; }
    .form-control { border-radius: 10px; border-color: #dfe5dc; }
    .form-control:focus { border-color: #4a6b3d; box-shadow: 0 0 0 0.2rem rgba(74,107,61,0.15); }
    .btn-primary { background: linear-gradient(135deg, #2d5016 0%, #4a6b3d 100%); border: none; border-radius: 12px; font-weight: 700; }
    .btn-primary:hover { background: linear-gradient(135deg, #3a6b2b 0%, #5a8f4a 100%); box-shadow: 0 8px 18px rgba(45,80,22,0.25); }
    .btn-secondary { border-radius: 12px; font-weight: 600; }
    
    .avatar-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
        gap: 16px; 
        margin-top: 16px;
    }
    
    .avatar-option { 
        border: 2px solid #e5e5e5; 
        border-radius: 16px; 
        padding: 14px 10px; 
        text-align: center; 
        background: linear-gradient(135deg, #f8f9fa 0%, #f0f5f2 100%);
        cursor: pointer; 
        transition: all 0.3s ease;
        position: relative;
    }
    
    .avatar-option:hover { 
        border-color: #4a6b3d; 
        box-shadow: 0 8px 20px rgba(74, 107, 61, 0.15);
        transform: translateY(-4px);
    }
    
    .avatar-option input { display: none; }
    
    .avatar-option img { 
        width: 85px; 
        height: 85px; 
        border-radius: 14px; 
        object-fit: cover; 
        margin-bottom: 10px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        transition: all 0.2s ease;
        background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%); /* default bg */
    }
    .avatar-option img[src*="girl.png"] {
        background: linear-gradient(135deg, #ffe2f2 0%, #fff6fa 100%);
    }
    .avatar-option img[src*="boy.png"] {
        background: linear-gradient(135deg, #e2f0ff 0%, #f6fbff 100%);
    }
    
    .avatar-option .avatar-name { 
        font-weight: 600; 
        color: #2d5016; 
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .avatar-option input:checked + img {
        outline: 3px solid #4a6b3d;
        outline-offset: 3px;
        box-shadow: 0 0 0 2px white, 0 0 15px rgba(74, 107, 61, 0.3);
        transform: scale(1.05);
    }
    
    .avatar-option input:checked ~ .avatar-name { 
        color: #2d5016;
        font-weight: 700;
    }
    
    .avatar-option input:checked ~ .avatar-badge {
        display: block;
        position: absolute;
        top: 5px;
        right: 5px;
        background: linear-gradient(135deg, #4a6b3d 0%, #5a8f4a 100%);
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }
    
    .avatar-badge { display: none; }
    
    .helper-text { color: #6c757d; }
</style>

<div class="container py-5 profile-edit-wrapper">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h4 class="mb-0">Edit Profil</h4>
                </div>
                <div class="card-body p-4 p-md-5">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors() ?>
                        </div>
                    <?php endif; ?>
                    
                    <?= form_open_multipart('profil/update') ?>
                        <div class="text-center mb-4">
                            <img src="<?= get_user_image($foto_value) ?>" id="imagePreview" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="Profile">
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="display: block; margin-bottom: 12px; font-size: 15px;">
                                <i class="fas fa-image me-2" style="color: #4a6b3d;"></i>Pilih Avatar Karakter/Hewan/Bunga
                            </label>
                            <div class="avatar-grid">
                                <?php foreach ($avatar_options as $value => $label): ?>
                                    <label class="avatar-option">
                                        <input type="radio" name="avatar_choice" value="<?= $value ?>" <?= $current_avatar === $value ? 'checked' : '' ?>>
                                        <?php if ($value === 'avatar:girl'): ?>
                                            <img src="<?= base_url('assets/images/girl.png') ?>" alt="<?= $label ?>">
                                        <?php elseif ($value === 'avatar:boy'): ?>
                                            <img src="<?= base_url('assets/images/boy.png') ?>" alt="<?= $label ?>">
                                        <?php else: ?>
                                            <img src="<?= get_user_image($value) ?>" alt="<?= $label ?>">
                                        <?php endif; ?>
                                        <div class="avatar-badge"><i class="fas fa-check"></i></div>
                                        <div class="avatar-name"><?= $label ?></div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted d-block mt-3">
                                <i class="fas fa-info-circle me-1"></i>Pilih avatar jika tidak ingin mengunggah foto. Jika Anda mengunggah foto, foto akan dipakai dan avatar diabaikan.
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG (Max 2MB)</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?? '' ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?? '' ?>" required>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3">Ganti Password (Opsional)</h5>
                        <p class="helper-text small">Kosongkan jika tidak ingin mengganti password</p>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirm" class="form-control">
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="<?= base_url('profil') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
