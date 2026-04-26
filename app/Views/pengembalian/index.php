<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">📜 Riwayat Pengembalian</h3>
            <p class="text-muted small">Data log buku yang telah dikembalikan oleh anggota</p>
        </div>
        <div class="text-end text-muted small">
            <i class="bi bi-info-circle me-1"></i> Total: <strong><?= count($pengembalian) ?></strong> Data
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 text-center">No</th>
                        <th>Informasi Anggota</th>
                        <th class="text-center">Linimasa</th>
                        <th>Denda</th>
                        <th class="text-center">Status Bayar</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengembalian)): ?>
                        <?php $no = 1; foreach ($pengembalian as $p): ?>
                        <tr>
                            <td class="ps-4 text-center text-muted small"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= esc($p['nama_anggota'] ?? '-') ?></div>
                                <div class="extra-small text-muted text-uppercase">Buku Terlampir</div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="small text-muted" title="Tanggal Pinjam"><?= esc($p['tanggal_pinjam'] ?? '-') ?></span>
                                    <i class="bi bi-arrow-down small opacity-25"></i>
                                    <span class="small fw-bold text-success" title="Tanggal Kembali Realitas">
                                        <?= ($p['tanggal_dikembalikan'] != '-') ? date('d/m/Y', strtotime($p['tanggal_dikembalikan'])) : '-' ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold <?= ($p['denda'] ?? 0) > 0 ? 'text-danger' : 'text-dark' ?>">
                                    Rp <?= number_format($p['denda'] ?? 0, 0, ',', '.') ?>
                                </div>
                                <div class="extra-small text-muted">Beban Denda</div>
                            </td>
                            <td class="text-center">
                                <?php if (($p['status_bayar'] ?? 'belum') == 'lunas'): ?>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 border border-success">
                                        <i class="bi bi-check-circle-fill me-1"></i> Lunas
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 border border-danger">
                                        <i class="bi bi-x-circle-fill me-1"></i> Belum Bayar
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <?php if (($p['status_bayar'] ?? 'belum') != 'lunas'): ?>
                                    <a href="<?= base_url('pengembalian/bayar/'.$p['id_pengembalian']) ?>" 
                                       class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-cash-stack me-1"></i> Bayar
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small italic">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x display-4 d-block mb-2 opacity-25"></i>
                                Tidak ada data pengembalian yang valid ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .extra-small { font-size: 10px; font-weight: 600; letter-spacing: 0.5px; }
    .table thead th { 
        font-size: 11px; 
        text-transform: uppercase; 
        color: #777; 
        padding: 15px 10px; 
    }
    .btn-sm { font-size: 11px; font-weight: 600; }
</style>

<?= $this->endSection() ?>