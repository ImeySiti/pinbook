<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<?php if (session()->get('role') == 'anggota'): ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Pinjam Buku</a>
<?php endif; ?>

<br><br>

<?php
// Pengaturan Teks Status sesuai ENUM Database
$statusText = [
    'menunggu'     => 'Diproses',
    'dipinjam'     => 'Dipinjam',
    'diperpanjang' => 'Diperpanjang',
    'kembali'      => 'Dikembalikan',
    'dikembalikan' => 'Dikembalikan', 
    'terlambat'    => 'Terlambat'
];

// Pengaturan Warna Status
$statusColor = [
    'menunggu'     => 'orange',
    'dipinjam'     => 'blue',
    'diperpanjang' => 'purple',
    'kembali'      => 'green',
    'dikembalikan' => 'green',
    'terlambat'    => 'red'
];
?>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Buku</th>
    <th>Tgl Pinjam</th>
    <th>Jatuh Tempo</th>
    <th>Status</th>
    <th>Pengantaran</th>
    <th>Pengajuan</th>
    <th>Aksi</th>
</tr>

<?php if (!empty($peminjaman)): ?>
<?php $no = 1; foreach ($peminjaman as $p): ?>

<?php
$today = date('Y-m-d');
$status = (isset($p['status']) && !empty($p['status'])) ? $p['status'] : 'dipinjam';

if (!in_array($status, ['kembali', 'dikembalikan']) && !empty($p['tanggal_kembali']) && $p['tanggal_kembali'] < $today) {
    $status = 'terlambat';
}

$metode    = $p['metode_pengambilan'] ?? '';
$sp        = $p['status_pengantaran'] ?? '';
$pengajuan = $p['status_pengajuan'] ?? '';
?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= esc($p['nama_anggota'] ?? '-') ?></td>
    <td><?= esc($p['daftar_buku'] ?? '-') ?></td>
    <td><?= esc($p['tanggal_pinjam'] ?? '-') ?></td>
    <td><?= esc($p['tanggal_kembali'] ?? '-') ?></td>

    <td>
        <?php
        $text  = $statusText[$status] ?? 'Diproses';
        $color = $statusColor[$status] ?? 'black';
        ?>
        <span style="color:<?= $color ?>; font-weight: bold;"><?= $text ?></span>
    </td>

    <td>
    <?php if ($metode == 'antar'): ?>
        <?php
        $map = [
            'menunggu_pembayaran' => ['Menunggu Bayar', 'orange'],
            'menunggu_konfirmasi' => ['Menunggu Konfirmasi', 'purple'],
            'siap_diantar'         => ['Siap Diantar', 'blue'],
            'dalam_pengantaran'    => ['Sedang Diantar', 'green'],
            'sudah_bayar'          => ['Sudah Bayar', 'teal'],
            'selesai'             => ['Selesai', 'black']
        ];
        ?>
        <span style="color:<?= $map[$sp][1] ?? 'gray' ?>">
            <?= $map[$sp][0] ?? 'Diproses' ?>
        </span>
    <?php else: ?>
        <span style="color:gray">Ambil Sendiri</span>
    <?php endif; ?>
    </td>

    <td>
    <?php if ($pengajuan == 'kembali'): ?>
        <span style="color:red">Pengembalian</span>
    <?php elseif ($pengajuan == 'perpanjang'): ?>
        <span style="color:purple">Perpanjangan</span>
    <?php elseif ($pengajuan == 'penarikan'): ?>
        <span style="color:blue">Penarikan</span>
    <?php else: ?>
        <span style="color:gray">-</span>
    <?php endif; ?>
    </td>

    <td>
        <a href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>">Detail</a>

        <?php if (session()->get('role') == 'anggota'): ?>
            <?php if ($metode == 'antar' && $sp == 'dalam_pengantaran'): ?>
                | <a href="<?= base_url('peminjaman/pembayaran/'.$p['id_peminjaman']) ?>" style="color: green; font-weight: bold;">💰 Bayar</a>
            <?php endif; ?>

            <?php if (empty($pengajuan) && !in_array($status, ['kembali', 'dikembalikan'])): ?>
                | <a href="<?= base_url('peminjaman/ajukanPerpanjang/'.$p['id_peminjaman']) ?>">Perpanjang</a>
                | <a href="<?= base_url('peminjaman/ajukanKembali/'.$p['id_peminjaman']) ?>">Pengembalian</a>
                <?php if ($metode == 'antar'): ?>
                    | <a href="<?= base_url('peminjaman/ajukanPenarikan/'.$p['id_peminjaman']) ?>">Penarikan</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (session()->get('role') == 'petugas'): ?>
            <?php if ($metode == 'antar' && !empty($p['alamat_pengantaran'])): ?>
                | <a target="_blank" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($p['alamat_pengantaran']) ?>">📍 Maps</a>
            <?php endif; ?>

            <?php if (!empty($pengajuan)): ?>
                <?php if ($pengajuan == 'kembali'): ?>
                    | <a href="<?= base_url('peminjaman/konfirmasiPengembalian/'.$p['id_peminjaman']) ?>">Konfirmasi Pengembalian</a>
                <?php elseif ($pengajuan == 'perpanjang'): ?>
                    | <a href="<?= base_url('peminjaman/konfirmasiPerpanjangan/'.$p['id_peminjaman']) ?>">Konfirmasi Perpanjangan</a>
                <?php elseif ($pengajuan == 'penarikan'): ?>
                    | <a href="<?= base_url('peminjaman/konfirmasiPenarikan/'.$p['id_peminjaman']) ?>">Konfirmasi Penarikan</a>
                <?php endif; ?>
            <?php else: ?>
                <?php if ($status == 'menunggu'): ?>
                    | <a href="<?= base_url('peminjaman/konfirmasiPeminjaman/'.$p['id_peminjaman']) ?>" onclick="return confirm('Konfirmasi peminjaman ini?')">✔ Konfirmasi</a>
                <?php endif; ?>

                <?php if ($metode == 'antar'): ?>
                    <?php if ($sp == 'menunggu_konfirmasi'): ?>
                        | <a href="<?= base_url('peminjaman/konfirmasiAntar/'.$p['id_peminjaman']) ?>">Konfirmasi Antar</a>
                    <?php elseif ($sp == 'siap_diantar'): ?>
                        | <a href="<?= base_url('peminjaman/mulaiAntar/'.$p['id_peminjaman']) ?>">Mulai Antar</a>
                    <?php elseif ($sp == 'dalam_pengantaran'): ?>
                        | <span style="color:orange; font-size: 0.8em;">Menunggu Pembayaran</span>
                    <?php elseif ($sp == 'sudah_bayar'): ?>
                        | <a href="<?= base_url('peminjaman/selesai/'.$p['id_peminjaman']) ?>" style="background: #28a745; color: white; padding: 2px 5px; border-radius: 3px;" onclick="return confirm('Selesaikan pengantaran?')">Selesai</a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!in_array($status, ['kembali', 'dikembalikan'])): ?>
                    | <a href="<?= base_url('peminjaman/kembali/'.$p['id_peminjaman']) ?>" onclick="return confirm('Yakin ingin mengembalikan buku?')">Kembalikan</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (session()->get('role') == 'admin'): ?>
            | <a href="<?= base_url('peminjaman/delete/'.$p['id_peminjaman']) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
        <?php endif; ?>
    </td>
</tr>

<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="9" align="center">Belum ada data</td>
</tr>
<?php endif; ?>

</table>

<?= $this->endSection() ?>