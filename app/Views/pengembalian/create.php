<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">📥 Form Pengembalian</h3>
                    <p class="text-muted small">Catat pengembalian buku dan hitung denda jika ada</p>
                </div>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="post" action="<?= base_url('pengembalian/simpan') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">ID TRANSAKSI PEMINJAMAN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-hash text-primary"></i></span>
                                <select name="id_peminjaman" class="form-select bg-light border-0" required>
                                    <option value="" disabled selected>-- Pilih ID Peminjaman --</option>
                                    <?php foreach ($peminjaman as $p): ?>
                                        <option value="<?= $p['id_peminjaman'] ?>">
                                            Transaksi #<?= str_pad($p['id_peminjaman'], 5, '0', STR_PAD_LEFT) ?> - <?= $p['nama_anggota'] ?? 'Anggota' ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-text extra-small mt-2">Hanya menampilkan transaksi yang berstatus 'Dipinjam' atau 'Terlambat'.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small">TANGGAL DIKEMBALIKAN</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-check text-success"></i></span>
                                    <input type="date" name="tgl_pengembalian" class="form-control bg-light border-0" value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small">TOTAL DENDA (RP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-danger fw-bold">Rp</span>
                                    <input type="number" name="denda" class="form-control bg-light border-0" value="0" min="0" step="500">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-box-arrow-in-down me-2"></i> Proses Pengembalian
                            </button>
                            <p class="text-center small text-muted mt-2">
                                <i class="bi bi-info-circle me-1"></i> Stok buku akan otomatis bertambah kembali.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert bg-primary-subtle border-0 rounded-4 mt-4 p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb-fill text-primary fs-4 me-3"></i>
                    <div class="small text-primary-emphasis">
                        <strong>Tips Petugas:</strong> Periksa kondisi fisik buku sebelum menyimpan. Jika ada kerusakan berat, Anda dapat menambahkan nominal denda secara manual.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .form-select:focus, .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .input-group-text { border-radius: 0.5rem 0 0 0.5rem; }
    .form-control, .form-select { border-radius: 0 0.5rem 0.5rem 0; }
    .extra-small { font-size: 11px; }
</style>

<?= $this->endSection() ?>