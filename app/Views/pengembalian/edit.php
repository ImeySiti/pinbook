<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>



<h2>Edit Pengembalian</h2>

<form method="post"
      action="<?= base_url('pengembalian/update/' . $pengembalian['id_pengembalian']) ?>">

<label>Peminjaman</label><br>
<select name="id_peminjaman">
    <?php foreach ($peminjaman as $p): ?>
        <option value="<?= $p['id_peminjaman'] ?>"
            <?= $p['id_peminjaman'] == $pengembalian['id_peminjaman'] ? 'selected' : '' ?>>
            <?= $p['id_peminjaman'] ?>
        </option>
    <?php endforeach; ?>
</select>

<br><br>

<label>Tanggal Dikembalikan</label><br>
<input type="date" name="tanggal_dikembalikan"
       value="<?= $pengembalian['tanggal_dikembalikan'] ?>">

<br><br>

<label>Denda</label><br>
<input type="number" step="0.01" name="denda"
       value="<?= $pengembalian['denda'] ?>">

<br><br>

<button type="submit">Update</button>

</form>
<?= $this->endSection() ?>