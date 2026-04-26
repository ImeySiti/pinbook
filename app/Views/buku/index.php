<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
.page-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f766e;
    margin-bottom: 5px;
}

.sub-title {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 20px;
}

.card-box {
    background: #fff;
    padding: 16px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    margin-bottom: 15px;
}

.form-box {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

input, select {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    outline: none;
    font-size: 14px;
}

input:focus, select:focus {
    border-color: #0f766e;
}

.btn {
    padding: 10px 14px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
}

.btn-green {
    background: #0f766e;
    color: #fff;
}

.btn-green:hover {
    background: #115e59;
}

.btn-red {
    background: #dc2626;
    color: #fff;
}

.btn-red:hover {
    background: #b91c1c;
}

.btn-gray {
    background: #f3f4f6;
    color: #111827;
}

.btn-gray:hover {
    background: #e5e7eb;
}

.table-box {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #0f766e;
    color: #fff;
}

th, td {
    padding: 12px;
    font-size: 14px;
    border-bottom: 1px solid #f1f1f1;
}

tbody tr:hover {
    background: #f9fafb;
}

img {
    border-radius: 6px;
}

a {
    color: #0f766e;
    text-decoration: none;
    font-weight: 500;
}

a:hover {
    text-decoration: underline;
}

.badge {
    background: #d1fae5;
    color: #065f46;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
}
</style>

<div>

    <div class="page-title">📚 Data Buku</div>
    <div class="sub-title">Kelola koleksi buku perpustakaan</div>

    <!-- FORM -->
    <div class="card-box">
        <form method="get" class="form-box">

            <input type="text" name="keyword"
                   placeholder="Cari judul..."
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

            <button class="btn btn-green">Cari</button>

            <a href="<?= base_url('buku') ?>" class="btn btn-gray">Reset</a>

            <a href="<?= base_url('buku/print?' . http_build_query($_GET)) ?>"
               target="_blank"
               class="btn btn-red">
                Print
            </a>

        </form>
    </div>

    <!-- ADD BUTTON -->
    <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
        <a href="<?= base_url('buku/create') ?>" class="btn btn-green mb-3">
            + Tambah Buku
        </a>
    <?php endif; ?>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="card-box" style="color:green;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Rak</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            </thead>

            <tbody>

            <?php if (!empty($buku)): ?>
                <?php $no = 1; ?>

                <?php foreach ($buku as $b): ?>
                    <tr>

                        <td><?= $no++ ?></td>

                        <td>
                            <?php if (!empty($b['cover'])): ?>
                                <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="45">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <td><?= esc($b['judul']) ?></td>
                        <td><span class="badge"><?= esc($b['nama_kategori'] ?? '-') ?></span></td>
                        <td><?= esc($b['nama_penulis'] ?? '-') ?></td>
                        <td><?= esc($b['nama_rak'] ?? '-') ?></td>
                        <td><?= esc($b['tersedia'] ?? 0) ?> / <?= esc($b['jumlah'] ?? 0) ?></td>

                        <td>
            
                <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>">Detail</a> |

                <form action="<?= base_url('peminjaman/simpan') ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                    <button type="submit" class="btn btn-green" style="padding:4px 8px; font-size:12px;">
                        Pinjam
                    </button>
                </form>

                <?php if (in_array(session()->get('role'), ['admin', 'petugas'])): ?>
                    | <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>">Edit</a>
                <?php endif; ?>

                | <a href="<?= base_url('buku/wa/' . $b['id_buku']) ?>" target="_blank">WA</a>

                <?php if (session()->get('role') == 'admin'): ?>
                    | <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>"
                         onclick="return confirm('Hapus buku ini?')">
                        Hapus
                    </a>
                <?php endif; ?>
            </td>

        </tr>
    <?php endforeach; ?>

<?php else: ?>
    <tr>
        <td colspan="8" style="text-align:center;">Tidak ada data buku</td>
    </tr>
<?php endif; ?>


</td>
                <tr>
                    <td colspan="8" style="text-align:center;">Tidak ada data buku</td>
                </tr>


            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div style="margin-top:15px;">
        <?= $pager->links() ?? '' ?>
    </div>

</div>

<?= $this->endSection() ?>