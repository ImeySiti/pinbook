<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">✏️ Koreksi Pengembalian</h3>
                    <p class="text-muted small">Update status pembayaran atau penyesuaian denda</p>
                </div>
                <a href="<?= base_url('pengembalian') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-bold text-uppercase">Data Referensi</span>
                    <span class="badge bg-white text-dark border shadow-sm small">ID #<?= $pengembalian['id_pengembalian'] ?></span>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('pengembalian/update/' . $pengembalian['id_pengembalian']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-4 p-3 bg-primary-subtle rounded-3 border-0">
                            <div class="row small">
                                <div class="col-6 mb-2">
                                    <span class="text-muted d-block">Peminjam:</span>
                                    <span class="fw-bold"><?= esc($pengembalian['nama_anggota'] ?? 'N/A') ?></span>
                                </div>
                                <div class="col-6 mb-2 text-end">
                                    <span class="text-muted d-block">Tgl Kembali:</span>
                                    <span class="fw-bold text-success"><?= esc($pengembalian['tgl_pengembalian'] ?? '-') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">NOMINAL DENDA (RP)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0 text-danger fw-bold">Rp</span>
                                <input type="number" name="denda" 
                                       class="form-control bg-white border-start-0 ps-0 fw-bold" 
                                       value="<?= $pengembalian['denda'] ?? 0 ?>" 
                                       min="0">
                            </div>
                            <div class="form-text extra-small mt-2 italic text-muted">Ubah nominal jika terdapat denda tambahan (misal: buku rusak).</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">STATUS PEMBAYARAN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-credit-card-2-front"></i></span>
                                <select name="status_bayar" class="form-select bg-light border-0">
                                    <option value="belum" <?= ($pengembalian['status_bayar'] ?? '') == 'belum' ? 'selected' : '' ?>>
                                        🔴 Belum Bayar
                                    </option>
                                    <option value="lunas" <?= ($pengembalian['status_bayar'] ?? '') == 'lunas' ? 'selected' : '' ?>>
                                        🟢 Lunas
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-save me-2"></i> Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-warning border-0 rounded-4 mt-4 p-3 small d-flex">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    Perubahan denda akan mempengaruhi riwayat keuangan perpustakaan. Pastikan Anda telah menerima bukti bayar fisik/digital sebelum mengubah status menjadi <strong>Lunas</strong>.
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .extra-small { font-size: 11px; }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: none;
    }
    .input-group-text { border-radius: 0.5rem 0 0 0.5rem; }
    .form-control, .form-select { border-radius: 0 0.5rem 0.5rem 0; }
</style>

<?= $this->endSection() ?>