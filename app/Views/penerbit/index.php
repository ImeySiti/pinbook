<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">🏢 Koleksi Penerbit</h3>
            <p class="text-muted small mb-0">Daftar perusahaan penerbit yang bekerja sama dengan perpustakaan</p>
        </div>
        <a href="<?= base_url('penerbit/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Penerbit
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="get" action="<?= base_url('penerbit') ?>" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control border-start-0 bg-light" 
                               placeholder="Cari berdasarkan nama atau alamat penerbit..." 
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
                        <th>Informasi Penerbit</th>
                        <th>Alamat Kantor</th>
                        <th class="text-end pe-4" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penerbit)) : ?>
                        <?php foreach ($penerbit as $p): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-muted border small">#<?= $p['id_penerbit'] ?></span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($p['nama_penerbit']) ?></div>
                                <div class="extra-small text-muted">Mitra Aktif</div>
                            </td>
                            <td>
                                <div class="small text-muted text-wrap" style="max-width: 350px;">
                                    <i class="bi bi-geo-alt me-1 text-danger"></i>
                                    <?= esc($p['alamat'] ?: 'Alamat belum dilengkapi') ?>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="<?= base_url('penerbit/edit/'.$p['id_penerbit']) ?>" 
                                       class="btn btn-sm btn-outline-warning px-3" title="Edit Data">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('penerbit/delete/'.$p['id_penerbit']) ?>" 
                                       class="btn btn-sm btn-outline-danger px-3" 
                                       onclick="return confirm('Hapus data penerbit ini?')" title="Hapus Data">
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
                                    <i class="bi bi-building-x display-4 text-muted opacity-25"></i>
                                    <p class="mt-3 text-muted">Data penerbit tidak ditemukan atau masih kosong.</p>
                                    <?php if (!empty($keyword)): ?>
                                        <a href="<?= base_url('penerbit') ?>" class="btn btn-sm btn-link">Lihat semua data</a>
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
    .extra-small { font-size: 10px; font-weight: bold; text-transform: uppercase; }
    .btn-group .btn:hover { color: white !important; }
</style>

<?= $this->endSection() ?>