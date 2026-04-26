<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Detail Peminjaman</h2>

<?php if (!empty($peminjaman)): ?>

<?php
    $today = date('Y-m-d');
    $status = $peminjaman['status'] ?? 'dipinjam';
    $tgl_kembali = $peminjaman['tanggal_kembali'] ?? null;

    // 🔥 auto status terlambat
    if ($status != 'kembali' && $tgl_kembali && $tgl_kembali < $today) {
        $status = 'terlambat';
    }
?>

<table border="1" cellpadding="8" cellspacing="0">

<tr>
    <td>Anggota</td>
    <td><?= $peminjaman['nama_anggota'] ?? '-' ?></td>
</tr>

<tr>
    <td>Petugas</td>
    <td><?= $peminjaman['nama_petugas'] ?? '-' ?></td>
</tr>

<tr>
    <td>Tanggal Pinjam</td>
    <td><?= $peminjaman['tanggal_pinjam'] ?? '-' ?></td>
</tr>

<tr>
    <td>Jatuh Tempo</td>
    <td><?= $peminjaman['tanggal_kembali'] ?? '-' ?></td>
</tr>

<tr>
    <td>Status</td>
    <td>
        <?php if ($status == 'kembali'): ?>
            <span style="color: green;">Dikembalikan</span>

        <?php elseif ($status == 'diperpanjang'): ?>
            <span style="color: blue;">Diperpanjang</span>

        <?php elseif ($status == 'terlambat'): ?>
            <span style="color: red;">Terlambat</span>

        <?php else: ?>
            <span style="color: orange;">Dipinjam</span>
        <?php endif; ?>
    </td>
</tr>

<tr>
    <td>Buku Dipinjam</td>
    <td>
        <?php if (!empty($buku)): ?>
            <ul>
                <?php foreach ($buku as $b): ?>
                    <li><?= $b['judul'] ?? '-' ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <i>Tidak ada buku</i>
        <?php endif; ?>
    </td>
</tr>

</table>

<br>

<!-- 🔥 AKSI -->

<a href="<?= base_url('peminjaman') ?>">
    ← Kembali
</a>

<?php else: ?>
    <p>Data tidak ditemukan</p>
<?php endif; ?>

<?= $this->endSection() ?>