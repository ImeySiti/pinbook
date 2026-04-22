<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$role = session()->get('role');
?>

<h3>Data Penulis</h3>

<?php if ($role == 'admin'): ?>
    <a href="<?= base_url('penulis/create') ?>">+ Tambah</a>
<?php endif; ?>

<br><br>

<form method="get" action="<?= base_url('penulis') ?>">
    <input type="text" name="keyword"
           placeholder="Cari nama penulis..."
           value="<?= $keyword ?? '' ?>">
    <button type="submit">Search</button>
</form>

<br>

<!-- =========================
DATA PENULIS
========================= -->
<h4>Penulis</h4>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nama Penulis</th>

        <?php if ($role == 'admin'): ?>
            <th>Aksi</th>
        <?php endif; ?>
    </tr>

    <?php if (!empty($penulis)) : ?>
        <?php foreach ($penulis as $p): ?>
        <tr>
            <td><?= $p['id_penulis'] ?></td>
            <td><?= $p['nama_penulis'] ?></td>

            <?php if ($role == 'admin'): ?>
            <td>
                <a href="<?= base_url('penulis/edit/'.$p['id_penulis']) ?>">Edit</a>
                |
                <a href="<?= base_url('penulis/delete/'.$p['id_penulis']) ?>"
                   onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
            <?php endif; ?>

        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="<?= ($role == 'admin') ? '3' : '2' ?>">
                Data tidak ditemukan
            </td>
        </tr>
    <?php endif; ?>
</table>

<br><br>

<!-- =========================
DATA PENGEMBALIAN
========================= -->
<h4>Data Pengembalian</h4>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>ID Peminjaman</th>
        <th>Tanggal Kembali</th>
        <th>Denda</th>
    </tr>

    <?php if (!empty($pengembalian)) : ?>
        <?php foreach ($pengembalian as $pg): ?>
        <tr>
            <td><?= $pg['id_pengembalian'] ?></td>
            <td><?= $pg['id_peminjaman'] ?></td>
            <td><?= $pg['tanggal_kembali'] ?></td>
            <td>Rp <?= number_format($pg['denda'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Belum ada data pengembalian</td>
        </tr>
    <?php endif; ?>

</table>

<?= $this->endSection() ?>