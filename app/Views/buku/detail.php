<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">📖 Detail Informasi Buku</h3>
            <p class="text-muted small">Informasi lengkap mengenai koleksi pustaka</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('buku/wa/' . $buku['id_buku']) ?>" target="_blank" class="btn btn-success rounded-pill px-3">
                    <i class="bi bi-whatsapp me-2"></i>Kirim WA
                </a>
            <?php endif; ?>
            
            <a href="<?= (session()->get('role') == 'admin') ? base_url('buku') : base_url('peminjaman/create') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4 border-end">
                <?php if ($buku['cover']): ?>
                    <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>" 
                         class="img-fluid rounded-3 shadow" 
                         style="max-height: 400px; object-fit: cover;" 
                         alt="Cover Buku">
                <?php else: ?>
                    <div class="text-center text-muted">
                        <i class="bi bi-book" style="font-size: 5rem;"></i>
                        <p class="mt-2 small">Tidak ada cover</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-8">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2">
                            <?= $buku['nama_kategori'] ?>
                        </span>
                        <h2 class="fw-bold"><?= $buku['judul'] ?></h2>
                        <p class="text-muted"><i class="bi bi-person-fill me-1"></i> <?= $buku['nama_penulis'] ?></p>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="text-muted extra-small text-uppercase fw-bold" style="font-size: 10px;">ISBN</label>
                            <p class="fw-semibold"><?= $buku['isbn'] ?: '-' ?></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted extra-small text-uppercase fw-bold" style="font-size: 10px;">Penerbit</label>
                            <p class="fw-semibold"><?= $buku['nama_penerbit'] ?></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted extra-small text-uppercase fw-bold" style="font-size: 10px;">Tahun Terbit</label>
                            <p class="fw-semibold"><?= $buku['tahun_terbit'] ?></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted extra-small text-uppercase fw-bold" style="font-size: 10px;">Lokasi Rak</label>
                            <p class="fw-semibold text-success"><i class="bi bi-layers me-1"></i> <?= $buku['nama_rak'] ?> (<?= $buku['lokasi'] ?>)</p>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="row text-center bg-light rounded-4 p-3 mb-4 g-2">
                        <div class="col-4 border-end">
                            <label class="text-muted d-block small">Total Stok</label>
                            <span class="h5 fw-bold mb-0"><?= $buku['jumlah'] ?></span>
                        </div>
                        <div class="col-4 border-end">
                            <label class="text-muted d-block small">Tersedia</label>
                            <span class="h5 fw-bold mb-0 text-primary"><?= $buku['tersedia'] ?></span>
                        </div>
                        <div class="col-4">
                            <label class="text-muted d-block small">ID Buku</label>
                            <span class="h5 fw-bold mb-0">#<?= $buku['id_buku'] ?></span>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted extra-small text-uppercase fw-bold" style="font-size: 10px;">Sinopsis / Deskripsi</label>
                        <p class="text-secondary mt-2" style="line-height: 1.6; text-align: justify;">
                            <?= $buku['deskripsi'] ?: '<em>Tidak ada deskripsi untuk buku ini.</em>' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .extra-small { font-size: 10px; }
    .bg-primary-subtle { background-color: #e7f1ff; }
    .text-primary { color: #0d6efd !important; }
</style>

<?= $this->endSection() ?>