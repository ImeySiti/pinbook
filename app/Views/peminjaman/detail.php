<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

<?php if (!empty($peminjaman)): ?>

<?php
    $today = date('Y-m-d');
    $status = $peminjaman['status'] ?? 'dipinjam';
    $tgl_kembali = $peminjaman['tanggal_kembali'] ?? null;

    if ($status != 'kembali' && $tgl_kembali && $tgl_kembali < $today) {
        $status = 'terlambat';
    }

    $statusConfig = [
        'kembali' => ['color' => 'success', 'icon' => 'bi-check-circle-fill', 'label' => 'Dikembalikan'],
        'terlambat' => ['color' => 'danger', 'icon' => 'bi-exclamation-octagon-fill', 'label' => 'Terlambat'],
        'diperpanjang' => ['color' => 'info', 'icon' => 'bi-arrow-repeat', 'label' => 'Diperpanjang'],
        'dipinjam' => ['color' => 'warning', 'icon' => 'bi-clock-history', 'label' => 'Sedang Dipinjam'],
    ];

    $currentStatus = $statusConfig[$status] ?? $statusConfig['dipinjam'];
?>

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">📄 Detail Peminjaman</h3>
        <p class="text-muted small">
            ID Transaksi: <b>#TRX-<?= str_pad($peminjaman['id_peminjaman'], 5, '0', STR_PAD_LEFT) ?></b>
        </p>
    </div>

    <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary rounded-pill px-4">
        ← Kembali
    </a>
</div>

<div class="row g-4">

    <!-- INFO UTAMA -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 rounded-4 p-4">

            <!-- STATUS -->
            <div class="d-flex align-items-center mb-4 p-3 bg-<?= $currentStatus['color'] ?>-subtle rounded-4">
                <i class="bi <?= $currentStatus['icon'] ?> fs-2 text-<?= $currentStatus['color'] ?> me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0 text-<?= $currentStatus['color'] ?>">
                        <?= $currentStatus['label'] ?>
                    </h5>
                    <small class="text-muted">Status transaksi</small>
                </div>
            </div>

            <!-- DATA UTAMA (tanpa peminjam & petugas) -->
            <div class="row g-4">

                <div class="col-sm-6">
                    <label class="text-muted small text-uppercase fw-bold">Tanggal Pinjam</label>
                    <p class="h6 fw-bold">
                        <i class="bi bi-calendar-event me-2"></i>
                        <?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])) ?>
                    </p>
                </div>

                <div class="col-sm-6">
                    <label class="text-muted small text-uppercase fw-bold">Jatuh Tempo</label>
                    <p class="h6 fw-bold text-danger">
                        <i class="bi bi-calendar-x me-2"></i>
                        <?= date('d M Y', strtotime($peminjaman['tanggal_kembali'])) ?>
                    </p>
                </div>

            </div>

        </div>
    </div>

    <!-- BUKU -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 rounded-4 p-4">

            <h6 class="fw-bold mb-3">📚 Buku yang Dipinjam</h6>

            <?php if (!empty($buku)): ?>
                <?php foreach ($buku as $b): ?>
                    <div class="p-3 mb-3 bg-light rounded-4 d-flex align-items-center">

                        <i class="bi bi-book fs-4 text-primary me-3"></i>

                        <div>
                            <div class="fw-bold"><?= $b['judul'] ?? '-' ?></div>
                            <small class="text-muted">ISBN: <?= $b['isbn'] ?? 'N/A' ?></small>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted text-center">Tidak ada buku</p>
            <?php endif; ?>

        </div>
    </div>

</div>

<?php else: ?>

<div class="text-center py-5">
    <h4 class="text-muted">Data tidak ditemukan</h4>
    <a href="<?= base_url('peminjaman') ?>" class="btn btn-primary mt-3">
        Kembali
    </a>
</div>

<?php endif; ?>

</div>

<style>
.bg-success-subtle { background:#d1e7dd; }
.bg-danger-subtle { background:#f8d7da; }
.bg-warning-subtle { background:#fff3cd; }
.bg-info-subtle { background:#cff4fc; }
</style>

<?= $this->endSection() ?>