<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">🏷️ Manajemen Kategori</h3>
            <p class="text-muted small mb-0">Kelola kategori untuk klasifikasi buku yang lebih baik</p>
        </div>
        <a href="<?= base_url('kategori/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="get" action="<?= base_url('kategori') ?>" class="row g-2 justify-content-between">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="keyword" class="form-control border-start-0 bg-light" 
                               placeholder="Cari nama kategori..." value="<?= $keyword ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-dark rounded-3 px-4">Cari</button>
                    <?php if (!empty($keyword)): ?>
                        <a href="<?= base_url('kategori') ?>" class="btn btn-light border rounded-3">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8"> <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4" width="80">ID</th>
                                <th>Nama Kategori</th>
                                <th class="text-end pe-4" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kategori)) : ?>
                                <?php foreach ($kategori as $k): ?>
                                <tr>
                                    <td class="ps-4"><span class="badge bg-light text-dark border">#<?= $k['id_kategori'] ?></span></td>
                                    <td><span class="fw-bold text-dark"><?= $k['nama_kategori'] ?></span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="<?= base_url('kategori/edit/'.$k['id_kategori']) ?>" 
                                               class="btn btn-sm btn-outline-warning rounded-start-pill px-3">
                                                <i class="bi bi-pencil me-1"></i> Edit
                                            </a>
                                            <a href="<?= base_url('kategori/delete/'.$k['id_kategori']) ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-end-pill px-3"
                                               onclick="return confirm('Hapus kategori ini? Buku dengan kategori ini mungkin akan terpengaruh.')">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="bi bi-tag-fill mb-2 d-block fs-2 opacity-25"></i>
                                        Data kategori tidak ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 bg-primary text-white rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold"><i class="bi bi-lightbulb me-2"></i>Tips</h5>
                    <p class="small mb-0 opacity-75">
                        Gunakan kategori yang spesifik untuk mempermudah anggota dalam mencari buku. Anda bisa melihat statistik kategori terpopuler di halaman dashboard utama.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th { font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #666; }
    .btn-group .btn { font-size: 0.85rem; }
</style>

<?= $this->endSection() ?>