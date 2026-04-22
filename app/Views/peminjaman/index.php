<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<?php if (session()->get('role') == 'anggota'): ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Pinjam Buku</a>
<?php endif; ?>

<br><br>

<?php
// ================= STATUS UTAMA =================
$statusText = [
    'menunggu' => 'Diproses',
    'menunggu_pembayaran' => 'Menunggu Pembayaran',
    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
    'diproses' => 'Diproses',
    'dipinjam' => 'Dipinjam',
    'diperpanjang' => 'Diperpanjang',
    'kembali' => 'Dikembalikan',
    'terlambat' => 'Terlambat'
];

$statusColor = [
    'menunggu' => 'orange',
    'menunggu_pembayaran' => 'red',
    'menunggu_konfirmasi' => 'purple',
    'diproses' => 'blue',
    'dipinjam' => 'green',
    'diperpanjang' => 'purple',
    'kembali' => 'green',
    'terlambat' => 'red'
];
?>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Buku</th>
    <th>Tgl Pinjam</th>
    <th>Jatuh Tempo</th>
    <th>Status</th>
    <th>Pengantaran</th>
    <th>Aksi</th>
</tr>

<?php if (!empty($peminjaman)): ?>
<?php $no = 1; foreach ($peminjaman as $p): ?>

<?php
$today = date('Y-m-d');

$status = $p['status'];

// ================= AUTO TERLAMBAT =================
if ($status != 'kembali' && !empty($p['tanggal_kembali']) && $p['tanggal_kembali'] < $today) {
    $status = 'terlambat';
}

// ================= OVERRIDE STATUS ANTAR =================
if ($p['metode_pengambilan'] == 'antar') {

    if ($p['status_pengantaran'] == 'menunggu_pembayaran') {
        $status = 'menunggu_pembayaran';
    }

    if ($p['status_pengantaran'] == 'menunggu_konfirmasi') {
        $status = 'menunggu_konfirmasi';
    }

    if ($p['status_pengantaran'] == 'siap_diantar') {
        $status = 'diproses';
    }

    if ($p['status_pengantaran'] == 'dalam_pengantaran') {
        $status = 'dipinjam';
    }
}

$metode = $p['metode_pengambilan'] ?? '';
$sp = $p['status_pengantaran'] ?? '';
?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= esc($p['nama_anggota'] ?? '-') ?></td>
    <td><?= esc($p['daftar_buku'] ?? '-') ?></td>
    <td><?= esc($p['tanggal_pinjam'] ?? '-') ?></td>
    <td><?= esc($p['tanggal_kembali'] ?? '-') ?></td>

    <!-- STATUS UTAMA -->
    <td>
        <?php
        $text = $statusText[$status] ?? $status;
        $color = $statusColor[$status] ?? 'black';
        ?>
        <font color="<?= $color ?>">
            <?= $text ?>
        </font>
    </td>

    <!-- STATUS PENGANTARAN -->
    <td>
        <?php if ($metode == 'antar'): ?>

            <?php
            $map = [
                'menunggu_pembayaran' => ['Menunggu Bayar', 'orange'],
                'menunggu_konfirmasi' => ['Menunggu Konfirmasi', 'purple'],
                'siap_diantar' => ['Siap Diantar', 'blue'],
                'dalam_pengantaran' => ['Sedang Diantar', 'green'],
                'selesai' => ['Selesai', 'black']
            ];

            $label = $map[$sp][0] ?? 'Diproses';
            $color = $map[$sp][1] ?? 'gray';
            ?>

            <font color="<?= $color ?>">
                <?= $label ?>
            </font>

        <?php else: ?>
            <font color="gray">Ambil Sendiri</font>
        <?php endif; ?>
    </td>

    <!-- AKSI -->
    <td>

        <!-- DETAIL -->
        <a href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>">Detail</a>

        <!-- BAYAR -->
        <?php if (session()->get('role') == 'anggota'): ?>
            <?php if ($metode == 'antar' && $sp == 'menunggu_pembayaran'): ?>
                | <a href="<?= base_url('peminjaman/pembayaran/'.$p['id_peminjaman']) ?>">Bayar</a>
            <?php endif; ?>
        <?php endif; ?>

        <!-- PETUGAS -->
        <?php if (session()->get('role') == 'petugas'): ?>

            <?php if ($metode == 'antar'): ?>

                <?php if ($sp == 'menunggu_konfirmasi'): ?>
                    | <a href="<?= base_url('peminjaman/konfirmasi/'.$p['id_peminjaman']) ?>">Konfirmasi</a>

                <?php elseif ($sp == 'siap_diantar'): ?>
                    | <a href="<?= base_url('peminjaman/mulaiAntar/'.$p['id_peminjaman']) ?>">Mulai Antar</a>

                <?php elseif ($sp == 'dalam_pengantaran'): ?>
                    | <a href="<?= base_url('peminjaman/selesai/'.$p['id_peminjaman']) ?>">Selesai</a>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($status != 'kembali'): ?>
                | <a href="<?= base_url('peminjaman/kembali/'.$p['id_peminjaman']) ?>">Kembalikan</a>
            <?php endif; ?>

        <?php endif; ?>

        <!-- ADMIN -->
        <?php if (session()->get('role') == 'admin'): ?>
            | <a href="<?= base_url('peminjaman/delete/'.$p['id_peminjaman']) ?>">Hapus</a>
        <?php endif; ?>

    </td>
</tr>

<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="8" align="center">Belum ada data</td>
</tr>
<?php endif; ?>

</table>

<?= $this->endSection() ?>