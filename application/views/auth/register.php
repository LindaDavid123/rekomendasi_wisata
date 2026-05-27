<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Wisata Jogja</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

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
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .auth-container {
                border-radius: 15px;
            }
        }

        .auth-left {
            background: linear-gradient(135deg, #C8C3B8 0%, #D5D1C6 50%, #e0dcd1 100%);
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
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            bottom: -250px;
            left: -150px;
            animation: float 8s ease-in-out infinite;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -200px;
            right: -100px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }

        .auth-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d2d2d;
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-align: center;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .icon-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.2rem;
            margin: 2.5rem 0;
            max-width: 320px;
            width: 100%;
            z-index: 1;
        }

        .icon-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 1.4rem;
            text-align: center;
            font-size: 2.2rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid rgba(255, 255, 255, 0.5);
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            cursor: pointer;
        }

        .icon-box:hover {
            transform: translateY(-8px) scale(1.08);
            background: white;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.8);
        }

        .auth-heading {
            font-size: 1.9rem;
            font-weight: 800;
            color: #2d2d2d;
            margin-bottom: 0.8rem;
            text-align: center;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .auth-subtitle {
            color: #666;
            text-align: center;
            font-size: 1rem;
            line-height: 1.6;
            z-index: 1;
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
            font-size: 2.3rem;
            font-weight: 900;
            color: #1a1a1a;
            margin-bottom: 0.8rem;
            text-align: left;
        }

        .form-label {
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 0.6rem;
            font-size: 0.92rem;
            display: block;
        }

        .alert {
            padding: 1rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            padding-left: 3rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
            background: #fafafa;
        }

        .form-control:focus {
            outline: none;
            border-color: #5a8f4a;
            box-shadow: 0 0 0 4px rgba(90, 143, 74, 0.1);
            background: white;
        }

        .form-control::placeholder {
            color: #999;
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
            font-size: 1rem;
        }

        .btn-register {
            background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 1rem;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .divider {
            text-align: center;
            margin: 1.8rem 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
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

        .btn-google {
            border: 2px solid #D5D1C6;
            background: white;
            color: #2d2d2d;
            border-radius: 50px;
            padding: 0.85rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            margin-bottom: 0.8rem;
            text-decoration: none;
            display: block;
            text-align: center;
            width: 100%;
            cursor: pointer;
        }

        .btn-google:hover {
            border-color: #2d2d2d;
            background: #E8E4DC;
            color: #2d2d2d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            font-size: 0.95rem;
            padding-top: 1rem;
        }

        .login-link a {
            color: #2d2d2d;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #5a8f4a;
            text-decoration: underline;
        }

        .password-hint {
            font-size: 0.85rem;
            color: #999;
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-error {
            font-size: 0.82rem;
            color: #dc3545;
            margin-top: 0.4rem;
            display: block;
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
            padding: 1rem;
            font-size: 0.9rem;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }

        .mb-3 {
            margin-bottom: 1.3rem;
        }

        .mb-4 {
            margin-bottom: 1.8rem;
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

        .me-2 {
            margin-right: 0.5rem;
        }

        .w-100 {
            width: 100%;
        }

        /* Success Modal Styles */
        .success-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.3s ease-out;
        }

        .success-modal.show {
            display: flex;
        }

        .success-modal-content {
            background: white;
            padding: 3rem 2.5rem;
            border-radius: 20px;
            text-align: center;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideUp 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #5a8f4a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: scaleIn 0.5s ease-out 0.2s both;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        .success-modal h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2d2d2d;
            margin-bottom: 1rem;
        }

        .success-modal p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .success-modal .btn {
            background: #5a8f4a;
            color: white;
            padding: 0.9rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .success-modal .btn:hover {
            background: #4a7f3a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(90, 143, 74, 0.3);
        }

        .loading-spinner {
            display: none;
            margin-left: 10px;
        }

        .loading-spinner.show {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-row">
                <!-- Left Side - Info -->
                <div class="auth-left">
                    <div class="auth-logo">
                        <i class="fas fa-map-marked-alt"></i> Wisata Jogja
                    </div>

                    <div class="icon-grid">
                        <div class="icon-box">✈️</div>
                        <div class="icon-box">🗺️</div>
                        <div class="icon-box">📷</div>
                        <div class="icon-box">🎒</div>
                        <div class="icon-box">🎫</div>
                        <div class="icon-box">⭐</div>
                    </div>

                    <h2 class="auth-heading">Mulai Petualanganmu!</h2>
                    <p class="auth-subtitle">Daftar dan temukan destinasi favoritmu</p>
                </div>

                <!-- Right Side - Form -->
                <div class="auth-right">
                    <div class="form-wrapper">
                        <h1 class="auth-title">Daftar</h1>
                        <p style="color: #888; font-size: 0.95rem; margin-bottom: 2rem;">Buat akun baru untuk mulai menjelajahi Yogyakarta</p>

                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $this->session->flashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $this->session->flashdata('success') ?>
                    </div>
                    <?php endif; ?>

                    <?php echo validation_errors('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ', '</div>'); ?>

                    <form class="register-form" method="post" action="<?php echo base_url('auth/register') ?>">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <i class="fas fa-at input-icon"></i>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="<?php echo set_value('username') ?>" required>
                            </div>
                            <!-- <small class="form-error">Username sudah digunakan</small> -->
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="<?php echo set_value('email') ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <div class="password-hint">
                                <i class="fas fa-info-circle"></i>
                                Minimal 6 karakter, gunakan kombinasi huruf dan angka
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100" id="btnRegister">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                            <span class="loading-spinner" id="loadingSpinner"></span>
                        </button>
                    </form>

                    <div class="divider">
                        <span>atau daftar dengan</span>
                    </div>

                    <a href="#" class="btn btn-google w-100" onclick="alert('Google OAuth belum dikonfigurasi'); return false;">
                        <i class="fab fa-google me-2"></i> Daftar dengan Google
                    </a>

                    <div class="login-link">
                        Sudah punya akun? <a href="<?php echo base_url('auth/login') ?>">Login di sini</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="success-modal-content">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>🎉 Registrasi Berhasil!</h2>
            <p>Akun Anda telah berhasil dibuat. <br>Silakan login untuk memulai petualangan wisata Anda di Yogyakarta.</p>
            <a href="<?php echo base_url('auth/login') ?>" class="btn">
                <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
            </a>
        </div>
    </div>

    <script>
        // Show success modal if registration was successful
        <?php if ($this->session->flashdata('success')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('successModal').classList.add('show');

            // Play success sound (optional)
            // var audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBTGH0fPTgjMGHm7A7+OZSA0PVK3m77BdGAg+ltryxnMmBSuAzvLZiTYIG2m98OScTQwNUKXh8bllHgU9k9bxy3orBSR2xe/djj8KFV+16emoVRQLR6Df8r1uIAQwhM/z1YU0Bhxqvu7knUoND1On5O+zYRoGPJTY8cd0KAUtgM3y2Ik2Bhxov+zknE0MDFCK4fG5ZB0FO5LX88x6LAUjdsTv3I0/ChZftObpqFQVCkat4PC+bhwELYHO8tiIPQkeb8Lu5J1KCw5RpuTvsV4cBTuT1vLKeisFI3bE79yOQAkWX7Tp6ahUFQpGr+DwvW4dBC6B0/LXijQFHW/B7eSdSgwPVKfj8LJgGgY7k9jyx3UoBCuAzvLYiTUJHG6+7OKeSwwOUKTi8bhlHAQ6kdXyzHorBSJ2xO/djj8JFlmz5+mnVBULRq/g8L1uHQQugdHy14o0BR1ww+3knUoLDlSl5O+yYBoGOpPW8sh0JwQrgs/x2Yo1Bhxu');
            // audio.play();
        });
        <?php endif; ?>

        // Add loading spinner on form submit
        document.querySelector('.register-form').addEventListener('submit', function() {
            const btn = document.getElementById('btnRegister');
            const spinner = document.getElementById('loadingSpinner');
            btn.disabled = true;
            spinner.classList.add('show');
            btn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Memproses... <span class="loading-spinner show"></span>';
        });

        // Close modal when clicking outside
        document.getElementById('successModal').addEventListener('click', function(e) {
            if (e.target === this) {
                window.location.href = '<?php echo base_url('auth/login') ?>';
            }
        });
    </script>
</body>
</html>