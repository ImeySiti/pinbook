<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="text-center mb-4">
                <div class="bg-warning bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="bi bi-pencil-square text-warning fs-2"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Penulis</h3>
                <p class="text-muted small">Memperbarui informasi nama penulis</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('penulis/update/'.$penulis['id_penulis']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase tracking-wider">Nama Penulis</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="nama_penulis" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       value="<?= esc($penulis['nama_penulis']) ?>" 
                                       placeholder="Nama penulis" 
                                       required autofocus>
                            </div>
                            <div class="form-text mt-2 small text-muted italic">
                                <i class="bi bi-info-circle me-1"></i> ID Penulis: <strong>#<?= $penulis['id_penulis'] ?></strong>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning text-white btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="<?= base_url('penulis') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">
                                Batal & Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4 opacity-50">
                <p class="extra-small">Terakhir diakses: <?= date('d/m/Y H:i') ?></p>
            </div>

        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05rem; }
    .extra-small { font-size: 10px; }
    .italic { font-style: italic; }
    
    /* Custom Focus Style untuk Edit Mode */
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        border: 1px solid #ffc107 !important;
    }
    
    .input-group-text {
        border-radius: 0.75rem 0 0 0.75rem;
    }
    .form-control {
        border-radius: 0 0.75rem 0.75rem 0;
    }
</style>

<?= $this->endSection() ?>