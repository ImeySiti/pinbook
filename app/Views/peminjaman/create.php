<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Pinjam Buku</h2>

<!-- 🔍 SEARCH -->
<form method="get" action="<?= base_url('peminjaman/create') ?>">
    <input type="text" name="q" placeholder="Cari buku...">
    <input type="text" name="kategori" placeholder="Kategori">
    <button type="submit">Cari</button>
</form>

<br>

<!-- 🔍 HASIL PENCARIAN -->
<?php if (!empty($hasil_cari)): ?>
    <h3>Hasil Pencarian</h3>

    <div style="display:flex; flex-wrap:wrap; gap:15px;">
        <?php foreach ($hasil_cari as $b): ?>
            <div style="border:1px solid #ccc; padding:10px; width:200px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                
                <!-- 📸 COVER -->
                <?php if (!empty($b['cover'])): ?>
                    <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" 
                         style="width:100%; height:200px; object-fit:cover; border-radius:5px;">
                <?php endif; ?>

                <br>

                <!-- 📚 JUDUL -->
                <b><?= esc($b['judul']) ?></b>

                <br><br>

                <!-- 🔥 AKSI -->
                <a href="<?= base_url('buku/detail/'.$b['id_buku']) ?>">Detail</a> |

                <?php if ($b['tersedia'] > 0): ?>
                    <a href="<?= base_url('peminjaman/pinjam/'.$b['id_buku']) ?>">Pinjam</a>
                <?php else: ?>
                    <span style="color:red">Stok Habis</span>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<hr>

<!-- ⭐ REKOMENDASI -->
<h3>Rekomendasi Buku</h3>

<?php if (!empty($rekomendasi)): ?>
    <div style="display:flex; flex-wrap:wrap; gap:15px;">
        <?php foreach ($rekomendasi as $r): ?>
            <div style="border:1px solid #ccc; padding:10px; width:200px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                
                <!-- 📸 COVER -->
                <?php if (!empty($r['cover'])): ?>
                    <img src="<?= base_url('uploads/buku/' . $r['cover']) ?>" 
                         style="width:100%; height:200px; object-fit:cover; border-radius:5px;">
                <?php endif; ?>

                <br>

                <!-- 📚 JUDUL -->
                <b><?= esc($r['judul']) ?></b>

                <br><br>

                <!-- 🔥 AKSI -->
                <a href="<?= base_url('buku/detail/'.$r['id_buku']) ?>">Detail</a> |

                <?php if ($r['tersedia'] > 0): ?>
                    <a href="<?= base_url('peminjaman/pinjam/'.$r['id_buku']) ?>">Pinjam</a>
                <?php else: ?>
                    <span style="color:red">Stok Habis</span>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>