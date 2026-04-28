<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-person-circle text-warning fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Edit Profil</h3>
                        <p class="text-muted small mb-0">Perbarui data akun kamu</p>
                    </div>
                </div>

                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">

                    <!-- ✅ FIX: tidak pakai profile/update/{id} lagi -->
                    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row g-4">

                            <!-- FOTO -->
                            <div class="col-md-4 text-center border-end">
                                <label class="form-label fw-bold text-muted small mb-3 d-block">FOTO PROFIL</label>

                                <div class="position-relative d-inline-block mb-3">
                                    <?php if (!empty($user['foto'])): ?>
                                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>"
                                            id="previewFoto"
                                            class="rounded-circle img-thumbnail shadow-sm"
                                            style="width:150px;height:150px;object-fit:cover;">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/img/default-user.png') ?>"
                                            id="previewFoto"
                                            class="rounded-circle img-thumbnail shadow-sm"
                                            style="width:150px;height:150px;object-fit:cover;">
                                    <?php endif; ?>

                                    <label for="fotoInput"
                                        class="btn btn-warning btn-sm rounded-circle shadow position-absolute bottom-0 end-0 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </label>
                                </div>

                                <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*">

                                <small class="text-muted">Klik ikon untuk mengganti foto</small>
                            </div>

                            <!-- FORM -->
                            <div class="col-md-8">

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">NAMA</label>
                                    <input type="text" name="nama"
                                        class="form-control bg-light border-0"
                                        value="<?= esc($user['nama']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">EMAIL</label>
                                    <input type="email" name="email"
                                        class="form-control bg-light border-0"
                                        value="<?= esc($user['email']) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">USERNAME</label>
                                    <input type="text" name="username"
                                        class="form-control bg-light border-0"
                                        value="<?= esc($user['username']) ?>" required>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-muted small">PASSWORD BARU</label>
                                    <input type="password" name="password"
                                        class="form-control bg-light border-0"
                                        placeholder="Kosongkan jika tidak diubah">
                                    <small class="text-danger">Kosongkan jika tidak ingin mengubah password</small>
                                </div>

                            </div>

                        </div>

                        <div class="mt-4 d-grid">
                            <button type="submit" class="btn btn-warning text-white btn-lg rounded-pill fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
const fotoInput = document.getElementById('fotoInput');
const previewFoto = document.getElementById('previewFoto');

fotoInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        previewFoto.src = URL.createObjectURL(file);
    }
});
</script>

<style>
.bg-light { background-color: #f8f9fa !important; }
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 .2rem rgba(255,193,7,.25);
}
</style>

<?= $this->endSection() ?>