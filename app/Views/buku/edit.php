<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Buku</h3>

<form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">

    <div>
        <label>Judul</label><br>
        <input type="text" name="judul" value="<?= $buku['judul'] ?>" required>
    </div>

    <div>
        <label>ISBN</label><br>
        <input type="text" name="isbn" value="<?= $buku['isbn'] ?>">
    </div>

    <!-- KATEGORI -->
    <div>
        <label>Kategori</label><br>
        <select name="id_kategori" required>
    <option value="">Pilih Kategori</option>
    <?php foreach ($kategori as $k): ?>
        <option value="<?= $k['id_kategori'] ?>">
            <?= $k['nama_kategori'] ?>
        </option>
    <?php endforeach; ?>
</select>
        <br>
        <input type="text" name="kategori_baru" placeholder="Atau tambah kategori baru">
    </div>

    <!-- PENULIS -->
    <div>
        <label>Penulis</label><br>
        <select name="id_penulis">
            <option value="">-- Pilih --</option>
            <?php foreach ($penulis as $p): ?>
                <option value="<?= $p['id_penulis'] ?>"
                    <?= ($buku['id_penulis'] == $p['id_penulis']) ? 'selected' : '' ?>>
                    <?= $p['nama_penulis'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>
        <input type="text" name="penulis_baru" placeholder="Atau tambah penulis baru">
    </div>

    <!-- PENERBIT -->
    <div>
        <label>Penerbit</label><br>
        <select name="id_penerbit">
            <option value="">-- Pilih --</option>
            <?php foreach ($penerbit as $p): ?>
                <option value="<?= $p['id_penerbit'] ?>"
                    <?= ($buku['id_penerbit'] == $p['id_penerbit']) ? 'selected' : '' ?>>
                    <?= $p['nama_penerbit'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>
        <input type="text" name="penerbit_baru" placeholder="Atau tambah penerbit baru">
    </div>

    <!-- rak -->
    <div>
        <label>Rak</label><br>
        <select name="id_rak">
            <option value="">-- Pilih Rak --</option>
            <?php foreach ($rak as $r): ?>
                <option value="<?= $r['id_rak'] ?>"
                    <?= ($buku['id_rak'] ?? '') == $r['id_rak'] ? 'selected' : '' ?>>
                    <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label>Tahun Terbit</label><br>
        <input type="number" name="tahun_terbit" value="<?= $buku['tahun_terbit'] ?>">
    </div>

    <div>
        <label>Jumlah</label><br>
        <input type="number" name="jumlah" value="<?= $buku['jumlah'] ?>">
    </div>

    <div>
        <label>Tersedia</label><br>
        <input type="number" name="tersedia" value="<?= $buku['tersedia'] ?>">
    </div>

    <div>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi"><?= $buku['deskripsi'] ?></textarea>
    </div>

    <input type="hidden" name="old_cover" value="<?= $buku['cover'] ?>">
    <!-- COVER -->
    <div>
        <label>Cover</label><br>

        <?php if ($buku['cover']): ?>
            <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>" width="80"><br>
        <?php endif; ?>

        <input type="file" name="cover">
        <small>Biarkan kosong jika tidak ingin ganti cover</small>
    </div>

    <br>
    <button type="submit">Update</button>
    <a href="<?= base_url('buku') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>