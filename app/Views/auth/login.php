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
            /* 📚 Background buku / perpustakaan */
            background: 
                linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.65)),
                url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1600&q=80');
            
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 25px 50px rgba(0,0,0,0.35);
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            padding: 40px 30px 10px;
        }

        .icon-box {
            width: 85px;
            height: 85px;
            background: #e8faf0;
            color: #0f766e;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 15px;
            font-size: 44px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 14px;
            background: #f1f3f5;
            border: 2px solid transparent;
        }

        .form-control:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15,118,110,0.15);
        }

        .input-group-text {
            background: #f1f3f5;
            border: none;
            color: #0f766e;
        }

        .btn-login {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            color: #fff;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15,118,110,0.3);
        }

        .footer-text {
            font-size: 13px;
            color: #6c757d;
        }

        .footer-text a {
            color: #0f766e;
            font-weight: 600;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-header">
            <div class="icon-box">
                <i class="bi bi-book-half"></i>
            </div>

            <h4 class="fw-bold mb-1">Pinbook Library</h4>
            <p class="text-muted small">Kelola literasi dengan lebih mudah</p>
        </div>

        <div class="card-body px-4 pb-4">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger small text-center border-0 rounded-3">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/auth') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">USERNAME</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person-circle"></i>
                        </span>
                        <input type="text" name="username" class="form-control shadow-none" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-shield-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control shadow-none" required>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-login">
                        MASUK <i class="bi bi-box-arrow-in-right ms-1"></i>
                    </button>
                </div>

                <div class="text-center footer-text">
                    Belum punya akun?
                    <a href="<?= base_url('users/create') ?>">Daftar</a>
                    <br>
                    <a href="<?= base_url('restore') ?>" class="text-danger small">
                        <i class="bi bi-database"></i> Restore DB
                    </a>
                </div>

            </form>
        </div>

    </div>

</body>

</html>