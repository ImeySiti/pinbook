<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Pinbook Library</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            /* 📚 Background perpustakaan */
            background:
                linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.65)),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1600&q=80');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px 0;
        }

        .register-card {
            border: none;
            border-radius: 24px;
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            box-shadow: 0 25px 50px rgba(0,0,0,0.35);
            overflow: hidden;
        }

        .register-header {
            background: #f6fffb;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #e6f5ef;
        }

        .icon-box {
            width: 65px;
            height: 65px;
            background: #0f766e;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            font-size: 30px;
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: #555;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 14px;
            background-color: #f1f3f5;
            border: 2px solid transparent;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: #0f766e;
            box-shadow: 0 0 0 4px rgba(15,118,110,0.12);
        }

        .btn-register {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(15,118,110,0.3);
        }

        .login-link {
            color: #0f766e;
            font-weight: 700;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .custom-file-upload {
            font-size: 11px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="register-card">

        <div class="register-header">
            <div class="icon-box">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <h4 class="fw-bold mb-1">Bergabung Sekarang</h4>
            <p class="text-muted small mb-0">Daftar untuk akses perpustakaan</p>
        </div>

        <div class="card-body p-4 p-md-5">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 small rounded-3 mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label">NAMA LENGKAP</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">EMAIL</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">USERNAME</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">PASSWORD</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-success">FOTO (OPSIONAL)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <div class="custom-file-upload mt-1">
                            JPG / PNG / WEBP
                        </div>
                    </div>

                    <div class="col-12 d-grid mt-3">
                        <button type="submit" class="btn btn-register">
                            Daftar Akun
                        </button>
                    </div>

                </div>

                <div class="text-center mt-4 small text-muted">
                    Sudah punya akun?
                    <a href="<?= base_url('login') ?>" class="login-link">Masuk</a>
                </div>

            </form>
        </div>

    </div>

</body>

</html>