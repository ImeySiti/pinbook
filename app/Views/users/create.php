<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                    <i class="bi bi-person-plus-fill text-primary fs-3"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">Registrasi User Baru</h3>
                    <p class="text-muted small mb-0">Tambahkan akun pengelola atau anggota ke dalam sistem</p>
                </div>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div><?= session()->getFlashdata('error') ?></div>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row g-4">
                            <div class="col-md-4 text-center border-end">
                                <label class="form-label fw-bold text-muted small d-block mb-3">FOTO PROFIL</label>
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="<?= base_url('assets/img/default-user.png') ?>" 
                                         id="previewFoto" 
                                         class="rounded-circle img-thumbnail shadow-sm" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="fotoInput" class="btn btn-primary btn-sm rounded-circle shadow">
                                            <i class="bi bi-camera"></i>
                                        </label>
                                    </div>
                                </div>
                                <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*">
                                <p class="extra-small text-muted px-2 italic">Format: JPG, PNG. Maks 2MB. Kosongkan jika tidak ada foto.</p>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                                        <input type="text" name="nama" class="form-control bg-light border-0 py-2" placeholder="Masukkan nama sesuai identitas" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">EMAIL</label>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-2" placeholder="contoh@mail.com" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">ROLE / HAK AKSES</label>
                                        <select name="role" class="form-select bg-light border-0 py-2" required>
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="admin">🛡️ Admin</option>
                                            <option value="petugas">🔑 Petugas</option>
                                            <option value="anggota">📖 Anggota</option>
                                        </select>
                                    </div>

                                    <div class="col-12"><hr class="my-2 opacity-25"></div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">USERNAME</label>
                                        <input type="text" name="username" class="form-control bg-light border-0 py-2" placeholder="Gunakan huruf & angka" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">PASSWORD</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="passInput" class="form-control bg-light border-0 py-2" placeholder="Minimal 8 karakter" required>
                                            <button class="btn btn-light border-0" type="button" id="togglePass">
                                                <i class="bi bi-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('login') ?>" class="text-decoration-none small text-primary fw-bold">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm fw-bold">
                                <i class="bi bi-check2-circle me-1"></i> Simpan User Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Preview Foto sebelum Upload
    const fotoInput = document.getElementById('fotoInput');
    const previewFoto = document.getElementById('previewFoto');

    fotoInput.onchange = evt => {
        const [file] = fotoInput.files;
        if (file) {
            previewFoto.src = URL.createObjectURL(file);
        }
    }

    // Toggle Lihat Password
    const togglePass = document.getElementById('togglePass');
    const passInput = document.getElementById('passInput');

    togglePass.addEventListener('click', function() {
        const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });
</script>

<style>
    .bg-light { background-color: #f8f9fa !important; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .extra-small { font-size: 10px; }
    .italic { font-style: italic; }
</style>

<?= $this->endSection() ?>