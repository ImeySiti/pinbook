<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h2>Edit Rak</h2>

<form action="<?= base_url('rak/update/' . $rak['id_rak']) ?>" method="post">

<label>Nama Rak</label><br>
<input type="text" name="nama_rak" value="<?= $rak['nama_rak'] ?>" required><br><br>

<label>Lokasi</label><br>
<input type="text" name="lokasi" value="<?= $rak['lokasi'] ?>" required><br><br>

<button type="submit">Update</button>

</form>

<?= $this->endSection() ?>