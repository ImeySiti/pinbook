<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Penulis</h3>

<!-- =========================
TOMBOL TAMBAH
========================= -->
<a href="<?= base_url('penulis/create') ?>">+ Tambah</a>

<br><br>

<!-- =========================
SEARCH
========================= -->
<form method="get" action="<?= base_url('penulis') ?>">
    <input type="text" name="keyword"
           placeholder="Cari nama penulis..."
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
        <th>Nama Penulis</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($penulis)) : ?>
        <?php foreach ($penulis as $p): ?>
        <tr>
            <td><?= $p['id_penulis'] ?></td>
            <td><?= $p['nama_penulis'] ?></td>
            <td>
                <a href="<?= base_url('penulis/edit/'.$p['id_penulis']) ?>">Edit</a>
                |
                <a href="<?= base_url('penulis/delete/'.$p['id_penulis']) ?>"
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