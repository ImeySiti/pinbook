<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Pengembalian</h2>

<form action="<?= base_url('pengembalian/update/' . $pengembalian['id_pengembalian']) ?>" method="post">

    <label>Denda</label><br>
    <input type="number" name="denda"
        value="<?= $pengembalian['denda'] ?? 0 ?>"><br><br>

    <label>Status Bayar</label><br>
    <select name="status_bayar">

        <option value="belum"
            <?= ($pengembalian['status_bayar'] ?? '') == 'belum' ? 'selected' : '' ?>>
            Belum Bayar
        </option>

        <option value="lunas"
            <?= ($pengembalian['status_bayar'] ?? '') == 'lunas' ? 'selected' : '' ?>>
            Lunas
        </option>

    </select>

    <br><br>

    <button type="submit">Update</button>

</form>

<?= $this->endSection() ?>