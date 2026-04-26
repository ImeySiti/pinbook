<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Pembayaran Pengantaran</h2>

<!-- NOTIF -->
<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<p><b>ID Peminjaman:</b> <?= esc($peminjaman['id_peminjaman']) ?></p>
<p><b>Metode:</b> <?= esc($peminjaman['metode_pengambilan']) ?></p>

<hr>

<h3>Total Ongkir: Rp <?= number_format($ongkir,0,',','.') ?></h3>

<h3>Scan QR untuk pembayaran</h3>

<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($dataQR) ?>" />

<br><br>

<p>Silakan scan QR menggunakan e-wallet / mobile banking.</p>

<hr>

<h3>Upload Bukti Pembayaran</h3>

<form method="post" enctype="multipart/form-data" 
      action="<?= base_url('peminjaman/prosesBayar/'.$id_transaksi) ?>">
    
    <?= csrf_field() ?> <input type="file" name="bukti" required>
    <button type="submit">Kirim Bukti Pembayaran</button>
</form>
<br>

<a href="<?= base_url('peminjaman') ?>">← Kembali</a>

<?= $this->endSection() ?>