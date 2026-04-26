<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Profil Anggota</h2>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<<form action="<?= base_url('anggota/store') ?>" method="post">
    
    <label>NISN</label><br>
    <input type="text" name="nisn"
        value="<?= esc($anggota['nisn'] ?? '') ?>"
        required>

    <br><br>

    <label>Alamat</label><br>
    <textarea name="alamat" required><?= esc($anggota['alamat'] ?? '') ?></textarea>

    <br><br>

    <label>No HP</label><br>
    <input type="text" name="no_hp"
        value="<?= esc($anggota['no_hp'] ?? '') ?>"
        required>

    <br><br>

    <button type="submit">Simpan Profil</button>

</form>

<?= $this->endSection() ?>