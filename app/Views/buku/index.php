<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div>

    <h3>Data Buku</h3>

    <!-- FORM PENCARIAN -->
    <form method="get" action="">

    <input type="text" name="keyword" placeholder="Cari judul..."
        value="<?= $_GET['keyword'] ?? '' ?>">

    <select name="kategori">
        <option value="">-- Semua Kategori --</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori'] ?>"
                <?= (($_GET['kategori'] ?? '') == $k['id_kategori']) ? 'selected' : '' ?>>
                <?= $k['nama_kategori'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Cari</button>
    <a href="<?= base_url('buku') ?>">Reset</a>
<a href="<?= base_url('buku/print?' . http_build_query($_GET)) ?>" target="_blank">
    Print
</a>
</form>

    <br>

    <?php if (in_array(session()->get('role'), ['admin', 'petugas'])) : ?>
    <a href="<?= base_url('buku/create') ?>">+ Tambah Buku</a>
<?php endif; ?>

    <br><br>

    <?php if (session()->getFlashdata('success')): ?>
        <div><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>cover</th>
                <th>judul</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Rak</th>
                <th>Tahun</th>
                <th>Jumlah</th>
                <th>Tersedia</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($buku)): ?>
                <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                <?php foreach ($buku as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?php if ($b['cover']): ?>
                                <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="60">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
            
                        <td><?= $b['judul'] ?></td>
                        <td><?= $b['isbn'] ?></td>

                        <td><?= $b['nama_kategori'] ?? '-' ?></td>
                        <td><?= $b['nama_penulis'] ?? '-' ?></td>
                        <td><?= $b['nama_penerbit'] ?? '-' ?></td>
                        <td><?= $b['nama_rak'] ?? '-' ?></td>

                        <td><?= $b['tahun_terbit'] ?></td>
                        <td><?= $b['jumlah'] ?></td>
                        <td><?= $b['tersedia'] ?></td>
                        

                        <td>
    <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>">Detail</a>

    <?php if (in_array(session()->get('role'), ['admin', 'petugas'])) : ?>
        <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>">Edit</a>
    <?php endif; ?>
 
    <a href="<?= base_url('buku/wa/' . $b['id_buku']) ?>" target="_blank">Kirim WA</a>
    <?php if (session()->get('role') == 'admin') : ?>
        <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>"
           onclick="return confirm('Hapus buku ini?')">Hapus</a>
    <?php endif; ?>

</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">Belum ada data buku</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>

    <!-- PAGINATION -->
    <div>
        <?= $pager->links() ?>
    </div>

</div>

<?= $this->endSection() ?>