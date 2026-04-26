<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            
            <div class="text-center mb-4">
                <div class="bg-info bg-opacity-10 d-inline-block p-3 rounded-circle mb-3">
                    <i class="bi bi-layers text-info fs-2"></i>
                </div>
                <h3 class="fw-bold mb-1">Tambah Rak Baru</h3>
                <p class="text-muted small">Kelola organisasi penempatan buku di perpustakaan</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="<?= base_url('rak/store') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Nama / Kode Rak</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-muted"></i></span>
                                <input type="text" name="nama_rak" 
                                       class="form-control bg-light border-0" 
                                       placeholder="Misal: Rak Sains A1" 
                                       required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted text-uppercase">Lokasi Spesifik</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-muted"></i></span>
                                <input type="text" name="lokasi" 
                                       class="form-control bg-light border-0" 
                                       placeholder="Misal: Lantai 2, Samping Jendela" 
                                       required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info text-white btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-plus-circle me-1"></i> Simpan Lokasi Rak
                            </button>
                            <a href="<?= base_url('rak') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded-4 border-0">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb text-warning fs-4 me-3"></i>
                    <p class="small text-muted mb-0">
                        Pemberian nama rak yang unik memudahkan anggota dan petugas saat mencari buku secara fisik.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.15); /* Warna Info (Cyan) */
        border: 1px solid #0dcaf0 !important;
    }
    .input-group-text { border-radius: 0.75rem 0 0 0.75rem; }
    .form-control { border-radius: 0 0.75rem 0.75rem 0; }
</style>

<?= $this->endSection() ?>