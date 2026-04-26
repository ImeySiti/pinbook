<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-3">

    <div class="card shadow">
        <div class="card-header">
            <h4>Form Pembayaran Denda</h4>
        </div>

        <div class="card-body">

            <form action="<?= base_url('transaksi/bayar') ?>" method="post" enctype="multipart/form-data">

                <!-- HIDDEN -->
                <input type="hidden" name="id_peminjaman" value="<?= $p['id_peminjaman'] ?>">
                <input type="hidden" name="id_denda" value="<?= $p['id_denda'] ?>">
                <input type="hidden" name="jumlah" value="<?= $p['jumlah_denda'] ?>">

                <!-- INFO DENDA -->
                <div class="mb-3">
                    <label>Jumlah Denda</label>
                    <input type="text" class="form-control"
                        value="Rp <?= number_format($p['jumlah_denda'], 0, ',', '.') ?>" readonly>
                </div>

                <!-- METODE -->
                <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="metode" id="metode" class="form-control" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">💵 Cash (langsung lunas)</option>
                        <option value="transfer">🏦 Transfer Bank</option>
                    </select>
                </div>

                <!-- CASH -->
                <div id="cashInfo" class="alert alert-success" style="display:none;">
                    ✔ Bayar langsung di kasir, status otomatis LUNAS
                </div>

                <!-- TRANSFER -->
                <div id="tfInfo" class="alert alert-warning" style="display:none;">
                    🏦 Transfer ke rekening berikut:<br>
                    BCA: 1234567890<br>
                    A/N: Perpustakaan
                </div>

                <!-- BUKTI (HANYA TRANSFER) -->
                <div id="buktiBox" style="display:none;" class="mb-3">
                    <label>Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_bayar" class="form-control">
                    <small class="text-muted">Wajib untuk Transfer</small>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Bayar Sekarang
                </button>

            </form>

        </div>
    </div>

</div>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const metode = document.getElementById('metode');

    const cash = document.getElementById('cashInfo');
    const tf = document.getElementById('tfInfo');
    const bukti = document.getElementById('buktiBox');

    function hideAll() {
        cash.style.display = 'none';
        tf.style.display = 'none';
        bukti.style.display = 'none';
    }

    metode.addEventListener('change', function () {
        hideAll();

        if (this.value === 'cash') {
            cash.style.display = 'block';
        }

        if (this.value === 'transfer') {
            tf.style.display = 'block';
            bukti.style.display = 'block';
        }
    });

});
</script>

<?= $this->endSection() ?>