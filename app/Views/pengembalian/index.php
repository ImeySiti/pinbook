<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $role = session()->get('role'); ?>

<h2>Data Pengembalian</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>

        <th>Nama Anggota</th>

        <th>Buku</th>
        <th>Tanggal Kembali</th>
        <th>Denda</th>

        <?php if ($role == 'admin'): ?>
            <th>Aksi</th>
        <?php endif; ?>
    </tr>

    <?php if (!empty($pengembalian)): ?>
        <?php foreach ($pengembalian as $p): ?>
        <tr>
            <td><?= $p['id_pengembalian'] ?></td>

            <!-- 🔥 SELALU TAMPIL (ADMIN & ANGGOTA) -->
            <td><?= $p['nama_anggota'] ?? '-' ?></td>

            <td><?= $p['daftar_buku'] ?? '-' ?></td>
            <td><?= $p['tanggal_kembali'] ?? '-' ?></td>

            <td>
                Rp <?= number_format($p['denda'] ?? 0, 0, ',', '.') ?>
            </td>

            <?php if ($role == 'admin'): ?>
            <td>
                <a href="<?= base_url('pengembalian/edit/' . $p['id_pengembalian']) ?>">Edit</a> |
                <a href="<?= base_url('pengembalian/delete/' . $p['id_pengembalian']) ?>"
                   onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
            <?php endif; ?>

        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="<?= ($role == 'admin') ? 6 : 5 ?>">
                Data tidak ditemukan
            </td>
        </tr>
    <?php endif; ?>

</table>

<?= $this->endSection() ?>