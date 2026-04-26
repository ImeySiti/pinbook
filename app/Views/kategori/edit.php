<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">📝 Edit Kategori</h3>
                    <p class="text-muted small">Ubah nama kategori: <span class="text-primary fw-bold"><?= $kategori['nama_kategori'] ?></span></p>
                </div>
                <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('kategori/update/'.$kategori['id_kategori']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">NAMA KATEGORI</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-pencil-square text-warning"></i></span>
                                <input type="text" name="nama_kategori" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       value="<?= $kategori['nama_kategori'] ?>" 
                                       placeholder="Ubah nama kategori" 
                                       required autofocus>
                            </div>
                            <div class="form-text mt-2 small">
                                Perubahan nama kategori akan otomatis terupdate pada semua buku yang menggunakan kategori ini.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning text-white btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Kategori
                            </button>
                            <a href="<?= base_url('buku') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">Batal & Kembali</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Styling fokus untuk input */
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15); /* Shadow warna kuning tipis */
        border: 1px solid #ffc107 !important;
    }
    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
    }
    input.form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }
</style>

<?= $this->endSection() ?>