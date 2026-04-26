<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Peminjaman</h2>

<form method="post" action="<?= base_url('peminjaman/update/'.$peminjaman['id_peminjaman']) ?>">

<!-- ANGGOTA -->
<label>Anggota</label><br>
<select name="id_anggota">
    <?php if (!empty($anggota)): ?>
        <?php foreach ($anggota as $a): ?>
            <option value="<?= $a['id_anggota'] ?>"
                <?= (isset($peminjaman['id_anggota']) && $peminjaman['id_anggota'] == $a['id_anggota']) ? 'selected' : '' ?>>
                <?= $a['nama_anggota'] ?> (<?= $a['nis'] ?>)
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>

<br><br>

<!-- PETUGAS -->
<label>Petugas</label><br>
<select name="id_petugas">
    <?php if (!empty($petugas)): ?>
        <?php foreach ($petugas as $pt): ?>
            <option value="<?= $pt['id_petugas'] ?>"
                <?= (isset($peminjaman['id_petugas']) && $peminjaman['id_petugas'] == $pt['id_petugas']) ? 'selected' : '' ?>>
                <?= $pt['jabatan'] ?>
            </option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>

<br><br>

<!-- TANGGAL KEMBALI -->
<label>Tanggal Kembali</label><br>
<input type="date" name="tanggal_kembali"
       value="<?= $peminjaman['tanggal_kembali'] ?? '' ?>">

<br><br>

<!-- STATUS -->
<label>Status</label><br>
<select name="status">
    <option value="pinjam" <?= (isset($peminjaman['status']) && $peminjaman['status']=='pinjam') ? 'selected' : '' ?>>Pinjam</option>
    <option value="kembali" <?= (isset($peminjaman['status']) && $peminjaman['status']=='kembali') ? 'selected' : '' ?>>Kembali</option>
    <option value="perpanjang" <?= (isset($peminjaman['status']) && $peminjaman['status']=='perpanjang') ? 'selected' : '' ?>>Perpanjang</option>
</select>

<br><br>

<!-- BUKU -->
<h3>Edit Buku</h3>

<?php if (!empty($buku)): ?>
    <?php foreach ($buku as $b): ?>
        <label>
            <input type="checkbox" name="id_buku[]" value="<?= $b['id_buku'] ?>"
                <?= in_array($b['id_buku'], $buku_terpilih ?? []) ? 'checked' : '' ?>>
            <?= $b['judul'] ?>
        </label><br>
    <?php endforeach; ?>
<?php endif; ?>

<br>

<button type="submit">Update</button>

</form>

<?= $this->endSection() ?>