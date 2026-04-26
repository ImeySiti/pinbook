<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Penerbit</h3>

<!-- =========================
TOMBOL TAMBAH + SEARCH
========================= -->
<a href="<?= base_url('penerbit/create') ?>">+ Tambah</a>

<br><br>

<form method="get" action="<?= base_url('penerbit') ?>">
    <input type="text" name="keyword"
           placeholder="Cari nama / alamat..."
           value="<?= $keyword ?? '' ?>">

    <button type="submit">Search</button>
</form>

<br>

<!-- =========================
TABLE
========================= -->
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nama Penerbit</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($penerbit)) : ?>
        <?php foreach ($penerbit as $p): ?>
        <tr>
            <td><?= $p['id_penerbit'] ?></td>
            <td><?= $p['nama_penerbit'] ?></td>
            <td><?= $p['alamat'] ?></td>
            <td>
                <a href="<?= base_url('penerbit/edit/'.$p['id_penerbit']) ?>">Edit</a>
                |
                <a href="<?= base_url('penerbit/delete/'.$p['id_penerbit']) ?>"
                   onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Data tidak ditemukan</td>
        </tr>
    <?php endif; ?>

</table>

<?= $this->endSection() ?>