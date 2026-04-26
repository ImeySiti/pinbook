<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="d-flex align-items-center mb-4">
                <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3">
                    <i class="bi bi-cash-stack text-success fs-3"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0">Catat Transaksi</h3>
                    <p class="text-muted small mb-0">Input pembayaran ongkir atau denda anggota</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form method="post" action="<?= base_url('transaksi/store') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">ID PEMINJAMAN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-hash text-success"></i></span>
                                <input type="text" name="id_peminjaman" class="form-control bg-light border-0 py-2 shadow-none" placeholder="Contoh: PMJ-001" required>
                            </div>
                            <div class="form-text extra-small italic">Pastikan ID Peminjaman sudah sesuai dengan data di sistem.</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">JENIS PEMBAYARAN</label>
                                <select name="jenis" class="form-select bg-light border-0 py-2 shadow-none" required>
                                    <option value="ongkir">🚚 Ongkir</option>
                                    <option value="denda">⚠️ Denda</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">METODE</label>
                                <select name="metode" class="form-select bg-light border-0 py-2 shadow-none" required>
                                    <option value="cash">💵 Cash (Tunai)</option>
                                    <option value="qris">📱 QRIS</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold small text-muted">NOMINAL JUMLAH (RP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white border-0 fw-bold">Rp</span>
                                <input type="number" name="jumlah" class="form-control bg-light border-0 py-3 fs-5 fw-bold shadow-none" placeholder="0" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="<?= base_url('transaksi') ?>" class="btn btn-light px-4 rounded-pill fw-bold text-muted">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm fw-bold flex-grow-1">
                                <i class="bi bi-check2-circle me-1"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-light rounded-4 border-0 d-flex align-items-center shadow-sm">
                <i class="bi bi-shield-lock-fill text-success fs-4 me-3"></i>
                <p class="mb-0 small text-muted">
                    Setiap transaksi yang disimpan akan tercatat secara permanen di laporan keuangan harian.
                </p>
            </div>

        </div>
    </div>
</div>

<style>
    .bg-light { background-color: #f8f9fa !important; }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #198754 !important;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1) !important;
    }
    .extra-small { font-size: 11px; }
    .italic { font-style: italic; }
    
    /* Chrome, Safari, Edge, Opera - Remove arrows from number input */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<?= $this->endSection() ?>