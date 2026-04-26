<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
</head>
<body>

<h2>Data Transaksi</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>ID Peminjaman</th>
        <th>Jenis</th>
        <th>Status</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
        <th>Metode</th>
        <th>Bukti</th>
    </tr>

    <?php foreach ($transaksi as $t): ?>
    <tr>
        <td><?= $t['id_transaksi'] ?></td>
        <td><?= $t['id_peminjaman'] ?></td>
        <td><?= $t['jenis'] ?></td>
        <td><?= $t['status'] ?></td>
        <td><?= $t['jumlah'] ?></td>
        <td><?= $t['tanggal'] ?></td>
        <td><?= $t['metode'] ?></td>
        <td>
            <?php if ($t['bukti_bayar']): ?>
                <img src="<?= base_url('uploads/' . $t['bukti_bayar']) ?>" width="80">
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>