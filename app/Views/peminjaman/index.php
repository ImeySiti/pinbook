<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<?php if (session()->get('role') == 'anggota') : ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Tambah</a>
<?php endif; ?>

<br><br>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari status / buku..."
        value="<?= $_GET['keyword'] ?? '' ?>">
    <button type="submit">Cari</button>

    <a href="<?= base_url('peminjaman') ?>">Reset</a>
</form>

<br>

<!-- ================= ADMIN ================= -->
<?php if (session()->get('role') == 'admin') : ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Anggota</th>
        <th>Petugas</th>
        <th>Cover</th>
        <th>Judul</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($peminjaman as $p) : ?>
        <tr>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['nis'] ?? '-' ?></td>
            <td><?= $p['jabatan'] ?? '-' ?></td>

            <td>
                <?php if (!empty($p['cover'])): ?>
                    <img src="<?= base_url('uploads/cover/' . $p['cover']) ?>" width="60">
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td><?= $p['judul_buku'] ?? '-' ?></td>
            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['tanggal_kembali'] ?></td>
            <td><?= $p['status'] ?></td>

            <td>
                <a href="<?= base_url('peminjaman/' . $p['id_peminjaman']) ?>">Detail</a> |
                <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']) ?>">Edit</a> |
                <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>"
                   onclick="return confirm('Hapus data ini?')">
                    Hapus
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<!-- ================= ANGGOTA ================= -->
<?php else : ?>

    <?php if (empty($peminjaman)) : ?>
        <p><b>Kamu belum memiliki data peminjaman.</b></p>
    <?php else : ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Cover</th>
            <th>Judul</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($peminjaman as $p) : ?>
            <tr>
                <td><?= $p['id_peminjaman'] ?></td>

                <td>
                    <?php if (!empty($p['cover'])): ?>
                        <img src="<?= base_url('uploads/cover/' . $p['cover']) ?>" width="60">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

                <td><?= $p['judul_buku'] ?? '-' ?></td>
                <td><?= $p['tanggal_pinjam'] ?></td>
                <td><?= $p['tanggal_kembali'] ?></td>
                <td><?= $p['status'] ?></td>

                <td>
                    <a href="<?= base_url('peminjaman/' . $p['id_peminjaman']) ?>">Detail</a> |
                    <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>"
                       onclick="return confirm('Hapus data ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

    <?php endif; ?>

<?php endif; ?>

<?= $this->endSection() ?>