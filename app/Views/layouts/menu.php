<a href="#">
    <b>pinbook</b>App
</a><br>

<a href="<?= base_url('/') ?>">
    Dashboard
</a><br>

<?php if (session()->get('role') == 'admin'): ?>

    <a href="<?= base_url('/buku') ?>">Buku</a><br>
    <a href="<?= base_url('/kategori') ?>">Kategori</a><br>
    <a href="<?= base_url('/penulis') ?>">Penulis</a><br>
    <a href="<?= base_url('/penerbit') ?>">Penerbit</a><br>
    <a href="<?= base_url('/rak') ?>">Rak</a><br>

<?php endif; ?>

<?php if (
    session()->get('role') == 'admin' ||
    session()->get('role') == 'petugas' ||
    session()->get('role') == 'anggota'
): ?>
    <a href="<?= base_url('/peminjaman') ?>">Peminjaman</a><br>
    <a href="<?= base_url('/pengembalian') ?>">Pengembalian</a><br>
<?php endif; ?>

<?php if (
    session()->get('role') == 'admin' ||
    session()->get('role') == 'petugas'
): ?>
    <a href="<?= base_url('/users') ?>">Users</a><br>
<?php endif; ?>

<?php $idu = session('id'); ?>
<a href="<?= base_url('users/edit/' . $idu) ?>">
    Setting
</a><br>

<a href="<?= base_url('/logout') ?>">Log Out</a><br>

<br>
Masuk sebagai:
<b><?= session('nama'); ?> (<?= session('role'); ?>)</b>
<br><br>

<img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" height="80" />