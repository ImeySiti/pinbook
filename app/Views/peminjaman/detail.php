<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <?php if (!empty($peminjaman)): ?>
        
        <?php
            $today = date('Y-m-d');
            $status = $peminjaman['status'] ?? 'dipinjam';
            $tgl_kembali = $peminjaman['tanggal_kembali'] ?? null;

            // Logika Auto Status Terlambat
            if ($status != 'kembali' && $tgl_kembali && $tgl_kembali < $today) {
                $status = 'terlambat';
            }

            // Konfigurasi Warna & Ikon Status
            $statusConfig = [
                'kembali' => ['color' => 'success', 'icon' => 'bi-check-circle-fill', 'label' => 'Dikembalikan'],
                'terlambat' => ['color' => 'danger', 'icon' => 'bi-exclamation-octagon-fill', 'label' => 'Terlambat'],
                'diperpanjang' => ['color' => 'info', 'icon' => 'bi-arrow-repeat', 'label' => 'Diperpanjang'],
                'dipinjam' => ['color' => 'warning', 'icon' => 'bi-clock-history', 'label' => 'Sedang Dipinjam'],
            ];
            $currentStatus = $statusConfig[$status] ?? $statusConfig['dipinjam'];
        ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">📄 Detail Peminjaman</h3>
                <p class="text-muted small">ID Transaksi: <span class="fw-bold text-dark">#TRX-<?= str_pad($peminjaman['id_peminjaman'], 5, '0', STR_PAD_LEFT) ?></span></p>
            </div>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4 p-3 bg-<?= $currentStatus['color'] ?>-subtle rounded-4">
                            <div class="display-6 text-<?= $currentStatus['color'] ?> me-3">
                                <i class="bi <?= $currentStatus['icon'] ?>"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-<?= $currentStatus['color'] ?>"><?= $currentStatus['label'] ?></h5>
                                <small class="text-muted">Status transaksi saat ini</small>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Peminjam (Anggota)</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?= $peminjaman['nama_anggota'] ?? '-' ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Petugas Admin</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                                        <i class="bi bi-shield-check text-success"></i>
                                    </div>
                                    <span class="fw-bold text-dark"><?= $peminjaman['nama_petugas'] ?? '-' ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Tanggal Pinjam</label>
                                <p class="h6 fw-bold"><i class="bi bi-calendar-event me-2 text-muted"></i><?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])) ?></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Jatuh Tempo</label>
                                <p class="h6 fw-bold text-danger"><i class="bi bi-calendar-x me-2"></i><?= date('d M Y', strtotime($peminjaman['tanggal_kembali'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h6 class="fw-bold mb-0">📚 Buku yang Dipinjam</h6>
                    </div>
                    <div class="card-body p-4">
                        <?php if (!empty($buku)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($buku as $b): ?>
                                    <div class="list-group-item border-0 px-0 mb-3 bg-light rounded-4 p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 bg-white p-2 rounded-3 shadow-sm me-3">
                                                <i class="bi bi-book text-primary fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h6 class="mb-1 fw-bold text-truncate"><?= $b['judul'] ?? '-' ?></h6>
                                                <small class="text-muted d-block">ISBN: <?= $b['isbn'] ?? 'N/A' ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-archive text-muted display-4"></i>
                                <p class="text-muted mt-2">Tidak ada data buku</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center py-5">
            <img src="<?= base_url('assets/img/empty.svg') ?>" width="200" class="mb-3">
            <h4 class="text-muted">Data peminjaman tidak ditemukan</h4>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-primary rounded-pill mt-3 px-4">Kembali ke Daftar</a>
        </div>
    <?php endif; ?>
</div>

<style>
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-info-subtle { background-color: #cff4fc; }
    .list-group-item { transition: 0.3s; }
    .list-group-item:hover { transform: translateX(5px); }
</style>

<?= $this->endSection() ?>