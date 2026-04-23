<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Edit Anggota</h2>

<form method="post" action="<?= base_url('anggota/update/'.$anggota['id_anggota']) ?>">

    <label>User</label>
    <select name="user_id">
        <?php foreach ($users as $u): ?>
            <option value="<?= $u['id'] ?>" <?= ($u['id'] == $anggota['user_id']) ? 'selected' : '' ?>>
                <?= $u['nama'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <input type="text" name="nis" value="<?= $anggota['nis'] ?>"><br><br>
    <textarea name="alamat"><?= $anggota['alamat'] ?></textarea><br><br>
    <input type="text" name="no_hp" value="<?= $anggota['no_hp'] ?>"><br><br>

    <button type="submit">Update</button>
</form>
<?= $this->endSection() ?>