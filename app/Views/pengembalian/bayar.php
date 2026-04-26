<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">💰 Pembayaran Denda</h3>
                    <small class="text-muted">Selesaikan kewajiban denda untuk dapat meminjam kembali</small>
                </div>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
            </div>

            <!-- CARD -->
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                <!-- TOTAL DENDA -->
                <div class="bg-danger text-white text-center p-4">
                    <small class="text-uppercase opacity-75 fw-semibold">Total Denda</small>
                    <h2 class="fw-bold mb-0">
                        Rp <?= number_format($p['jumlah_denda'], 0, ',', '.') ?>
                    </h2>
                </div>

                <!-- FORM -->
                <div class="card-body p-4">
                    <form action="<?= base_url('transaksi/bayar') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <input type="hidden" name="id_peminjaman" value="<?= $p['id_peminjaman'] ?>">
                        <input type="hidden" name="id_denda" value="<?= $p['id_denda'] ?>">
                        <input type="hidden" name="jumlah" value="<?= $p['jumlah_denda'] ?>">

                        <!-- METODE -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">METODE PEMBAYARAN</label>
                            <select name="metode" id="metode" class="form-select form-select-lg bg-light border-0" required>
                                <option value="" disabled selected>-- Pilih Metode --</option>
                                <option value="cash">💵 Cash</option>
                                <option value="transfer">🏦 Transfer Bank</option>
                            </select>
                        </div>

                        <!-- INFO AREA -->
                        <div id="infoArea">

                            <!-- CASH -->
                            <div id="cashInfo" class="alert alert-success d-none">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Tunjukkan layar ini ke petugas. Status akan otomatis <b>LUNAS</b>.
                            </div>

                            <!-- TRANSFER -->
                            <div id="tfInfo" class="alert alert-warning d-none">
                                <i class="bi bi-bank me-2"></i>
                                <b>Rekening Tujuan:</b><br>
                                BCA - 1122334455<br>
                                A/N Perpustakaan Digital Pinbook
                            </div>

                            <!-- UPLOAD -->
                            <div id="buktiBox" class="mb-4 d-none">
                                <label class="form-label fw-semibold small text-muted">UPLOAD BUKTI</label>

                                <div class="upload-box text-center p-3 rounded-3 position-relative">
                                    <input type="file" name="bukti_bayar" id="fileInput"
                                        class="position-absolute top-0 start-0 w-100 h-100 opacity-0">

                                    <div id="fileLabel">
                                        <i class="bi bi-cloud-arrow-up fs-3 text-muted"></i>
                                        <p class="small text-muted mb-0">Klik atau seret file</p>
                                    </div>
                                </div>

                                <div id="fileName" class="text-primary small mt-2 text-center fw-semibold"></div>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Konfirmasi
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="bi bi-shield-lock-fill"></i> Transaksi aman
                </small>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const metode = document.getElementById('metode');
    const cash = document.getElementById('cashInfo');
    const tf = document.getElementById('tfInfo');
    const bukti = document.getElementById('buktiBox');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    const reset = () => {
        cash.classList.add('d-none');
        tf.classList.add('d-none');
        bukti.classList.add('d-none');
    };

    metode.addEventListener('change', function () {
        reset();

        if (this.value === 'cash') {
            cash.classList.remove('d-none');
        }

        if (this.value === 'transfer') {
            tf.classList.remove('d-none');
            bukti.classList.remove('d-none');
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.innerText = "File: " + fileInput.files[0].name;
        }
    });
});
</script>

<!-- STYLE -->
<style>
.upload-box {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    cursor: pointer;
    transition: 0.2s;
}

.upload-box:hover {
    background: #eef2f7;
    border-color: #0d6efd;
}
</style>

<?= $this->endSection() ?>