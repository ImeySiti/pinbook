<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Tambah Anggota</h2>

<form method="post" action="<?= base_url('anggota/store') ?>">

    <label>User</label>
    <select name="user_id">
        <?php foreach ($users as $u): ?>
            <option value="<?= $u['id'] ?>"><?= $u['nama'] ?></option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <input type="text" name="nis" placeholder="NIS"><br><br>
    <textarea name="alamat" placeholder="Alamat"></textarea><br><br>
    <input type="text" name="no_hp" placeholder="No HP"><br><br>

    <button type="submit">Simpan</button>
</form>
<?= $this->endSection() ?>