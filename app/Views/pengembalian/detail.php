<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Detail Pengembalian</h2>

<?php if (!empty($pengembalian)): ?>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>Nama Anggota</th>
        <td><?= $pengembalian['nama_anggota'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Buku</th>
        <td><?= $pengembalian['daftar_buku'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Tanggal Kembali Seharusnya</th>
        <td><?= $pengembalian['batas_kembali'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Tanggal Pengembalian</th>
        <td><?= $pengembalian['tgl_pengembalian'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Jumlah Hari Telat</th>
        <td><?= $pengembalian['jumlah_hari_telat'] ?? 0 ?> hari</td>
    </tr>

    <tr>
        <th>Total Denda</th>
        <td>
            Rp <?= number_format($pengembalian['total_denda'] ?? 0, 0, ',', '.') ?>
        </td>
    </tr>

    <tr>
        <th>Status Bayar</th>
        <td>
            <?php if (($pengembalian['status_bayar'] ?? '') == 'lunas'): ?>
                <span style="color:green;">Lunas</span>
            <?php elseif (($pengembalian['status_bayar'] ?? '') == 'pending'): ?>
                <span style="color:orange;">Pending</span>
            <?php else: ?>
                <span style="color:red;">Belum Bayar</span>
            <?php endif; ?>
        </td>
    </tr>

</table>

<!-- ================= AKSI ================= -->
<br>

<a href="<?= base_url('pengembalian') ?>">⬅ Kembali</a>

<!-- 🔥 TOMBOL BAYAR (HANYA JIKA ADA DENDA) -->
<?php if (!empty($pengembalian['total_denda']) && $pengembalian['total_denda'] > 0): ?>
    <a href="<?= base_url('transaksi/bayarDenda/' . $pengembalian['id_peminjaman']) ?>"
       style="color:white; background:red; padding:5px 10px; margin-left:10px;">
        Bayar Denda
    </a>
<?php endif; ?>

<?php else: ?>
    <p>Data tidak ditemukan</p>
<?php endif; ?>

<?= $this->endSection() ?>