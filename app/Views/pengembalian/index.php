<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Pengembalian</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Nama Anggota</th>
        <th>Buku</th>
        <th>Tanggal Kembali</th>
        <th>Denda</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pengembalian as $p): ?>

    <tr>
        <td><?= $p['id_pengembalian'] ?></td>
        <td><?= $p['nama'] ?? '-' ?></td>
        <td><?= $p['daftar_buku'] ?? '-' ?></td>
        <td><?= $p['tanggal_kembali'] ?? '-' ?></td>

        <td>
            Rp <?= number_format($p['denda_otomatis'] ?? 0, 0, ',', '.') ?>
        </td>

        <td>
            <a href="<?= base_url('pengembalian/edit/'.$p['id_pengembalian']) ?>">Edit</a> |
            <a href="<?= base_url('pengembalian/delete/'.$p['id_pengembalian']) ?>"
               onclick="return confirm('Hapus data?')">Hapus</a>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>