<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Kategori</h3>

<!-- =========================
TOMBOL TAMBAH
========================= -->
<a href="<?= base_url('kategori/create') ?>">+ Tambah</a>

<br><br>

<!-- =========================
SEARCH
========================= -->
<form method="get" action="<?= base_url('kategori') ?>">
    <input type="text" name="keyword"
           placeholder="Cari nama kategori..."
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
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($kategori)) : ?>
        <?php foreach ($kategori as $k): ?>
        <tr>
            <td><?= $k['id_kategori'] ?></td>
            <td><?= $k['nama_kategori'] ?></td>
            <td>
                <a href="<?= base_url('kategori/edit/'.$k['id_kategori']) ?>">Edit</a>
                |
                <a href="<?= base_url('kategori/delete/'.$k['id_kategori']) ?>"
                   onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">Data tidak ditemukan</td>
        </tr>
    <?php endif; ?>

</table>

<?= $this->endSection() ?>