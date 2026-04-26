<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">🏢 Tambah Penerbit</h3>
                    <p class="text-muted small">Daftarkan mitra penerbit buku baru</p>
                </div>
                <a href="<?= base_url('penerbit') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('penerbit/store') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">NAMA PENERBIT</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-building text-primary"></i></span>
                                <input type="text" name="nama_penerbit" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="Misal: PT. Gramedia Pustaka Utama" 
                                       required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">ALAMAT KANTOR</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 align-items-start pt-2">
                                    <i class="bi bi-geo-alt text-danger"></i>
                                </span>
                                <textarea name="alamat" rows="4" 
                                          class="form-control bg-light border-0" 
                                          placeholder="Masukkan alamat lengkap kantor penerbit..."></textarea>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Simpan Penerbit
                            </button>
                            <a href="<?= base_url('penerbit') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
    }
    .form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }
    textarea.form-control {
        border-radius: 0 0.5rem 0.5rem 0;
        resize: none;
    }
</style>

<?= $this->endSection() ?>