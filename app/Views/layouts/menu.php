<a href="#">
    <b>pinbook</b>App
</a><br><br>

<a href="<?= base_url('/') ?>">Dashboard</a><br>

<!-- ================= ADMIN MENU ================= -->
<?php if (session()->get('role') == 'admin'): ?>

    <a href="<?= base_url('buku') ?>">Buku</a><br>
    <a href="<?= base_url('kategori') ?>">Kategori</a><br>
    <a href="<?= base_url('penulis') ?>">Penulis</a><br>
    <a href="<?= base_url('penerbit') ?>">Penerbit</a><br>
    <a href="<?= base_url('rak') ?>">Rak</a><br>

<?php endif; ?>

<!-- ================= DATA ANGGOTA (ADMIN + PETUGAS) ================= -->
<?php if (in_array(session()->get('role'), ['admin','petugas'])): ?>

    <a href="<?= base_url('anggota') ?>">Data Anggota</a><br>

<?php endif; ?>

<!-- ================= PEMINJAMAN (SEMUA ROLE) ================= -->
<?php if (in_array(session()->get('role'), ['admin','petugas','anggota'])): ?>

    <a href="<?= base_url('peminjaman') ?>">Peminjaman</a><br>
    <a href="<?= base_url('pengembalian') ?>">Pengembalian</a><br>

<?php endif; ?>

<!-- ================= USERS (ADMIN + PETUGAS) ================= -->
<?php if (in_array(session()->get('role'), ['admin','petugas'])): ?>

    <a href="<?= base_url('users') ?>">Users</a><br>

<?php endif; ?>

<!-- ================= SETTING ================= -->
<?php $idu = session()->get('id'); ?>
<a href="<?= base_url('users/edit/' . $idu) ?>">Setting</a><br>

<!-- ================= LOGOUT ================= -->
<a href="<?= base_url('logout') ?>">Log Out</a><br><br>

<!-- ================= INFO USER ================= -->
Masuk sebagai:
<b>
<?= session()->get('nama'); ?> (<?= session()->get('role'); ?>)
</b><br>

<?php if (session()->get('role') == 'anggota'): ?>
    - ID Anggota: <?= session()->get('id_anggota'); ?><br>
<?php elseif (session()->get('role') == 'petugas'): ?>
    - ID Petugas: <?= session()->get('id_petugas'); ?><br>
<?php endif; ?>

<br>

<!-- ================= FOTO (FIX AMAN) ================= -->
<?php
$foto = session()->get('foto');
$fotoPath = FCPATH . 'uploads/users/' . $foto;
?>

<?php if (!empty($foto) && file_exists($fotoPath)): ?>
    <img src="<?= base_url('uploads/users/' . $foto) ?>" height="80">
<?php else: ?>
    <img src="<?= base_url('uploads/users/default.png') ?>" height="80">
<?php endif; ?>