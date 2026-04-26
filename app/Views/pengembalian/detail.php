<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <?php if (!empty($pengembalian)): ?>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">🧾 Detail Pengembalian</h3>
                <p class="text-muted small">ID Pengembalian: <span class="fw-bold text-dark">#RTN-<?= str_pad($pengembalian['id_pengembalian'] ?? 0, 5, '0', STR_PAD_LEFT) ?></span></p>
            </div>
            <a href="<?= base_url('pengembalian') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-uppercase mb-4" style="font-size: 0.8rem; letter-spacing: 1px;">Informasi Transaksi</h6>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-muted small d-block mb-1">NAMA ANGGOTA</label>
                                <p class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary"></i><?= esc($pengembalian['nama_anggota'] ?? '-') ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small d-block mb-1">BUKU YANG DIKEMBALIKAN</label>
                                <p class="fw-bold mb-0"><i class="bi bi-book me-2 text-primary"></i><?= esc($pengembalian['daftar_buku'] ?? '-') ?></p>
                            </div>
                            <hr class="my-2 opacity-25">
                            <div class="col-md-6">
                                <label class="text-muted small d-block mb-1">JATUH TEMPO SEHARUSNYA</label>
                                <p class="fw-bold mb-0 text-muted small"><i class="bi bi-calendar-event me-2"></i><?= esc($pengembalian['batas_kembali'] ?? '-') ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small d-block mb-1">TANGGAL DIKEMBALIKAN</label>
                                <p class="fw-bold mb-0 text-success"><i class="bi bi-calendar-check me-2"></i><?= esc($pengembalian['tgl_pengembalian'] ?? '-') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-light h-100">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                        <label class="text-muted small fw-bold text-uppercase mb-3">Ringkasan Denda</label>
                        
                        <div class="mb-3">
                            <h2 class="fw-bold mb-0 <?= ($pengembalian['jumlah_hari_telat'] ?? 0) > 0 ? 'text-danger' : 'text-success' ?>">
                                <?= $pengembalian['jumlah_hari_telat'] ?? 0 ?>
                            </h2>
                            <span class="small text-muted">Hari Terlambat</span>
                        </div>

                        <div class="p-3 bg-white rounded-4 shadow-sm mb-4">
                            <p class="small text-muted mb-1">Total Biaya Denda</p>
                            <h4 class="fw-bold mb-0 text-dark">Rp <?= number_format($pengembalian['total_denda'] ?? 0, 0, ',', '.') ?></h4>
                        </div>

                        <div class="mb-4">
                            <?php 
                            $status = $pengembalian['status_bayar'] ?? '';
                            if ($status == 'lunas'): ?>
                                <span class="badge bg-success-subtle text-success rounded-pill px-4 py-2 border border-success w-100">
                                    <i class="bi bi-check-circle-fill me-1"></i> Pembayaran Lunas
                                </span>
                            <?php elseif ($status == 'pending'): ?>
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-4 py-2 border border-warning w-100">
                                    <i class="bi bi-clock-history me-1"></i> Menunggu Konfirmasi
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-4 py-2 border border-danger w-100">
                                    <i class="bi bi-x-circle-fill me-1"></i> Belum Dibayar
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($pengembalian['total_denda']) && $pengembalian['total_denda'] > 0 && ($pengembalian['status_bayar'] ?? '') != 'lunas'): ?>
                            <a href="<?= base_url('transaksi/bayarDenda/' . ($pengembalian['id_peminjaman'] ?? '')) ?>" 
                               class="btn btn-danger btn-lg rounded-pill shadow-sm py-2">
                                <i class="bi bi-cash-stack me-2"></i> Bayar Denda Sekarang
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-search display-1 text-muted opacity-25"></i>
            <h4 class="mt-3 text-muted">Data pengembalian tidak ditemukan</h4>
            <a href="<?= base_url('pengembalian') ?>" class="btn btn-primary rounded-pill mt-3 px-4">Kembali ke Daftar</a>
        </div>
    <?php endif; ?>
</div>

<style>
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .badge { font-size: 0.85rem; letter-spacing: 0.5px; }
</style>

<?= $this->endSection() ?>