<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Pilih Metode Pembayaran</h2>

<p><b>ID Peminjaman:</b> <?= $peminjaman['id_peminjaman'] ?? '-' ?></p>
<h3>Total Ongkir: Rp <?= number_format($ongkir ?? 0,0,',','.') ?></h3>

<hr>

<form method="post" action="<?= base_url('peminjaman/pilihMetode/'.$id_transaksi) ?>">
    <?= csrf_field() ?>

    <label>
        <input type="radio" name="metode" value="qris" required>
        QRIS
    </label>

    <label>
        <input type="radio" name="metode" value="cod">
        COD (Bayar di Tempat)
    </label>

    <br><br>

    <button type="submit">Lanjut</button>
</form>

<?= $this->endSection() ?>