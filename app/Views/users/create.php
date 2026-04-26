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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            overflow: hidden;
        }

        .register-header {
            background-color: #f8fdfa;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #eef2f0;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #11998e;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 28px;
            margin-bottom: 15px;
            box-shadow: 0 10px 20px rgba(17, 153, 142, 0.2);
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #555;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            background-color: #f1f3f5;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: #11998e;
            box-shadow: 0 0 0 4px rgba(17, 153, 142, 0.1);
        }

        .btn-register {
            background: linear-gradient(to right, #11998e, #38ef7d);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
            filter: brightness(1.1);
            color: white;
        }

        .login-link {
            color: #11998e;
            text-decoration: none;
            font-weight: 700;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .custom-file-upload {
            font-size: 0.75rem;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="register-card shadow-lg">
        <div class="register-header">
            <div class="icon-box">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h4 class="fw-bold mb-1">Bergabung Sekarang</h4>
            <p class="text-muted small mb-0">Lengkapi data untuk akses perpustakaan</p>
        </div>

        <div class="card-body p-4 p-md-5">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 small rounded-3 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">NAMA LENGKAP</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama sesuai identitas" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">EMAIL AKTIF</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">USERNAME</label>
                        <input type="text" name="username" class="form-control" placeholder="Username unik" required>
                    </div>
              
                        <label class="form-label">PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-success">FOTO PROFIL (OPSIONAL)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <div class="custom-file-upload italic">
                            <i class="bi bi-info-circle me-1"></i> Format: JPG, PNG, atau WEBP.
                        </div>
                    </div>

                    <div class="col-12 d-grid mt-4">
                        <button type="submit" class="btn btn-register">
                            Daftar Akun <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                        
                    </div>
                    
                </div>

                <div class="text-center mt-4 small text-muted">
                    Sudah memiliki akun? <a href="<?= base_url('login') ?>" class="login-link">Masuk di sini</a>
                </div>
            </form>
        </div>
        

    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>