<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h3>Tambah Kategori</h3>

<form method="post" action="<?= base_url('kategori/store') ?>">
    Nama Kategori <br>
    <input type="text" name="nama_kategori" required>
    <br><br>
    <button type="submit">Simpan</button>
</form>
<?= $this->endSection() ?>