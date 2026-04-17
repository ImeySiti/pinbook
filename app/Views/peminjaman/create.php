<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Peminjaman</h2>

<form action="<?= base_url('/peminjaman/store') ?>" method="post">

    <label>Anggota</label>
    <select name="id_anggota">
        <?php foreach ($anggota as $a): ?>
            <option value="<?= $a['id_anggota'] ?>">
                <?= $a['nis'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Petugas</label>
    <select name="id_petugas">
        <?php foreach ($petugas as $p): ?>
            <option value="<?= $p['id_petugas'] ?>">
                <?= $p['jabatan'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- 🔥 TAMBAHAN BUKU -->
    <label>Pilih Buku</label><br>
    <?php foreach ($buku as $b): ?>
        <input type="checkbox" name="id_buku[]" value="<?= $b['id_buku'] ?>">
        <?= $b['judul'] ?>
        <br>
    <?php endforeach; ?>

    <br>

    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam"><br><br>
    <button type="submit">Simpan</button>
</form>

<?= $this->endSection() ?>