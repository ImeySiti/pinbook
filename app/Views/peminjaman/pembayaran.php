<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- HEADER -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">💳 Pembayaran Ongkir</h3>

                    <p class="text-muted small mb-0">
                        ID Transaksi:
                        <span class="fw-bold">
                            #<?= esc($peminjaman['id_peminjaman'] ?? '-') ?>
                        </span>
                    </p>
                </div>

                <a href="<?= base_url('peminjaman') ?>"
                   class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- FLASH MESSAGE -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- QRIS -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 text-center overflow-hidden">

                <div class="bg-primary text-white p-4">
                    <small class="opacity-75 text-uppercase fw-bold">
                        Total Pembayaran
                    </small>

                    <h2 class="fw-bold mb-0">
                        Rp <?= number_format($ongkir ?? 15000, 0, ',', '.') ?>
                    </h2>
                </div>

                <div class="p-4">

                    <p class="text-muted small">
                        Scan QRIS untuk melakukan pembayaran
                    </p>

                    <div class="p-3 border rounded-4 d-inline-block mb-3 bg-white">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= urlencode($dataQR ?? 'pembayaran') ?>"
                             class="img-fluid">
                    </div>

                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-light text-dark border">GoPay</span>
                        <span class="badge bg-light text-dark border">OVO</span>
                        <span class="badge bg-light text-dark border">Dana</span>
                        <span class="badge bg-light text-dark border">ShopeePay</span>
                    </div>

                </div>
            </div>

            <!-- UPLOAD BUKTI -->
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-cloud-arrow-up me-2"></i>
                        Upload Bukti Pembayaran
                    </h6>

                    <form method="post"
                          enctype="multipart/form-data"
                          action="<?= base_url('peminjaman/prosesBayar/' . ($id_transaksi ?? $peminjaman['id_peminjaman'])) ?>">

                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <div class="upload-box p-4 border rounded-4 text-center bg-light position-relative">

                                <input type="file"
                                       name="bukti"
                                       id="buktiInput"
                                       class="position-absolute w-100 h-100 opacity-0 top-0 start-0"
                                       required
                                       onchange="previewLabel()">

                                <i class="bi bi-image display-6 text-muted"></i>

                                <div id="fileName" class="small text-muted mt-2">
                                    Pilih file bukti pembayaran
                                </div>

                            </div>
                        </div>

                        <button class="btn btn-primary w-100 rounded-pill">
                            <i class="bi bi-send me-1"></i> Kirim Konfirmasi
                        </button>

                    </form>

                </div>
            </div>

            <!-- INFO -->
            <div class="alert alert-info border-0 rounded-4 mt-3 small">
                Petugas akan memverifikasi pembayaran dalam 1x24 jam.
            </div>

        </div>
    </div>
</div>

<script>
function previewLabel() {
    let input = document.getElementById('buktiInput');
    let label = document.getElementById('fileName');

    if (input.files.length > 0) {
        label.innerHTML = "📎 " + input.files[0].name;
        label.classList.add('text-primary');
    }
}
</script>

<style>
.upload-box{
    border: 2px dashed #ced4da !important;
    transition: .3s;
}
.upload-box:hover{
    border-color: #0d6efd !important;
    background: #f8f9fa !important;
}
</style>

<?= $this->endSection() ?>