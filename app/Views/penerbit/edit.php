<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">📝 Edit Penerbit</h3>
                    <p class="text-muted small">Mengubah data: <span class="text-warning fw-bold"><?= esc($penerbit['nama_penerbit']) ?></span></p>
                </div>
                <a href="<?= base_url('penerbit') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('penerbit/update/'.$penerbit['id_penerbit']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">NAMA PENERBIT</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-building text-warning"></i></span>
                                <input type="text" name="nama_penerbit" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       value="<?= esc($penerbit['nama_penerbit']) ?>" 
                                       placeholder="Nama instansi penerbit" 
                                       required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">ALAMAT LENGKAP</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 align-items-start pt-2">
                                    <i class="bi bi-geo-alt text-warning"></i>
                                </span>
                                <textarea name="alamat" rows="4" 
                                          class="form-control bg-light border-0" 
                                          placeholder="Masukkan alamat kantor..."><?= esc($penerbit['alamat']) ?></textarea>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning text-white btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Data Penerbit
                            </button>
                            <a href="<?= base_url('penerbit') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">Batal & Batalkan Perubahan</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <small class="text-muted">ID Penerbit: <strong>#<?= $penerbit['id_penerbit'] ?></strong></small>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        border: 1px solid #ffc107 !important;
    }
    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
    }
    .form-control, textarea.form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }
    textarea.form-control {
        resize: none;
    }
</style>

<?= $this->endSection() ?>