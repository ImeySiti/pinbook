<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">👤 Profil Anggota</h3>
            <small class="text-muted">Kelola data diri kamu di Pinbook</small>
        </div>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- FORM -->
        <div class="col-md-7">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <form action="<?= base_url('anggota/store') ?>" method="post">

                        <!-- NISN -->
                        <div class="mb-3">
                            <label class="form-label">NISN</label>
                            <input type="text"
                                   name="nisn"
                                   class="form-control form-control-lg"
                                   value="<?= esc($anggota['nisn'] ?? '') ?>"
                                   placeholder="Masukkan NISN"
                                   required>
                        </div>

                        <!-- ALAMAT -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat"
                                      class="form-control form-control-lg"
                                      rows="3"
                                      placeholder="Masukkan alamat"
                                      required><?= esc($anggota['alamat'] ?? '') ?></textarea>
                        </div>

                        <!-- NO HP -->
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control form-control-lg"
                                   value="<?= esc($anggota['no_hp'] ?? '') ?>"
                                   placeholder="08xxxxxxxxxx"
                                   required>
                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="btn btn-primary w-100 btn-lg rounded-3">
                            💾 Simpan Profil
                        </button>

                    </form>

                </div>
            </div>

        </div>

        <!-- SIDE INFO -->
        <div class="col-md-5">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <h5 class="mb-3">📌 Tips Profil</h5>

                <ul class="list-unstyled mb-0">
                    <li class="mb-2">✔ Pastikan NISN sesuai data sekolah</li>
                    <li class="mb-2">✔ Gunakan nomor HP aktif</li>
                    <li class="mb-2">✔ Alamat harus jelas untuk pengiriman buku</li>
                </ul>

                <hr>

                <div class="text-muted small">
                    Profil yang lengkap membantu sistem Pinbook berjalan lebih optimal 📚
                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>