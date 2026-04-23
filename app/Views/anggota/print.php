<!DOCTYPE html>
<html>
<head>
    <title>Print Data Anggota</title>

    <style>
        body {
            font-family: Arial;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #eee;
        }

        @media print {
            @page {
                margin: 20px;
            }
        }
    </style>
</head>

<body onload="window.print()">

<h2>DATA ANGGOTA</h2>
<p>Tanggal Cetak: <?= date('d-m-Y') ?></p>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIS</th>
        <th>Alamat</th>
        <th>No HP</th>
    </tr>

    <?php $no = 1; foreach ($anggota as $a): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($a['nama'] ?? '-') ?></td>
        <td><?= esc($a['nis'] ?? '-') ?></td>
        <td><?= esc($a['alamat'] ?? '-') ?></td>
        <td><?= esc($a['no_hp'] ?? '-') ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>
</html>