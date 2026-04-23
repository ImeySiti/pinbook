<!DOCTYPE html>
<html>
<head>
    <title>Print Peminjaman</title>
</head>
<body onload="window.print()">

<h2>Data Peminjaman</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Anggota</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Status</th>
        <th>Metode</th>
    </tr>

    <?php $no = 1; foreach ($peminjaman as $p): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $p['nama_anggota'] ?? '-' ?></td>
        <td><?= $p['tanggal_pinjam'] ?></td>
        <td><?= $p['tanggal_kembali'] ?></td>
        <td><?= $p['status'] ?></td>
        <td><?= $p['metode_pengambilan'] ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>