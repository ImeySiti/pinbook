<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $role = session()->get('role'); ?>

<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">✍️ Manajemen Penulis</h3>
            <p class="text-muted small mb-0">Kelola daftar pengarang buku dan pantau riwayat pengembalian</p>
        </div>
        <?php if ($role == 'admin'): ?>
            <a href="<?= base_url('penulis/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Penulis
            </a>
        <?php endif; ?>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-3">
            <form method="get" action="<?= base_url('penulis') ?>" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control border-start-0 bg-light shadow-none" 
                               placeholder="Cari nama penulis..." value="<?= $keyword ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-dark rounded-3">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-person-lines-fill fs-4 text-primary me-2"></i>
                <h5 class="fw-bold mb-0">Daftar Penulis</h5>
            </div>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3" width="60">ID</th>
                                <th>Nama Penulis</th>
                                <?php if ($role == 'admin'): ?>
                                    <th class="text-center">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($penulis)) : ?>
                                <?php foreach ($penulis as $p): ?>
                                <tr>
                                    <td class="ps-3 text-muted small">#<?= $p['id_penulis'] ?></td>
                                    <td class="fw-semibold"><?= esc($p['nama_penulis']) ?></td>
                                    <?php if ($role == 'admin'): ?>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= base_url('penulis/edit/'.$p['id_penulis']) ?>" class="btn btn-sm btn-outline-warning border-0"><i class="bi bi-pencil"></i></a>
                                                <a href="<?= base_url('penulis/delete/'.$p['id_penulis']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus data?')"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center py-4 text-muted small">Penulis tidak ditemukan</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<style>
    .bg-light { background-color: #f8f9fa !important; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 10px; }
    .bg-secondary-subtle { background-color: #e2e3e5 !important; }
    .btn-group .btn:hover { background-color: rgba(0,0,0,0.05); }
</style>

<?= $this->endSection() ?>