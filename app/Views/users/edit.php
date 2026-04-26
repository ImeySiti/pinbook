<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-pencil-square text-warning fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Perbarui Profil</h3>
                        <p class="text-muted small mb-0">ID User: <span class="fw-bold text-dark">#<?= $user['id'] ?></span></p>
                    </div>
                </div>
                <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= base_url('profile/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row g-4">
                            <div class="col-md-4 text-center border-end">
                                <label class="form-label fw-bold text-muted small d-block mb-3">FOTO PROFIL</label>
                                <div class="position-relative d-inline-block mb-3">
                                    <?php if ($user['foto']): ?>
                                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" 
                                             id="previewFoto" 
                                             class="rounded-circle img-thumbnail shadow-sm" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?= base_url('assets/img/default-user.png') ?>" 
                                             id="previewFoto" 
                                             class="rounded-circle img-thumbnail shadow-sm" 
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                    
                                    <div class="position-absolute bottom-0 end-0">
                                        <label for="fotoInput" class="btn btn-warning btn-sm rounded-circle shadow text-white">
                                            <i class="bi bi-pencil"></i>
                                        </label>
                                    </div>
                                </div>
                                <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*">
                                <p class="extra-small text-muted italic">Klik ikon pensil untuk mengganti foto profil.</p>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted">NAMA LENGKAP</label>
                                        <input type="text" name="nama" class="form-control bg-light border-0" value="<?= esc($user['nama']) ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">EMAIL</label>
                                        <input type="email" name="email" class="form-control bg-light border-0" value="<?= esc($user['email']) ?>" required>
                                    </div>

                

                                    <div class="col-12"><hr class="my-2 opacity-25"></div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">USERNAME</label>
                                        <input type="text" name="username" class="form-control bg-light border-0 text-muted" value="<?= esc($user['username']) ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">PASSWORD BARU</label>
                                        <input type="password" name="password" class="form-control bg-light border-0" placeholder="Biarkan kosong jika tidak diubah">
                                        <div class="extra-small text-danger mt-1 italic">*Kosongkan jika ingin tetap menggunakan password lama.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 d-grid">
                            <button type="submit" class="btn btn-warning btn-lg text-white rounded-pill shadow-sm fw-bold">
                                <i class="bi bi-arrow-repeat me-1"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert bg-warning-subtle border-0 rounded-4 mt-4 p-3 small d-flex align-items-start">
                <i class="bi bi-info-circle-fill text-warning me-2 fs-5"></i>
                <div class="text-warning-emphasis">
                    <strong>Catatan:</strong> Mengubah <em>Role</em> akan langsung mempengaruhi hak akses pengguna tersebut di seluruh fitur aplikasi. Pastikan Anda memberikan hak akses yang sesuai.
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Live Preview Foto yang baru dipilih
    const fotoInput = document.getElementById('fotoInput');
    const previewFoto = document.getElementById('previewFoto');

    fotoInput.onchange = evt => {
        const [file] = fotoInput.files;
        if (file) {
            previewFoto.src = URL.createObjectURL(file);
        }
    }
</script>

<style>
    .bg-light { background-color: #f8f9fa !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .extra-small { font-size: 10px; }
    .italic { font-style: italic; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        border: 1px solid #ffc107 !important;
    }
</style>

<?= $this->endSection() ?>