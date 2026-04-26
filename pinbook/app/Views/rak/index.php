<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Rak</h2>

<!-- =========================
TOMBOL TAMBAH
========================= -->
<a href="<?= base_url('rak/create') ?>">+ Tambah Rak</a>

<br><br>

<!-- =========================
SEARCH
========================= -->
<form method="get" action="<?= base_url('rak') ?>">
    <input type="text" name="keyword"
           placeholder="Cari nama rak / lokasi..."
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
    <th>Nama Rak</th>
    <th>Lokasi</th>
    <th>Aksi</th>
</tr>

<?php if (!empty($rak)) : ?>
    <?php foreach ($rak as $r): ?>
    <tr>
        <td><?= $r['id_rak'] ?></td>
        <td><?= $r['nama_rak'] ?></td>
        <td><?= $r['lokasi'] ?></td>
        <td>
            <a href="<?= base_url('rak/edit/' . $r['id_rak']) ?>">Edit</a>
            |
            <a href="<?= base_url('rak/delete/' . $r['id_rak']) ?>"
               onclick="return confirm('Hapus?')">Hapus</a>
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