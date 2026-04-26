<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Buku</h3>
<?php if (session()->getFlashdata('error')): ?>
    <div style="color:red; margin-bottom:10px;">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('buku/store') ?>" method="post" enctype="multipart/form-data">

    <div>
        <label>Judul</label><br>
        <input type="text" name="judul" required>
    </div>

    <div>
        <label>ISBN</label><br>
        <input type="text" name="isbn">
    </div>

    <!-- KATEGORI -->
    <div>
        <label>Kategori</label><br>
        <select name="id_kategori">
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
                <option value="<?= $p['id_penulis'] ?>">
                    <?= $p['nama_penulis'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>
        <input type="text" name="penulis_baru" placeholder="Atau tambah penulis baru">
    </div>

   <div>
    <label>Penerbit</label><br>
    <select name="id_penerbit">
        <option value="">-- Pilih --</option>
        <?php foreach ($penerbit as $p): ?>
            <option value="<?= $p['id_penerbit'] ?>">
                <?= $p['nama_penerbit'] ?> - <?= $p['alamat'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>
    <input type="text" name="penerbit_baru" placeholder="Atau tambah penerbit baru">

    <br>
    <input type="text" name="alamat_penerbit_baru" placeholder="Alamat penerbit baru">
</div>

    <!-- RAK -->
    <div>
        <label>Rak</label><br>
        <select name="id_rak">
            <option value="">-- Pilih Rak --</option>
            <?php foreach ($rak as $r): ?>
                <option value="<?= $r['id_rak'] ?>">
                    <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label>Tahun Terbit</label><br>
        <input type="number" name="tahun_terbit">
    </div>

    <div>
        <label>Jumlah</label><br>
        <input type="number" name="jumlah">
    </div>

    <div>
        <label>Tersedia</label><br>
        <input type="number" name="tersedia">
    </div>

    <div>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi"></textarea>
    </div>

    <!-- COVER -->
    <div>
        <label>Cover</label><br>
        <input type="file" name="cover">
    </div>

    <br>
    <button type="submit">Simpan</button>
    <a href="<?= base_url('buku') ?>">Kembali</a>
    

</form>

<?= $this->endSection() ?>