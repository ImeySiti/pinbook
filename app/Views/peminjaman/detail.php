aaaaaaaaaaaaaaaaaa<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Detail Peminjaman</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <td><?= $peminjaman['id_peminjaman'] ?></td>
    </tr>

    <tr>
        <th>Anggota</th>
        <td><?= $peminjaman['nis'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Petugas</th>
        <td><?= $peminjaman['jabatan'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Buku</th>
        <td><?= $peminjaman['judul_buku'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Cover</th>
        <td>
            <?php if (!empty($peminjaman['cover'])): ?>
                <img src="<?= base_url('uploads/cover/' . $peminjaman['cover']) ?>" width="120">
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <th>Tanggal Pinjam</th>
        <td><?= $peminjaman['tanggal_pinjam'] ?></td>
    </tr>

    <tr>
        <th>Tanggal Kembali</th>
        <td><?= $peminjaman['tanggal_kembali'] ?></td>
    </tr>

    <tr>
        <th>Status</th>
        <td><?= $peminjaman['status'] ?></td>
    </tr>

</table>

<br>

<a href="<?= base_url('peminjaman') ?>">Kembali</a>

<?= $this->endSection() ?>