<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h2>Data Anggota</h2>

<a href="<?= base_url('anggota/create') ?>">+ Tambah Anggota</a>
|
<a href="<?= base_url('anggota/print') ?>" target="_blank">🖨 Print</a>

<br><br>

<table border="1" cellpadding="8">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>NIS</th>
    <th>Alamat</th>
    <th>No HP</th>
    <th>Aksi</th>
</tr>

<?php $no = 1; foreach ($anggota as $a): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= esc($a['nama']) ?></td>
    <td><?= esc($a['nis']) ?></td>
    <td><?= esc($a['alamat']) ?></td>
    <td><?= esc($a['no_hp']) ?></td>

    <td>
        <a href="<?= base_url('anggota/edit/'.$a['id_anggota']) ?>">Edit</a> |
        <a href="<?= base_url('anggota/delete/'.$a['id_anggota']) ?>" onclick="return confirm('Yakin?')">Hapus</a> |

        <a href="<?= base_url('anggota/wa/'.$a['id_anggota']) ?>" target="_blank">📱 WA</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?= $this->endSection() ?>