<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="text-center mb-4">
                <div class="bg-info bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="bi bi-pencil-square text-info fs-2"></i>
                </div>
                <h3 class="fw-bold mb-1">Edit Lokasi Rak</h3>
                <p class="text-muted small">ID Rak: <span class="fw-bold text-dark">#<?= $rak['id_rak'] ?></span></p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="<?= base_url('rak/update/' . $rak['id_rak']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Nama / Kode Rak</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-tag-fill text-info"></i></span>
                                <input type="text" name="nama_rak" 
                                       class="form-control bg-light border-0" 
                                       value="<?= esc($rak['nama_rak']) ?>" 
                                       required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Lokasi Fisik</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt-fill text-info"></i></span>
                                <input type="text" name="lokasi" 
                                       class="form-control bg-light border-0" 
                                       value="<?= esc($rak['lokasi']) ?>" 
                                       required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info text-white btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-arrow-repeat me-1"></i> Perbarui Data Rak
                            </button>
                            <a href="<?= base_url('rak') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">Batalkan Perubahan</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="small text-muted italic">
                    <i class="bi bi-info-circle me-1"></i> Perubahan nama atau lokasi akan langsung berdampak pada penempatan koleksi buku.
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.15);
        border: 1px solid #0dcaf0 !important;
    }
    .input-group-text { border-radius: 0.75rem 0 0 0.75rem; }
    .form-control { border-radius: 0 0.75rem 0.75rem 0; }
    .italic { font-style: italic; }
</style>

<?= $this->endSection() ?>