
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin - Rekomendasi Wisata</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #ece7df;
            font-family: 'Montserrat', Arial, sans-serif;
        }
        .auth-wrapper {
            max-width: 900px;
            margin: 40px auto;
            background: #f7f4ee;
            border-radius: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            display: flex;
            overflow: hidden;
        }
        .auth-left {
            flex: 1;
            background: #e2dbce;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 30px;
        }
        .auth-left h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: #2d2d2d;
        }
        .icon-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }
        .icon-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
        }
        .auth-left h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2d2d2d;
        }
        .auth-left p {
            color: #6c6c6c;
            font-size: 1rem;
        }
        .auth-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 40px;
        }
        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #222;
        }
        .auth-desc {
            color: #7a7a7a;
            margin-bottom: 30px;
        }
        .auth-form label {
            font-weight: 600;
            color: #222;
            margin-bottom: 8px;
            display: block;
        }
        .auth-form input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            margin-bottom: 18px;
            font-size: 1rem;
            background: #f7f7f7;
            transition: border 0.2s;
        }
        .auth-form input:focus {
            border-color: #4a6b3d;
            outline: none;
        }
        .auth-form .btn-register {
            width: 100%;
            background: #222;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 18px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .auth-form .btn-register:hover {
            background: #4a6b3d;
        }
        .auth-form .divider {
            text-align: center;
            margin: 18px 0;
            color: #aaa;
            position: relative;
        }
        .auth-form .divider:before, .auth-form .divider:after {
            content: '';
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #e0e0e0;
            vertical-align: middle;
            margin: 0 8px;
        }
        .auth-form .btn-social {
            width: 100%;
            background: #f7f4ee;
            color: #222;
            border: 2px solid #e0e0e0;
            padding: 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.05rem;
            margin-bottom: 12px;
            cursor: pointer;
            transition: background 0.2s, border 0.2s;
        }
        .auth-form .btn-social:hover {
            background: #e2dbce;
            border-color: #4a6b3d;
        }
        .auth-form .login-link {
            text-align: center;
            margin-top: 18px;
            font-size: 1rem;
        }
        .auth-form .login-link a {
            color: #4a6b3d;
            font-weight: 700;
            text-decoration: none;
        }
        @media (max-width: 900px) {
            .auth-wrapper { flex-direction: column; }
            .auth-left, .auth-right { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-left">
            <h2>Wisata Jogja</h2>
            <div class="icon-grid">
                <div class="icon-box"><i class="fas fa-plane"></i></div>
                <div class="icon-box"><i class="fas fa-map"></i></div>
                <div class="icon-box"><i class="fas fa-camera"></i></div>
                <div class="icon-box"><i class="fas fa-backpack"></i></div>
                <div class="icon-box"><i class="fas fa-ticket"></i></div>
                <div class="icon-box"><i class="fas fa-star"></i></div>
            </div>
            <h3>Mulai Petualanganmu!</h3>
            <p>Daftar dan temukan destinasi favoritmu</p>
        </div>
        <div class="auth-right">
            <div class="auth-title">Daftar</div>
            <div class="auth-desc">Buat akun baru untuk mulai menjelajahi Yogyakarta</div>
            <form method="post" class="auth-form">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email" required>
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
                <small style="color:#888;display:block;margin-bottom:12px;">Minimal 6 karakter, gunakan kombinasi huruf dan angka</small>
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirm" placeholder="Konfirmasi password" required>
                <button type="submit" class="btn-register">Daftar Sekarang</button>
                <div class="divider">atau daftar dengan</div>
                <button type="button" class="btn-social"><i class="fab fa-google"></i> Daftar dengan Google</button>
                <div class="login-link">Sudah punya akun? <a href="<?= base_url('admin/auth/login') ?>">Login di sini</a></div>
            </form>
        </div>
    </div>
</body>
</html>
