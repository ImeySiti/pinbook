<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Data Peminjaman</h2>

<?php if (session()->get('role') == 'anggota'): ?>
    <a href="<?= base_url('peminjaman/create') ?>">+ Pinjam Buku</a>
<?php endif; ?>

<br><br>

<?php
$statusText = [
    'menunggu' => 'Diproses',
    'dipinjam' => 'Dipinjam',
    'diperpanjang' => 'Diperpanjang',
    'kembali'  => 'Dikembalikan',
    'terlambat' => 'Terlambat'
];

$statusColor = [
    'menunggu' => 'orange',
    'dipinjam' => 'blue',
    'diperpanjang' => 'purple',
    'kembali'  => 'green',
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
    <th>Pengajuan</th>
    <th>Aksi</th>
</tr>

<?php if (!empty($peminjaman)): ?>
<?php $no = 1; foreach ($peminjaman as $p): ?>

<?php
$today = date('Y-m-d');

$status = $p['status'] ?? 'dipinjam';
if ($status != 'kembali' && !empty($p['tanggal_kembali']) && $p['tanggal_kembali'] < $today) {
    $status = 'terlambat';
}

$metode   = $p['metode_pengambilan'] ?? '';
$sp       = $p['status_pengantaran'] ?? '';
$pengajuan = $p['status_pengajuan'] ?? '';
?>

<tr>
<td><?= $no++ ?></td>
<td><?= esc($p['nama_anggota'] ?? '-') ?></td>
<td><?= esc($p['daftar_buku'] ?? '-') ?></td>
<td><?= esc($p['tanggal_pinjam'] ?? '-') ?></td>
<td><?= esc($p['tanggal_kembali'] ?? '-') ?></td>

<!-- STATUS -->
<td>
    <?php
    $text = $statusText[$status] ?? 'Diproses';
    $color = $statusColor[$status] ?? 'black';
    ?>
    <span style="color:<?= $color ?>"><?= $text ?></span>
</td>

<!-- PENGANTARAN -->
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
    ?>
    <span style="color:<?= $map[$sp][1] ?? 'gray' ?>">
        <?= $map[$sp][0] ?? 'Diproses' ?>
    </span>
<?php else: ?>
    <span style="color:gray">Ambil Sendiri</span>
<?php endif; ?>
</td>

<!-- PENGAJUAN -->
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

<!-- ================= AKSI ================= -->
<td>

<a href="<?= base_url('peminjaman/detail/'.$p['id_peminjaman']) ?>">Detail</a>

<?php
$metode    = $p['metode_pengambilan'] ?? '';
$sp        = $p['status_pengantaran'] ?? '';
$pengajuan = $p['status_pengajuan'] ?? '';
$status    = $p['status'] ?? '';
?>

<!-- ================= ANGGOTA ================= -->
<?php if (session()->get('role') == 'anggota'): ?>

    <?php 
        $metode   = $p['metode_pengambilan'] ?? '';
        $status   = $p['status'] ?? '';
        $pengajuan = $p['status_pengajuan'] ?? null;
    ?>

    <!-- BAYAR (khusus antar rumah) -->
    <?php if ($metode == 'antar' && $p['status_pengantaran'] == 'menunggu_pembayaran'): ?>
        | <a href="<?= base_url('peminjaman/pembayaran/'.$p['id_peminjaman']) ?>">Bayar</a>
    <?php endif; ?>

    <!-- JIKA BELUM ADA PENGAJUAN -->
    <?php if ($pengajuan === null || $pengajuan == ''): ?>

        <!-- PERPANJANG (SEMUA METODE) -->
        <?php if (in_array($status, ['menunggu','dipinjam','diproses','terlambat'])): ?>
            | <a href="<?= base_url('peminjaman/ajukanPerpanjang/'.$p['id_peminjaman']) ?>">Perpanjang</a>
        <?php endif; ?>

        <!-- PENGEMBALIAN (SEMUA METODE) -->
        <?php if (in_array($status, ['menunggu','dipinjam','diproses','terlambat'])): ?>
            | <a href="<?= base_url('peminjaman/ajukanKembali/'.$p['id_peminjaman']) ?>">Pengembalian</a>
        <?php endif; ?>

        <!-- PENARIKAN (KHUSUS ANTAR RUMAH SAJA) -->
        <?php if ($metode == 'antar'): ?>
            | <a href="<?= base_url('peminjaman/ajukanPenarikan/'.$p['id_peminjaman']) ?>">Penarikan</a>
        <?php endif; ?>

    <?php else: ?>
        <span style="color:gray">Menunggu konfirmasi petugas</span>
    <?php endif; ?>

<?php endif; ?>
<!-- ================= PETUGAS ================= -->
<?php if (session()->get('role') == 'petugas'): ?>

    <?php
        $metode   = $p['metode_pengambilan'] ?? '';
        $status   = $p['status'] ?? '';
        $sp       = $p['status_pengantaran'] ?? '';
        $pengajuan = $p['status_pengajuan'] ?? null;
    ?>

    <!-- 📍 MAPS (KHUSUS ANTAR RUMAH) -->
    <?php if ($metode == 'antar' && !empty($p['alamat_pengantaran'])): ?>
        | <a target="_blank"
             href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($p['alamat_pengantaran']) ?>">
             📍 Maps
          </a>
    <?php endif; ?>

    <!-- ================= PENGAJUAN ================= -->
    <?php if (!empty($pengajuan)): ?>

        <?php if ($pengajuan == 'kembali'): ?>
            | <a href="<?= base_url('peminjaman/konfirmasiPengembalian/'.$p['id_peminjaman']) ?>">
                Konfirmasi Pengembalian
              </a>

        <?php elseif ($pengajuan == 'perpanjang'): ?>
            | <a href="<?= base_url('peminjaman/konfirmasiPerpanjangan/'.$p['id_peminjaman']) ?>">
                Konfirmasi Perpanjangan
              </a>

        <?php elseif ($pengajuan == 'penarikan'): ?>
            | <a href="<?= base_url('peminjaman/konfirmasiPenarikan/'.$p['id_peminjaman']) ?>">
                Konfirmasi Penarikan
              </a>
        <?php endif; ?>

    <?php else: ?>

        <!-- ================= AMBIL DI PERPUS ================= -->
        <?php if ($metode == 'ambil' && $status == 'menunggu'): ?>
            | <a href="<?= base_url('peminjaman/konfirmasiAmbilPerpus/'.$p['id_peminjaman']) ?>">
                ✔ Konfirmasi Ambil (Perpus)
              </a>
        <?php endif; ?>

        <!-- ================= ANTAR RUMAH ================= -->
        <?php if ($metode == 'antar'): ?>

            <?php if ($sp == 'menunggu_konfirmasi'): ?>
                | <a href="<?= base_url('peminjaman/konfirmasiAntar/'.$p['id_peminjaman']) ?>">
                    ✔ Konfirmasi Antar
                  </a>

            <?php elseif ($sp == 'diproses'): ?>
                | <a href="<?= base_url('peminjaman/mulaiAntar/'.$p['id_peminjaman']) ?>">
                    🚚 Mulai Antar
                  </a>

            <?php elseif ($sp == 'dalam_pengantaran'): ?>
                | <a href="<?= base_url('peminjaman/selesai/'.$p['id_peminjaman']) ?>">
                    ✔ Selesai (jadi dipinjam)
                  </a>
            <?php endif; ?>

        <?php endif; ?>

        <!-- ================= KEMBALI ================= -->
        <?php if ($status != 'kembali'): ?>
            | <a href="<?= base_url('peminjaman/kembali/'.$p['id_peminjaman']) ?>">
                ↩ Kembalikan
              </a>
        <?php endif; ?>

        <!-- ================= ANTAR RUMAH ================= -->
        <?php if ($metode == 'antar'): ?>

            <?php if ($sp == 'menunggu_konfirmasi'): ?>
                | <a href="<?= base_url('peminjaman/konfirmasiAntar/'.$p['id_peminjaman']) ?>">Konfirmasi Antar</a>

            <?php elseif ($sp == 'diproses'): ?>
                | <a href="<?= base_url('peminjaman/mulaiAntar/'.$p['id_peminjaman']) ?>">Mulai Antar</a>

            <?php elseif ($sp == 'dalam_pengantaran'): ?>
                | <a href="<?= base_url('peminjaman/selesai/'.$p['id_peminjaman']) ?>">Selesai</a>
            <?php endif; ?>

        <?php endif; ?>

        <!-- ================= KEMBALI ================= -->
        <?php if ($status != 'kembali'): ?>
            | <a href="<?= base_url('peminjaman/kembali/'.$p['id_peminjaman']) ?>">Kembalikan</a>
        <?php endif; ?>

    <?php endif; ?>

<?php endif; ?>

<!-- ================= ADMIN ================= -->
<?php if (session()->get('role') == 'admin'): ?>
    | <a href="<?= base_url('peminjaman/delete/'.$p['id_peminjaman']) ?>">Hapus</a>
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