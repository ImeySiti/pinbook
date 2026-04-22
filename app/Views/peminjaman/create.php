<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Pinjam Buku</h2>

<!-- 🔔 NOTIF -->
<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color:green"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<!-- 🔍 SEARCH -->
<form method="get" action="<?= base_url('peminjaman/create') ?>">

    <input type="text" name="q" placeholder="Cari buku..."
        value="<?= esc($_GET['q'] ?? '') ?>">

    <select name="kategori">
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategori_list as $k): ?>
            <option value="<?= $k['id_kategori'] ?>"
                <?= (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : '' ?>>
                <?= esc($k['nama_kategori']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Cari</button>
</form>

<br>

<!-- =========================
FORM PINJAM
========================= -->
<form method="post" action="<?= base_url('peminjaman/pinjamMulti') ?>" onsubmit="return validasiForm()">

<!-- 👤 PILIH PETUGAS -->
<label>Petugas</label><br>
<select name="id_petugas" id="petugas" required>
    <option value="">-- Pilih Petugas --</option>
    <?php foreach ($petugas as $p): ?>
        <option value="<?= $p['id_petugas'] ?>">
            <?= esc($p['nama']) ?> (<?= esc($p['jabatan']) ?>)
        </option>
    <?php endforeach; ?>
</select>

<br><br>

<?php 
$isSearching = !empty($_GET['q']) || !empty($_GET['kategori']);
$dataTampil = $isSearching ? $hasil_cari : $rekomendasi;
?>

<h3><?= $isSearching ? 'Hasil Pencarian' : 'Rekomendasi Buku' ?></h3>

<!-- 📚 LIST BUKU -->
<div style="display:flex; flex-wrap:wrap; gap:15px;">

<?php foreach ($dataTampil as $b): ?>
    <div style="
        border:1px solid #ccc;
        padding:10px;
        width:200px;
        border-radius:10px;
        text-align:center;
        box-shadow:0 2px 6px rgba(0,0,0,0.1);
    ">

        <!-- 📸 COVER -->
        <?php if (!empty($b['cover'])): ?>
            <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>"
                 style="width:100%; height:200px; object-fit:cover; border-radius:5px;">
        <?php else: ?>
            <div style="width:100%; height:200px; background:#eee;">
                Tidak ada gambar
            </div>
        <?php endif; ?>

        <br>

        <!-- 📚 JUDUL -->
        <b><?= esc($b['judul']) ?></b>

        <br><br>

        <a href="<?= base_url('buku/detail/'.$b['id_buku']) ?>">Detail</a>

        <br><br>

        <!-- 🔥 CHECKBOX -->
        <?php if ($b['tersedia'] > 0): ?>
            <input type="checkbox"
                   class="bukuCheck"
                   name="buku[]"
                   value="<?= $b['id_buku'] ?>"
                   onchange="updateKeranjang()">
            Pilih
        <?php else: ?>
            <span style="color:red">Stok Habis</span>
        <?php endif; ?>

    </div>
<?php endforeach; ?>

</div>

<br>

<!-- 🔢 JUMLAH -->
<p>Jumlah dipilih: <span id="jumlah">0</span> / 2</p>

<!-- 🧾 KERANJANG -->
<h4>Keranjang Buku</h4>
<ul id="keranjang"></ul>

<br>

<!-- 🚚 METODE -->
<label>Metode Pengambilan</label><br>
<select name="metode_pengambilan" id="metode" required onchange="toggleAlamat()">
    <option value="">-- Pilih Metode --</option>
    <option value="ambil">Ambil di Perpustakaan</option>
    <option value="antar">Antar ke Rumah</option>
</select>

<br><br>

<!-- 📍 ALAMAT -->
<div id="alamatBox" style="display:none;">
    <label>Alamat Pengantaran</label><br>
    <textarea name="alamat"><?= esc($anggota['alamat'] ?? '') ?></textarea>
</div>

<br>

<button type="submit">Pinjam Buku</button>

</form>

<!-- =========================
SCRIPT
========================= -->
<script>

function updateKeranjang() {

    let checked = document.querySelectorAll('.bukuCheck:checked');
    let jumlah = checked.length;

    if (jumlah > 2) {
        alert('Maksimal 2 buku!');
        event.target.checked = false;
        return;
    }

    document.getElementById('jumlah').innerText = jumlah;

    let keranjang = document.getElementById('keranjang');
    keranjang.innerHTML = '';

    checked.forEach(function(item) {
        let nama = item.closest('div').querySelector('b').innerText;

        let li = document.createElement('li');
        li.innerText = nama;

        keranjang.appendChild(li);
    });
}

function toggleAlamat() {
    let metode = document.getElementById('metode').value;
    document.getElementById('alamatBox').style.display =
        (metode === 'antar') ? 'block' : 'none';
}

function validasiForm() {

    let buku = document.querySelectorAll('.bukuCheck:checked').length;
    let petugas = document.getElementById('petugas').value;
    let metode = document.getElementById('metode').value;

    if (!petugas) {
        alert('Pilih petugas!');
        return false;
    }

    if (buku === 0) {
        alert('Pilih minimal 1 buku!');
        return false;
    }

    if (!metode) {
        alert('Pilih metode pengambilan!');
        return false;
    }

    if (metode === 'antar') {
        let alamat = document.querySelector('[name="alamat"]').value.trim();
        if (!alamat) {
            alert('Alamat wajib diisi!');
            return false;
        }
    }

    return true;
}

</script>

<?= $this->endSection() ?>