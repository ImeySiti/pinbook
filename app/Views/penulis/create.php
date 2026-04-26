<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="bi bi-person-plus text-primary fs-2"></i>
                </div>
                <h3 class="fw-bold mb-1">Tambah Penulis</h3>
                <p class="text-muted small">Daftarkan nama pengarang atau penulis baru</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('penulis/store') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase tracking-wider">Nama Lengkap Penulis</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-pencil-square text-muted"></i></span>
                                <input type="text" name="nama_penulis" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="Misal: Andrea Hirata" 
                                       required autofocus>
                            </div>
                            <div class="form-text mt-2 small text-muted">
                                <i class="bi bi-info-circle me-1"></i> Gunakan nama asli atau nama pena.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Simpan Data Penulis
                            </button>
                            <a href="<?= base_url('penulis') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                    Pinbook Library Engine v3.0
                </span>
            </div>

        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05rem; }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .input-group-text {
        border-radius: 0.75rem 0 0 0.75rem;
    }
    .form-control {
        border-radius: 0 0.75rem 0.75rem 0;
    }
</style>

<?= $this->endSection() ?>