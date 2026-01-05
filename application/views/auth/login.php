<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wisata Jogja</title>
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

        .btn-login {
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

        .btn-login:hover {
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .btn-login:active {
            transform: translateY(-1px);
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

        .btn-google:hover, .btn-apple:hover {
            border-color: #2d2d2d;
            background: #E8E4DC;
            color: #2d2d2d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .forgot-link {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            float: right;
            margin-top: 0.4rem;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #5a8f4a;
            text-decoration: underline;
        }

        .signup-link {
            text-align: center;
            margin-top: 1.2rem;
            color: #666;
            font-size: 0.95rem;
        }

        .signup-link a {
            color: #2d2d2d;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: #5a8f4a;
            text-decoration: underline;
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

        .alert-success {
            background: #efe;
            color: #3c3;
            border-left: 4px solid #3c3;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1.3rem;
        }

        .mb-4 {
            margin-bottom: 1.8rem;
        }

        .mt-3 {
            margin-top: 1.3rem;
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

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .text-danger {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }

        /* Alert Styles */
        .alert {
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            animation: slideDown 0.4s ease-out;
            border-left: 4px solid;
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

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left-color: #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left-color: #dc3545;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
        }

        .alert i {
            font-size: 1.3rem;
        }

        .alert-success i {
            color: #28a745;
        }

        .alert-danger i {
            color: #dc3545;
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
                        <h1 class="auth-title mb-2">Masuk ke Akun Anda</h1>
                        <p class="auth-subtitle-form mb-4">Selamat datang kembali! Silakan login untuk melanjutkan eksplorasi wisata Jogja.</p>

                        <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo $this->session->flashdata('success')?></span>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo $this->session->flashdata('error')?></span>
                        </div>
                        <?php endif; ?>

                        <?php echo validation_errors('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i><span>', '</span></div>'); ?>


                        <div class="divider"><span>atau login dengan akun</span></div>

                        <form method="post" action="<?php echo base_url('auth/login')?>">
                            <div class="mb-3">
                                <label class="form-label" for="username">Username atau Email</label>
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username atau email" required>
                                </div>
                                <!-- <small class="text-danger">Username atau email tidak ditemukan</small> -->
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                </div>
                                <!-- <small class="text-danger">Password salah</small> -->
                            </div>
                            <a href="#" class="forgot-link">Lupa Password?</a>
                            <div class="clearfix"></div>
                            <button type="submit" class="btn btn-login w-100">Masuk</button>
                        </form>
                        <a href="<?php echo base_url('auth/google_login')?>" class="btn btn-google w-100 mb-2 mt-2">
                            <i class="fab fa-google me-2"></i> Masuk dengan Google
                        </a>

                        <div class="signup-link mt-3">
                            Belum punya akun? <a href="<?php echo base_url('auth/register')?>">Daftar di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.animation = 'slideUp 0.3s ease-out';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>