<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pinbook Library</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <style>
        body {
            /* Gradasi Hijau Alam */
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .login-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            background: #ffffff;
        }

        .login-header {
            padding: 40px 30px 20px;
            text-align: center;
        }

        /* Lingkaran Ikon Hijau */
        .login-header .icon-box {
            width: 85px;
            height: 85px;
            background: #e8faf0;
            color: #11998e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 20px;
            font-size: 45px;
            box-shadow: inset 0 0 10px rgba(17, 153, 142, 0.1);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            background-color: #f1f3f5;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #11998e;
            box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
        }

        .input-group-text {
            border-radius: 12px 0 0 12px !important;
            background-color: #f1f3f5;
            color: #11998e !important;
        }

        /* Tombol Hijau */
        .btn-login {
            background: linear-gradient(to right, #11998e, #38ef7d);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: bold;
            color: white;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
            color: white;
            filter: brightness(1.1);
        }

        .footer-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .footer-text a {
            color: #11998e;
            text-decoration: none;
            transition: 0.2s;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-card card">
        <div class="login-header">
            <div class="icon-box">
                <i class="bi bi-book-half"></i>
            </div>
            <h4 class="fw-bold text-dark">Pinbook Library</h4>
            <p class="text-muted small">Kelola literasi dengan sentuhan jari</p>
        </div>

        <div class="card-body px-4 pb-5">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 small shadow-sm mb-4 rounded-3 py-2 text-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/auth') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">USERNAME</label>
                    <div class="input-group">
                        <span class="input-group-text border-0"><i class="bi bi-person-circle"></i></span>
                        <input type="text" name="username" class="form-control shadow-none" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text border-0"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password" class="form-control shadow-none" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-login shadow-sm text-uppercase">
                        Masuk Sekarang <i class="bi bi-box-arrow-in-right ms-2"></i>
                    </button>
                </div>

                <div class="text-center footer-text">
                    Belum memiliki akun? 
                    
                    <a href="<?= base_url('users/create') ?>" class="fw-bold">Daftar Anggota</a>
                    <a href="<?= base_url('restore') ?>" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-database"></i> Restore DB
                    </a>
                </div>
                
            </form>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>