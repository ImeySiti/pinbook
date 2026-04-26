<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<h3>Edit Penulis</h3>

<form method="post" action="<?= base_url('penulis/update/'.$penulis['id_penulis']) ?>">
    Nama Penulis <br>
    <input type="text" name="nama_penulis" value="<?= $penulis['nama_penulis'] ?>" required>
    <br><br>
    <button type="submit">Update</button>
</form>
<?= $this->endSection() ?>