<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Pengembalian</h2>

<form method="post" action="<?= base_url('pengembalian/simpan') ?>">

    <label>Peminjaman</label><br>
    <select name="id_peminjaman" required>
        <option value="">-- pilih --</option>
        <?php foreach ($peminjaman as $p): ?>
            <option value="<?= $p['id_peminjaman'] ?>">
                <?= $p['id_peminjaman'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <label>Tanggal Dikembalikan</label><br>
    <input type="date" name="tgl_pengembalian" value="<?= date('Y-m-d') ?>">

    <br><br>

    <label>Denda</label><br>
    <input type="number" name="denda" value="0">

    <br><br>

    <button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>