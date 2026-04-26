<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-0">💳 Pembayaran Ongkir</h3>
                    <p class="text-muted small">ID Transaksi: <span class="fw-bold">#<?= esc($peminjaman['id_peminjaman']) ?></span></p>
                </div>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-0 text-center">
                    <div class="bg-primary p-4 text-white">
                        <p class="small opacity-75 mb-1 text-uppercase fw-bold">Total Pembayaran</p>
                        <h2 class="fw-bold mb-0">Rp <?= number_format($ongkir, 0, ',', '.') ?></h2>
                    </div>
                    
                    <div class="p-4">
                        <p class="text-muted small mb-3">Pindai kode QR di bawah ini dengan aplikasi e-wallet atau mobile banking Anda (QRIS).</p>
                        
                        <div class="d-inline-block p-3 bg-white border rounded-4 shadow-sm mb-3">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=<?= urlencode($dataQR) ?>" 
                                 class="img-fluid" alt="QR Code Pembayaran">
                        </div>
                        
                        <div class="d-flex justify-content-center gap-2 mb-2">
                            <span class="badge bg-light text-dark border px-2 py-1 small">GoPay</span>
                            <span class="badge bg-light text-dark border px-2 py-1 small">OVO</span>
                            <span class="badge bg-light text-dark border px-2 py-1 small">Dana</span>
                            <span class="badge bg-light text-dark border px-2 py-1 small">ShopeePay</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-cloud-arrow-up me-2"></i>Upload Bukti Pembayaran</h6>
                    
                    <form method="post" enctype="multipart/form-data" 
                          action="<?= base_url('peminjaman/prosesBayar/'.$id_transaksi) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <div class="upload-box p-4 border border-dashed rounded-4 text-center bg-light position-relative">
                                <input type="file" name="bukti" class="opacity-0 position-absolute w-100 h-100 top-0 start-0 cursor-pointer" id="buktiInput" required onchange="previewLabel()">
                                <i class="bi bi-image text-muted display-6 d-block mb-2"></i>
                                <span class="small text-muted" id="fileName">Pilih foto atau seret ke sini</span>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-send-fill me-2"></i> Kirim Konfirmasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert bg-info-subtle border-0 rounded-4 p-3 small text-info-emphasis">
                <div class="d-flex">
                    <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                    <div>
                        <strong>Catatan:</strong> Petugas akan memverifikasi bukti pembayaran Anda dalam waktu maksimal 1x24 jam sebelum status pengantaran diubah menjadi 'Selesai'.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function previewLabel() {
        const input = document.getElementById('buktiInput');
        const label = document.getElementById('fileName');
        if (input.files.length > 0) {
            label.innerHTML = "<strong>File Terpilih:</strong> " + input.files[0].name;
            label.classList.add('text-primary');
        }
    }
</script>

<style>
    .upload-box {
        transition: 0.3s;
        border: 2px dashed #ced4da !important;
    }
    .upload-box:hover {
        background-color: #f1f1f1 !important;
        border-color: #0d6efd !important;
    }
    .cursor-pointer { cursor: pointer; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .border-dashed { border-style: dashed !important; }
</style>

<?= $this->endSection() ?>