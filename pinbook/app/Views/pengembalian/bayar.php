<div class="container mt-3">

    <div class="card shadow">
        <div class="card-header">
            <h4>Form Pembayaran Denda</h4>
        </div>

        <div class="card-body">

            <form action="<?= base_url('transaksi/bayar') ?>" method="post" enctype="multipart/form-data">

                <!-- HIDDEN DATA -->
                <input type="hidden" name="id_peminjaman" value="<?= $p['id_peminjaman'] ?>">
                <input type="hidden" name="id_denda" value="<?= $p['id_denda'] ?>">
                <input type="hidden" name="jumlah" value="<?= $p['jumlah_denda'] ?>">

                <!-- INFO DENDA -->
                <div class="mb-3">
                    <label>Jumlah Denda</label>
                    <input type="text" class="form-control"
                        value="Rp <?= number_format($p['jumlah_denda'],0,',','.') ?>" readonly>
                </div>

                <!-- PILIH METODE -->
                <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="metode" id="metode" class="form-control" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">💵 Cash (langsung lunas)</option>
                        <option value="qris">📱 QRIS</option>
                        <option value="transfer">🏦 Transfer Bank</option>
                    </select>
                </div>

                <!-- CASH INFO -->
                <div id="cashInfo" class="alert alert-success" style="display:none;">
                    ✔ Bayar langsung di kasir, status otomatis LUNAS
                </div>

                <!-- QRIS INFO -->
                <div id="qrisInfo" class="alert alert-info" style="display:none;">
                    📱 Scan QRIS untuk pembayaran digital
                </div>

                <!-- TRANSFER INFO -->
                <div id="tfInfo" class="alert alert-warning" style="display:none;">
                    🏦 Transfer ke rekening berikut:<br>
                    BCA: 1234567890<br>
                    A/N: Perpustakaan
                </div>

                <!-- BUKTI BAYAR -->
                <div id="buktiBox" style="display:none;" class="mb-3">
                    <label>Upload Bukti Pembayaran</label>
                    <input type="file" name="bukti_bayar" class="form-control">
                    <small class="text-muted">Wajib untuk QRIS & Transfer</small>
                </div>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-primary w-100">
                    Bayar Sekarang
                </button>

            </form>

        </div>
    </div>

</div>

<!-- SCRIPT LOGIC -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const metode = document.getElementById('metode');

    metode.addEventListener('change', function () {

        let val = this.value;

        let cash = document.getElementById('cashInfo');
        let qris = document.getElementById('qrisInfo');
        let tf = document.getElementById('tfInfo');
        let bukti = document.getElementById('buktiBox');

        // reset
        cash.style.display = 'none';
        qris.style.display = 'none';
        tf.style.display = 'none';
        bukti.style.display = 'none';

        if (val === 'cash') {
            cash.style.display = 'block';
        }

        if (val === 'qris') {
            qris.style.display = 'block';
            bukti.style.display = 'block';
        }

        if (val === 'transfer') {
            tf.style.display = 'block';
            bukti.style.display = 'block';
        }

    });

});
</script>