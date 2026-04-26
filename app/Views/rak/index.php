<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">📚 Manajemen Rak</h3>
            <p class="text-muted small mb-0">Atur denah lokasi dan klasifikasi penyimpanan buku</p>
        </div>
        <a href="<?= base_url('rak/create') ?>" class="btn btn-info text-white rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Rak
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="get" action="<?= base_url('rak') ?>" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control border-start-0 bg-light shadow-none" 
                               placeholder="Cari berdasarkan nama rak atau lokasi spesifik..." 
                               value="<?= $keyword ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark rounded-3">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" width="80">ID</th>
                        <th>Identitas Rak</th>
                        <th>Titik Lokasi</th>
                        <th class="text-end pe-4" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rak)) : ?>
                        <?php foreach ($rak as $r): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted small fw-bold">#<?= $r['id_rak'] ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3 text-info">
                                        <i class="bi bi-layers-half fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= esc($r['nama_rak']) ?></div>
                                        <div class="extra-small text-muted text-uppercase tracking-wider">Kapasitas Tersedia</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    <?= esc($r['lokasi']) ?>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                    <a href="<?= base_url('rak/edit/' . $r['id_rak']) ?>" 
                                       class="btn btn-sm btn-outline-info px-3" title="Edit Lokasi">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('rak/delete/' . $r['id_rak']) ?>" 
                                       class="btn btn-sm btn-outline-danger px-3" 
                                       onclick="return confirm('Hapus data rak ini? Buku di dalamnya mungkin akan kehilangan referensi lokasi.')" 
                                       title="Hapus Rak">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-archive display-4 text-muted opacity-25"></i>
                                    <p class="mt-3 text-muted">Belum ada rak yang terdaftar.</p>
                                    <?php if (!empty($keyword)): ?>
                                        <a href="<?= base_url('rak') ?>" class="btn btn-sm btn-outline-secondary rounded-pill">Reset Pencarian</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    .table thead th { 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        color: #777;
        padding: 15px 10px;
    }
    .extra-small { font-size: 10px; font-weight: bold; }
    .tracking-wider { letter-spacing: 0.05rem; }
    .btn-outline-info:hover { color: white !important; }
</style>

<?= $this->endSection() ?>