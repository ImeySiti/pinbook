<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h2>Tambah Rak</h2>

<form action="<?= base_url('rak/store') ?>" method="post">

<label>Nama Rak</label><br>
<input type="text" name="nama_rak" required><br><br>

<label>Lokasi</label><br>
<input type="text" name="lokasi" required><br><br>

<button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>