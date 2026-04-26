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
    border-radius: 14px;
    padding: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    margin-bottom: 20px;
}

.form-inline {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

input, select {
    padding: 10px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
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

.btn-gray {
    background: #f3f4f6;
    color: #111827;
}

.btn-gray:hover {
    background: #e5e7eb;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

table thead {
    background: #0f766e;
    color: #fff;
}

table th, table td {
    padding: 12px;
    font-size: 14px;
    text-align: left;
    border-bottom: 1px solid #f1f1f1;
}

table tbody tr:hover {
    background: #f9fafb;
}

img {
    border-radius: 8px;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    background: #d1fae5;
    color: #065f46;
    display: inline-block;
}

.aksi a {
    margin-right: 6px;
    font-size: 13px;
    text-decoration: none;
    color: #0f766e;
    font-weight: 500;
}

.aksi a:hover {
    text-decoration: underline;
}

.pagination {
    margin-top: 15px;
    text-align: center;
}
</style>

<div>

    <div class="page-title">👤 Data Users</div>
    <div class="sub-title">Kelola data pengguna sistem perpustakaan</div>

    <!-- TOMBOL SETTING PROFIL (UNTUK SEMUA USER) -->
    <div style="margin-bottom:15px;">
        <a href="<?= base_url('profile') ?>" class="btn btn-green">
            ⚙️ Setting Profil Saya
        </a>
    </div>

    <!-- FILTER -->
    <div class="card-box">
        <form method="get" class="form-inline">

            <input type="text" name="keyword" placeholder="Cari nama..." 
                   value="<?= $_GET['keyword'] ?? '' ?>">

            <select name="role">
                <option value="">-- Semua Role --</option>
                <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="petugas" <?= (($_GET['role'] ?? '') == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
            </select>

            <button class="btn btn-green" type="submit">Cari</button>

            <a class="btn btn-gray" href="<?= base_url('users') ?>">Reset</a>

            <a class="btn btn-green" 
               href="<?= base_url('users/print?' . http_build_query($_GET)) ?>" 
               target="_blank">
                Print
            </a>

        </form>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="card-box" style="color:green;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php if (!empty($users)): ?>
            <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>

            <?php foreach ($users as $u): ?>

                <!-- 🔒 hanya tampil jika admin atau user itu sendiri -->
                <?php if (session()->get('role') == 'admin' || session()->get('id') == $u['id']) : ?>

                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($u['nama']) ?></td>
                    <td><?= esc($u['email']) ?></td>
                    <td><?= esc($u['username']) ?></td>
                    <td><span class="badge"><?= ucfirst($u['role']) ?></span></td>

                    <td>
                        <?php if ($u['foto']): ?>
                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" width="50">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td class="aksi">

                        <!-- semua bisa lihat detail sendiri -->
                        <a href="<?= base_url('users/detail/' . $u['id']) ?>">Detail</a>

                        <?php if (session()->get('role') == 'admin'): ?>
                            <a href="<?= base_url('users/edit/' . $u['id']) ?>">Edit</a>
                            <a href="<?= base_url('users/wa/' . $u['id']) ?>">WA</a>
                            <a href="<?= base_url('users/delete/' . $u['id']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
                        <?php endif; ?>

                    </td>
                </tr>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">Belum ada data user</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- PAGINATION -->
    <div class="pagination">
        <?= $pager->links() ?>
    </div>

</div>

<?= $this->endSection() ?>