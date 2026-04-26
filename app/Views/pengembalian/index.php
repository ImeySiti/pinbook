<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $role = session()->get('role'); ?>

<h2>Data Pengembalian</h2>

<table border="1" cellpadding="5" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Nama Anggota</th>
        <th>Tgl Kembali Asli</th>
        <th>Tgl Pengembalian</th>
        <th>Hari Telat</th>
        <th>Total Denda</th>
        <th>Status Bayar</th>
        <th>Aksi</th>
    </tr>

    <?php if (!empty($pengembalian)): ?>
        <?php $no = 1; foreach ($pengembalian as $p): ?>

        <?php 
            $denda = $p['denda'] ?? 0;
            $status = $p['status_bayar'] ?? 'belum';
        ?>

        <tr>
            <td><?= $no++ ?></td>

            <!-- 👤 NAMA AMBIL DARI JOIN DI CONTROLLER -->
            <td><?= esc($p['nama_anggota'] ?? '-') ?></td>

            <td><?= esc($p['tgl_kembali_asli'] ?? '-') ?></td>

            <td><?= esc($p['tanggal_dikembalikan'] ?? '-') ?></td>

            <td><?= esc($p['jumlah_hari_telat'] ?? 0) ?> hari</td>

            <!-- 💰 DENDA (DEFAULT 0) -->
            <td>Rp <?= number_format($denda, 0, ',', '.') ?></td>

            <!-- 💳 STATUS -->
            <td>
                <?php if ($status == 'lunas'): ?>
                    <span style="color:green;">Lunas</span>
                <?php else: ?>
                    <span style="color:red;">Belum Bayar</span>
                <?php endif; ?>
            </td>

            <!-- ⚙️ AKSI -->
            <td>

                <a href="<?= base_url('pengembalian/edit/'.$p['id_pengembalian']) ?>">
                    Edit
                </a>

                <!-- 🔥 BAYAR HANYA JIKA ADA DENDA -->
                <?php if ($denda > 0): ?>
                    |
                    <a href="<?= base_url('pengembalian/bayar/'.$p['id_pengembalian']) ?>">
                        Bayar
                    </a>
                <?php endif; ?>

                <?php if ($role == 'admin'): ?>
                    |
                    <a href="<?= base_url('pengembalian/delete/'.$p['id_pengembalian']) ?>"
                       onclick="return confirm('Hapus data?')"
                       style="color:red;">
                        Hapus
                    </a>
                <?php endif; ?>

            </td>
        </tr>

        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" align="center">Data tidak ditemukan</td>
        </tr>
    <?php endif; ?>

</table>

<?= $this->endSection() ?>