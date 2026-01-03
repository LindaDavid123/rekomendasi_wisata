<style>
    .auth-page {
        min-height: 100vh;
        background: #E8E4DC;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .auth-container {
        max-width: 1100px;
        width: 100%;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }
    @media (max-width: 992px) {
        .auth-container {
            border-radius: 15px;
        }
    }
    .auth-left {
        background: linear-gradient(135deg, #D5D1C6 0%, #e0dcd1 100%);
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        min-height: 650px;
    }
    @media (max-width: 992px) {
        .auth-left {
            min-height: 400px;
            padding: 2.5rem 2rem;
        }
    }
    .auth-left::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        bottom: -250px;
        left: -150px;
    }
    .auth-logo {
        font-size: 1.4rem;
        font-weight: 800;
        color: #2d2d2d;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        text-align: center;
    }
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.2rem;
        margin: 2.5rem 0;
        max-width: 320px;
        width: 100%;
    }
    .icon-box {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 16px;
        padding: 1.4rem;
        text-align: center;
        font-size: 2.2rem;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.4);
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .icon-box:hover {
        transform: translateY(-5px) scale(1.05);
        background: white;
    }
    .auth-heading {
        font-size: 1.8rem;
        font-weight: 800;
        color: #2d2d2d;
        margin-bottom: 0.8rem;
        text-align: center;
    }
    .auth-subtitle {
        color: #777;
        text-align: center;
        font-size: 0.95rem;
        line-height: 1.6;
    }
    .auth-right {
        padding: 4rem 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: white;
        min-height: 650px;
    }
    @media (max-width: 992px) {
        .auth-right {
            min-height: auto;
            padding: 2.5rem 2rem;
        }
    }
    .form-wrapper {
        width: 100%;
        max-width: 380px;
    }
    .auth-title {
        font-size: 2.2rem;
        font-weight: 900;
        color: #1a1a1a;
        margin-bottom: 0.8rem;
        text-align: left;
    }
    .auth-subtitle-form {
        color: #888;
        font-size: 0.95rem;
        margin-bottom: 2rem;
        text-align: left;
        line-height: 1.6;
    }
    .form-label {
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 0.6rem;
        font-size: 0.92rem;
        display: block;
    }
    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        padding-left: 3rem;
        font-size: 0.9rem;
        transition: all 0.3s;
        width: 100%;
    }
    .form-control:focus {
        border-color: #5a8f4a;
        box-shadow: 0 0 0 3px rgba(90, 143, 74, 0.1);
    }
    .input-group {
        position: relative;
    }
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        z-index: 10;
    }
    .btn-login {
        background: #2d2d2d;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.9rem;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s;
        margin-top: 1.5rem;
        width: 100%;
    }
    .btn-login:hover {
        background: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        color: white;
    }
    .divider {
        text-align: center;
        margin: 1.2rem 0;
        position: relative;
    }
    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background: #e0e0e0;
    }
    .divider::before { left: 0; }
    .divider::after { right: 0; }
    .divider span {
        background: white;
        padding: 0 1rem;
        color: #999;
        font-size: 0.85rem;
    }
    .btn-google, .btn-apple {
        border: 2px solid #D5D1C6;
        background: white;
        color: #2d2d2d;
        border-radius: 50px;
        padding: 0.8rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
        margin-bottom: 0.8rem;
        text-decoration: none;
        display: block;
        text-align: center;
        width: 100%;
    }
    .btn-google:hover, .btn-apple:hover {
        border-color: #2d2d2d;
        background: #E8E4DC;
        color: #2d2d2d;
        transform: translateY(-2px);
    }
    .forgot-link {
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        float: right;
        margin-top: 0.25rem;
    }
    .forgot-link:hover {
        color: #2d2d2d;
        text-decoration: underline;
    }
    .signup-link {
        text-align: center;
        margin-top: 1.2rem;
        color: #666;
        font-size: 0.9rem;
    }
    .signup-link a {
        color: #2d2d2d;
        font-weight: 600;
        text-decoration: none;
    }
    .signup-link a:hover {
        text-decoration: underline;
    }
    .auth-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr;
    }
    @media (max-width: 992px) {
        .auth-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-row">
                <!-- Left Side - Info -->
                <div class="auth-left">
                    <div class="auth-logo">
                        <i class="fas fa-map-marked-alt"></i> Wisata Jogja
                    </div>
                    
                    <div class="icon-grid">
                        <div class="icon-box">🏝️</div>
                        <div class="icon-box">🏛️</div>
                        <div class="icon-box">🏔️</div>
                        <div class="icon-box">🎪</div>
                        <div class="icon-box">🌋</div>
                        <div class="icon-box">🏖️</div>
                    </div>
                    
                    <h2 class="auth-heading">Jelajahi Yogyakarta</h2>
                    <p class="auth-subtitle">Temukan destinasi wisata impianmu</p>
                </div>
                
                <!-- Right Side - Form -->
                <div class="auth-right">
                    <div class="form-wrapper">
                        <h1 class="auth-title">Login</h1>
                        <p class="auth-subtitle-form">Selamat datang kembali! Silakan masuk ke akun Anda</p>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?= form_open('auth/login') ?>
                        <div class="mb-3">
                            <label class="form-label">Username atau Email</label>
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email" required value="<?= set_value('username') ?>">
                            </div>
                            <?= form_error('username', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <a href="#" class="forgot-link">Forgot Password?</a>
                        <div class="clearfix"></div>
                        
                        <button type="submit" class="btn btn-login w-100">Log In</button>
                    <?= form_close() ?>
                    
                    <div class="divider">
                        <span>or</span>
                    </div>
                    
                    <a href="#" class="btn btn-google w-100" onclick="alert('Google OAuth belum dikonfigurasi'); return false;">
                        <i class="fab fa-google me-2"></i> Continue with Google
                    </a>
                    
                    <a href="#" class="btn btn-apple w-100" onclick="alert('Apple Sign-in belum tersedia'); return false;">
                        <i class="fab fa-apple me-2"></i> Continue with Apple
                    </a>
                    
                    <div class="signup-link">
                        Belum punya akun? <a href="<?= base_url('auth/register') ?>">Daftar di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


