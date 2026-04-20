<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<h3>Tambah Penulis</h3>

<form method="post" action="<?= base_url('penulis/store') ?>">
    Nama Penulis <br>
    <input type="text" name="nama_penulis" required>
    <br><br>
    <button type="submit">Simpan</button>
</form>
<?= $this->endSection() ?>