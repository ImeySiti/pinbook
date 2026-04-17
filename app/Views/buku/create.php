<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Buku</h3>

<form method="post" action="<?= base_url('buku/store') ?>" enctype="multipart/form-data">

    Judul:<br>
    <input type="text" name="judul" required><br><br>

    ISBN:<br>
    <input type="text" name="isbn"><br><br>

    <!-- KATEGORI (FIX: pakai ID) -->
    Kategori:<br>
    <select name="id_kategori" id="kategori" style="width:100%">
        <option value=""></option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori'] ?>">
                <?= $k['nama_kategori'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- PENULIS (FIX: pakai ID) -->
    Penulis:<br>
    <select name="id_penulis" id="penulis" style="width:100%">
        <option value=""></option>
        <?php foreach ($penulis as $p): ?>
            <option value="<?= $p['id_penulis'] ?>">
                <?= $p['nama_penulis'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- PENERBIT (FIX: pakai ID) -->
    Penerbit:<br>
    <select name="id_penerbit" id="penerbit" style="width:100%">
        <option value=""></option>
        <?php foreach ($penerbit as $p): ?>
            <option value="<?= $p['id_penerbit'] ?>">
                <?= $p['nama_penerbit'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- RAK -->
    Rak:<br>
    <select name="id_rak" style="width:100%">
        <option value="">Pilih Rak</option>
        <?php foreach ($rak as $r): ?>
            <option value="<?= $r['id_rak'] ?>">
                <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    Tahun Terbit:<br>
    <input type="number" name="tahun_terbit"><br><br>

    Jumlah:<br>
    <input type="number" name="jumlah"><br><br>

    Tersedia:<br>
    <input type="number" name="tersedia"><br><br>

    Deskripsi:<br>
    <textarea name="deskripsi"></textarea><br><br>

    Cover:<br>
    <input type="file" name="cover"><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('buku') ?>">Kembali</a>
</form>

<!-- SELECT2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    function select2Tag(id, placeholder) {
        $(id).select2({
            tags: false, // ❗ FIX penting: jangan tags biar tidak kirim string liar
            width: '100%',
            placeholder: placeholder,
            allowClear: true
        });
    }

    select2Tag('#kategori', 'Pilih kategori');
    select2Tag('#penulis', 'Pilih penulis');
    select2Tag('#penerbit', 'Pilih penerbit');

});
</script>

<?= $this->endSection() ?>