<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">🏷️ Tambah Kategori</h3>
                    <p class="text-muted small">Kelompokkan koleksi buku Anda</p>
                </div>
                <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('kategori/store') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">NAMA KATEGORI</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                                <input type="text" name="nama_kategori" 
                                       class="form-control form-control-lg bg-light border-0" 
                                       placeholder="Misal: Fiksi, Teknologi, Sejarah..." 
                                       required autofocus>
                            </div>
                            <div class="form-text mt-2 small">
                                Pastikan kategori belum terdaftar sebelumnya untuk menghindari duplikasi.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                            </button>
                            <a href="<?= base_url('buku') ?>" class="btn btn-link btn-sm text-decoration-none text-muted">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-info-subtle border-0 rounded-4 d-flex align-items-start">
                <i class="bi bi-info-circle-fill text-info me-3 fs-4"></i>
                <div class="small text-info-emphasis">
                    Kategori yang Anda tambahkan di sini akan langsung muncul di pilihan dropdown saat menambah atau mengedit data buku.
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Fokus input styling */
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .input-group-text {
        border-radius: 0.5rem 0 0 0.5rem;
    }
    input.form-control {
        border-radius: 0 0.5rem 0.5rem 0;
    }
    .bg-info-subtle { background-color: #e0f7fa !important; }
</style>

<?= $this->endSection() ?>